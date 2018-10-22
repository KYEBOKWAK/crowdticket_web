<?php namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\Channel as Channel;
//use App\Models\Categories_channel as Categories_channel;
use Illuminate\Http\Request as Request;

class ChannelController extends Controller
{

    public function createChannel(Request $request, $projectId)
    {
      //UserController 에 save코드 있음.
      /*
        $project = Project::findOrFail(227);

        \Auth::user()->checkOwnership($project);


        for($i = 0 ; $i < 4 ; $i++)
        {
          $channel = new Channel();

          $category = Categories_channel::findOrFail(1);
          $channel->categories_channel()->associate($category);
          $channel->user()->associate($project->user);
          $channel->setAttribute('url', 'aaagg'.$i);
          //$channel->setAttribute('category_channel_id', 2);
          $channel->save();
        }
        */

/*
        //$channel = new Channel(\Input::all());
        $channel = new Channel();

        $category = Categories_channel::findOrFail(1);
        $channel->categories_channel()->associate($category);
        $channel->user()->associate($project->user);
        //$channel->setAttribute('url', 'aaagg');
        //$channel->setAttribute('category_channel_id', 2);
        $channel->save();
*/
        //return $channel;
        return '';
    }

    public function deleteChannel($id)
    {
      $channel = Channel::findOrFail($id);
      //$project = $channel->project()->firstOrFail();

      \Auth::user()->checkOwnership($channel);

      $channel->delete();

      return $channel;
    }
}
