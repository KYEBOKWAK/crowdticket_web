<?php namespace App\Http\Controllers;

use App\Models\Order as Order;
use App\Models\Ticket as Ticket;
use App\Models\Project as Project;
use App\Models\Supporter as Supporter;

class OrderController extends Controller {
	
	public function createOrder($ticketId) {
		$ticket = Ticket::findOrFail($ticketId);
		$project = $ticket->project()->first();
		if (!\Auth::check() || $project->state !== Project::STATE_APPROVED) {
			throw new \App\Exceptions\InvalidTicketStateException;
		}
		
		$dummy = [];
		$dummy['address'] = 'dummy_address';
		$dummy['contact'] = '01000000000';
		
		$user = \Auth::user();
		
		\DB::beginTransaction();
		
		$order = new Order($dummy);
		$order->project()->associate($project);
		$order->ticket()->associate($ticket);
		$order->user()->associate($user);
		$order->save();
		
		$supporter = new Supporter;
		$supporter->project()->associate($project);
		$supporter->user()->associate($user);
		
		$user->increment('supports_count');
		$user->increment('tickets_count');
		$project->increment('supporters_count');
		$ticket->increment('audiences_count');
		
		\DB::commit();
		
		return $order;
	} 
	
	public function getProjectOrders($projectId) {
		$project = Project::findOrFail($projectId);
		\Auth::user()->checkOwnership($project);
		return $project->orders()->get();
	}

}
