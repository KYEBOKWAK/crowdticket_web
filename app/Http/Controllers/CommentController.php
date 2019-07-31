<?php namespace App\Http\Controllers;

use App\Models\Comment as Comment;
use App\Models\Project as Project;
use App\Models\Meetup as Meetup;

use Illuminate\Http\Request as Request;

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
        } else if($entityName ==='overcount') {
            $entity = Project::findOrFail($entityId);
        } else if($entityName ==='mannayo') {
            $entity = Meetup::findOrFail($entityId);
        } else if($entityName ==='mannayocommentscomment') {
            $entity = Comment::findOrFail($entityId);
        } 
        else {
            return;
        }

        $comment = new Comment(\Input::all());
        $comment->user()->associate(\Auth::user());
        $entity->comments()->save($comment);

        if ($entityName === 'projects' ||
            $entityName === 'tickets' ||
            $entityName === 'mannayo' ||
            $entityName === 'overcount') {
            $entity->increment('comments_count');
        }

        if ($entityName === 'mannayocommentscomment'){
          $meetup_id = \Input::get('meetup_id');
          //\Log::info("meetup id:".$meetup_id);
          $meetup = Meetup::find((int)$meetup_id);
          if($meetup)
          {
            $meetup->increment('comments_count');
          }
        }

        if($entityName === 'tickets'){
          return \Redirect::action('OrderController@completecomment', ['id' => $entityId]);
        }
        else if($entityName === 'overcount'){
          //return \Redirect::action('OrderController@completecomment', ['id' => $entityId]);
          return 'success';
        }
        else if($entityName === 'mannayo'){
          //return 'success';
          return ['state' => 'success', 'meetup_comment' => $comment, 'entityname' => $entityName, 'comments_count' => $entity->comments_count];
        }
        else if($entityName === 'mannayocommentscomment'){
          return ['state' => 'success', 'meetup_comment' => $comment, 'entityname' => $entityName, 'comments_count' => $meetup->comments_count, 'commentscomment_parent' => \Input::get('commentscomment_parent'), 'commentscomment_button_id' => \Input::get('commentscomment_button_id')];
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
        //\Log::info("count : ".$comment->comments()->count());
      }

      $comment->delete();

      return ['state' => 'success', 'comment_id' => $commentId];
    }

    public function deleteMeetupComment(Request $request)
    {
      $comment_id = $request->comment_id;
      $meetup_id = (int)$request->meetup_id;

      $comment = Comment::findOrFail($comment_id);

      $user = \Auth::user();

      if(!$user->isOwnerOf($comment))
      {
        return false;
      }

      $meetup = Meetup::find($meetup_id);
      if(!$meetup)
      {
        return ['state' => 'error', 'message' => '만나요 정보가 없습니다'];
      }
      
      if($meetup->comments_count > 0)
      {
        $meetup->decrement('comments_count');
      }
      
      //코멘트의 코멘트가 있다면 전부 삭제해준다.
      if($comment->comments())
      {
        $commentCommentsCount = $comment->comments()->count();
        
        if($meetup->comments_count - $commentCommentsCount >= 0)
        {
          $meetup->decrement('comments_count', $commentCommentsCount);
        }
        else{
          $meetup->comments_count = 0;
          $meetup->save();
        }

        $comment->comments()->delete();
      }

      $comment->delete();

      return ['state' => 'success', 'comment_id' => $comment_id, 'comments_count' => $meetup->comments_count];
    }
}
