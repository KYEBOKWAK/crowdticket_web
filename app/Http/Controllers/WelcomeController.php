<?php namespace App\Http\Controllers;

use App\Models\Maincarousel as Maincarousel;

class WelcomeController extends Controller
{

    public function index()
    {
        $now = date('Y-m-d H:i:s');

        $total_suppoter = 0;
        $total_view = 0;
        $total_amount = 0;
//whereNotIn('order_number', [0])->orderBy('order_number')->get()
        $minExposedNum = 8;
        /*
        $projects = \App\Models\Project::where('state', 4)
            ->where('funding_closing_at', '>', $now)
            ->orderBy('id', 'desc')
            ->take($minExposedNum)->get();
        */
        $projects = \App\Models\Project::whereNotIn('project_order_number', [0])
            ->orderBy('project_order_number')
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

        //maincarousel
        $main_carousel = Maincarousel::orderby('id')->get();
        //$main_carousel = Maincarousel::where('id', '=', 1)->get();

        return view('welcome_new', [
            'projects' => $projects,
            'total_suppoter' => number_format($total_suppoter),
            'total_view' => number_format($total_view),
            'total_amount' => number_format($total_amount),
            'main_carousels' => $main_carousel
        ]);

        /*
        return view('welcome', [
            'projects' => $projects,
            'total_suppoter' => number_format($total_suppoter),
            'total_view' => number_format($total_view),
            'total_amount' => number_format($total_amount)
        ]);
        */
    }

}
