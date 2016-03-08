<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	public function index() {
		$now = date('Y-m-d H:i:s');
		
		return view('welcome', [
			'projects' => \App\Models\Project::where('state', 4)
					->where('funding_closing_at', '>', $now)
					->orderBy('id', 'desc')
					->take(6)->get()
		]);
	}

}
