<?php namespace App\Http\Controllers;

use App\Models\Maincarousel as Maincarousel;
use App\Models\Main_thumbnail as Main_thumbnail;
use App\Models\Main_thumb_play_creator as Main_thumb_play_creator;
use App\Models\Meetup_user as Meetup_user;

use App\Models\Alive_user as Alive_user;

use App\Models\Item as Item;
use App\Models\Store as Store;

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
    return view('store.store_home');
    /*
      $thumbnailProjects = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND);
      $thumbMagazines = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE);
      $thumbEventProjects = [];
      
      $thumbPlayCreators = Main_thumb_play_creator::orderBy('order_number')->get();
      $thumb_store_items = $this->getThumbnailStore(Main_thumbnail::THUMBNAIL_TYPE_STORE_ITEM);

      return view('welcome_new_new', [
        'projects' => $thumbnailProjects,
        'magazines' => $thumbMagazines,
        'playedcreators' => $thumbPlayCreators,
        'thumb_store_items' => $thumb_store_items,
        'thumbEventProjects' => $thumbEventProjects
    ]);
    */
  }

  public function getThumbnailStore($thumbnailType)
  {
    $mainThumbs = Main_thumbnail::where('type', '=', $thumbnailType)->where('order_number', '>', 0)->orderByRaw("RAND()")->skip(0)->take(4)->get();

    foreach($mainThumbs as $mainThumb)
    {
      $target_id = $mainThumb->target_id;

      if((int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_STORE_ITEM)
      {
        $store = Store::where('id', $target_id)->first();
        $mainThumb['store'] = $store;       

        // $item = Item::where('id', $target_id)->first();
        // $mainThumb['item'] = $item;

        // $store = Store::where('id', $item->store_id)->first();
        // $mainThumb['store'] = $store;
      }
    }

    return $mainThumbs;
  }

  public function getThumbnailProject($thumbnailType)
  {
    $orderInfoList = '';
    if((int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND ||
      (int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_RECOMMENT_SANDBOX_EVENT)
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
      if((int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND ||
        (int)$thumbnailType === Main_thumbnail::THUMBNAIL_TYPE_RECOMMENT_SANDBOX_EVENT)
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

  public function getSearchResult(Request $request)
  {
    $search = null;
    if($request->has('search')){
      $search = $request->search;
    }

    return view('store.store_search_result', [
      'search' => $search
    ]);
  }

  public function getCategoryPage($category_top_item_id)
  {
    return view('category.category', [
      'category_top_item_id' => $category_top_item_id
    ]);
  }

  public function goDownloadPage()
  {
    return view('bridge_file_download');
  }
}
