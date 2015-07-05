<?php namespace App\Http\Controllers;

use App\Models\Ticket as Ticket;
use App\Models\Project as Project;

class TicketController extends Controller {
	
	public function createTicket($projectId) {
		$project = Project::findOrFail($projectId);
		
		\Auth::user()->checkOwnership($project);
		
		$ticket = new Ticket(\Input::all());
		$ticket->project()->associate($project);
		$ticket->save();
		
		return $ticket;
	}
	
	public function updateTicket($id) {
		$ticket = Ticket::findOrFail($id);
		$project = $ticket->project()->firstOrFail();
		
		\Auth::user()->checkOwnership($project);
		
		$ticket->update(\Input::all());
		$ticket->save();
		
		return $ticket;
	}
	
	public function deleteTicket($id) {
		$ticket = Ticket::findOrFail($id);
		$project = $ticket->project()->firstOrFail();
		
		\Auth::user()->checkOwnership($project);
		
		$ticket->delete();
	}

}
