<?php namespace App\Http\Controllers;

use App\Exceptions\InvalidTicketStateException;
use App\Exceptions\PaymentFailedException;
use App\Models\Order as Order;
use App\Models\Project as Project;
use App\Models\Supporter as Supporter;
use App\Models\Ticket as Ticket;
use App\Models\Categories_ticket as Categories_ticket;
use App\Models\Discount as Discount;

use App\Models\Orders_goods as Orders_goods;

use App\Services\Payment;
use App\Services\PaymentInfo;
use App\Services\PaymentService;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request as Request;

class OrderController extends Controller
{
  public function createNewOrder(Request $request)
  {
    $projectId = '';
    $ticketId = '';
    $ticket = '';
    $payType = 'card';

    if($request->has('pay_type')){
      $payType = \Input::get('pay_type');
    }

    if($request->has('project_id'))
    {
      $projectId = \Input::get('project_id');
    }

    if($request->has('ticket_id'))
    {
      $ticketId = \Input::get('ticket_id');
    }

    if(!$projectId)
    {
      //프로젝트 정보는 반드시 있어야 함.
      //return view('test', ['project' => '프로젝트 에러']);
      return ["orderResultType" => "FALSE", "orderId" => '', "eMessage" => "프로젝트 정보를 가져오지 못했습니다."];
    }

    $project = Project::findOrFail($projectId);
    $user = Auth::user();

    if($ticketId)
    {
      //티켓 정보가 있을때 저장한다.
      $ticket = $this->getOrderableTicket($ticketId);
    }
    //구매 가능한 수량이 있는지 체크

    $goodsSelectArray = $this->getSelectGoodsArray($project->goods);

    $discount = '';
    if($request->has('discountId'))
    {
      $discount = Discount::findOrFail(\Input::get('discountId'));
      if($discount)
      {

        //if($project->getAmountDiscount($discount->id) <= 0)
        //{
        //  return view('test', ['project' => '할인 수량이 매진되었습니다.']);
        //}

      }
    }

    $g_order = '';

    try {

      DB::beginTransaction();

      $order = new Order($this->getNewFilteredInput($goodsSelectArray));
      $order->project()->associate($project);
      $order->user()->associate($user);
      
      //질문이 있는경우 질문 가공해서 저장한다.
      if(count($project->questions) > 0)
      {
        $order->answer = $this->getAnswerJsonData($project->questions, $request);
      }

      if($ticket)
      {
        $order->ticket()->associate($ticket);
      }

      if($discount)
      {
        $order->discount()->associate($discount);
      }
      $order->setState(Order::ORDER_STATE_STANDBY_START);
      $order->setOrderTypeCommision(env('ORDER_TYPE_COMMISION'));
      $order->save();

      $g_order = $order;

      //최종구매 수량체크로 프로젝트 정보를 다시 가져온다.
      if($ticket)
      {
        //티켓 정보가 있을때 저장한다.
        $totalBuyCount = Order::where('ticket_id', '=', $ticketId)->where('state', '<=', Order::ORDER_STATE_PAY_END)->sum('count');
        if($ticket->audiences_limit - $totalBuyCount < 0)
        {
          $order->setState(Order::ORDER_STATE_ERROR_TICKET_OVER_COUNT);
          $order->save();

          DB::commit();

          return ["orderResultType" => "orderResultFailOverCount", "orderId" => $order->id, "projectId" => $projectId, "eMessage" => "해당 상품이 매진되었습니다."];
        }
      }

      //$order->setState(Order::ORDER_STATE_STAY);
      //$order->save();

      //$project->increment('funded_amount', $this->getOrderPrice());
      //$project->increment('tickets_count', $this->getTicketOrderCount($ticket));
      //$ticket->increment('audiences_count', $this->getOrderCount());
      //$user->increment('tickets_count');

      if($request->has('supportPrice'))
      {
        $supportPrice = Input::get('supportPrice');
        if($supportPrice > 0)
        {
          $supporter = new Supporter;
          $supporter->project()->associate($project);
          if($ticket)
          {
            $supporter->ticket()->associate($ticket);
          }
          $supporter->user()->associate($user);
          $supporter->price = $supportPrice;
          $supporter->save();

          $order->supporter()->associate($supporter);
          $order->save();
        }
      }

      DB::commit();

      $order->setState(Order::ORDER_STATE_PAY_NO_PAYMENT);

      $payment = null;
      if ($this->isPaymentProcess()) {
        $info = $this->buildPaymentNewInfo($user, $project);

        if($payType === 'card')
        {
          if($info->getAmount() >  0)
          {
            $paymentService = new PaymentService();
            if ($project->type === 'funding') {
                $payment = $paymentService->schedule($info, $project->getFundingOrderConcludeAt());
                $order->setState(Order::ORDER_STATE_PAY_SCHEDULE);
            } else {
                $payment = $paymentService->rightNow($info);
                $order->setState(Order::ORDER_STATE_PAY);
            }

            $order->imp_meta = $payment ? $payment->toJson() : '{}';
          }
        }
        else
        {
          $account_name = '';
          if($request->has('account_name')){
            $account_name = \Input::get('account_name');
          }

          $order->account_name = $account_name;
          $order->setState(Order::ORDER_STATE_PAY_ACCOUNT_STANDBY);
        }
      }

      $order->save();

      $this->createGoodsOrder($project, $order, $user, $goodsSelectArray);

      //하단에 정보 전송 전에 결제 진행한다.
      if($project->isEventTypeDefault()){
        //기본 이벤트 형태일 경우만 문자 메일을 보낸다.
        if($payType === 'card'){
          $this->sendSMS($project, $order);
          $emailTo = $order->email;
          $this->sendMail($emailTo, $project, $order);
        }else if($payType === 'account'){
          $this->sendAccountSMS($project, $order);
        }
      }

      return ["orderResultType" => "orderResultSuccess", "orderId" => $order->id, "eMessage" => ""];

    } catch (PaymentFailedException $e) {
      $orderId = '';
      if($g_order)
      {
        $orderId = $g_order->id;
        $g_order->setState(Order::ORDER_STATE_ERROR_PAY);
        $g_order->fail_message = $e->getMessage();
        $g_order->save();
      }


      return ["orderResultType" => "FALSE", "orderId" => $orderId, "eMessage" => $e->getMessage()];
    }
  }

