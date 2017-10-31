<?php namespace App\Http\Controllers;

class WelcomeController extends Controller
{

    public function index()
    {
        $now = date('Y-m-d H:i:s');

        $total_suppoter = 0;
        $total_view = 0;
        $total_amount = 0;

        $minExposedNum = 6;
        $projects = \App\Models\Project::where('state', 4)
            ->where('funding_closing_at', '>', $now)
            ->orderBy('id', 'desc')
            ->take($minExposedNum)->get();

        $lack = $minExposedNum - count($projects);
        if ($lack > 0) {
            $additional = \App\Models\Project::where('state', 4)
                ->where('funding_closing_at', '<', $now)
                ->orderBy('id', 'desc')
                ->take($lack)->get();

            $projects = $projects->merge($additional);
        }

        $total_suppoter = \App\Models\Project::where('supporters_count', '<>', 0)->sum('supporters_count');
        $total_view = \App\Models\Project::where('view_count', '<>', 0)->sum('view_count');
        $total_amount = \App\Models\Project::where('funded_amount', '<>', 0)->sum('funded_amount');

        return view('welcome', [
            'projects' => $projects,
            'total_suppoter' => $total_suppoter,
            'total_view' => $total_view,
            'total_amount' => $total_amount
        ]);
    }

}
