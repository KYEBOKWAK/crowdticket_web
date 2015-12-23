<?php namespace App\Http\Controllers;

use App\Models\Order as Order;
use App\Models\Ticket as Ticket;
use App\Models\Project as Project;
use App\Models\Supporter as Supporter;

class OrderController extends Controller {
	
	public function createOrder($ticketId) {
		$this->initOrder($ticketId);
		
		$inputs = \Input::only(['contact', 'account_name', 'name', 'email', 'postcode', 'address_main', 'address_detail', 'requirement', 'refund_name', 'refund_bank', 'refund_account']);
		$inputs['count'] = $this->ticketCount;
		$inputs['price'] = $this->price;
		
		\DB::beginTransaction();
		
		$order = new Order($inputs);
		$order->project()->associate($this->project);
		$order->ticket()->associate($this->ticket);
		$order->user()->associate($this->user);
		$order->save();
		
		$this->user->increment('supports_count');
		$this->user->increment('tickets_count');
		
		\DB::commit();
		
		return view('order.complete', [
			'project' => $this->project,
			'order' => $order
		]);
	} 
	
	public function getOrderForm($ticketId) {
		$this->initOrder($ticketId);
		
		return view('order.form', [
			'order' => null,
			'project' => $this->project,
			'ticket' => $this->ticket,
			'price' => $this->price,
			'ticket_count' => $this->ticketCount
		]);
	}
	
	public function getOrder($orderId) {
		$order = Order::where('id', $orderId)->withTrashed()->first();
		\Auth::user()->checkOwnership($order);
		
		return view('order.form', [
			'order' => $order,
			'project' => $order->project()->first(),
			'ticket' => $order->ticket()->first(),
			'price' => $order->price * $order->count,
			'ticket_count' => $order->count
		]);
	}
	
	public function getTickets($projectId) {
		$project = Project::findOrFail($projectId);
		$this->validateProject($project);
		$project->load(['tickets']);
		
		return view('order.tickets', [
			'project' => $project,
		]);
	}
	
	private function initOrder($ticketId) {
		$this->injectOrderInfos($ticketId);
		$this->validateState();
	}
	
	private function injectOrderInfos($ticketId) {
		$this->user = \Auth::user();
		$this->ticket = Ticket::findOrFail($ticketId);
		$this->project = $this->ticket->project()->first();
	}
	
	private function validateState() {
		$this->validateUser($this->user);
		$this->validateTicket($this->project, $this->ticket);
		$this->validateProject($this->project);
	}
	
	private function validateUser($user) {
		// user has unprocessed order
	}
	
	private function validateTicket($project, $ticket) {
		$requestPrice = (int) \Input::get('request_price');
		if ($requestPrice < $ticket->price) {
			throw new \App\Exceptions\InvalidTicketStateException;
		}
		
		$ticketCount = (int) \Input::get('ticket_count');
		if ($ticketCount < 1) {
			throw new \App\Exceptions\InvalidTicketStateException;
		}
		
		if ($ticket->audiences_limit > 0) {
			$remainCount = $ticket->audiences_limit - $ticket->audiences_count;
			if ($ticketCount > $remainCount) {
				throw new \App\Exceptions\InvalidTicketStateException;
			}
		}
		
		$this->price = $requestPrice * $ticketCount;
		$this->ticketCount = $ticketCount;
	}
	
	private function validateProject($project) {
		if ((int) $project->state !== Project::STATE_APPROVED) {
			throw new \App\Exceptions\InvalidTicketStateException;
        }
		
		if ($project->funding_closing_at) {
			if (strtotime('now') > strtotime($project->funding_closing_at)) {
				throw new \App\Exceptions\InvalidTicketStateException;
			}
		} else {
			throw new \App\Exceptions\InvalidTicketStateException;
		}
	}
	
	public function deleteOrder($orderId) {
		$order = Order::where('id', $orderId)->withTrashed()->first();
		\Auth::user()->checkOwnership($order);
		
		$user = $order->user()->first();
		$ticket = $order->ticket()->first();
		$project = $order->project()->first();
		
		\DB::beginTransaction();
		
		$order->delete();
		if ($user->supports_count > 0) {
			$user->decrement('supports_count');
		}
		if ($user->tickets_count > 0) {
			$user->decrement('tickets_count');
		}
		if ($order->confirmed) {
			$supporter = Supporter::where('project_id', $project->id)->where('user_id', $user->id)->where('ticket_id', $ticket->id)->first();
			if ($supporter) {
				$supporter->delete();
			}
			$funded = $order->count * $order->price;
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
		
		\DB::commit();
		
		return redirect()->action('UserController@getUserOrders', [$user->id]);
	}

}
