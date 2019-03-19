<?php namespace App\Http\Controllers;

use App\Models\Maincarousel as Maincarousel;
use App\Models\Main_thumbnail as Main_thumbnail;

class WelcomeController extends Controller
{

    public function index()
    {

        $thumbnailProjects = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_RECOMMEND);
        $thumbnailCrowdticketPicProject = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_CROLLING);

        $thumbMagazines = $this->getThumbnailProject(Main_thumbnail::THUMBNAIL_TYPE_MAGAZINE);

        //maincarousel
        $main_carousel = Maincarousel::where('order_number', '>', 0)->orderby('order_number')->get();

        return view('welcome_new', [
            'projects' => $thumbnailProjects,
            'crowdticketPicProjects' => $thumbnailCrowdticketPicProject,
            'main_carousels' => $main_carousel,
            'magazines' => $thumbMagazines,
            'isNotYet' => 'FALSE'
        ]);

    }

    public function getThumbnailProject($thumbnailType)
    {
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
        $projectsByOrderInfo = \App\Models\Magazine::whereIn('id', $thumbnailProjectIds)->select('id', 'title', 'subtitle', 'thumb_img_url', 'updated_at')->get();
      }
      else
      {
        $projectsByOrderInfo = \App\Models\Project::whereIn('id', $thumbnailProjectIds)->get();
      }

      $projectSortInfo = $this->getArraySortByOrdernumber($projectsByOrderInfo, $orderInfoList, $thumbnailType);

      return $projectSortInfo;
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
