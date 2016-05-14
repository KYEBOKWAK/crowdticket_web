<?php namespace App\Http\Controllers;

use App\Models\News as News;
use App\Models\Project as Project;

class NewsController extends Controller
{

    public function createNews($projectId)
    {
        $project = Project::findOrFail($projectId);

        \Auth::user()->checkOwnership($project);

        $news = new News(\Input::all());
        $news->project()->associate($project);
        $news->save();

        $project->increment('news_count');

        return $news;
    }

    public function updateNews($id)
    {
        $news = News::findOrFail($id);
        $project = $news->project()->first();

        \Auth::user()->checkOwnership($project);

        $news->update(\Input::all());
        $news->save();

        return $news;
    }

    public function getCreateForm($projectId)
    {
        $project = Project::findOrFail($projectId);

        \Auth::user()->checkOwnership($project);

        return view('project.news.form', [
            'ajax_url' => '/projects/' . $projectId . '/news',
            'project' => $project,
            'news' => null
        ]);
    }

    public function getUpdateForm($id)
    {
        $news = News::findOrFail($id);
        $project = $news->project()->first();

        \Auth::user()->checkOwnership($project);

        return view('project.news.form', [
            'ajax_url' => '/news/' . $id,
            'project' => $project,
            'news' => $news
        ]);
    }

    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        $project = $news->project()->first();

        \Auth::user()->checkOwnership($project);

        $news->delete();

        $project->decrement('news_count');
    }

}
