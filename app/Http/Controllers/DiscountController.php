<?php namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\Discount as Discount;

class DiscountController extends Controller
{

    public function createDiscount($projectId)
    {
        $project = Project::findOrFail($projectId);

        \Auth::user()->checkOwnership($project);

        $discount = new Discount(\Input::all());
        $discount->project()->associate($project);
        $discount->save();

        //$tickets = $project->tickets()->orderBy('show_date', 'asc')->get();
        //if ($project->type === 'sale') {
            //$this->updateProjectPerformanceDate($project, $ticket);
        //}

        return $discount;
    }
/*
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
*/
    public function updateDiscount($id)
    {
        $discount = Discount::findOrFail($id);
        $project = $discount->project()->firstOrFail();

        \Auth::user()->checkOwnership($project);

        $discount->update(\Input::all());
        $discount->save();

        if ($project->type === 'sale') {
            //$this->updateProjectPerformanceDate($project, $ticket);
        }

        return $discount;
    }

    public function deleteDiscount($id)
    {
        $discount = Discount::findOrFail($id);
        $project = $discount->project()->firstOrFail();

        \Auth::user()->checkOwnership($project);

        $discount->delete();

        /*
        if ($project->type === 'sale') {
            $this->updateProjectPerformanceDate($project, $ticket);
        }
        */
    }

}
