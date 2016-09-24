<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;
use App\Models\Project as Project;

class AdminController extends Controller
{

    public function getDashboard()
    {
        return view('admin.home', [

            'blueprints' => Blueprint::orderBy('id', 'desc')->get()->load('user'),

            'investigation_projects' => Project::where('state', '=', Project::STATE_UNDER_INVESTIGATION)->get(),

            'funding_projects' => $this->getFailedFundingProjects()

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
        return view('project.orders', [
            'project' => $project,
            'tickets' => $project->tickets()->with(['orders' => function ($query) {
                $query->withTrashed();
            }, 'orders.user'])->get()
        ]);
    }

    public function cancelFundingProjectOrders($id)
    {
        $project = Project::find($id);
        if ($project->type === 'funding') {
            $orders = $project->orders();
            foreach ($orders as $order) {
                if ($order->canCancel()) {
                    OrderController::deleteOrder($order->id);
                }
            }
        }
    }

    private function getFailedFundingProjects()
    {
        return Project::where('type', 'funding')
            ->where('funding_closing_at', '<', date('Y-m-d H:i:s', time()))
            ->where('funded_amount', '>', 0)
            ->whereRaw('funded_amount < pledged_amount')
            ->get();
    }

}
