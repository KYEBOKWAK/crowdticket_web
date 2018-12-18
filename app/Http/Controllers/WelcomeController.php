<?php namespace App\Http\Controllers;

use App\Models\Maincarousel as Maincarousel;
use App\Models\Main_thumbnail as Main_thumbnail;

class WelcomeController extends Controller
{

    public function index()
    {
        //$now = date('Y-m-d H:i:s');

        /*
        $projects = \App\Models\Project::whereNotIn('project_order_number', [0])
            ->orderBy('project_order_number')
            ->take($minExposedNum)->get();
        */

        $thumbnailProjects = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND);
        $thumbnailCrowdticketPicProject = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_CROLLING);

        //maincarousel
        $main_carousel = Maincarousel::where('order_number', '>', 0)->orderby('order_number')->get();

        return view('welcome_new', [
            'projects' => $thumbnailProjects,
            'crowdticketPicProjects' => $thumbnailCrowdticketPicProject,
            'main_carousels' => $main_carousel,
            'isNotYet' => 'FALSE'
        ]);
    }

    public function getThumbnailProject($thumbnailType)
    {
      $orderInfoList = Main_thumbnail::where('type', '=', $thumbnailType)->where('order_number', '>', 0)->orderBy('order_number')->get();

      $thumbnailProjectIds = [];
      foreach($orderInfoList as $orderInfo)
      {
        array_push($thumbnailProjectIds, $orderInfo->project_id);
      }

      $projectsByOrderInfo = \App\Models\Project::whereIn('id', $thumbnailProjectIds)->get();

      $projectSortInfo = $this->getArraySortByOrdernumber($projectsByOrderInfo, $orderInfoList);

      return $projectSortInfo;
    }


    //orderArray 데이터 기준으로 projectArray 정렬
    public function getArraySortByOrdernumber($projectArray, $orderArray)
    {
      $tempProjectArray = [];

      foreach($orderArray as $orderInfo)
      {
        if(!$orderInfo->project_id || $orderInfo->project_id == 0)
        {
          continue;
        }

        foreach($projectArray as $projectInfo)
        {
          if($projectInfo->id == $orderInfo->project_id)
          {
            array_push($tempProjectArray, $projectInfo);
            break;
          }
        }
      }


      return $tempProjectArray;
    }

}
