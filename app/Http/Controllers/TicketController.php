<?php namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\Ticket as Ticket;

class TicketController extends Controller
{

    public function createTicket($projectId)
    {
        $project = Project::findOrFail($projectId);

        \Auth::user()->checkOwnership($project);

        $ticket = new Ticket(\Input::all());
        $ticket->project()->associate($project);
        $ticket->save();

        if ($project->type === 'sale') {
            $this->updateProjectPerformanceDate($project, $ticket);
        }

        return $ticket;
    }

    private function updateProjectPerformanceDate($project)
    {
        $tickets = $project->tickets()->orderBy('delivery_date', 'asc')->get();
        $ticketCount = count($tickets);
        if ($ticketCount > 0) {
            $openTicket = $tickets[0];
            $closeTicket = $tickets[$ticketCount - 1];
            $project->performance_opening_at = $openTicket->delivery_date;
            $project->performance_closing_at = $closeTicket->delivery_date;
            $project->save();
        }
    }

    public function updateTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $project = $ticket->project()->firstOrFail();

        \Auth::user()->checkOwnership($project);

        $ticket->update(\Input::all());
        $ticket->save();

        if ($project->type === 'sale') {
            $this->updateProjectPerformanceDate($project, $ticket);
        }

        return $ticket;
    }

    public function deleteTicket($id)
    {
        $ticket = Ticket::findOrFail($id);
        $project = $ticket->project()->firstOrFail();

        \Auth::user()->checkOwnership($project);

        $ticket->delete();

        if ($project->type === 'sale') {
            $this->updateProjectPerformanceDate($project, $ticket);
        }
    }

}
