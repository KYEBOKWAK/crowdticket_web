<?php namespace App\Http\Controllers;

use App\Models\Comment as Comment;
use App\Models\Project as Project;

class CommentController extends Controller {
	
	public function createComment($entityName, $entityId) {
		$entity;
		if ($entityName === 'projects') {
			$entity = Project::findOrFail($entityId);
		} elseif ($entityName === 'comments') {
			$entity = Comment::findOrFail($entityId);
		} else {
			return;
		}
		
		$comment = new Comment(\Input::all());
		$comment->user()->associate(\Auth::user());
		$entity->comments()->save($comment);
		
		if ($entityName === 'projects') {
			$entity->increment('comments_count');
		}
		
		return \Redirect::back();
	}

}