  public function createGoodsOrder($project, $order, $user, $goodsSelectArray){
    $goodsArrayCount = count($goodsSelectArray);
    if($goodsArrayCount == 0)
    {
      return;
    }

    $goodsArray = [];
    for($i = 0 ; $i < $goodsArrayCount ; ++$i)
    {
      $goodsId = $goodsSelectArray[$i]['info']->id;
      $goodsCount = $goodsSelectArray[$i]['count'];
      // $goodsInfo = ['project_id' => $project->id, 'order_id' => $order->id];

      $goodsInfo = [
        'project_id' => $project->id,
        'order_id' => $order->id,
        'user_id' => $user->id,
        'goods_id' => $goodsId,
        'count' => $goodsCount,
        'created_at' => date('Y-m-d H:i:s', time())
      ];

      array_push($goodsArray, $goodsInfo);
    }

    DB::table('orders_goods')->insert($goodsArray);
  }

  public function deleteGoodsOrder($order){    
    DB::table('orders_goods')->where('order_id', '=', $order->id)->delete();
  }

  public function completeOrder($orderId)
  {
    //$project = Project::findOrFail($projectid);
    $order = Order::findOrFail($orderId);
    $project = $order->project;
    return view('order.complete', [
        'project' => $project,
        'order' => $order,
        'isComment' => 'FALSE'
    ]);
  }

  public function getAnswerJsonData($questions, Request $request)
  {
    if(count($questions) > 0)
    {
      $questionJson = [];
      foreach($questions as $question)
      {
        $questionRequestName = "question-id-".$question->id;
        if($request->has($questionRequestName))
        {
          $questionValue = \Input::get($questionRequestName);
          array_push($questionJson, ["key" => $question->id, "question_id" => $question->id, "value" => $questionValue]);
        }
      }

      return json_encode($questionJson);
    }
    else
    {
      return '';
    }
  }

  public function overCounterOrder($projectId)
  {
    $project = Project::findOrFail($projectId);

    return view('errors.overcounter_ticket', ['project' => $project]);
  }

  public function updateOrderStory(Request $request, $id)
  {
    $order = $this->getSecureOrderById($id);
    if(!$order)
    {
      return false;
    }

    if($request->has('order_story'))
    {
      $order->order_story = \Input::get('order_story');
      $order->save();
    }
    else
    {
      return false;
    }
    
  }

  public function updateOrderAnswer(Request $request, $id)
  {
    $order = $this->getSecureOrderById($id);
    if(!$order)
    {
      return false;
    }

    $project = $order->project;

    $questionJson = [];
    foreach($project->questions as $question)
    {
      $questionRequestName = "question-id-".$question->id;
      if($request->has($questionRequestName))
      {
        $questionValue = $request[$questionRequestName];
        array_push($questionJson, ["key" => $question->id, "question_id" => $question->id, "value" => $questionValue]);
      }
    }

    $order->answer = json_encode($questionJson, JSON_UNESCAPED_UNICODE);
    $order->save();    
  }

