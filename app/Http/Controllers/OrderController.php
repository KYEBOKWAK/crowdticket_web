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
            $emailTo = $order->email;
            if ($project->type === 'funding') {
                $sms->send([$contact], '결제 예약 완뇨');
                Mail::raw('결제 예약 완뇨', function ($message) use ($emailTo) {
                    $message->from('contact@crowdticket.kr', '크라우드티켓');
                    $message->to($emailTo);
                });
            } else {
                $sms->send([$contact], '결제 완뇨');
                Mail::raw('결제 완뇨', function ($message) use ($emailTo) {
                    $message->from('contact@crowdticket.kr', '크라우드티켓');
                    $message->to($emailTo);
                });
            }

            return view('order.complete', [
                'project' => $project,
                'order' => $order
            ]);
        } catch (PaymentFailedException $e) {
            return view('order.error', [
                'message' => $e->getMessage()
            ]);
        }
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

        return view('order.form', [
            'order' => null,
            'project' => $project,
            'ticket' => $ticket,
            'request_price' => $this->getOrderUnitPrice(),
            'ticket_count' => $this->getOrderCount(),
            'form_url' => url(sprintf('/tickets/%d/orders', $ticket->id))
        ]);
    }

    public function getOrder($orderId)
    {
        $order = Order::where('id', $orderId)->withTrashed()->first();
        \Auth::user()->checkOwnership($order);

        return view('order.form', [
            'order' => $order,
            'project' => $order->project()->first(),
            'ticket' => $order->ticket()->first(),
            'request_price' => $order->price,
            'ticket_count' => $order->count,
            'form_url' => url(sprintf('/orders/%d', $order->id))
        ]);
    }

    public function getTickets($projectId)
    {
        $project = Project::findOrFail($projectId);
        if ($project->canOrder()) {
            $project->load(['tickets']);
            return view('order.tickets', [
                'project' => $project,
            ]);
        }
        throw new InvalidTicketStateException();
    }

    public function deleteOrder($orderId)
    {
        return self::cancelOrder($orderId);
    }

    public static function cancelOrder($orderId)
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
            $emailTo = $order->email;
            if ($project->type === 'funding') {
                $sms->send([$contact], '결제 예약 취소 완뇨');
                Mail::raw('결제 예약 취소 완뇨', function ($message) use ($emailTo) {
                    $message->from('contact@crowdticket.kr', '크라우드티켓');
                    $message->to($emailTo);
                });
            } else {
                $sms->send([$contact], '결제 취소 완뇨');
                Mail::raw('결제 취소 완뇨', function ($message) use ($emailTo) {
                    $message->from('contact@crowdticket.kr', '크라우드티켓');
                    $message->to($emailTo);
                });
            }

            return redirect()->action('UserController@getUserOrders', [$user->id]);
        } catch (PaymentFailedException $e) {
            return view('order.error', [
                'message' => $e->getMessage()
            ]);
        }
    }

}
