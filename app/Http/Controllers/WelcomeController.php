<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	public function index() {
		return view('welcome', [
			'projects' => \App\Models\Project::where('state', 4)->get()
		]);
	}

}
