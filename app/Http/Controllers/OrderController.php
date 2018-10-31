<?php namespace App\Http\Controllers;

use App\Exceptions\InvalidTicketStateException;
use App\Exceptions\PaymentFailedException;
use App\Models\Order as Order;
use App\Models\Project as Project;
use App\Models\Supporter as Supporter;
use App\Models\Ticket as Ticket;
use App\Models\Categories_ticket as Categories_ticket;
use App\Models\Discount as Discount;
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
  //public function createNewOrder(Request $request, $ticketId)
  public function createNewOrder(Request $request)
  {

    $isNewOrderStart = $_COOKIE["isNewOrderStart"];

    $projectId = '';
    $ticketId = '';
    $ticket = '';
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
      return view('test', ['project' => '프로젝트 에러']);
    }

    $project = Project::findOrFail($projectId);

    if($isNewOrderStart == "false")
    {
      return view('order.complete', [
          'project' => $project,
          'order' => '',
          'isComment' => FALSE
      ]);
    }

    $user = Auth::user();

    if($ticketId)
    {
      //티켓 정보가 있을때 저장한다.
      $ticket = $this->getOrderableTicket($ticketId);

      if($this->getAmountTicketWithTicketId($ticketId, $project->orders) <= 0)
      {
        return view('test', ['project' => '수량이 매진되었습니다.']);
      }
    }
    //구매 가능한 수량이 있는지 체크

    $goodsSelectArray = $this->getSelectGoodsArray($project->goods);

    $discount = '';
    if($request->has('discountId'))
    {
      $discount = Discount::findOrFail(\Input::get('discountId'));
      if($discount)
      {
        if($project->getAmountDiscount($discount->id) <= 0)
        {
          return view('test', ['project' => '할인 수량이 매진되었습니다.']);
        }
      }
    }

    try {
      $payment = null;
      if ($this->isPaymentProcess()) {
        $info = $this->buildPaymentNewInfo($user, $project);

        if($info->getAmount() >  0)
        {
          $paymentService = new PaymentService();
          if ($project->type === 'funding') {
              $payment = $paymentService->schedule($info, $project->getFundingOrderConcludeAt());
          } else {
              $payment = $paymentService->rightNow($info);
          }
        }
      }

      DB::beginTransaction();

      $order = new Order($this->getNewFilteredInput($goodsSelectArray, $payment));
      $order->project()->associate($project);
      if($ticket)
      {
        $order->ticket()->associate($ticket);
      }

      $order->user()->associate($user);

      //if($request->has('discountId'))
      if($discount)
      {
        //$discount = Discount::findOrFail(\Input::get('discountId'));
        $order->discount()->associate($discount);
      }

      $order->save();

      $project->increment('funded_amount', $this->getOrderPrice());
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

      $sms = new SmsService();
      $contact = $order->contact;
      $limit = $project->type === 'funding' ? 10 : 14;
      $titleLimit = str_limit($project->title, $limit, $end = '..');
      $priceFormatted = number_format($order->getFundedAmount());
      //$totalRealTicket = $ticket->real_ticket_count * $order->count;
      $totalRealTicket = $this->getOrderCount();

      if($ticket)
      {
        $datetime = date('Y/m/d H:i', strtotime($ticket->show_date));
        $msg = sprintf('%s %s %d매 예매완료', $titleLimit, $datetime, $totalRealTicket);
      }
      else
      {
        $msg = sprintf('%s %d매 예매완료', $titleLimit, $totalRealTicket);
      }

      $sms->send([$contact], $msg);

      $emailTo = $order->email;
      if ($project->type === 'funding') {
        if($ticket)
        {
          $this->sendMail($emailTo, '결제예약이 완료되었습니다 (크라우드티켓).', $this->mailDataOnFunding($project, $ticket, $order));
        }
      } else {
        if($ticket)
        {
          $this->sendMail($emailTo, '티켓 구매가 완료되었습니다 (크라우드티켓).', $this->mailDataOnTicketing($project, $ticket));
        }
      }

      setcookie("isNewOrderStart","false", time()+604800, "/tickets");

      return view('order.complete', [
          'project' => $project,
          'order' => $order,
          'isComment' => FALSE
      ]);
    } catch (PaymentFailedException $e) {
      return view('order.error', [
          'message' => $e->getMessage(),
          //'ticket_id' => $ticket->id,
          'project_id' => $project->id,
          'request_price' => $this->getOrderUnitPrice(),
          'ticket_count' => $this->getOrderCount()
      ]);
    }

    /*
    $isNewOrderStart = $_COOKIE["isNewOrderStart"];

    if($isNewOrderStart == "false")
    {
      $ticketTemp = Ticket::findOrFail($ticketId);
      $project = Project::findOrFail($ticketTemp->project_id);

      return view('order.complete', [
          'project' => $project,
          'order' => '',
          'isComment' => FALSE
      ]);
    }

    //쿠키가 동작 안함.... 재 수정 필요
    $user = Auth::user();
    $ticket = $this->getOrderableTicket($ticketId);
    //구매 가능한 수량이 있는지 체크

    $project = $ticket->project()->first();
    $goodsSelectArray = $this->getSelectGoodsArray($project->goods);

    if($this->getAmountTicketWithTicketId($ticketId, $project->orders) <= 0)
    {
      return view('test', ['project' => '수량이 매진되었습니다.']);
    }

    $discount = '';
    if($request->has('discountId'))
    {
      $discount = Discount::findOrFail(\Input::get('discountId'));
      if($discount)
      {
        if($project->getAmountDiscount($discount->id) <= 0)
        {
          return view('test', ['project' => '할인 수량이 매진되었습니다.']);
        }
      }

    }

    try {
      $payment = null;
      if ($this->isPaymentProcess()) {
        $info = $this->buildPaymentNewInfo($user, $project, $ticket, $goodsSelectArray);

        if($info->getAmount() >  0)
        {
          $paymentService = new PaymentService();
          if ($project->type === 'funding') {
              //$payment = $paymentService->schedule($info, $project->getFundingOrderConcludeAt());
          } else {
              //$payment = $paymentService->rightNow($info);
          }
        }
      }

      DB::beginTransaction();

      $order = new Order($this->getNewFilteredInput($ticket, $goodsSelectArray, $payment));
      $order->project()->associate($project);
      $order->ticket()->associate($ticket);
      $order->user()->associate($user);

      //if($request->has('discountId'))
      if($discount)
      {
        //$discount = Discount::findOrFail(\Input::get('discountId'));
        $order->discount()->associate($discount);
      }

      $order->save();

      $project->increment('funded_amount', $this->getOrderPrice());
      $project->increment('tickets_count', $this->getTicketOrderCount($ticket));
      //$ticket->increment('audiences_count', $this->getOrderCount());
      //$user->increment('tickets_count');

      if($request->has('supportPrice'))
      {
        $supportPrice = Input::get('supportPrice');
        if($supportPrice > 0)
        {
          $supporter = new Supporter;
          $supporter->project()->associate($project);
          $supporter->ticket()->associate($ticket);
          $supporter->user()->associate($user);
          $supporter->price = $supportPrice;
          $supporter->save();

          $order->supporter()->associate($supporter);
          $order->save();
        }
      }

      DB::commit();

      $sms = new SmsService();
      $contact = $order->contact;
      $limit = $project->type === 'funding' ? 10 : 14;
      $titleLimit = str_limit($project->title, $limit, $end = '..');
      $priceFormatted = number_format($order->getFundedAmount());
      //$totalRealTicket = $ticket->real_ticket_count * $order->count;
      $totalRealTicket = $this->getOrderCount();

      $datetime = date('Y/m/d H:i', strtotime($ticket->show_date));
      $msg = sprintf('%s %s %d매 예매완료', $titleLimit, $datetime, $totalRealTicket);
      $sms->send([$contact], $msg);

      $emailTo = $order->email;
      if ($project->type === 'funding') {
          $this->sendMail($emailTo, '결제예약이 완료되었습니다 (크라우드티켓).', $this->mailDataOnFunding($project, $ticket, $order));
      } else {
          $this->sendMail($emailTo, '티켓 구매가 완료되었습니다 (크라우드티켓).', $this->mailDataOnTicketing($project, $ticket));
      }

      setcookie("isNewOrderStart","false", time()+604800, "/tickets");

      return view('order.complete', [
          'project' => $project,
          'order' => $order,
          'isComment' => FALSE
      ]);
    } catch (PaymentFailedException $e) {
      return view('order.error', [
          'message' => $e->getMessage(),
          'ticket_id' => $ticket->id,
          'project_id' => $project->id,
          'request_price' => $this->getOrderUnitPrice(),
          'ticket_count' => $this->getOrderCount()
      ]);
    }
    */
  }

  public function getAmountTicketWithTicketId($ticketID, $orders){
    $ticket = Ticket::findOrFail($ticketID);

    $totalBuyCount = 0;
    foreach($orders as $order){
      if($ticketID == $order->ticket_id)
      {
        $totalBuyCount += $order->count;
      }
    }

    return $ticket->audiences_limit - $totalBuyCount;
  }

    public function completecomment($projectId){
      $project = Project::findOrFail($projectId);
      return view('order.complete', [
          'project' => $project,
          'order' => '',
          'isComment' => TRUE
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

/*
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
*/
    private function sendMail($to, $title, $data)
    {
        Mail::send('emails.test', $data, function ($m) use ($title, $to) {
            $m->from('contact@crowdticket.kr', '크라우드티켓');
            $m->to($to)->subject($title);
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

      //굿즈 총 가격
      $goodsTotalPrice = $this->getGoodsTotalPrice($project->goods);
      //궂즈에 붙은 티켓 할인 가격
      $goodsTotalTicketDiscountPrice = $this->getGoodsTotalTicketDiscountPrice($project->goods);

      $discountValue = $ticketPrice * ($percent_value/100);

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
            $commission = $count * 500;
          }

          $totalPrice = $orderPrice + $commission;

          return $totalPrice;
      }
      return 0;

      /*
        if ($this->isPaymentProcess()) {
            $orderPrice = $this->getOrderPrice();
            $count = $this->getOrderCount();
            $commission = $count * 500;
            return $orderPrice + $commission;
        }
        return 0;
        */
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
                'postcode', 'address_main', 'address_detail', 'requirement', 'answer'
            ]
        );
        $inputs['price'] = $this->getOrderUnitPrice();
        $inputs['count'] = $this->getOrderCount();
        //$inputs['total_price'] = $this->getTotalPrice($ticket);
        //$inputs['total_price'] = $this->getNewTotalPrice($ticket, $goodsSelectArray);
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
        $goodsInfo['count'] = $goodsSelectArray[$i]['count'];

        array_push($goodsArray, $goodsInfo);
      }

      return json_encode($goodsArray);
      //return $goodsArray;
    }


    public function getOrderForm(Request $request)
    {
      //return view('test', ['project'=>\Input::get('project_id')]);

      setcookie("isNewOrderStart","true", time()+604800, "/tickets");

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


      /*
      setcookie("isNewOrderStart","true", time()+604800, "/tickets");
      //티켓ID Count
      $ticketId = 0;

      if ($request->has('ticket_select_id')) {
        $ticketId = \Input::get('ticket_select_id');
      }

      if($ticketId == 0) {
        //에러
        return view('test', ['project' => $request]);
      }

      $ticket = $this->getOrderableTicket($ticketId);
      $project = $ticket->project()->first();

      $goodsSelectJson = $this->getSelectGoodsArray($project->goods);
      $goodsSelectJson = json_encode($goodsSelectJson);

      $discount = '';
      if ($request->has('discount_select_id')) {
        $discountId = \Input::get('discount_select_id');
        $discount = Discount::findOrFail($discountId);
      }

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
          'form_url' => url(sprintf('/tickets/%d/neworders', $ticket->id))
      ]));
      */
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

    public function deleteOrder($orderId, $bypass = false)
    {
      //return view('test', ['project' => $orderId]);

        $order = Order::where('id', $orderId)->withTrashed()->first();
        Auth::user()->checkOwnership($order);

        if (!$bypass) {
            if (!$order->canCancel()) {
                throw new PaymentFailedException();
            }
        }

        $user = $order->user()->first();
        $ticket = $order->ticket()->first();
        $project = $order->project()->first();

        //$meta = json_decode($order->imp_meta, true);

        //return view('test', ['project' => count($meta)]);
        try {
            if ((int)$order->total_price > 0) {
              $meta = json_decode($order->imp_meta, true);
              if(count($meta) > 0){
                $payment = PaymentService::getPayment($order);
                $payment->cancel();
              }
            }

            DB::beginTransaction();

            $order->delete();

            if (!$bypass) {
                if ($user->supports_count > 0) {
                    $user->decrement('supports_count');
                }
                if ($user->tickets_count > 0) {
                    $user->decrement('tickets_count');
                }
                /*
                $supporter = Supporter::where('project_id', $project->id)
                    ->where('user_id', $user->id)
                    //->where('ticket_id', $ticket->id)
                    ->first();
                if ($supporter) {
                    $supporter->delete();
                }
                */
                $funded = $order->getFundedAmount();
                if ($project->funded_amount - $funded >= 0) {
                    $project->decrement('funded_amount', $funded);
                }
                $ticketCount = $ticket->real_ticket_count * $order->count;
                if ($project->tickets_count - $ticketCount >= 0) {
                    $project->decrement('tickets_count', $ticketCount);
                }
                if ($project->supporters_count > 0) {
                    $project->decrement('supporters_count');
                }
                if ($ticket->audiences_count - $order->count >= 0) {
                    $ticket->decrement('audiences_count', $order->count);
                }
            }

            DB::commit();

            $sms = new SmsService();
            $contact = $order->contact;
            $titleLimit = str_limit($project->title, 18, $end = '..');
            $msg = $project->type === 'funding'
                ? sprintf('%s 후원취소', $titleLimit)
                : sprintf('%s 환불완료', $titleLimit);

            $sms->send([$contact], $msg);

            $emailTo = $order->email;
            if ($project->type === 'funding') {
                //$this->sendMail($emailTo, '결제예약이 취소 되었습니다 (크라우드티켓).', $this->mailDataOnFundingCancel($project, $ticket, $order));
            } else {
                //$this->sendMail($emailTo, '결제예약이 완료되었습니다 (크라우드티켓).', $this->mailDataOnTicketRefund($project, $ticket, $order));
            }

            return redirect()->action('UserController@getUserOrders', [$user->id]);
        } catch (PaymentFailedException $e) {
            return view('order.error', [
                'message' => $e->getMessage()
            ]);
        }
    }

}
