<?php namespace App\Http\Controllers;

use App\Models\Maincarousel as Maincarousel;
use App\Models\Main_thumbnail as Main_thumbnail;
use App\Models\Main_thumb_play_creator as Main_thumb_play_creator;
use App\Models\Meetup_user as Meetup_user;

use App\Models\Alive_user as Alive_user;

use Illuminate\Http\Request as Request;

class WelcomeController extends Controller
{

  public function initialize(Request $request)
  {
    $ga_id = $this->getGAId();
    if($ga_id === '')
    {
      return false;
    }

    $aliveUser = Alive_user::where('ga_user', '=', $ga_id)->first();
    $aliveUsers = null;
    if(!$aliveUser)
    {
      $aliveUsers = new Alive_user();
    }

    if($aliveUsers)
    {
      $aliveUsers->ga_user = $ga_id;
      $aliveUsers->save();
    }
  }

  public function ping(Request $request)
  {
    $ga_id = $this->getGAId();
    if($ga_id === '')
    {
      return false;
    }
    
    $lastAliveUserInfo = Alive_user::orderBy('id', 'desc')->first();

    $aliveUser = Alive_user::where('ga_user', '=', $ga_id)->first();

    if(!isset($aliveUser))
    {
      $aliveUser = null;
      $aliveUser = new Alive_user();
      //$aliveUser->ga_user()

      //id값 셋팅
      if(isset($lastAliveUserInfo))
      {
        $id = (int)$lastAliveUserInfo->id + 1;
        $aliveUser->id = $id;
      }
      else
      {
        $aliveUser->id = 1;
      }
    }

    $aliveUser->ga_user = $ga_id;
    $aliveUser->ping_at = date('Y-m-d H:i:s', time());

    $aliveUser->save();
    
    return $aliveUser;

    /*
    $aliveUser = Alive_user::where('ga_user', '=', $ga_id)->first();
    return $aliveUser;
    if(!isset($aliveUser))
    {
      $aliveUser = null;
      $aliveUser = new Alive_user();
    }

    //return $aliveUser;

    if($aliveUser)
    {
      $aliveUser->ga_user = $ga_id;
      $aliveUser->ping_at = date('Y-m-d H:i:s', time());
      $aliveUser->save();
    }

    return $ga_id;
    */
  }

  public function getGAId()
  {
    $ga_id = '';
    if(isset($_COOKIE['_ga']))
		{
			$ga_id = $_COOKIE['_ga'];

			//$ga_id = str_replace('GA1.1.', '', $ga_id);
    }
    
    return $ga_id;
  }

    public function index()
    {
        $thumbnailProjects = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND);
        //$thumbnailCrowdticketPicProject = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_CROLLING);

        $thumbMagazines = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE);

        $thumbPlayCreators = Main_thumb_play_creator::get();

        ///////meetup start
        $meetups = \DB::table('meetups')->whereNull('deleted_at')
                        ->join('creators', 'meetups.creator_id', '=', 'creators.id')
                        ->select('meetups.id', 'meetups.user_id', 'meetups.creator_id', 
                                'meetups.what', 'meetups.where', 'meetups.meet_count', 'meetups.comments_count',
                                'creators.channel_id', 'creators.title', 'creators.thumbnail_url')
                        ->orderBy('meetups.meet_count', 'desc')->skip(0)->take(4)->get();
        
        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }
        
        foreach($meetups as $meetup)
        {
            $meetup->meetup_users = [];
            $meetup->is_meetup = false;
            if($user)
            {
                $meetup_user_my = Meetup_user::where('meetup_id', $meetup->id)->where('user_id', $user->id)->first();
                if($meetup_user_my)
                {
                    $userMyInfo = $meetup_user_my->user;
                    $userMyProfileURL = $userMyInfo->getPhotoUrl();

                    $meetup_user_my->user_profile_url = $userMyProfileURL;
                    $meetup_user_my->user_name = '나';

                    array_push($meetup->meetup_users, $meetup_user_my);

                    $meetup->is_meetup = true;
                }
            }

            $meetup_users = null;

            if($user)
            {
                $meetup_users = Meetup_user::where('meetup_id', $meetup->id)->where('user_id', '<>', $user->id)->orderBy('id', 'desc')->take(3)->get();
            }
            else
            {
                $meetup_users = Meetup_user::where('meetup_id', $meetup->id)->orderBy('id', 'desc')->take(3)->get();
            }

            foreach($meetup_users as $meetup_user)
            {
                $userInfo = $meetup_user->user;
                //$userProfileURL = $userInfo->getPhotoUrl();
                $userProfileURL = $userInfo->getMannayoPhotoURL($meetup_user->anonymity);

                $meetup_user->user_profile_url = $userProfileURL;
                $meetup_user->user_name = $userInfo->getMannayoUserNickName($meetup_user->anonymity);

                array_push($meetup->meetup_users, $meetup_user);

                if(count($meetup->meetup_users) >= 3)
                {
                    break;
                }
            }
        }
        ///////meetup end

        return view('welcome_new_new', [
          'projects' => $thumbnailProjects,
          'magazines' => $thumbMagazines,
          'playedcreators' => $thumbPlayCreators,
          'meetups' => $meetups
      ]);

