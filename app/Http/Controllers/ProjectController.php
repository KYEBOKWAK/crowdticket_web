<?php namespace App\Http\Controllers;

use Storage as Storage;
use Illuminate\Http\Request as Request;
use App\Models\Project as Project;
use App\Models\Blueprint as Blueprint;
use App\Models\Category as Category;
use App\Models\City as City;
use App\Models\Model as Model;

class ProjectController extends Controller {
	
	public function updateProject(Request $request, $id) {
		$project = $this->getProjectById($id);
		
		\Auth::user()->checkOwnership($project);
		
		$project->update(\Input::all());
		
		if (\Input::has('category_id')) {
			$categoryId = \Input::get('category_id');
			$category = Category::findOrFail($categoryId);
			$project->category()->associate($category);
		}
		
		if (\Input::has('city_id')) {
			$cityId = \Input::get('city_id');
			$city = City::findOrFail($cityId);
			$project->city()->associate($city);
		}
		
		if ($request->file('poster')) {
			$posterUrl = $this->uploadPosterImage($request, $project);
			$project->setAttribute('poster_url', $posterUrl);
		}
		
		$project->save();
		return $project;
	}
	
	private function uploadPosterImage($request, $project) {
		$posterUrlPartial = Model::S3_POSTER_DIRECTORY . $project->id . '.jpg';
		
		Storage::put(
			$posterUrlPartial,
			file_get_contents($request->file('poster')->getRealPath())
		);
		
		return Model::S3_BASE_URL . $posterUrlPartial;
	}
	
	public function uploadStoryImage(Request $request, $id) {
		$project = $this->getProjectById($id);
		
		\Auth::user()->checkOwnership($project);
		
		
		$file = $request->file('image');
		$originalName = $file->getClientOriginalName();
		$hashedName = md5($originalName);
		$storyUrlPartial = Model::S3_STORY_DIRECTORY . $project->id . '/' . $hashedName . '.jpg';
		
		Storage::put(
			$storyUrlPartial,
			file_get_contents($file->getRealPath())
		);
		
		return Model::S3_BASE_URL . $storyUrlPartial;
	}
	
	public function uploadNewsImage(Request $request, $id) {
		$project = $this->getProjectById($id);
		
		\Auth::user()->checkOwnership($project);
		
		$file = $request->file('image');
		$originalName = $file->getClientOriginalName();
		$hashedName = md5($originalName);
		$newsUrlPartial = Model::S3_NEWS_DIRECTORY . $project->id . '/' . $hashedName . '.jpg';
		
		Storage::put(
			$newsUrlPartial,
			file_get_contents($file->getRealPath())
		);
		
		return Model::S3_BASE_URL . $newsUrlPartial;
	}
	
	public function getUpdateFormById($id) {
		$project = Project::findOrFail($id);
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
		$project = Project::findOrFail($id);
        $project = $this->returnApprovedProject($project);
		return view('project.detail', [
			'project' => $project
		]);
	}
	
	public function getProjectByAlias($alias) {
		$project = Project::where('alias', '=', $alias)->firstOrFail();
		return $this->returnApprovedProject($project);
	}

	private function returnApprovedProject($project) {
		if ($project->state !== Project::STATE_APPROVED) {
			if (\Auth::check()) {
				\Auth::user()->checkOwnership($project);
			} else {
				throw new \App\Exceptions\OwnershipException;
			} 
		}
        return $project;
	}
	
	public function validateProjectAlias($alias) {
		$pattern = '/^[a-zA-Z]{1}[a-zA-Z0-9-_]{3,63}/';
		$match = preg_match($pattern, $alias);
		if ($match) {
			$project = Project::where('alias', '=', $alias)->first();
			if (!$project) {
				return "";
			} else {
				return \App::abort(409);
			}
		} else {
			return \App::abort(422);
		}
	}
	
	public function submitProject($id) {
		$project = $this->getProjectById($id);
		
		\Auth::user()->checkOwnership($project);
		
		$project->submit();
		
		return "";
	}
	
	private function createProject() {
		$project = new Project(\Input::all());
		$project->user()->associate(\Auth::user());
		$project->setAttribute('story', ' ');
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
