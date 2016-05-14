<?php namespace App\Http\Controllers;

class WelcomeController extends Controller
{

    public function index()
    {
        $now = date('Y-m-d H:i:s');

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

        return view('welcome', [
            'projects' => $projects
        ]);
    }

}
