<?php namespace App\Http\Controllers;

use App\Models\Project as Project;
use App\Models\Goods as Goods;
use App\Models\Model as Model;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Storage as Storage;

class GoodsController extends Controller
{
    public function createGoods(Request $request, $projectId)
    {
      if($request->has('updatebutton')) {

        $goods = $this->updateGoods($request, $projectId);
        $project = $goods->project()->firstOrFail();

        $goodsArray = array(
          'goodsState' => 'updategoods',
          'goods' => $goods,
          'goodsList' => $project->goods()->get()
        );

        return $goodsArray;
      }
      else {
        $project = Project::findOrFail($projectId);

        \Auth::user()->checkOwnership($project);

        $goods = new Goods(\Input::all());
        $goods->project()->associate($project);

        if ($request->file('goods_img_file')) {
          $posterUrl = $this->createGoodsImage($request, $project, $goods);
          $goods->setAttribute('img_url', $posterUrl);
        }

        $goods->save();

        $goodsArray = array(
          'goodsState' => 'creategoods',
          'goods' => $goods,
          'goodsList' => ''
        );


        return $goodsArray;
        //return $goods;
      }

      /*

      */
    }

    public function updateGoods(Request $request, $projectId)
    {
        $goodsId = \Input::get('goodsId');

        $goods = Goods::findOrFail($goodsId);

        $project = $goods->project()->firstOrFail();

        \Auth::user()->checkOwnership($project);

        $goods->update(\Input::all());

        $imgUrl = $this->updateGoodsImage($request, $project, $goods);
        $goods->setAttribute('img_url', $imgUrl);

        $goods->save();

        return $goods;
    }

    //private function uploadGoodsImage($request, $project)
    private function createGoodsImage($request, $project, $goods)
    {
      $goods->setAttribute('img_cache', 0);

      //ID값을 얻기 위해 저장을 한번 한다.(이미지 만들때 고유의 id값 필요)
      $goods->save();

      $posterUrlPartial = Model::getS3Directory(Model::S3_GOODS_DIRECTORY) . $project->id . '/'. $goods->id . '-' . $goods->img_cache . '.jpg';

      Storage::put(
          $posterUrlPartial,
          file_get_contents($request->file('goods_img_file')->getRealPath())
      );

      return Model::S3_BASE_URL . $posterUrlPartial;
    }

    private function updateGoodsImage($request, $project, $goods)
    {
      $posterUrlPartial = Model::getS3Directory(Model::S3_GOODS_DIRECTORY) . $project->id . '/'. $goods->id . '-' . $goods->img_cache . '.jpg';
      if(Storage::disk('s3')->exists($posterUrlPartial) == true){
        //파일이 있으면 지워준다.
        Storage::delete($posterUrlPartial);

        $img_cache_number = $goods->img_cache;
        $img_cache_number++;

        $goods->setAttribute('img_cache', $img_cache_number);

        //캐시넘버가 증가된 이미지로 다시 저장
        $posterUrlPartial = Model::getS3Directory(Model::S3_GOODS_DIRECTORY) . $project->id . '/'. $goods->id . '-' . $goods->img_cache . '.jpg';
      }

      //$posterUrlPartial = Model::getS3Directory(Model::S3_GOODS_DIRECTORY) . $project->id . '/'. $goods->id . '-' . $goods->img_cache . '.jpg';

      if ($request->file('goods_img_file')) {
        //파일이 있을때만 저장한다.
        Storage::put(
            $posterUrlPartial,
            file_get_contents($request->file('goods_img_file')->getRealPath())
        );

        return Model::S3_BASE_URL . $posterUrlPartial;
      }

      return "";
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

    public function deleteGoods($id)
    {
        $goods = Goods::findOrFail($id);
        $project = $goods->project()->firstOrFail();

        \Auth::user()->checkOwnership($project);

        $goodsUrlPartial = Model::getS3Directory(Model::S3_GOODS_DIRECTORY) . $project->id . '/'. $goods->id . '-' . $goods->img_cache . '.jpg';
        if(Storage::disk('s3')->exists($goodsUrlPartial) == true){
          //파일이 있으면 지워준다.
          Storage::delete($goodsUrlPartial);
        }

        $goods->delete();

        return $project->goods()->get();

        /*
        if ($project->type === 'sale') {
            $this->updateProjectPerformanceDate($project, $ticket);
        }
        */
    }
}
