<?php namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\Blueprint as Blueprint;

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
			'project' => $project
		]);
	}
	
	public function getProjects() {
		return Project::all();
	}
	
	public function getProjectById($id) {
		return Project::findOrFail($id);
	}
	
	public function getProjectByName($name) {
		return Project::where('name', '=', $name)->first();
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
		$blueprint = Blueprint::where('code', '=', $code)->first();
		
		\Auth::user()->checkOwnership($blueprint);
		
		if ($blueprint->isProjectCreated()) {
			return $blueprint->project()->first();
		} else {
			$project = $this->createProject();
			$blueprint->project()->associate($project);
			$blueprint->save();
			return $project;
		}
	}

}