  public function sendSMS($project, $order)
  {
    $sms = new SmsService();
    $contact = $order->contact;
    $limit = $project->type === 'funding' ? 10 : 14;
    $titleLimit = str_limit($project->title, $limit, $end = '..');
    $totalPrice = number_format($order->total_price);
    //$totalRealTicket = $ticket->real_ticket_count * $order->count;
    $totalRealTicket = $this->getOrderCount();

    $ticket = $order->ticket;

    //펀딩일 경우
    if($ticket)
    {
      $seatName = str_limit($ticket->getSeatCategory(), 2, $end = '..');
      $datetime = date('Y/m/d H:i', strtotime($ticket->show_date));
      if($ticket->isPlaceTicket() == false)
      {
        $datetime = $ticket->getSeatCategory();
        $msg = sprintf('%s %s %d매 결제 예약 완료', $titleLimit, $datetime, $totalRealTicket);
      }
      else
      {
        $msg = sprintf('%s %s %s %d매 예매 완료', $titleLimit, $datetime, $seatName, $totalRealTicket);

        if($project->type == 'funding')
        {
          $msg = sprintf('%s %s %s %d매 결제 예약 완료', $titleLimit, $datetime, $seatName, $totalRealTicket);
        }
      }
    }
    else
    {
      //[크라우드티켓] 사랑해 엄마 ‘결제 총액’원 결제 예약 완료
      $msg = sprintf('%s %s원 결제 완료', $titleLimit, $totalPrice);
      if($project->type == 'funding')
      {
        $msg = sprintf('%s %s원 결제 예약 완료', $titleLimit, $totalPrice);
      }
    }

    $sms->send([$contact], $msg);
  }

  public function sendAccountSMS($project, $order)
  {
    $sms = new SmsService();
    $contact = $order->contact;
    $limit = $project->type === 'funding' ? 10 : 14;
    $titleLimit = str_limit($project->title, $limit, $end = '..');
    $totalPrice = number_format($order->total_price);
    //$totalRealTicket = $ticket->real_ticket_count * $order->count;
    $totalRealTicket = $this->getOrderCount();

    /*
    아래 계좌로 24시간 내에 [결제금액]을 입금하시면
    [이벤트제목]의 참여가 확정됩니다!
    1005-
    우리은행 (주)나인에이엠
    입금자명: xxx
    Jun 5:58 PM
    */
    
    //$msg = sprintf('아래 계좌로 24시간 내에 [%s원]을 입금하시면 [%s]의 참여가 확정됩니다! 1005-903-653846 우리은행 (주)나인에이엠 입금자명: %s', $totalPrice, $titleLimit, $order->account_name);
    $msg = sprintf('아래 계좌로 24시간 내에 [%s원]을 입금해주세요. 1005-903-653846 우리은행 (주)나인에이엠 입금자명: %s', $totalPrice, $order->account_name);
                    

    $sms->send([$contact], $msg);
  }

    public function completecomment($projectId){
      $project = Project::findOrFail($projectId);
      return view('order.complete', [
          'project' => $project,
          'order' => '',
          'isComment' => 'TRUE'
      ]);
    }

    private function isPaymentProcess() {
        return (int) $this->getOrderPrice() > 0;
    }

    private function buildPaymentInfo($user, $project, $ticket) {
        $info = new PaymentInfo();
        $info->withSignature($user->id, $project->id);
        $info->withAmount($this->getTotalPrice($ticket));
        $info->withCardNumber(Input::get('card_number'));
        $info->withExpiry(Input::get('expiry_year'), Input::get('expiry_month'));
        $info->withBirth(Input::get('birth'));
        $info->withPassword(Input::get('card_password'));
        return $info;
    }

    private function buildPaymentNewInfo($user, $project) {
        $info = new PaymentInfo();
        $info->withSignature($user->id, $project->id);
        //$info->withAmount($this->getNewTotalPrice($ticket, $goodsSelectArray));
        $info->withAmount($this->getNewTotalPrice());
        $info->withCardNumber(Input::get('card_number'));
        $info->withExpiry(Input::get('expiry_year'), Input::get('expiry_month'));
        $info->withBirth(Input::get('birth'));
        $info->withPassword(Input::get('card_password'));
        return $info;
    }

