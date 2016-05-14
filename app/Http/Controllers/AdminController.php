<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;
use App\Models\Project as Project;
use App\Models\Order as Order;
use App\Models\Supporter as Supporter;

class AdminController extends Controller
{

    public function getDashboard()
    {
        return view('admin.home', [

            'blueprints' => Blueprint::orderBy('id', 'desc')->get()->load('user'),

            'investigation_projects' => Project::where('state', '=', Project::STATE_UNDER_INVESTIGATION)->get(),

            'approved_projects' => Project::where('state', '=', Project::STATE_APPROVED)->get()

        ]);
    }

    public function approveBlueprint($id)
    {
        $blueprint = Blueprint::find($id);
        $blueprint->approve();

        return redirect('/admin/');
    }

    public function rejectProject($id)
    {
        $project = Project::find($id);
        $project->reject();

        return redirect('/admin/');
    }

    public function approveProject($id)
    {
        $project = Project::find($id);
        $project->approve();

        return redirect('/admin/');
    }

    public function getOrders($id)
    {
        $project = Project::find($id);
        return view('admin.orders', [
            'project' => $project,
            'tickets' => $project->tickets()->with(['orders' => function ($query) {
                $query->withTrashed();
            }, 'orders.user'])->get()
        ]);
    }

    public function approveOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $user = $order->user()->first();
        $ticket = $order->ticket()->first();
        $project = $order->project()->first();

        \DB::beginTransaction();

        $supporter = new Supporter;
        $supporter->project()->associate($project);
        $supporter->ticket()->associate($ticket);
        $supporter->user()->associate($user);
        $supporter->save();

        $order->confirmed = true;
        $order->save();

        $ticketCount = $ticket->real_ticket_count * $order->count;
        $project->increment('funded_amount', $order->count * $order->price);
        $project->increment('tickets_count', $ticketCount);
        $project->increment('supporters_count');
        $ticket->increment('audiences_count', $order->count);

        \DB::commit();

        return redirect()->back();
    }

}
