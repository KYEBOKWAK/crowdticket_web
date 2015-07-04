<?php namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\Blueprint as Blueprint;
use App\Models\Category as Category;
use App\Models\City as City;

class ProjectController extends Controller {
	
	public function updateProject($id) {
		$project = $this->getProjectById($id);
		
		\Auth::user()->checkOwnership($project);
		
		$project->update(\Input::all());
		$project->save();
		return $project;
	}
	
	public function getUpdateFormById($id) {
		$project = $this->getProjectById($id);
		return $this->getUpdateForm($project);
	} 
	
	public function getUpdateFormByCode($code) {
		$project = $this->getProjectByBlueprintCode($code);
		return $this->getUpdateForm($project);
	}
	
	private function getUpdateForm($project) {
		\Auth::user()->checkOwnership($project);
		
		$project->load('tickets');
		return view('project.form', [
			'project' => $project,
			'categories' => Category::orderBy('id')->get(),
			'cities' => City::orderBy('id')->get()
		]);
	}
	
	public function getProjects() {
		return Project::all();
	}
	
	public function getProjectById($id) {
		return Project::findOrFail($id);
	}
	
	public function getProjectByAlias($alias) {
		return Project::where('alias', '=', $alias)->firstOrFail();
	}
	
	public function approveProject($id) {
		$project = $this->getProjectById($id);
		$project->approve();
		// return something
	}
	
	private function createProject() {
		$project = new Project(\Input::all());
		$project->user()->associate(\Auth::user());
		$project->save();
		return $project;
	}
	
	private function getProjectByBlueprintCode($code) {
		$blueprint = Blueprint::findByCode($code);
		
		\Auth::user()->checkOwnership($blueprint);
		
		if ($blueprint->hasProjectCreated()) {
			return $blueprint->project()->first();
		} else {
			$project = $this->createProject();
			$blueprint->project()->associate($project);
			$blueprint->save();
			return $project;
		}
	}

}