    private function sendMail($to, $project, $order)
    {
      $mailForm = '';
      $subject = '';
      $data = [];
      $ticketInfo = '티켓 없음';
      $discount = $order->getDiscountText();
      $goods = $order->getGoodsTotalTextInEmail();
      $supportPrice = 0;
      if($order->supporter)
      {
        $supportPrice = $order->supporter->price;
      }
      $commission = $order->getCommission();

      //티켓 정보 셋팅
      if($order->ticket)
      {
        $showDate = new \DateTime($order->ticket->show_date);
        $date = $showDate->format('Y-m-d H:i');
        $seat = $order->ticket->getSeatCategory();
        if($order->ticket->isPlaceTicket() == false)
        {
          $date = '';
        }

        $ticketInfo = $date.' ['.$seat.'] '.number_format($order->count).'매';
      }

      if ($project->type === 'funding')
      {
        $mailForm = 'template.emailform.email_complite_schedule';
        $subject = '(크라우드티켓) 프로젝트에 참여했습니다.';
      }
      else
      {
        $mailForm = 'template.emailform.email_complite_onetime';
        $subject = '(크라우드티켓) 프로젝트에 참여했습니다.';
      }

      $data = [
        'title' => $project->title,
        'ticket' => $ticketInfo,
        'discount' => $discount,
        'goods' => $goods,
        'supportPrice' => number_format($supportPrice),
        'commission' => number_format($commission),
        'totalPrice' => number_format($order->total_price),
        'payDate' => $project->getFundingOrderConcludeAt(),
        'gotoPayPageURL' => url('orders/'.$order->id)
      ];

      Mail::send($mailForm, $data, function ($m) use ($subject, $to) {
          $m->from('contact@crowdticket.kr', '크라우드티켓');
          $m->to($to)->subject($subject);
      });
    }

    private function sendCancelMail($to, $project, $order)
    {
      $mailForm = '';
      $subject = '';
      $data = [];

      $totalPrice = $order->total_price;
      $refundAmount = $order->getRefundAmount();
      $cancellationFees = $order->getCancellationFees();

      if ($project->type === 'funding')
      {
        $mailForm = 'template.emailform.email_complite_schedule_cancel';
        $subject = '(크라우드티켓) 프로젝트 참여를 취소했습니다.';
      }
      else
      {
        $mailForm = 'template.emailform.email_complite_onetime_cancel';
        $subject = '(크라우드티켓) 프로젝트 참여를 취소했습니다.';
      }

      $data = [
        'title' => $project->title,
        'totalPrice' => number_format($totalPrice),
        'refundAmount' => number_format($refundAmount),
        'cancellationFees' => number_format($cancellationFees),

        'gotoPayPageURL' => url('orders/'.$order->id)
      ];

      Mail::send($mailForm, $data, function ($m) use ($subject, $to) {
          $m->from('contact@crowdticket.kr', '크라우드티켓');
          $m->to($to)->subject($subject);
      });
    }



    private function mailDataOnFunding(Project $project, Ticket $ticket, Order $order)
    {
      $closingAt = date('Y.m.d', strtotime($project->funding_closing_at));

      $row = [
          0 => [
              'col1' => '후원금',
              'col2' => $order->getFundedAmount() . '원'
          ],
          1 => [
              'col1' => '결제예정일',
              'col2' => '목표금액을 달성할 경우 ' . $closingAt . ' (펀딩 완료일 익일)에 결제될 예정입니다.'
          ]
      ];

      if($ticket)
      {
        $row = [
            0 => [
                'col1' => '후원금',
                'col2' => $order->getFundedAmount() . '원'
            ],
            1 => [
                'col1' => '구매한 티켓',
                'col2' => $this->getOrderCount() . '매'
            ],
            2 => [
                'col1' => '결제예정일',
                'col2' => '목표금액을 달성할 경우 ' . $closingAt . ' (펀딩 완료일 익일)에 결제될 예정입니다.'
            ]
        ];
      }

        return [
            'title' => '아래의 내역으로 결제예약이 완료되었습니다.',
            'thead1' => '후원한 프로젝트',
            'thead2' => $project->title,
            'rows' => $row
        ];
    }

    private function mailDataOnFundingCancel(Project $project, Ticket $ticket, Order $order)
    {
        return [
            'title' => '취소한 내역은 아래와 같습니다.',
            'thead1' => '취소한 프로젝트',
            'thead2' => $project->title,
            'rows' => [
                0 => [
                    'col1' => '취소한 금액',
                    'col2' => $order->total_price . '원'
                ],
                1 => [
                    'col1' => '취소한 티켓',
                    'col2' => $order->count * $ticket->real_ticket_count . '매'
                ]
            ]
        ];
    }

    private function mailDataOnTicketing(Project $project, Ticket $ticket)
    {
      $row = [
          0 => [
              'col1' => '예매완료',
              'col2' => ''
          ]
        ];

      if($ticket)
      {
        $showDate = date('Y.m.d H:i', strtotime($ticket->show_date));

        $row = [
            0 => [
                'col1' => '공연 일시',
                'col2' => $showDate
            ],
            1 => [
                'col1' => '매수',
                'col2' => $this->getOrderCount() . '매'
            ]
          ];
      }


      return [
          'title' => '구매하신 내역은 다음과 같습니다.',
          'thead1' => '구매한 공연',
          'thead2' => $project->title,
          'rows' => $row
      ];
    }

