<?php namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\Poster as Poster;
use App\Models\Model as Model;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Storage as Storage;

class PosterController extends Controller
{
    public function createPoster(Request $request, $projectId)
    {
      $project = Project::findOrFail($projectId);

      \Auth::user()->checkOwnership($project);

      $poster = '';
      $data = json_decode($project->posters, true);

      if(empty($data))
      {
        //데이터가 없으므로 새로 만들어준다.
        $poster = new Poster(\Input::all());
        $poster->project()->associate($project);

        $poster->setAttribute('poster_img_cache', 0);
        $poster->setAttribute('title_1_img_cache', 0);
        $poster->setAttribute('title_2_img_cache', 0);
        $poster->setAttribute('title_3_img_cache', 0);
        $poster->setAttribute('title_4_img_cache', 0);
        //$poster->setAttribute('title_5_img_cache', 0);
        //$poster->setAttribute('title_6_img_cache', 0);
      }
      else{
        $poster = $project->posters()->firstOrFail();
      }

      if ($request->has('description')){
        $projectDescription = \Input::get('description');
        $project->setAttribute('description', $projectDescription);

        $project->save();
      }

      if ($request->file('poster_img_file')) {
        $img_cache_number = $this->createPosterImage($request, $project, $poster, 'poster_img_file');
        $poster->setAttribute('poster_img_cache', $img_cache_number);
      }

      //전역으로 빼야하는데.. 시간이 없으니 일단 고고
      for($i = 0 ; $i < 4 ; $i++){
        $imgNum = $i + 1;
        $fileName = 'title_img_file_'.$imgNum;
        $cacheName = 'title_'.$imgNum.'_img_cache';
        if($request->file($fileName))
        {
          $img_cache_number = $this->createTitlePosterImage($request, $project, $poster, $fileName, $cacheName);
          $poster->setAttribute($cacheName, $img_cache_number);
        }
      }

      $poster->save();

      return $poster;
    }

    public function updatePoster(Request $request, $projectId)
    {
      return $request;
      /*
        $goodsId = \Input::get('goodsId');

        $goods = Goods::findOrFail($goodsId);

        $project = $goods->project()->firstOrFail();

        \Auth::user()->checkOwnership($project);

        $goods->update(\Input::all());

        $imgUrl = $this->updateGoodsImage($request, $project, $goods);
        $goods->setAttribute('img_url', $imgUrl);

        $goods->save();

        return $goods;
        */
    }

    //private function uploadGoodsImage($request, $project)
    private function createPosterImage($request, $project, $poster, $fileName)
    {
      $img_cache_number = $poster->poster_img_cache;
      $posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $fileName . '-' . $poster->poster_img_cache . '.jpg';
      //if(Storage::disk('s3')->exists($posterUrlPartial) == true){
      if($this->deleteImage($posterUrlPartial) == "TRUE"){
        //파일이 있으면 지워준다.

        //캐시 올려주는 코드는, 이미지 추가 및 변경시 무조건 올라가게 수정
        //$img_cache_number = $poster->poster_img_cache;
        //$img_cache_number++;

        //$poster->setAttribute('poster_img_cache', $img_cache_number);

        //캐시넘버가 증가된 이미지로 다시 저장
        //$posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $fileName . '-' . $poster->poster_img_cache . '.jpg';
      }

      if ($request->file($fileName)) {
        //파일이 있을때만 저장한다.
        $img_cache_number = $poster->poster_img_cache;
        $img_cache_number++;

        $poster->setAttribute('poster_img_cache', $img_cache_number);

        //캐시넘버가 증가된 이미지로 다시 저장
        $posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $fileName . '-' . $poster->poster_img_cache . '.jpg';

        Storage::put(
            $posterUrlPartial,
            file_get_contents($request->file($fileName)->getRealPath())
        );

        //return Model::S3_BASE_URL . $posterUrlPartial;
        return $img_cache_number;
      }

      return 0;
    }

    private function createTitlePosterImage($request, $project, $poster, $fileName, $cacheName)
    {
      $img_cache_number = $poster[$cacheName];
      $posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $fileName . '-' . $poster[$cacheName] . '.jpg';
      //if(Storage::disk('s3')->exists($posterUrlPartial) == true){
      if($this->deleteImage($posterUrlPartial) == "TRUE"){
        //파일이 있으면 지워준다.
        //Storage::delete($posterUrlPartial);

        //캐시 올려주는 코드는, 이미지 추가 및 변경시 무조건 올라가게 수정
        //$img_cache_number++;

        //$poster->setAttribute($cacheName, $img_cache_number);

        //캐시넘버가 증가된 이미지로 다시 저장
        //$posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $fileName . '-' . $poster[$cacheName] . '.jpg';
      }

      if ($request->file($fileName)) {
        //파일이 있을때만 저장한다.
        $img_cache_number++;

        $poster->setAttribute($cacheName, $img_cache_number);

        //캐시넘버가 증가된 이미지로 다시 저장
        $posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $fileName . '-' . $poster[$cacheName] . '.jpg';

        Storage::put(
            $posterUrlPartial,
            file_get_contents($request->file($fileName)->getRealPath())
        );

        return $img_cache_number;
      }

      return 0;
    }

/*
    private function updateProjectPerformanceDate($project)
    {
        $tickets = $project->tickets()->orderBy('delivery_date', 'asc')->get();
        $ticketCount = count($tickets);
        if ($ticketCount > 0) {
            $openTicket = $tickets[0];
            $closeTicket = $tickets[$ticketCount - 1];
            $project->performance_opening_at = $openTicket->delivery_date;
            $project->performance_closing_at = $closeTicket->delivery_date;
            $project->save();
        }
    }
*/

    public function deleteTitlePoster($id, $imgnum)
    {
        $poster = Poster::findOrFail($id);
        $project = $poster->project()->firstOrFail();

        $imgCache = $poster['title_'.$imgnum.'_img_cache'];

        $imgName = 'title_img_file_' . $imgnum . '-' . $imgCache . '.jpg';

        \Auth::user()->checkOwnership($project);

        $goodsUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $imgName;

        $this->deleteImage($goodsUrlPartial);

        return $imgnum;
    }

    public function deletePoster($id)
    {
        $poster = Poster::findOrFail($id);
        $project = $poster->project()->firstOrFail();

        $imgCache = $poster['poster_img_cache'];

        $imgName = 'poster_img_file-' . $imgCache . '.jpg';

        \Auth::user()->checkOwnership($project);

        $posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $imgName;

        $this->deleteImage($posterUrlPartial);

        return $poster;
    }

    private function deleteImage($img_url)
    {
      if(Storage::disk('s3')->exists($img_url) == true){
        //파일이 있으면 지워준다.
        Storage::delete($img_url);

        return "TRUE";
      }
      //return $img_url;
      return "FALSE";
    }
}
