<?php namespace App\Http\Controllers;

use App\Models\News as News;
use App\Models\Project as Project;

class NewsController extends Controller {
	
	public function createNews($projectId) {
		$project = Project::findOrFail($projectId);
		
		\Auth::user()->checkOwnership($project);
		
		$news = new News(\Input::all());
		$news->project()->associate($project);
		$news->save();
		
		$project->increment('news_count');
		
		return $news;
	}
	
	public function getCreateForm($projectId) {
		$project = Project::findOrFail($projectId);
		
		\Auth::user()->checkOwnership($project);
		
		return view('project.news.form', [
			'project' => $project
		]);
	}
	
	public function deleteNews($id) {
		$news = News::findOrFail($id);
		$project = $news->project()->first();
		
		\Auth::user()->checkOwnership($project);
		
		$news->delete();
		
		$project->decrement('news_count');
	}

}