    private function mailDataOnTicketRefund(Project $project, Ticket $ticket, Order $order)
    {
        $deliveryDate = date('Y.m.d H:i', strtotime($ticket->delivery_date));

        return [
            'title' => '환불하신 내역은 다음과 같습니다.',
            'thead1' => '환불한 공연',
            'thead2' => $project->title,
            'rows' => [
                0 => [
                    'col1' => '공연 일시',
                    'col2' => $deliveryDate
                ],
                1 => [
                    'col1' => '매수',
                    'col2' => $order->count . '매'
                ],
                2 => [
                    'col1' => '환불 수수료',
                    'col2' => '결제금액의 10% (공연 8일 전 ~ 2일 전 환불했을 경우 발생)'
                ]
            ]
        ];
    }

    public function testWithMail()
    {
        \Illuminate\Support\Facades\Mail::send('emails.test', ['data' => 'fuckyou'], function ($m) {
            $m->from('contact@crowdticket.kr', '안뇽 나야');
            $m->to('mhdjang@gmail.com', 'wtf')->subject('제목?');
        });
    }

    private function getOrderUnitPrice()
    {
        return (int)Input::get('request_price');
    }

    private function getOrderCount()
    {
        return (int)Input::get('ticket_count');
    }

    private function getDiscountValue()
    {
      $discountValue = 0;
      $discountId = Input::get('discountId');
      if($discountId)
      {
        $discount = Discount::findOrFail($discountId);
        if($discount)
        {
          $discountValue = $discount->percent_value;
        }
      }

      return $discountValue;
    }

    private function getTicketOrderCount($ticket)
    {
      if(!$ticket)
      {
        return 0;
      }

      return $ticket->real_ticket_count * $this->getOrderCount();
    }

    private function getOrderPrice()
    {
      $projectId = \Input::get('project_id');
      $project = Project::findOrFail($projectId);

      $totalOrderPrice = 0;
      $ticketPrice = $this->getOrderUnitPrice() * $this->getOrderCount();
      //할인적용
      $percent_value = $this->getDiscountValue();
      $percent_value = $percent_value * $this->getOrderCount();

      //굿즈 총 가격
      $goodsTotalPrice = $this->getGoodsTotalPrice($project->goods);
      //궂즈에 붙은 티켓 할인 가격
      $goodsTotalTicketDiscountPrice = $this->getGoodsTotalTicketDiscountPrice($project->goods);

      // $discountValue = $ticketPrice * ($percent_value/100);
      $discountValue = $percent_value;
      
      //티켓 가격 - 할인이 적용된 가격
      $ticketTotalPrice = $ticketPrice - $discountValue;

      //티켓 가격 - 굿즈 티켓 할인 가격
      $ticketTotalPrice = $ticketTotalPrice - $goodsTotalTicketDiscountPrice;

      //최종 가격에서 후원가를 더한다.
      //후원정보 추가
      $supportPrice = Input::get('supportPrice');
      if(!$supportPrice)
      {
        $supportPrice = 0;
      }

      //최종적으로 티켓 가격이 0보다 작으면 0(할인 다 되서)
      if($ticketTotalPrice < 0)
      {
        $ticketTotalPrice = 0;
      }

      $totalOrderPrice = $ticketTotalPrice + $goodsTotalPrice + $supportPrice;

      if($totalOrderPrice < 0)
      {
        $totalOrderPrice = 0;
      }

      return (int)$totalOrderPrice;
    }

    private function getGoodsTotalPrice($goodsList)
    {
      $goodsTotalPrice = 0;
      foreach($goodsList as $goods)
      {
        $goodsCountName = 'goods_count'.$goods->id;

        $goodsCount = \Input::get($goodsCountName);

        if($goodsCount > 0)
        {
          $goodsTotalPrice += ($goods->price * $goodsCount);
        }
      }

      return $goodsTotalPrice;
    }

    private function getGoodsTotalTicketDiscountPrice($goodsList)
    {
      $goodsTotalTicketDiscountPrice = 0;
      foreach($goodsList as $goods)
      {
        $goodsCountName = 'goods_count'.$goods->id;

        $goodsCount = \Input::get($goodsCountName);

        if($goodsCount > 0)
        {
          $goodsTotalTicketDiscountPrice += ($goods->ticket_discount * $goodsCount);
        }
      }

      return $goodsTotalTicketDiscountPrice;
    }
    /*
    private function getOrderPrice()
    {
        return $this->getOrderUnitPrice() * $this->getOrderCount();
    }
    */

    private function getTotalPrice($ticket)
    {
      //예전 총구매량 구하는 함수 지금은 getNewTotalPrice 로 바뀜
        if ($this->isPaymentProcess()) {
            $orderPrice = $this->getOrderPrice();
            $count = $this->getOrderCount();
            $commission = $ticket->real_ticket_count * $count * 500;
            return $orderPrice + $commission;
        }
        return 0;
    }

