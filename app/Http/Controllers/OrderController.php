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
		
		$order = new Order($inputs);
		$order->project()->associate($this->project);
		$order->ticket()->associate($this->ticket);
		$order->user()->associate($this->user);
		$order->save();
		
		return view('order.complete', [
			'project' => $this->project,
			'order' => $order
		]);
	} 
	
	public function getOrderForm($ticketId) {
		$this->initOrder($ticketId);
		
		return view('order.form', [
			'project' => $this->project,
			'ticket' => $this->ticket,
			'price' => $this->price,
			'ticket_count' => $this->ticketCount
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
		if ($project->state !== Project::STATE_APPROVED) {
			throw new \App\Exceptions\InvalidTicketStateException;
        }
		
		$now = strtotime('now');
		$end = $project->type === 'funding' ? $project->funding_closing_at : $project->performance_opening_at;
		$end = strtotime($end);
		if ($end < $now) {
			throw new \App\Exceptions\InvalidTicketStateException;
		}
	}
	
	public function approveOrder($orderId) {
		\DB::beginTransaction();
		
		$order = Order::findOrFail($orderId);
		$user = $order->ticket()->first();
		$ticket = $order->ticket()->first();
		$project = $order->ticket()->first();
		
		// check duplicate supporter?
		$supporter = new Supporter;
		$supporter->project()->associate($project);
		$supporter->user()->associate($user);
		$supporter->save();
		
		$user->increment(['supports_count', 'tickets_count']);
		$project->increment('supporters_count');
		$ticket->increment('audiences_count');
		
		\DB::commit();
		
		return "success";
	}
	
	public function deleteOrder($orderId) {
		\DB::beginTransaction();
		
		$order = Order::findOrFail($orderId);
		$user = $order->ticket()->first();
		$ticket = $order->ticket()->first();
		$project = $order->ticket()->first();
		
		// remove supporter
		
		$user->decrement(['supports_count', 'tickets_count']);
		$project->decrement('supporters_count');
		$ticket->decrement('audiences_count');
		
		\DB::commit();
		
		return "success";
	}

}
