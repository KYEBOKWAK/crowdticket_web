<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {
		return view('welcome', [
			'projects' => \App\Models\Project::where('state', 4)->get()
		]);
	}

}