    private function getNewTotalPrice()
    {
      if ($this->isPaymentProcess()) {
          $orderPrice = $this->getOrderPrice();
          $count = $this->getOrderCount();

          $commission = 0;

          if($this->getOrderUnitPrice() > 0)
          {
            if(env('ORDER_TYPE_COMMISION') === (string)Order::ORDER_TYPE_COMMISION_WITHOUT_COMMISION)
            {
              $commission = 0;//수수료 프로모션
            }
            else
            {
              $commission = $count * 500; //수수료 프로모션
            }
          }

          $totalPrice = $orderPrice + $commission;

          return $totalPrice;
      }
      return 0;
    }

    private function getOrderableTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->validateOrder($this->getOrderUnitPrice(), $this->getOrderCount());
        return $ticket;
    }

    private function getFilteredInput(Ticket $ticket, Payment $payment = null)
    {
        $inputs = Input::only(
            [
                'name', 'contact', 'email',
                'postcode', 'address_main', 'address_detail', 'requirement', 'answer'
            ]
        );
        $inputs['price'] = $this->getOrderUnitPrice();
        $inputs['count'] = $this->getOrderCount();
        $inputs['total_price'] = $this->getTotalPrice($ticket);
        //getNewTotalPrice
        $inputs['imp_meta'] = $payment ? $payment->toJson() : '{}';

        //goods 저장한다.
        //$inputs['goods_meta'] = $this->getSelectgoodsJson($goodsSelectArray);

        if ($inputs['postcode'] === null) {
            $inputs['postcode'] = '';
        }
        if ($inputs['address_main'] === null) {
            $inputs['address_main'] = '';
        }
        if ($inputs['address_detail'] === null) {
            $inputs['address_detail'] = '';
        }
        if ($inputs['requirement'] === null) {
            $inputs['requirement'] = '';
        }
        if ($inputs['answer'] === null) {
            $inputs['answer'] = '';
        }
        return $inputs;
    }

    private function getNewFilteredInput($goodsSelectArray, Payment $payment = null)
    {

        $inputs = Input::only(
            [
                'name', 'contact', 'email',
                'postcode', 'address_main', 'address_detail', 'requirement', 'answer', 'order_story'
            ]
        );
        $inputs['price'] = $this->getOrderUnitPrice();
        $inputs['count'] = $this->getOrderCount();

        $inputs['total_price'] = $this->getNewTotalPrice();
        //getNewTotalPrice
        $inputs['imp_meta'] = $payment ? $payment->toJson() : '{}';

        //goods 저장한다.
        $inputs['goods_meta'] = $this->getMakeGoodsMetaData($goodsSelectArray);

        if ($inputs['postcode'] === null) {
            $inputs['postcode'] = '';
        }
        if ($inputs['address_main'] === null) {
            $inputs['address_main'] = '';
        }
        if ($inputs['address_detail'] === null) {
            $inputs['address_detail'] = '';
        }
        if ($inputs['requirement'] === null) {
            $inputs['requirement'] = '';
        }
        if ($inputs['answer'] === null) {
            $inputs['answer'] = '';
        }

        if ($inputs['order_story'] === null) {
            $inputs['order_story'] = '';
        }

        return $inputs;

    }

    public function getMakeGoodsMetaData($goodsSelectArray){
      $goodsArrayCount = count($goodsSelectArray);
      if($goodsArrayCount == 0)
      {
        return '{}';
      }

      /*
      return json_encode([
            'serializer_uid' => self::SERIALIZER_UID,
            'imp_uid' => $this->getImpId(),
            'merchant_uid' => $this->getMerchantId(),
            'customer_uid' => $this->getCustomerId()
        ]);
      */

      $goodsArray = [];
      for($i = 0 ; $i < $goodsArrayCount ; ++$i)
      {
        $goodsInfo['id'] = $goodsSelectArray[$i]['info']->id;
        $goodsInfo['count'] = (int)$goodsSelectArray[$i]['count'];

        array_push($goodsArray, $goodsInfo);
      }


      return json_encode($goodsArray);
      //return $goodsArray;
    }


    public function getOrderForm(Request $request)
    {
      $ticketId = 0;
      $ticket = '';
      $project = '';
      $discount = '';
      if ($request->has('project_id')) {
        $projectId = \Input::get('project_id');
        $project = Project::findOrFail($projectId);
      }

      if(!$project)
      {
        return view('test', ['project'=>'프로젝트를 불러올 수 없습니다.']);
      }

      if ($request->has('ticket_select_id')) {
        $ticketId = \Input::get('ticket_select_id');
        if($ticketId > 0)
        {
          $ticket = $this->getOrderableTicket($ticketId);
          //티켓 정보가 있을때만 할인정보를 가져온다.
          if ($request->has('discount_select_id')) {
            $discountId = \Input::get('discount_select_id');
            $discount = Discount::findOrFail($discountId);
          }
        }
      }

      $goodsSelectJson = $this->getSelectGoodsArray($project->goods);
      $goodsSelectJson = json_encode($goodsSelectJson);

      $supportPrice = '';
      if ($request->has('order_support_price')) {
        $supportPrice = \Input::get('order_support_price');
      }      

      return $this->responseWithNoCache(view('order.form', [
          'order' => null,
          'project' => $project,
          'ticket' => $ticket,
          'ticket_count' => \Input::get('ticket_count'),
          'discount' => $discount,
          'request_price' => $this->getOrderUnitPrice(),
          'ticket_count' => $this->getOrderCount(),
          'goodsList' => $goodsSelectJson,
          'supportPrice' => $supportPrice,
          'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
          //'form_url' => url(sprintf('/tickets/%d/neworders', $ticket->id))
          'form_url' => url(sprintf('/tickets/neworders'))
      ]));

    }

    public function getSelectGoodsArray($goodsList){
      $goodsArray = [];
      //$goodsArray = '';
      foreach($goodsList as $goods)
      {
        $goodsCountName = 'goods_count'.$goods->id;

        $goodsCount = \Input::get($goodsCountName);

        if($goodsCount > 0)
        {
          $goodsInfo['info'] = $goods;
          $goodsInfo['count'] = $goodsCount;

          array_push($goodsArray, $goodsInfo);
        }
      }

      return $goodsArray;
    }

    public function getOrderGoodsArray($goodsList, $orderGoodsList){
      $goodsArray = [];
      //$goodsArray = '';

      if(!$orderGoodsList)
      {
        return $goodsArray;
      }

      $goodsOrders = json_decode($orderGoodsList, true);
      foreach($goodsOrders as $goodsOrder)
      {
        foreach($goodsList as $goods)
        {
          if($goodsOrder['id'] == $goods->id)
          {
            $goodsInfo['info'] = $goods;
            $goodsInfo['count'] = $goodsOrder['count'];

            array_push($goodsArray, $goodsInfo);
            break;
          }
        }
      }

      return $goodsArray;
    }

    public function getOrder(Request $request, $orderId)
    {
        $order = Order::where('id', $orderId)->withTrashed()->first();
        \Auth::user()->checkOwnership($order);

        $project = $order->project()->first();

        $discount = '';
        if($order->discount_id)
        {
          $discount = Discount::findOrFail($order->discount_id);
        }

        $goodsSelectJson = $this->getOrderGoodsArray($project->goods, $order->goods_meta);
        $goodsSelectJson = json_encode($goodsSelectJson);


        $supportPrice = 0;
        if($order->supporter)
        {
          $supportPrice = $order->supporter->price;
        }

        return $this->responseWithNoCache(view('order.form', [
            'order' => $order,
            'project' => $project,
            'ticket' => $order->ticket()->first(),
            'request_price' => $order->price,
            'ticket_count' => $order->count,
            //new form start
            'discount' => $discount,
            'goodsList' => $goodsSelectJson,
            'supportPrice' => $supportPrice,
            'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
            //new form end
            'form_url' => url(sprintf('/orders/%d', $order->id))
        ]));
    }

    private function responseWithNoCache($contents) {
        return response($contents)->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache') //HTTP 1.0
            ->header('Expires','Sat, 01 Jan 1990 00:00:00 GMT'); // Date in the past
    }

    public function getTickets($projectId)
    {
      $project = Project::findOrFail($projectId);
        if ($project->canOrder()) {
            $project->load(['tickets' => function ($query) {
                $query->whereRaw('audiences_limit > audiences_count');
                $query->where('delivery_date', '>', date('Y-m-d H:i:s', time()));
            }]);

            $ticketsCountInfoListJson = $project->getAmountTicketCountInfoList();
            return view('order.tickets', [
                'project' => $project,
                'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
                'selectedTicket' => '',
                'ticketsCountInfoJson' => $ticketsCountInfoListJson
            ]);
        }
        throw new InvalidTicketStateException();
    }

    //리뉴얼 티켓 정보
    public function getRenewalTicketsWithTicketID($projectId, $ticketId)
    {
      $project = Project::findOrFail($projectId);
        if ($project->canOrder()) {
            $ticket = Ticket::findOrFail($ticketId);
            $ticketsCountInfoListJson = $project->getAmountTicketCountInfoList();
            return view('order.tickets', [
                'project' => $project,
                'selectedTicket' => $ticket,
                'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
                'ticketsCountInfoJson' => $ticketsCountInfoListJson
            ]);
        }
        throw new InvalidTicketStateException();
    }

    public function getRenewalTickets($projectId)
    {
      $project = Project::findOrFail($projectId);
        if ($project->canOrder()) {
          $ticketsCountInfoListJson = $project->getAmountTicketCountInfoList();
            return view('order.tickets', [
                'project' => $project,
                'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
                'selectedTicket' => '',
                'ticketsCountInfoJson' => $ticketsCountInfoListJson
            ]);
        }
        throw new InvalidTicketStateException();
    }

    public function deleteOrder($orderId, $stateCancel = Order::ORDER_STATE_CANCEL, $bypass = false)
    {

        $order = Order::where('id', $orderId)->withTrashed()->first();
        Auth::user()->checkOwnership($order);

        if($order->getState() === Order::ORDER_STATE_PAY_ACCOUNT_STANDBY ||
          $order->getState() === Order::ORDER_STATE_PAY_ACCOUNT_SUCCESS){
            $stateCancel = Order::ORDER_STATE_CANCEL_ACCOUNT_PAY;
        }

        if (!$bypass) {
            if (!$order->canCancel()) {
                //throw new PaymentFailedException();
                return ["orderResultType" => "orderResultNotCancel", "orderId" => "", "eMessage" => "이미 지난 이벤트 입니다. 환불이 불가능합니다."];
            }
        }

        $user = $order->user()->first();
        $ticket = $order->ticket()->first();
        $project = $order->project()->first();

        //결제 취소 프로젝트 점검중 해당 프로젝트는 수동 결제 취소 해야함.
        if(isset($project->alias))
        {
          if($project->alias === 'yosang_jeju' ||
          $project->alias === 'midnightconcert')
          {
            return ["orderResultType" => "orderResultNotCancel", "orderId" => "", "eMessage" => "결제 취소 기능 점검중입니다. 취소를 원하시면 070-8819-4308 로 전화 주세요."];
          }
        }


        try {
            if ((int)$order->total_price > 0) {
              $meta = json_decode($order->imp_meta, true);
              if(count($meta) > 0){
                $payment = PaymentService::getPayment($order);
                $payment->cancel();
              }
            }

            DB::beginTransaction();

            $order->setState($stateCancel);
            $order->save();
            //$order->delete();

            if (!$bypass) {
                if ($user->supports_count > 0) {
                    $user->decrement('supports_count');
                }
                if ($user->tickets_count > 0) {
                    $user->decrement('tickets_count');
                }

                $project->funded_amount = $project->getTotalFundingAmount();
                $project->save();

                if($ticket)
                {
                  $ticketCount = $ticket->real_ticket_count * $order->count;
                  if ($project->tickets_count - $ticketCount >= 0) {
                      $project->decrement('tickets_count', $ticketCount);
                  }
                }

                if ($project->supporters_count > 0) {
                    $project->decrement('supporters_count');
                }

                if($ticket)
                {
                  if ($ticket->audiences_count - $order->count >= 0) {
                      $ticket->decrement('audiences_count', $order->count);
                  }
                }
            }

            DB::commit();

            $this->deleteGoodsOrder($order);

            if($project->isEventTypeDefault()){
              $this->sendCencelSMS($project, $order);

              if($stateCancel != Order::ORDER_STATE_PROJECT_CANCEL)
              {
                //예약 취소 이메일은 고객이 직접 취소 했을때만 보내진다.
                $emailTo = $order->email;
                $this->sendCancelMail($emailTo, $project, $order);
              }
            }

            //return redirect()->action('UserController@getUserOrders', [$user->id]);
            return ["orderResultType" => "orderResultCancelSuccess", "orderId" => "", "eMessage" => "취소 되었습니다."];
        } catch (PaymentFailedException $e) {
          return ["orderResultType" => "orderResultErrorCancel", "orderId" => "", "eMessage" => $e->getMessage()];
          /*
            return view('order.error', [
                'message' => $e->getMessage()
            ]);
            */
        }
    }

    public function sendCencelSMS($project, $order)
    {
      $sms = new SmsService();
      $contact = $order->contact;
      $titleLimit = str_limit($project->title, 18, $end = '..');

      if($project->type == 'funding')
      {
        //[크라우드티켓] 사랑해 엄마 ‘결제 총액’원 결제 예약 취소
        $msg = sprintf('%s %s원 결제 예약 취소 완료', $titleLimit, number_format($order->total_price));
      }
      else
      {
        $msg = sprintf('%s 수수료 %s원 총 %s원 취소 완료', $titleLimit, number_format($order->getCancellationFees()), number_format($order->getRefundAmount()));
      }

      $sms->send([$contact], $msg);
    }

    public function getGoodsInfo($projectid, $orderid)
    {
      $project = Project::findOrFail($projectid);
      $order = Order::findOrFail($orderid);

      $goodsSelectJson = $this->getOrderGoodsArray($project->goods, $order->goods_meta);
      $goodsSelectJson = json_encode($goodsSelectJson);

      return $goodsSelectJson;
    }

    private function getSecureOrderById($id)
    {
        $order = Order::findOrFail($id);
        \Auth::user()->checkOwnership($order);
        return $order;
    }
}
