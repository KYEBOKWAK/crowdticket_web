<?php namespace App\Http\Controllers;

use App\Models\Comment as Comment;
use App\Models\Project as Project;

class CommentController extends Controller
{

    public function createComment($entityName, $entityId)
    {
      //print("entityName : ".$entityName." entityId : ".$entityId."entityTicketId : ".$entityTicketId);

        $entity;
        if ($entityName === 'projects') {
            $entity = Project::findOrFail($entityId);
        } elseif ($entityName === 'comments') {
            $entity = Comment::findOrFail($entityId);
        } else if($entityName ==='tickets') {
            $entity = Project::findOrFail($entityId);
        }
        else {
            return;
        }

        $comment = new Comment(\Input::all());
        $comment->user()->associate(\Auth::user());
        $entity->comments()->save($comment);

        if ($entityName === 'projects' ||
            $entityName === 'tickets') {
            $entity->increment('comments_count');
        }

        if($entityName === 'tickets'){
          return \Redirect::action('OrderController@completecomment', ['id' => $entityId]);
        }
        else {
          // code...
          return \Redirect::back();
        }
    }

    public function deleteComment($commentId)
    {
      $comment = Comment::findOrFail($commentId);

      $user = \Auth::user();

      if(!$user->isOwnerOf($comment))
      {
        return false;
      }

      //코멘트의 코멘트가 있다면 전부 삭제해준다.
      if($comment->comments())
      {
        $comment->comments()->delete();
      }

      $comment->delete();
    }
}
