<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;
use App\Models\Project as Project;

class AdminController extends Controller {

	public function getDashboard() {
		return view('admin.home', [
		
			'blueprints' => Blueprint::orderBy('id', 'desc')->get()->load('user'),
			
			/*'projects' => Project::where('submitted', '=', true)->get()*/
			
		]);
	}
	
	public function approveBlueprint($id) {
		$blueprint = Blueprint::find($id);
		$blueprint->approve();
		
		return redirect('/admin/');
	}
	
	public function rejectProject($id) {
		$project = Project::find($id);
		$project->reject();
		
		return redirect('/admin/');
	}
	
	public function approveProject($id) {
		$project = Project::find($id);
		$project->approve();
		
		return redirect('/admin/');
	}

}
