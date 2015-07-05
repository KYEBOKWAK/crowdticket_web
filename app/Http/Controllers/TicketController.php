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
		
	}
	
	public function deleteTicket($id) {
		
	}

}
