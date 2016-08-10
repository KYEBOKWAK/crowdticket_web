<?php namespace App\Http\Controllers;

use App\Exceptions\InvalidTicketStateException;
use App\Exceptions\PaymentFailedException;
use App\Models\Order as Order;
use App\Models\Project as Project;
use App\Models\Supporter as Supporter;
use App\Models\Ticket as Ticket;
use App\Services\Payment;
use App\Services\PaymentInfo;
use App\Services\PaymentService;
use App\Services\SmsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    public function createOrder($ticketId)
    {
        $user = Auth::user();
        $ticket = $this->getOrderableTicket($ticketId);
        $project = $ticket->project()->first();

        $info = new PaymentInfo();
        $info->withSignature($user->id, $project->id);
        $info->withAmount($this->getTotalPrice($ticket));
        $info->withCardNumber(Input::get('card_number'));
        $info->withExpiry(Input::get('expiry_year'), Input::get('expiry_month'));
        $info->withBirth(Input::get('birth'));
        $info->withPassword(Input::get('card_password'));

        try {
            $paymentService = new PaymentService();
            $payment = null;
            if ($project->type === 'funding') {
                $payment = $paymentService->schedule($info, $project->getFundingOrderConcludeAt());
            } else {
                $payment = $paymentService->rightNow($info);
            }

            DB::beginTransaction();

            $order = new Order($this->getFilteredInput($ticket, $payment));
            $order->project()->associate($project);
            $order->ticket()->associate($ticket);
            $order->user()->associate($user);
            $order->save();

            $project->increment('funded_amount', $this->getOrderPrice());
            $project->increment('tickets_count', $this->getTicketOrderCount($ticket));
            $ticket->increment('audiences_count', $this->getOrderCount());
            $user->increment('tickets_count');

            $supporter = new Supporter;
            $supporter->project()->associate($project);
            $supporter->ticket()->associate($ticket);
            $supporter->user()->associate($user);
            $supporter->save();

            $project->increment('supporters_count');
            $user->increment('supports_count');

            DB::commit();

            $sms = new SmsService();
            $contact = $order->contact;
            $limit = $project->type === 'funding' ? 10 : 14;
            $titleLimit = str_limit($project->title, $limit, $end = '..');
            $priceFormatted = number_format($order->getFundedAmount());
            $totalRealTicket = $ticket->real_ticket_count * $order->count;
            $ticketFormatted = $totalRealTicket > 0 ? sprintf('(티켓 %d매 포함)', $totalRealTicket) : '';
            $datetime = date('Y/m/d H:i', strtotime($ticket->delivery_date));
            $msg = $project->type === 'funding'
                ? sprintf('%s %s원%s 후원완료', $titleLimit, $priceFormatted, $ticketFormatted)
                : sprintf('%s %s %d매 예매완료', $titleLimit, $datetime, $totalRealTicket);
            $sms->send([$contact], $msg);

            $emailTo = $order->email;
            if ($project->type === 'funding') {
                $this->sendMail($emailTo, '결제예약이 완료되었습니다 (크라우드티켓).', $this->mailDataOnFunding($project, $ticket, $order));
            } else {
                $this->sendMail($emailTo, '티켓 구매가 완료되었습니다 (크라우드티켓).', $this->mailDataOnTicketing($project, $ticket));
            }

            return view('order.complete', [
                'project' => $project,
                'order' => $order
            ]);
        } catch (PaymentFailedException $e) {
            return view('order.error', [
                'message' => $e->getMessage(),
                'ticket_id' => $ticket->id,
                'request_price' => $this->getOrderUnitPrice(),
                'ticket_count' => $this->getOrderCount()
            ]);
        }
    }

    private function sendMail($to, $title, $data)
    {
        Mail::send('emails.test', $data, function ($m) use ($title, $to) {
            $m->from('contact@crowdticket.kr', '크라우드티켓');
            $m->to($to)->subject($title);
        });
    }

    private function mailDataOnFunding(Project $project, Ticket $ticket, Order $order)
    {
        return [
            'title' => '아래의 내역으로 결제예약이 완료되었습니다.',
            'thead1' => '후원한 프로젝트',
            'thead2' => $project->title,
            'rows' => [
                0 => [
                    'col1' => '후원금',
                    'col2' => $order->getFundedAmount() . '원'
                ],
                1 => [
                    'col1' => '구매한 티켓',
                    'col2' => $this->getTicketOrderCount($ticket) . '매'
                ],
                2 => [
                    'col1' => '결제예정일',
                    'col2' => '목표금액을 달성할 경우 ' . $project->funding_closing_at . ' (펀딩 완료일 익일)에 결제될 예정입니다.'
                ]
            ]
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
        return [
            'title' => '구매하신 내역은 다음과 같습니다.',
            'thead1' => '구매한 공연',
            'thead2' => $project->title,
            'rows' => [
                0 => [
                    'col1' => '공연 일시',
                    'col2' => $ticket->delivery_date
                ],
                1 => [
                    'col1' => '매수',
                    'col2' => $this->getTicketOrderCount($ticket) . '매'
                ]
            ]
        ];
    }

    private function mailDataOnTicketRefund(Project $project, Ticket $ticket, Order $order)
    {
        return [
            'title' => '환불하신 내역은 다음과 같습니다.',
            'thead1' => '환불한 공연',
            'thead2' => $project->title,
            'rows' => [
                0 => [
                    'col1' => '공연 일시',
                    'col2' => $ticket->delivery_date
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

    private function getTicketOrderCount($ticket)
    {
        return $ticket->real_ticket_count * $this->getOrderCount();
    }

    private function getOrderPrice()
    {
        return $this->getOrderUnitPrice() * $this->getOrderCount();
    }

    private function getTotalPrice($ticket)
    {
        $orderPrice = $this->getOrderPrice();
        $count = $this->getOrderCount();
        $commission = $ticket->real_ticket_count * $count * 500;
        return $orderPrice + $commission;
    }

    private function getOrderableTicket($ticketId)
    {
        $ticket = Ticket::findOrFail($ticketId);
        $ticket->validateOrder($this->getOrderUnitPrice(), $this->getOrderCount());
        return $ticket;
    }

    private function getFilteredInput(Ticket $ticket, Payment $payment)
    {
        $inputs = Input::only(
            [
                'name', 'contact', 'email',
                'postcode', 'address_main', 'address_detail', 'requirement'
            ]
        );
        $inputs['price'] = $this->getOrderUnitPrice();
        $inputs['count'] = $this->getOrderCount();
        $inputs['total_price'] = $this->getTotalPrice($ticket);
        $inputs['imp_meta'] = $payment->toJson();

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
        return $inputs;
    }

    public function getOrderForm($ticketId)
    {
        $ticket = $this->getOrderableTicket($ticketId);
        $project = $ticket->project()->first();

        return $this->responseWithNoCache(view('order.form', [
            'order' => null,
            'project' => $project,
            'ticket' => $ticket,
            'request_price' => $this->getOrderUnitPrice(),
            'ticket_count' => $this->getOrderCount(),
            'form_url' => url(sprintf('/tickets/%d/orders', $ticket->id))
        ]));
    }

    public function getOrder($orderId)
    {
        $order = Order::where('id', $orderId)->withTrashed()->first();
        \Auth::user()->checkOwnership($order);

        return $this->responseWithNoCache(view('order.form', [
            'order' => $order,
            'project' => $order->project()->first(),
            'ticket' => $order->ticket()->first(),
            'request_price' => $order->price,
            'ticket_count' => $order->count,
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
            return view('order.tickets', [
                'project' => $project,
            ]);
        }
        throw new InvalidTicketStateException();
    }

    public function deleteOrder($orderId)
    {
        $order = Order::where('id', $orderId)->withTrashed()->first();
        Auth::user()->checkOwnership($order);

        if (!$order->canCancel()) {
            throw new PaymentFailedException();
        }

        $user = $order->user()->first();
        $ticket = $order->ticket()->first();
        $project = $order->project()->first();

        try {
            $payment = PaymentService::getPayment($order);
            $payment->cancel();

            DB::beginTransaction();

            $order->delete();
            if ($user->supports_count > 0) {
                $user->decrement('supports_count');
            }
            if ($user->tickets_count > 0) {
                $user->decrement('tickets_count');
            }
            $supporter = Supporter::where('project_id', $project->id)
                ->where('user_id', $user->id)
                ->where('ticket_id', $ticket->id)
                ->first();
            if ($supporter) {
                $supporter->delete();
            }
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
                $this->sendMail($emailTo, '결제예약이 취소 되었습니다 (크라우드티켓).', $this->mailDataOnFundingCancel($project, $ticket, $order));
            } else {
                $this->sendMail($emailTo, '결제예약이 완료되었습니다 (크라우드티켓).', $this->mailDataOnTicketRefund($project, $ticket, $order));
            }

            return redirect()->action('UserController@getUserOrders', [$user->id]);
        } catch (PaymentFailedException $e) {
            return view('order.error', [
                'message' => $e->getMessage()
            ]);
        }
    }

}