/*
        //$thumbnailProjects = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND);
        //$thumbnailCrowdticketPicProject = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_CROLLING);

        //$thumbMagazines = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE);

        //maincarousel
        //$main_carousel = Maincarousel::where('order_number', '>', 0)->orderby('order_number')->get();

        return view('welcome_new_new', [
            'projects' => $thumbnailProjects,
            //'crowdticketPicProjects' => $thumbnailCrowdticketPicProject,
            //'main_carousels' => $main_carousel,
            //'magazines' => $thumbMagazines,
            //'isNotYet' => 'FALSE'
        ]);
*/
    }

    public function getThumbnailProject($thumbnailType)
    {
      $orderInfoList = '';
      if((int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND)
      {
        $orderInfoList = Main_thumbnail::where('type', '=', $thumbnailType)->where('order_number', '>', 0)->orderByRaw("RAND()")->skip(0)->take(4)->get();
      }
      else
      {
        $orderInfoList = Main_thumbnail::where('type', '=', $thumbnailType)->where('order_number', '>', 0)->orderBy('order_number')->skip(0)->take(4)->get();
      }

      $projects = [];
      foreach($orderInfoList as $orderInfo)
      {
        $project = '';
        if((int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND)
        {
          //$project = \App\Models\Project::select('title', 'project_type', 'description', 'alias', 'poster_renew_url', 'poster_url', 'funding_closing_at', 'performance_opening_at', 'performance_closing_at')->find($orderInfo->project_id);
          $project = \App\Models\Project::find($orderInfo->project_id);
        }
        else if((int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE)
        {
          $project = \App\Models\Magazine::select('id', 'title', 'subtitle', 'thumb_img_url')->find($orderInfo->magazine_id);
        }

        $project['thumb_place'] = $orderInfo->thumb_place;

        array_push($projects, $project);
      }

      return $projects;
      /*
      $orderInfoList = Main_thumbnail::where('type', '=', $thumbnailType)->where('order_number', '>', 0)->orderBy('order_number')->get();

      $thumbnailProjectIds = [];
      foreach($orderInfoList as $orderInfo)
      {
        $thumbTargetId = $orderInfo->project_id;
        if((int)$thumbnailType == Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE)
        {
          $thumbTargetId = $orderInfo->magazine_id;
        }

        array_push($thumbnailProjectIds, $thumbTargetId);
      }

      $projectsByOrderInfo = '';

      if((int)$thumbnailType == Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE)
      {
        $projectsByOrderInfo = \App\Models\Magazine::whereIn('id', $thumbnailProjectIds)->select('id', 'title', 'subtitle', 'thumb_img_url', 'created_at')->get();
      }
      else
      {
        $projectsByOrderInfo = \App\Models\Project::whereIn('id', $thumbnailProjectIds)->get();
      }

      $projectSortInfo = $this->getArraySortByOrdernumber($projectsByOrderInfo, $orderInfoList, $thumbnailType);

      return $projectSortInfo;
      */
    }


    //orderArray 데이터 기준으로 projectArray 정렬
    public function getArraySortByOrdernumber($projectArray, $orderArray, $thumbnailType)
    {
      $tempProjectArray = [];

      foreach($orderArray as $orderInfo)
      {
        $checkTargetId = 0;

        if($thumbnailType == Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE)
        {
          $checkTargetId = $orderInfo->magazine_id;
        }
        else
        {
          $checkTargetId = $orderInfo->project_id;
        }

        if(!$checkTargetId || $checkTargetId == 0)
        {
          continue;
        }

        foreach($projectArray as $projectInfo)
        {
          if($projectInfo->id == $checkTargetId)
          {
            array_push($tempProjectArray, $projectInfo);
            break;
          }
        }
      }


      return $tempProjectArray;
    }

}
