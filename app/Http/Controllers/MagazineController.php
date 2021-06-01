<?php namespace App\Http\Controllers;

//use App\Models\Project as Project;
use App\Models\Magazine as Magazine;
use App\Models\Model as Model;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Storage as Storage;

class MagazineController extends Controller
{
  public function getMagazineAll()
  {
    // return view('magazine.magazine', [
    //     'magazines' => Magazine::where('is_open', true)->orderBy('id', 'desc')->get()
    // ]);

    return view('magazine.magazine');
  }

  public function getMagazine($magazineId)
  {
    $magazine = Magazine::findOrFail($magazineId);

    $cookieName = 'isShowMagazine_'.$magazineId;

    if(!isset($_COOKIE[$cookieName]))
    {
      setcookie($cookieName,"true", time()+86400, "/magazine");

      $magazine->increment('view_count');
    }

    return view('magazine.magazine_detail', [
        'magazine' => $magazine,
    ]);
  }

  public function deleteMagazine($magazineId)
  {

    if(\Auth::check() && \Auth::user()->isAdmin())
    {
      $magazine = Magazine::findOrFail($magazineId);

      if($magazine->title_img_url)
      {
        $this->removeMagazineTitleImage($magazine->title_img_url, $magazine->id);
      }

      if($magazine->thumb_img_url)
      {
        $this->removeMagazineThumbImage($magazine->thumb_img_url, $magazine->id);
      }

      $magazine->delete();

      return ['state' => 'sucess'];
    }

    return ['state' => 'fail', 'message' => '관리자만 삭제 가능합니다.'];
  }

  public function updateMagazine(Request $request, $magazineId)
  {

    $magazine = Magazine::findOrFail($magazineId);
    
    $magazine->update(\Input::all());

    if ($request->file('magazine_title_img_file')) {
      if($magazine->title_img_url)
      {
        $this->removeMagazineTitleImage($magazine->title_img_url, $magazineId);
        $magazine->title_img_url = '';
      }

      $title_img_url = $this->createMagazineTitleImage($request, $magazineId);
      $magazine->title_img_url = $title_img_url;
    }

    if ($request->file('magazine_thumb_img_file')) {
      if($magazine->thumb_img_url)
      {
        $this->removeMagazineThumbImage($magazine->thumb_img_url, $magazineId);
        $magazine->thumb_img_url = '';
      }

      $thumb_img_url = $this->createMagazineThumbImage($request, $magazineId);
      $magazine->thumb_img_url = $thumb_img_url;
    }

    $magazine->save();

    return ['state' => 'success'];
  }

  public function removeMagazineTitleImageByRequest($magazineId)
  {
    $magazine = Magazine::findOrFail($magazineId);

    if($magazine->title_img_url)
    {
      $this->removeMagazineTitleImage($magazine->title_img_url, $magazineId);
      $magazine->title_img_url = '';
      $magazine->save();
    }
  }

  public function removeMagazineThumbImageByRequest($magazineId)
  {
    $magazine = Magazine::findOrFail($magazineId);

    if($magazine->thumb_img_url)
    {
      $this->removeMagazineThumbImage($magazine->thumb_img_url, $magazineId);
      $magazine->thumb_img_url = '';
      $magazine->save();
    }
  }

  public function updateMagazineStory(Request $request)
  {
    $magazine = '';
    if($request->has('magazineId'))
    {
      $magazine = Magazine::find(\Input::get('magazineId'));
    }
    else
    {
      $magazine = new Magazine(\Input::all());
    }

    if(!$magazine)
    {
      return ['state' => 'fail', 'message' => '매거진 정보 가져오기 실패'];
    }

    if($request->has('story'))
    {
      $magazine->story = \Input::get('story');
    }

    $magazine->save();

    return ['state' => 'success', 'magazineId' => $magazine->id];
  }

  public function goMagazineWrite()
  {
    if(\Auth::check() && \Auth::user()->isAdmin())
    {
      return view('magazine.magazine_write');
    }

    return "잘못된 정보입니다. 관리자만 접속 가능합니다.";
  }

  public function goMagazineUpdateWrite()
  {
    if(\Auth::check() && \Auth::user()->isAdmin())
    {
      return view('magazine.magazine_write');
    }

    return "잘못된 정보입니다. 관리자만 접속 가능합니다.";
  }

  public function goMagazineModifyWrite($magazineId)
  {
    if(\Auth::check() && \Auth::user()->isAdmin())
    {
      return view('magazine.magazine_write', ['magazine' => Magazine::findOrFail($magazineId)]);
    }

    return "잘못된 정보입니다. 관리자만 접속 가능합니다.";
  }

  public function uploadStoryImage()
  {

    $base64Img = \Input::get('image');

    $base64ImgPos  = strpos($base64Img, ';');
    $base64Imgtype = explode(':', substr($base64Img, 0, $base64ImgPos))[1];

    $base64Img = str_replace('data:'.$base64Imgtype.';base64,', '', $base64Img);
    $base64Img = str_replace(' ', '+', $base64Img);
    $data = base64_decode($base64Img);

    $nowTimeUnix = time();

    $originalName = \Input::get('image_name');
    $hashedName = md5($originalName.$nowTimeUnix);
    $storyUrlPartial = Model::getS3Directory(Model::S3_MAGAZINE_STORY_DIRECTORY) . $hashedName . '.jpg';

    Storage::put(
        $storyUrlPartial,
        $data
    );

    return Model::S3_BASE_URL . $storyUrlPartial;
  }

  private function createMagazineTitleImage($request, $magazineId)
  {
    $originalName = \Input::get('magazine_title_image_name');
    $hashedName = md5($originalName);

    
    $posterUrlPartial = Model::getS3Directory(Model::S3_MAGAZINE_DIRECTORY) . $magazineId . '/' . 'title/' . $hashedName . '.jpg';

    Storage::put(
        $posterUrlPartial,
        file_get_contents($request->file('magazine_title_img_file')->getRealPath())
    );

    return Model::S3_BASE_URL . $posterUrlPartial;
  }

  private function removeMagazineTitleImage($imgURL, $magazineId)
  {
    $fileName = basename($imgURL).PHP_EOL;
    $magazineTitleUrlPartial = Model::getS3Directory(Model::S3_MAGAZINE_DIRECTORY) . $magazineId . '/'. 'title/' . $fileName;

    if(Storage::disk('s3')->exists($magazineTitleUrlPartial) == true)
    {
      //파일이 있으면 지워준다.
      Storage::delete($magazineTitleUrlPartial);
    }
  }

  private function createMagazineThumbImage($request, $magazineId)
  {
    $originalName = \Input::get('magazine_thumb_image_name');
    $hashedName = md5($originalName);

    $posterUrlPartial = Model::getS3Directory(Model::S3_MAGAZINE_DIRECTORY) . $magazineId . '/' . 'thumb/' . $hashedName . '.jpg';

    Storage::put(
        $posterUrlPartial,
        file_get_contents($request->file('magazine_thumb_img_file')->getRealPath())
    );

    return Model::S3_BASE_URL . $posterUrlPartial;
  }

  private function removeMagazineThumbImage($imgURL, $magazineId)
  {
    $fileName = basename($imgURL).PHP_EOL;
    $magazineTitleUrlPartial = Model::getS3Directory(Model::S3_MAGAZINE_DIRECTORY) . $magazineId . '/'. 'thumb/' . $fileName;

    if(Storage::disk('s3')->exists($magazineTitleUrlPartial) == true)
    {
      //파일이 있으면 지워준다.
      Storage::delete($magazineTitleUrlPartial);
    }
  }
}
