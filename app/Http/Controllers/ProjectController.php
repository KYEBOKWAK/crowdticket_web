<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;
use App\Models\Category as Category;
use App\Models\Categories_ticket as Categories_ticket;
use App\Models\Categories_channel as Categories_channel;
use App\Models\Maincarousel as Maincarousel;
use App\Models\City as City;
use App\Models\Model as Model;
use App\Models\Project as Project;
use App\Models\Order as Order;
use App\Models\Poster as Poster;
use App\Models\Mcn as Mcn;
use App\Models\Main_thumbnail as Main_thumbnail;
use App\Models\Test as Test;
use App\Services\SmsService;

use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Storage as Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    const SORT_TYPE_NEW = 0;
    //const SORT_TYPE_EVENT_SANDBOX = 1;

    const INPUT_KEY_TYPE_NORMAL = 'key_type_normal';
    const INPUT_KEY_TYPE_ENTER = 'key_type_enter';
    const INPUT_KEY_TYPE_MORE = 'key_type_more_button';

    const MCN_SANDBOX = 'sandbox';

    public function updateProject(Request $request, $id)
    {
        $project = $this->getSecureProjectById($id);

        $input = $request->all();
        if (isset($input['alias'])) {
            $alias = $input['alias'];
            if (!$alias) {
                $input['alias'] = null;
            }
        }

        if (isset($input['funding_closing_at'])) {
            $closingDate = $input['funding_closing_at'];
            $input['funding_closing_at'] = $closingDate . ' 23:59:59';
        }

        if (isset($input['picking_closing_at'])) {
          if($input['picking_closing_at'])
          {
            $pickingClosingDate = $input['picking_closing_at'];
            $input['picking_closing_at'] = $pickingClosingDate . ' 23:59:59';
          }
          else
          {
            $input['picking_closing_at'] = null;
          }
        }

        if(isset($input['sale_start_at']))
        {
          if(!$input['sale_start_at'])
          {
            $input['sale_start_at'] = null;
          }
        }

        //해당 코드는 임시로 넣는다. event type을 프로젝트에서 수정할 수 있을때 해당 이슈도 같이 수정한다.
        if(!$project->isPickType())
        {
          $project->picking_closing_at = null;
        }
        else
        {
          $project->type = "funding";
        }

        $project->update($input);

        if ($request->has('category_id')) {
            $categoryId = \Input::get('category_id');
            $category = Category::findOrFail($categoryId);
            $project->category()->associate($category);
        }

        if ($request->has('city_id')) {
            $cityId = \Input::get('city_id');
            $city = City::findOrFail($cityId);
            $project->city()->associate($city);
        }

        if ($request->file('poster')) {
            //$posterUrl = $this->uploadPosterImage($request, $project);
            //$project->setAttribute('poster_url', $posterUrl);
        }

        $project->save();

        return $project;
    }

    private function uploadPosterImage($request, $project)
    {
        $posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '.jpg';

        Storage::put(
            $posterUrlPartial,
            file_get_contents($request->file('poster')->getRealPath())
        );

        return Model::S3_BASE_URL . $posterUrlPartial;
    }

    public function uploadStoryImage(Request $request, $id)
    {

      $project = $this->getSecureProjectById($id);

      $base64Img = \Input::get('image');

      $base64ImgPos  = strpos($base64Img, ';');
      $base64Imgtype = explode(':', substr($base64Img, 0, $base64ImgPos))[1];

      $base64Img = str_replace('data:'.$base64Imgtype.';base64,', '', $base64Img);
    	$base64Img = str_replace(' ', '+', $base64Img);
    	$data = base64_decode($base64Img);

      $originalName = \Input::get('image_name');
      $hashedName = md5($originalName);
      $storyUrlPartial = Model::getS3Directory(Model::S3_STORY_DIRECTORY) . $project->id . '/' . $hashedName . '.jpg';

      Storage::put(
          $storyUrlPartial,
          $data
      );

      return Model::S3_BASE_URL . $storyUrlPartial;
    }

    public function uploadNewsImage(Request $request, $id)
    {
      //S3_NEWS_DIRECTORY
      $project = $this->getSecureProjectById($id);

      $base64Img = \Input::get('image');

      $base64ImgPos  = strpos($base64Img, ';');
      $base64Imgtype = explode(':', substr($base64Img, 0, $base64ImgPos))[1];

      $base64Img = str_replace('data:'.$base64Imgtype.';base64,', '', $base64Img);
      $base64Img = str_replace(' ', '+', $base64Img);
      $data = base64_decode($base64Img);

      $originalName = \Input::get('image_name');
      $hashedName = md5($originalName);
      $storyUrlPartial = Model::getS3Directory(Model::S3_NEWS_DIRECTORY) . $project->id . '/' . $hashedName . '.jpg';

      Storage::put(
          $storyUrlPartial,
          $data
      );

      return Model::S3_BASE_URL . $storyUrlPartial;

      /*
        $project = $this->getSecureProjectById($id);

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $hashedName = md5($originalName);
        $newsUrlPartial = Model::getS3Directory(Model::S3_NEWS_DIRECTORY) . $project->id . '/' . $hashedName . '.jpg';

        Storage::put(
            $newsUrlPartial,
            file_get_contents($file->getRealPath())
        );

        $imageSize = getimagesize($file);
        $imageWidth = $imageSize[0];
        $imageHeight = $imageSize[1];
        if ($imageWidth > 525) {
            $imageResizeRatio = 525 / $imageWidth;
            $imageWidth = 525;
            $imageHeight = (int)($imageHeight * $imageResizeRatio);
        }

        return [
            'image_url' => Model::S3_BASE_URL . $newsUrlPartial,
            'image_width' => $imageWidth,
            'image_height' => $imageHeight
        ];
        */
    }

    public function getUpdateFormById($id)
    {
        $project = $this->getSecureProjectById($id);
        return $this->returnUpdateForm($project);
    }

    public function getUpdateFormByCode($code)
    {
        $project = $this->getProjectByBlueprintCode($code);
        return $this->returnUpdateForm($project);
    }

    private function returnUpdateForm($project)
    {
        if ($project->isUnderConstruction()) {
            return view('project.form_not_permitted');
        } else {
            $project->load('tickets');
            $tab = $this->getValidUpdateFormTab();
            $posterJson = $this->getPosterUrl($project);
            $ticketsCountInfoListJson = $project->getAmountTicketCountInfoList();
            return view('project.form', [
                'selected_tab' => $tab,
                'project' => $project,
                'categories' => Category::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
                'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
                'categories_channel' => Categories_channel::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
                'posters' => $posterJson,
                'ticketsCountInfoJson' => $ticketsCountInfoListJson,
                'cities' => City::orderBy('id')->get()
            ]);
        }
    }

    private function getPosterUrl($project){

      //$posters = $project->posters()->firstOrFail();
      $posters = $project->posters()->first();
      if(is_null($posters))
      {
        //return '';
        //프로젝트 정보가 없으면 poster DB 생성
        $posters = new Poster(\Input::all());
        $posters->project()->associate($project);

        $posters->setAttribute('poster_img_cache', 0);
        $posters->setAttribute('title_1_img_cache', 0);
        $posters->setAttribute('title_2_img_cache', 0);
        $posters->setAttribute('title_3_img_cache', 0);
        $posters->setAttribute('title_4_img_cache', 0);

        $posters->save();
      }

      $postersArray['id'] = $posters->id;
      $postersArray['poster_img_file'] = $this->makePosterURL($project, "poster_img_file", 0);
      $postersArray['title_img_file_1'] = $this->makePosterURL($project, "title_img_file_1", 1);
      $postersArray['title_img_file_2'] = $this->makePosterURL($project, "title_img_file_2", 2);
      $postersArray['title_img_file_3'] = $this->makePosterURL($project, "title_img_file_3", 3);
      $postersArray['title_img_file_4'] = $this->makePosterURL($project, "title_img_file_4", 4);
      $postersArray['title_img_file_5'] = $this->makePosterURL($project, "title_img_file_5", 5);
      $postersArray['title_img_file_6'] = $this->makePosterURL($project, "title_img_file_6", 6);

      $project->poster_renew_url = $postersArray['title_img_file_1']['img_url'];
      $project->poster_sub_renew_url = $postersArray['poster_img_file']['img_url'];
      $project->save();

      $postersJson = json_encode($postersArray);
      //return $postersArray;
      return $postersJson;
    }

    private function makePosterURL($project, $fileName, $cacheNameNum){
      $img_url = '';
      $isFile = true;

      $data = json_decode($project->posters, true);
      if(empty($data))
      {
        //return $project->getDefaultImgUrl();
        $img_url = $project->getDefaultImgUrl();
        $isFile = false;
      }

      $posters = $project->posters()->firstOrFail();

      $cacheNum = '';

      if($fileName == 'poster_img_file'){
        $cacheNum = $posters->poster_img_cache;
      }
      else{
        $cacheName = 'title_'.$cacheNameNum.'_img_cache';
        $cacheNum = $posters[$cacheName];
      }

      $posterUrlPartial = Model::getS3Directory(Model::S3_POSTER_DIRECTORY) . $project->id . '/'. $fileName . '-' . $cacheNum . '.jpg';

      if(Storage::disk('s3')->exists($posterUrlPartial) == false){
        //만약 파일이 없으면 기본 디폴트 경로를 넣어준다.
        //return $project->getDefaultImgUrl();
        $img_url = $project->getDefaultImgUrl();
        $isFile = false;
      }
      else{
        $img_url = Model::S3_BASE_URL . $posterUrlPartial;
        $isFile = true;
      }

      $arrayTemp['img_url'] = $img_url;
      $arrayTemp['isFile'] = $isFile;

      return $arrayTemp;
      //return Model::S3_BASE_URL . $posterUrlPartial;
    }

    private function getValidUpdateFormTab()
    {
        $tab = \Input::get('tab');
        switch ($tab) {
            case 'required':
            case 'base':
            case 'reward':
            case 'ticket':
            case 'poster':
            case 'story':
            case 'creator':
                return $tab;
            default:
                return 'required';
        }
    }

    public function getProjectObjects(Request $request)
    {
        $orderBy = 'projects.funding_closing_at';
        $orderType = 'desc';

        $skip = $request->call_skip_counter;
        $take = $request->call_once_max_counter;

        $projects = [];

        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }

        $mcnMessage = '';

        if($request->company)
        {
          $mcn = Mcn::where('url', $request->company)->first();
          if($mcn)
          {
            //$projects = Project::where('super_user_id', $mcn->user_id)->where('state', Project::STATE_APPROVED)->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
            $projects = Project::where('super_user_id', $mcn->user_id)->where('state', Project::STATE_APPROVED)->where('event_type_sub', '!=', Project::EVENT_TYPE_SUB_SECRET_PROJECT)->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
          }
          else
          {
            $mcnMessage = 'MCN 정보가 없습니다!!';
          }
        }
        else
        {
          //$projects = Project::where('state', Project::STATE_APPROVED)->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
          $projects = Project::where('state', Project::STATE_APPROVED)->where('event_type_sub', '!=', Project::EVENT_TYPE_SUB_SECRET_PROJECT)->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
        }

        foreach($projects as $project)
        {
          $project->link = $project->getProjectURLWithIdOrAlias();
          $project->poster_url = $project->getPosterUrl();
          $project->ticket_data_slash = $project->getTicketDateFormattedSlash();

          $project->city_name = '';
          if(isset($project->city->name))
          {
            $project->city_name = $project->city->name;
          }
        }

        return ['state' => 'success', 'projects' => $projects, 'keytype' => $request->keytype, 'message' => $mcnMessage];
    }

    /*
    public function getProjectObjects(Request $request)
    {
        $orderBy = 'projects.funding_closing_at';
        $orderType = 'desc';

        $skip = $request->call_skip_counter;
        $take = $request->call_once_max_counter;

        $projects = [];

        $user = null;
        if(\Auth::check() && \Auth::user())
        {
            $user = \Auth::user();
        }

        if($request->company === self::MCN_SANDBOX)
        {
          $thumb_projectIds = Main_thumbnail::where('type', Main_thumbnail::THUMBNAIL_TYPE_RECOMMENT_SANDBOX_EVENT)->where('order_number', '>', 0)->select('project_id')->get();
          $thumb_projectIds = json_decode($thumb_projectIds, true);
          $projects = Project::whereIn('id', $thumb_projectIds)->where('state', Project::STATE_APPROVED)->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
        }
        else
        {
          $projects = Project::where('state', Project::STATE_APPROVED)->orderBy($orderBy, $orderType)->skip($skip)->take($take)->get();
        }

        foreach($projects as $project)
        {
          $project->link = $project->getProjectURLWithIdOrAlias();
          $project->poster_url = $project->getPosterUrl();
          $project->ticket_data_slash = $project->getTicketDateFormattedSlash();

          $project->city_name = '';
          if(isset($project->city->name))
          {
            $project->city_name = $project->city->name;
          }
        }

        return ['state' => 'success', 'projects' => $projects, 'keytype' => $request->keytype];
    }
    */


    public function getProjects()
    {
      $company = '';
      return view('project.explore_new', ['company' => $company]);
    }

    public function getMCNProjects($company)
    {
      return view('project.explore_new', ['company' => $company]);
    }

    public function getOldProjects()
    {
        $now = date('Y-m-d H:i:s');

        $projects = [];
        $tab = $this->getValidExploreTab();
        switch ($tab) {
            default:
            case 'all':
                $opened = Project::where('state', 4)
                    ->where('funding_closing_at', '>', $now)
                    ->orderBy('id', 'desc')->get();
                $closed = Project::where('state', 4)
                    ->where('funding_closing_at', '<', $now)
                    ->orderBy('id', 'desc')->get();
                $projects = $opened->merge($closed);
                break;

            case 'funding':
            case 'sale':
                $projects = Project::where('state', 4)
                    ->where('type', '=', $tab)
                    ->where('funding_closing_at', '>', $now)
                    ->orderBy('id', 'desc')->get();
                break;

            case 'date':
                $projects = Project::where('state', 4)
                    ->where('funding_closing_at', '>', $now)
                    ->orderBy('funding_closing_at', 'asc')->get();
                break;
        }

        return view('project.explore', [
            'selected_tab' => $tab,
            'projects' => $projects
        ]);
    }

    private function getValidExploreTab()
    {
        $tab = \Input::get('tab');
        switch ($tab) {
            case 'all':
            case 'funding':
            case 'sale':
            case 'date':
                return $tab;
            default:
                return 'all';
        }
    }

    private function getSecureProjectById($id)
    {
        $project = Project::findOrFail($id);
        \Auth::user()->checkOwnership($project);
        return $project;
    }

    private function getApprovedProject($project)
    {
        if ((int)$project->state !== Project::STATE_APPROVED) {
            if (\Auth::check()) {
                \Auth::user()->checkOwnership($project);
            } else {
                return false;
                //throw new \App\Exceptions\OwnershipException("aabb");
                //return view('auth.login', ['redirectPath' => redirect()->back()->getTargetUrl()]);
                //return \Redirect::action('Auth\AuthController@completecomment', ['id' => $entityId]);
                //return \Redirect::action('Auth\AuthController@getLogin');
            }
        }
        return $project;
    }

    public function getProjectById($id)
    {
        $project = Project::findOrFail($id);
        $project = $this->getApprovedProject($project);

        if(!$project)
        {
          return view('auth.login', ['redirectPath' => url().'/projects'.'/'.$id]);
        }

        //NEW 체크
        //$isArrayNew = $this->isArrayNew($project);

        return $this->getProjectDetailView($project);
    }

    public function getProjectByAlias($alias)
    {
        $project = Project::where('alias', '=', $alias)->firstOrFail();
        $project = $this->getApprovedProject($project);

        if(!$project)
        {
          return view('auth.login', ['redirectPath' => url().'/projects'.'/'.$alias]);
        }

        //NEW 체크
        //$isArrayNew = $this->isArrayNew($project);

        return $this->getProjectDetailView($project);
    }

    //new 인지 아닌지 boolean array 로 return 키 : news, comment, support
    public function isArrayNew($project)
    {
      $tempArray = NULL; //업데이트, 코멘트, 서포트 카운트값 저장할 임시 array
      $isNewArray = NULL;  //최종 결정된 new 값 데이터
      if($project->type === 'funding')
      {
        $tempArray['news'] = $project->news_count;
        $tempArray['comment'] = $project->comments_count;
        $tempArray['support'] = $project->supporters_count;
      }
      else
      {
        $tempArray['news'] = $project->news_count;
        $tempArray['comment'] = $project->comments_count;
        $tempArray['support'] = $project->supporters_count;
      }

      foreach ($tempArray as $key => $value) {

        //기본 Default 로 false 셋팅
        $isNewArray[$key] = FALSE;

        if($value <= 0)
        {
          continue;
        }

        $dataDB = NULL;
        $tableID = NULL;
        switch($key)
        {
          case 'news':
          {
            $dataDB = $project->news();
            $tableID = 'project_id';  //ID가 다 다''
          } break;
          case 'comment':
          {
            $dataDB = $project->comments();
            $tableID = 'commentable_id';  //ID가 다 다''
          } break;
          case 'support':
          {
            $dataDB = $project->supporters();
            $tableID = 'project_id';  //ID가 다 다''
          } break;
        }

        if(is_null($dataDB) || is_null($tableID))
        {
          continue;
        }

        $data = $dataDB->get();
        //null 체크
        if($data == '[]') {
          continue;
        }

        //데이터가 있으면 필요한 필드 데이터만 가져온다.
        $targetDate = $dataDB->where($tableID, '=', $project->id)->firstOrFail()->created_at;

        $dateVar = (strtotime(date("Ymd",strtotime ("+7 days", strtotime($targetDate)))) - strtotime(date("Ymd")))/60/60/24;
        if($dateVar >= 0)
        {
          //값이 0보다 크면 NEW 기한이 남았다.\
          $isNewArray[$key] = TRUE;
        }
      }

      return $isNewArray;
    }

    private function getProjectDetailView($project)
    {
        $project->load(['category', 'city', 'tickets']);
        $project->countSessionDependentViewNum();
        $posterJson = $this->getPosterUrl($project);
        $ticketsCountInfoListJson = $project->getAmountTicketCountInfoList();
        return view('project.detail_renew', [
            'project' => $project,
            'posters' =>$posterJson,
            //'ticketsCountInfoJson' => $ticketsCountInfoListJson,
            'ticketsCountInfoJson' => $ticketsCountInfoListJson,
            'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
            'is_master' => \Auth::check() && \Auth::user()->isOwnerOf($project)
        ]);
    }

    //티켓별로 남은 수량
    /*
    public function getAmountTicketCountInfoList($project)
    {
      $orders = $project->orders;
      $tickets = $project->tickets;

      $ticketBuyInfoArray = [];

      foreach ($tickets as $ticket) {
        $ticketBuyTotalCount = 0;

        foreach ($orders as $order) {
          if($ticket->id == $order->ticket_id)
          {
            $ticketBuyTotalCount += $order->count;
          }
        }

        if($ticketBuyTotalCount > 0)
        {
          $ticketInfoObject['id'] = $ticket->id;
          $ticketInfoObject['buycount'] = $ticketBuyTotalCount;

          array_push($ticketBuyInfoArray, $ticketInfoObject);
        }
      }

      return json_encode($ticketBuyInfoArray);
    }
    */

    public function checkProjectAlias($projectId, $alias)
    {
        $pattern = '/^[a-zA-Z]{1}[a-zA-Z0-9-_]{3,63}/';
        $match = preg_match($pattern, $alias);
        if ($match) {
            $project = Project::where('alias', '=', $alias)->first();
            if (!$project || $project->id == $projectId) {
                return Response::HTTP_ACCEPTED;
            } else {
                return \App::abort(409);
            }
        } else {
            return \App::abort(422);
        }
    }

    public function submitProject($id)
    {
        $project = $this->getSecureProjectById($id);
        $project->submit();

        //우리쪽에도 확인 메일 보내기
        // 이메일을 생성하고 메일을 전송하는 부분
        $projectId = strip_tags(htmlspecialchars($project->id));
  		  $projectTitle = strip_tags(htmlspecialchars($project->title));
        $userName = strip_tags(htmlspecialchars($project->user->name));
        $userPhone = strip_tags(htmlspecialchars($project->user->contact));
        $userEmail = strip_tags(htmlspecialchars($project->user->email));

  		  $to = 'contact@crowdticket.kr'; // 받는 측의 이메일 주소를 기입하는 부분
  		  $email_subject = "제출 완료! [$projectTitle]"; // 메일 제목에 해당하는 부분
  		  $email_body = ['content' => "\n\n프로젝트 ID:\n\n $projectId\n\n프로젝트 타이틀:\n\n $projectTitle\n\n이름:\n\n $userName\n\n 연락처:\n\n $userPhone\n\nEmail:\n\n $userEmail\n\n"];

  			Mail::send('landing.landing_email_form', $email_body, function ($m) use ($email_subject, $to) {
  								$m->from('contact@crowdticket.kr', '제출 완료!');
  								$m->to($to)->subject($email_subject);
  						});

        return $project;
    }

    private function createProject($blueprint)
    {
        $project = new Project(\Input::all());
        $project->user()->associate($blueprint->user);
        $project->setAttribute('story', ' ');
        //$project->setAttribute('type', $blueprint->type);
        $project->save();

        //프로젝트 만들때 포스터 DB 생성
        $poster = new Poster(\Input::all());
        $poster->project()->associate($project);

        $poster->setAttribute('poster_img_cache', 0);
        $poster->setAttribute('title_1_img_cache', 0);
        $poster->setAttribute('title_2_img_cache', 0);
        $poster->setAttribute('title_3_img_cache', 0);
        $poster->setAttribute('title_4_img_cache', 0);

        $poster->save();

        return $project;
    }

    private function getProjectByBlueprintCode($code)
    {
        $blueprint = Blueprint::findByCode($code);

        if (!$blueprint->approved) {
            throw new \Exception;
        }

        \Auth::user()->checkOwnership($blueprint);

        if ($blueprint->hasProjectCreated()) {
            return $blueprint->project()->first();
        } else {
            $project = $this->createProject($blueprint);
            $blueprint->project()->associate($project);
            $blueprint->save();
            return $blueprint->project()->first();;
        }
    }

    public function getNews($id)
    {
        $project = Project::findOrFail($id);
        return $project->news()->get();
    }

    public function getSupporters($id)
    {
        $project = Project::findOrFail($id);
        return $project->supporters()->with(['user', 'ticket'])->get();
    }

    public function getComments($id)
    {
        $project = Project::findOrFail($id);
        return $project->comments()->with('user', 'comments', 'comments.user')->get();
    }

    public function getOrders($id)
    {
        $project = $this->getSecureProjectById($id);
        //티켓 정보만 넘겨준다.

        return view('project.orders', [
            'project' => $project
        ]);
    }

    public function getOrdersTickets(Request $request)
    {      
      $project_id = $request->project_id;
      $project = $this->getSecureProjectById($project_id);
      if(!$project)
      {
        return ['state' => 'error', 'message' => '본인의 프로젝트가 아닙니다.'];
      }

      $tickets = $project->tickets;
      foreach($tickets as $ticket)
      {
        $ticket->ticket_name = $ticket->getSeatCategory();
        $ticket->order_max_count = $ticket->ordersWithoutError()->withTrashed()->count();
      }

      $goods = $project->goods;

      return ['state' => 'success', 'data_tickets' => $tickets, 'data_goods' => $goods];
    }

    public function getOrderObjects(Request $request, $project_id, $ticket_id)
    {
      $take = (int)$request->size;
      $skip = ((int)$request->page - 1) * $take;

      $project = Project::find($project_id);
      //$orders = $project->orders()->where('ticket_id', $ticket_id)->skip($skip)->take($take)->get();
      $orders = $project->ordersWithoutError()->withTrashed()->where('ticket_id', $ticket_id)->skip($skip)->take($take)->get();
      foreach($orders as $order)
      {
        $this->getSuperviseOrderList($order, $project);
      }

      
      //$orderTotalCount = $project->orders()->where('ticket_id', $ticket_id)->count();
      $orderTotalCount = $project->ordersWithoutError()->withTrashed()->where('ticket_id', $ticket_id)->count();
      $total_page = (int)$orderTotalCount / $take;
      
      return ["last_page"=> (int)$total_page + 1, 'data'=>$orders];
    }

    public function getOrdersNoTickets(Request $request)
    {
      $project_id = $request->project_id;
      $project = $this->getSecureProjectById($project_id);
      if(!$project)
      {
        return ['state' => 'error', 'message' => '본인의 프로젝트가 아닙니다.'];
      }

      $noTicketOrdersCount = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->count();

      $goods = $project->goods;

      return ['state' => 'success', 'data_noticket_orders_count' => $noTicketOrdersCount, 'data_goods' => $goods];
    }

    public function getOrderObjectsNoTicket(Request $request, $project_id)
    {
      $take = (int)$request->size;
      $skip = ((int)$request->page - 1) * $take;

      $project = Project::find($project_id);
      //$orders = $project->orders()->whereNull('ticket_id')->skip($skip)->take($take)->get();
      $orders = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->skip($skip)->take($take)->get();
      foreach($orders as $order)
      {
        $this->getSuperviseOrderList($order, $project);
      }

      //$orderTotalCount = $project->orders()->whereNull('ticket_id')->count();
      $orderTotalCount = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->count();
      $total_page = (int)$orderTotalCount / $take;
      
      return ["last_page"=> (int)$total_page + 1, 'data'=>$orders];
    }

    public function getOrdersSupports(Request $request)
    {
      $project_id = $request->project_id;
      $project = $this->getSecureProjectById($project_id);
      if(!$project)
      {
        return ['state' => 'error', 'message' => '본인의 프로젝트가 아닙니다.'];
      }

      $supportOrdersCount = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->where('supporter_id', '<>', '')->where('goods_meta', '{}')->count();

      return ['state' => 'success', 'data_support_orders_count' => $supportOrdersCount];
    }

    public function getOrderObjectsSupports(Request $request, $project_id)
    {
      $take = (int)$request->size;
      $skip = ((int)$request->page - 1) * $take;

      $project = Project::find($project_id);
      //$orders = $project->orders()->whereNull('ticket_id')->where('supporter_id', '<>', '')->where('goods_meta', '{}')->skip($skip)->take($take)->get();
      $orders = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->where('supporter_id', '<>', '')->where('goods_meta', '{}')->skip($skip)->take($take)->get();
      foreach($orders as $order)
      {
        $this->getSuperviseOrderList($order, $project);
      }

      //$orderTotalCount = $project->orders()->whereNull('ticket_id')->where('supporter_id', '<>', '')->where('goods_meta', '{}')->count();
      $orderTotalCount = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->where('supporter_id', '<>', '')->where('goods_meta', '{}')->count();
      $total_page = (int)$orderTotalCount / $take;
      
      return ["last_page"=> (int)$total_page + 1, 'data'=>$orders];
    }

    public function getOrdersAll(Request $request)
    {
      $project_id = $request->project_id;
      $project = $this->getSecureProjectById($project_id);
      if(!$project)
      {
        return ['state' => 'error', 'message' => '본인의 프로젝트가 아닙니다.'];
      }

      //$supportOrdersCount = $project->orders()->whereNull('ticket_id')->where('supporter_id', '<>', '')->where('goods_meta', '{}')->count();
      $ordersCount = $project->ordersWithoutError()->withTrashed()->count();

      $goods = $project->goods;

      return ['state' => 'success', 'data_orders_count' => $ordersCount, 'data_goods' => $goods];
    }

    public function getOrderObjectsAll(Request $request, $project_id)
    {
      $take = (int)$request->size;
      $skip = ((int)$request->page - 1) * $take;

      $project = Project::find($project_id);
      $orders = $project->ordersWithoutError()->withTrashed()->skip($skip)->take($take)->get();
      foreach($orders as $order)
      {
        $this->getSuperviseOrderList($order, $project);
      }

      $orderTotalCount = $project->ordersWithoutError()->withTrashed()->count();
      $total_page = (int)$orderTotalCount / $take;
      
      return ["last_page"=> (int)$total_page + 1, 'data'=>$orders];
    }

    public function getSuperviseOrderList($order, $project)
    {
      //관리 리스트 키 값에 맞게 변환한다. 기존 php에서 하던걸 javascript로 옴겼기 때문에 프론트 함수 처리 됐던걸 백단에서 처리한다.
      $order['supporterPrice'] = 0;
      if($order->supporter)
      {
        //$order['supporterPrice'] = number_format($order->supporter->price);
        $order['supporterPrice'] = $order->supporter->price;
      }


      if($order['attended'] === 'ATTENDED')
      {
        $order['attended'] = true;
      }
      else
      {
        $order['attended'] = false;
      }

      //$totalPriceWithoutCommission = number_format($order->getTotalPriceWithoutCommission());
      $totalPriceWithoutCommission = $order->getTotalPriceWithoutCommission();

      $order['totalPriceWithoutCommission'] = $totalPriceWithoutCommission;
      $order['discountText'] = $order->getDiscountText();
      $order['state_string'] = $order->state_string;
      $order['deliveryAddress'] = $order->getDeliveryAddress();

      $order['ticket_category'] = '';
      $order['show_date'] = '티켓 미구매(후원자 또는 굿즈 구매자)';
      $order['show_date_unix'] = 9999999999;
      if($order->ticket)
      {
        $order['ticket_category'] = $order->ticket->getSeatCategory();
        $order['show_date'] = $order->ticket->show_date;

        $order['show_date_unix'] = strtotime($order->ticket->show_date);
      }

      $orderState = intval($order['state']);
      $isCancel = false;
      if($orderState > Order::ORDER_STATE_PAY_END)
      {
        $isCancel = true;
      }

      if($order->goods_meta)
      {
        foreach($project->goods as $goods)
        {
          $goodsKey = 'goods'.$goods->id;
          $order[$goodsKey] = '';

          //실제 구매했는지 찾는다.
          $goodsOrders = json_decode($order->goods_meta, true);
          //foreach($goodsOrders as $goodsOrder)
          foreach($goodsOrders as $goodsOrder)
          {
            $goodsOrderId = $goodsOrder['id'];
            if((int)$goodsOrderId === (int)$goods->id)
            {
              //$isSetGoodsOrder = true;
              $order[$goodsKey] = $goodsOrder['count'];

              //set Log
              //\Log::info('order info ', ['id' => $order->id, 'goodsKey' => $goodsKey, 'counter' => $goodsOrder['count']]);

              if($isCancel)
              {
                $order[$goodsKey] = 0;
              }
              break;
            }
          }
        }
      }

      if($order->answer)
      {
        $orderAnswers = json_decode($order->answer, true);
        if($orderAnswers)
        {
          foreach($orderAnswers as $orderAnswer)
          {
            $answerKey = 'table_question_'.$orderAnswer['question_id'];
            $order[$answerKey] = $orderAnswer['value'];
          }
        }
      }

      if($isCancel)
      {
        $order['count'] = 0;
        $order['supporterPrice'] = 0;
        $order['totalPriceWithoutCommission'] = 0;
      }

      return $order;
    }

    public function getOrderGoodsArray($goodsList, $orderGoodsList){
      $goodsArray = [];
      //$goodsArray = '';

      $goodsOrders = json_decode($orderGoodsList, true);
      foreach($goodsOrders as $goodsOrder)
      {
        foreach($goodsList as $goods)
        {
          if($goodsOrder['id'] == $goods->id)
          {
            $goodsInfo['info'] = $goods;
            $goodsInfo['count'] = $goodsOrder['count'];

            array_push($goodsArray, $goodsInfo);
            break;
          }
        }
      }

      return $goodsArray;
    }

    public function setNoDiscount(Request $request, $id){
      $project = $this->getSecureProjectById($id);

      if ($request->has('discountcheck')) {
          $discountCheck = \Input::get('discountcheck');
          //$project->isDiscount = $discountCheck;
          $project->setAttribute('isDiscount', $discountCheck);
          $project->save();

          return $discountCheck;
      }

      return "FALSE";
    }

    public function setNoGoods(Request $request, $id){
      $project = $this->getSecureProjectById($id);

      if ($request->has('goodscheck')) {
          $goodsCheck = \Input::get('goodscheck');
          //$project->isDiscount = $discountCheck;
          $project->setAttribute('isGoods', $goodsCheck);
          $project->save();

          return $goodsCheck;
      }

      return "FALSE";
    }

    public function getOrderLightInfo(Request $request)
    {
      $project = Project::find($request->project_id);
      $orderAllCount = $project->ordersWithoutError()->withTrashed()->count();
      $orderBuyCount = $project->ordersWithoutError()->withTrashed()->where('state', '<=', Order::ORDER_STATE_PAY_END)->sum('count');
      
      /*
      User::chunk(200, function($users)
      {
          foreach ($users as $user)
          {
              //
          }
      });
      */
      $orderTotalPrice = 0;
      //$orderTotalPrice = $project->ordersWithoutError()->withTrashed()->where('state', '<=', Order::ORDER_STATE_PAY_END)->sum('price');
      Order::where('project_id', $project->id)->where('state', '<=', Order::ORDER_STATE_PAY_END)->withTrashed()->chunk(100, function($orders) use(&$orderTotalPrice){
        foreach($orders as $order)
        {
          $orderTotalPrice += $order->getTotalPriceWithoutCommission();
        }
      });

      //$orderSupportTotalPrice = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->where('supporter_id', '<>', '')->where('goods_meta', '{}')->sum('total_price');
      $orderSupportTotalPrice = $project->ordersWithoutError()->withTrashed()->whereNull('ticket_id')->where('state', '<=', Order::ORDER_STATE_PAY_END)->where('supporter_id', '<>', '')->where('goods_meta', '{}')->sum('total_price');
      $orderCancelCount = $project->ordersWithoutError()->withTrashed()->where('state', '>', Order::ORDER_STATE_PAY_END)->count();

      return ['state' => 'success', 'order_all_count' => $orderAllCount, 'order_count' => $orderBuyCount, 'order_cancel_count' => $orderCancelCount, 'order_total_price' => $orderTotalPrice, 'order_support_total_price' => $orderSupportTotalPrice];
    }

    public function getAttend($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      //현재 시간 찾아서 맞는 시간이 있으면 해당 id 가져온다.
      //$nowDateUnix = date(time());

      $nowDateUnix = date(time());

      $selectShowDateTicket = $project->ticketsMustOrderShowDateASC()->first()->show_date;
      foreach($project->ticketsMustOrderShowDateASC as $ticket)
      {
        $showDateUnix = strtotime($ticket->show_date);

        if($nowDateUnix <= $showDateUnix)
        {
          $selectShowDateTicket = $ticket->show_date;
          break;
        }
      }

      //
      /*
      //위에서 선택한 티켓을 찾으면, 중복된 타임이 있는지 확인한다.
      $ticketSameDateList = $project->ticketsOrderShowDate($selectShowDateTicket)->get();
      $ticketOrderIdArray = [];
      foreach($ticketSameDateList as $ticketSameDate)
      {
        array_push($ticketOrderIdArray, $ticketSameDate->id);
      }
      */

      //$orders = Order::whereIn('ticket_id', $ticketOrderIdArray)->orderBy('name')->get();

      $ticketTimeList = [];

      foreach($project->ticketsMustOrderShowDateASC as $ticket)
      {
        $isSameTime = false;
        foreach($ticketTimeList as $ticketTime)
        {
          $orderShowTimeUnix = strtotime($ticket->show_date);
          $ticketTimeUnix = strtotime($ticketTime['show_date']);
          if($orderShowTimeUnix === $ticketTimeUnix)
          {
            $isSameTime = true;
            break;
          }
        }

        if($isSameTime)
        {
          continue;
        }

        $tempTicketInfo['show_date_unix'] = strtotime($ticket->show_date);
        $tempTicketInfo['show_date'] = $ticket->show_date;

        array_push($ticketTimeList, $tempTicketInfo);
      }

      return view('project.attend', [
          'project' => $project,
          //'orders' => $orders,
          'ticketTimeList' => $ticketTimeList,
          'selectShowUnixDateTicket' => strtotime($selectShowDateTicket),
          'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get()
      ]);
    }

    public function getAttendedList($projectId, $selectTimeUnix)
    {
      $project = $this->getSecureProjectById($projectId);

      //현재 시간 찾아서 맞는 시간이 있으면 해당 id 가져온다.
      //$nowDateUnix = date(time());
      $nowDateUnix = (int)$selectTimeUnix;

      if($nowDateUnix === 0)
      {
        $nowDateUnix = date(time());
      }

      $selectShowDateTicket = $project->ticketsMustOrderShowDateASC()->first()->show_date;
      foreach($project->ticketsMustOrderShowDateASC as $ticket)
      {
        $showDateUnix = strtotime($ticket->show_date);

        if($nowDateUnix <= $showDateUnix)
        {
          $selectShowDateTicket = $ticket->show_date;
          break;
        }
      }
      //

      //위에서 선택한 티켓을 찾으면, 중복된 타임이 있는지 확인한다.
      $ticketSameDateList = $project->ticketsOrderShowDate($selectShowDateTicket)->get();
      $ticketOrderIdArray = [];
      foreach($ticketSameDateList as $ticketSameDate)
      {
        array_push($ticketOrderIdArray, $ticketSameDate->id);
      }

      $orders = Order::whereIn('ticket_id', $ticketOrderIdArray)->where('state', '<=', Order::ORDER_STATE_PAY_END)->orderBy('name')->get();

      //구한 오더정보에 티켓 정보까지 담는다
      $ordersWithTicket = [];
      foreach($orders as $order)
      {
        $order->ticket;
        $order->discount;
        $orderTemp = $order;

        array_push($ordersWithTicket, $orderTemp);
      }

      return $ordersWithTicket;
    }

    public function attendedOrder($projectId, $orderId)
    {
      $project = $this->getSecureProjectById($projectId);

      $order = Order::findOrFail($orderId);

      $order->attended = "ATTENDED";
      $order->save();

      /*
      $YYYY = date('Y');
      $mm = date('m');
      $dd = date('d');

      $h = date('H');
      $i = date('i');

      $project = $this->getSecureProjectById($projectId);

      $showDate = '';
      foreach($project->tickets as $ticket)
      {

        $showDate = $ticket->show_date;
        break;
      }
      */

      //$showDateTime = date($order->show_date);
      //$showDateYYYY = date('Y', strtotime($showDate));
      //$showDateMM = date('m', strtotime($showDate));
      //$showDateDD = date('d', strtotime($showDate));

      //return $showDateYYYY.'/'.$showDateMM.'/'.$showDateDD.'//'.$showDate."";

      //return $orderId;
    }

    public function unAttendedOrder($projectId, $orderId)
    {
      $order = Order::findOrFail($orderId);

      $order->attended = "";
      $order->save();

      //return "unAttended";
    }

    public function getPicking($projectId)
    {
      $project = $this->getSecureProjectById($projectId);
      $orders = $project->getOrdersWithoutPick();
      //$orders = '';

      //주문자 정보 START
      $pickingArray = $project->getOrdersOnlyPick()->get();
      //최종 정리된 타임을 기준으로 주문자를 정렬한다.

      $ordersJson = json_encode($orders);
      $pickingJson = json_encode($pickingArray);

      //임시코드
      $pickingYList = $project->getOrdersWithPickY();
      $pickingYList = json_encode($pickingYList);

      return view('project.picking', [
          'project' => $project,
          //'orderList' => $ordersJson,
          'orderList' => $ordersJson,
          'pickingOldList' => $pickingJson,
          'pickingYList' => $pickingYList,
      ]);
    }

    public function getPickingRandom($projectId)
    {
      $project = $this->getSecureProjectById($projectId);
      $orders = $project->getOrdersWithoutPick();

      //주문자 정보 START
      $pickingArray = $project->getOrdersOnlyPick()->get();
      //최종 정리된 타임을 기준으로 주문자를 정렬한다.

      $ordersJson = json_encode($orders);
      $pickingJson = json_encode($pickingArray);

      return view('project.picking_rand', [
          'project' => $project,
          'orderList' => $ordersJson,
          'pickingOldList' => $pickingJson
      ]);
    }

    public function getPickingExcel($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      $pickTotalCount = $project->ordersWithoutError()->where('is_pick', 'PICK')->count();

      return view('project.picking_excel', [
          'project' => $project,
          'pickcount' => $pickTotalCount
      ]);
    }

    public function getPickedExcel(Request $request, $project_id)
    {
      $take = (int)$request->size;
      $skip = ((int)$request->page - 1) * $take;

      $project = Project::find($project_id);
      //$orders = $project->orders()->where('ticket_id', $ticket_id)->skip($skip)->take($take)->get();
      $orders = $project->ordersWithoutError()->where('is_pick', 'PICK')->skip($skip)->take($take)->get();
      /*
      foreach($orders as $order)
      {
        $order->state = 'OK';
      }
      */
      
      $orderTotalCount = $project->ordersWithoutError()->where('is_pick', 'PICK')->count();
      $total_page = (int)$orderTotalCount / $take;
      
      return ["last_page"=> (int)$total_page + 1, 'data'=>$orders];
    }

    public function pickingExcelCheck($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      $isPick = Order::where('project_id', $projectId)->where('is_pick', 'PICK')->count();
      if($isPick > 0)
      {
        return ['state' => 'error', 'message' => '추첨된 인원이 있습니다. 추첨 취소 후 진행 해주세요.'];
      }
      
      return ['state' => 'success'];
    }

    public function pickingExcel(Request $request, $projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      /*
      $isPick = Order::where('project_id', $projectId)->where('is_pick', 'PICK')->count();
      if($isPick > 0)
      {
        return ['state' => 'error', 'message' => '추첨된 인원이 있습니다. 추첨 취소 후 진행 해주세요.'];
      }
      */

      $dataArray = [];
      foreach($request->list as $localData)
      {
        //$object['ccc'] = $object['email'].'dfdf';
        $email = '';
        $name = '';
        $contact = '';
        if(isset($localData['email']))
        {
          $email = $localData['email'];
        }

        if(isset($localData['name']))
        {
          $name = $localData['name'];
        }

        if(isset($localData['contact']))
        {
          $contact = $localData['contact'];
        }

        //$order = Order::where('project_id', $projectId)->where('email', $localData['email'])->where('name', $localData['name'])->where('contact', $localData['contact'])->first();v
        $order = Order::where('project_id', $projectId)->where('email', $email)->where('name', $name)->where('contact', $contact)->first();
        if(count($order) > 0)
        {
          $order->is_pick = "PICK";
          $order->save();
        }
      }
      
      return ['state' => 'success', 'data' => $request->list, 'nextindex' => $request->nextindex, 'islast' => $request->islast, 'alllength' => $request->alllength];
    }

    public function pickingExcelCancel($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      $orders = Order::where('project_id', $projectId)->where('is_pick', 'PICK')->get();
      foreach($orders as $order)
      {
        $order->is_pick = '';
        $order->save();
        //\Log::info($order);
      }

      return ['state' => 'success'];
    }

    public function requestPickingRandom($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      //$orders = $project->getOrdersWithPickY();
      $orders = $project->getOrdersWithoutPick();

      $ordersLength = sizeof($orders);

      $randIdx = rand(0, $ordersLength-1);

      if($randIdx >= $ordersLength)
      {
        return ['state' => 'error', 'index' => $randIdx, 'message' => 'Over Random Index'];
      }

      $order = $orders[$randIdx];

      $this->addPicking($project->id, $order->id);

      $orders = $project->getOrdersWithoutPick();

      return ['state' => 'success', 'order' => $order, 'orders' => $orders];
    }

    public function pickingComplete(Request $request, $projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      if($project->isPickedComplete())
      {
        return ["state" => "error", "message" => "이미 추첨이 완료되었습니다."];
      }

      if ((int)$project->event_type === Project::EVENT_TYPE_PICK_EVENT) {
        
        $startIndex = (int)$request->startindex;
        $take = Project::DATA_CALL_ONETIME_MAX_COUNTER;
        $skip = $startIndex * ($take);

        $totalCounter = $project->orders()->count();

        $orders = $project->orders()->skip(0)->take($take)->where("is_pick", "<>", "PICK")->get();
        foreach($orders as $order)
        {
          if($order->state >= Order::ORDER_STATE_CANCEL_START)
          {
            continue;
          }

          if($order->is_pick != 'PICK')
          {
            app('App\Http\Controllers\OrderController')->deleteOrder($order->id, Order::ORDER_STATE_PROJECT_PICK_CANCEL,true);

            $logMessage = $order->id;
            $this->saveLog($logMessage, Model::LOG_TYPE_PICKER_ORDER_CANCEL);
          }
        }

        if(count($orders) === 0)
        {
          //0개면 마무리
          $project->pick_state = Project::PICK_STATE_PICKED;
          $this->saveLog("pick_state = PICK_STATE_PICKED 변경", "");
          $project->save();
        }
      
        return ["state" => "success", "message" => '', 'start_index' => $startIndex, 'total_count' => $totalCounter, 'orders'=> $orders];  
      }
      else
      {
        return ["state" => "error", "message" => "추첨형 이벤트 타입이 아닙니다."];
      }
    }

    public function sendMailAfterPickComplete(Request $request, $projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      if ((int)$project->event_type === Project::EVENT_TYPE_PICK_EVENT) {
        
        $startIndex = (int)$request->startindex;
        $take = Project::DATA_CALL_ONETIME_MAX_COUNTER;
        $skip = $startIndex * ($take);

        
        $totalCounter = $project->ordersAll()->where('state', '<', Order::ORDER_STATE_PAY_END)->count();
        
        $orders = $project->ordersAll()->where('state', '<', Order::ORDER_STATE_PAY_END)->skip($skip)->take($take)->get();

        foreach($orders as $order)
        {
          $logMessage = $order->email;
          if($order->is_pick === 'PICK')
          {
            $this->sendMailPick("success", $project, $order);
            $this->saveLog($logMessage, Model::LOG_TYPE_SEND_PICK_SUCCESS_EMAIL);
          }
          else
          {
            //$this->sendMailPick("fail", $project, $order);
            //$this->saveLog($logMessage, Model::LOG_TYPE_SEND_PICK_FAIL_EMAIL);
          }
        }

        return ["state" => "success", "message" => '', 'start_index' => $startIndex, 'total_count' => $totalCounter, 'orders'=> $orders];
        
      }
      else
      {
        return ["state" => "error", "message" => "추첨형 이벤트 타입이 아닙니다."];
      }
    }

    public function sendCancelMailAfterPickComplete(Request $request, $projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      if ((int)$project->event_type === Project::EVENT_TYPE_PICK_EVENT) {
        
        $startIndex = (int)$request->startindex;
        $take = Project::DATA_CALL_ONETIME_MAX_COUNTER;
        $skip = $startIndex * ($take);

        
        $totalCounter = $project->ordersAll()->where('state', Order::ORDER_STATE_PROJECT_PICK_CANCEL)->count();
        
        $orders = $project->ordersAll()->where('state', Order::ORDER_STATE_PROJECT_PICK_CANCEL)->skip($skip)->take($take)->get();

        foreach($orders as $order)
        {
          $logMessage = $order->email;
          if($order->is_pick === 'PICK')
          {
            //$this->sendMailPick("success", $project, $order);
            //$this->saveLog($logMessage, Model::LOG_TYPE_SEND_PICK_SUCCESS_EMAIL);
          }
          else
          {
            $this->sendMailPick("fail", $project, $order);
            $this->saveLog($logMessage, Model::LOG_TYPE_SEND_PICK_FAIL_EMAIL);
          }
        }

        return ["state" => "success", "message" => '', 'start_index' => $startIndex, 'total_count' => $totalCounter, 'orders'=> $orders];
        
      }
      else
      {
        return ["state" => "error", "message" => "추첨형 이벤트 타입이 아닙니다."];
      }
    }

    public function sendSMSAfterPickComplete(Request $request, $projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      if ((int)$project->event_type === Project::EVENT_TYPE_PICK_EVENT) {
        
        $startIndex = (int)$request->startindex;
        $take = Project::DATA_CALL_ONETIME_MAX_COUNTER;
        $skip = $startIndex * ($take);

        //$totalCounter = $project->ordersAll()->count();
        $totalCounter = $project->ordersWithoutError()->withTrashed()->where('is_pick', 'PICK')->count();

        $orders = $project->ordersWithoutError()->withTrashed()->where('is_pick', 'PICK')->skip($skip)->take($take)->get();
        foreach($orders as $order)
        {
          if($order->state >= Order::ORDER_STATE_CANCEL_START)
          {
            continue;
          }
          
          if($order->is_pick === 'PICK')
          {
            $logMessage = 'id:'.$order->id."-".$order->email;
            $this->sendPickSuccessSMS($project, $order);
            $this->saveLog($logMessage, Model::LOG_TYPE_SEND_PICK_SUCCESS_SMS);
          }
        }

        return ["state" => "success", "message" => '', 'start_index' => $startIndex, 'total_count' => $totalCounter, 'orders'=> $orders];
        
      }
      else
      {
        return ["state" => "error", "message" => "추첨형 이벤트 타입이 아닙니다."];
      }
    }

    public function addPicking($projectId, $orderId)
    {
      $project = $this->getSecureProjectById($projectId);

      if($project->isPickedComplete())
      {
        return false;
      }

      $order = Order::findOrFail($orderId);

      $order->is_pick = "PICK";
      $order->save();
    }

    public function deletePicking($projectId, $orderId)
    {
      $project = $this->getSecureProjectById($projectId);

      if($project->isPickedComplete())
      {
        return false;
      }

      $order = Order::findOrFail($orderId);

      $order->is_pick = "";
      $order->save();

      $orders = $project->getOrdersWithoutPick();

      return ['state' => 'success', 'orders' => $orders];
    }

    public function sendMailPick($state, $project, $order)
    {
      if(!$project)
      {
        return false;
      }

      if(!$order)
      {
        return false;
      }

      $mailForm = '';
      $subject = '';
      $data = [];

      $to = $order->email;

      if ($state === 'success')
      {
        $mailForm = 'template.emailform.email_pick_success';
        $subject = '(크라우드티켓) 축하드립니다! 이벤트에 당첨되셨습니다!';
      }
      else
      {
        $mailForm = 'template.emailform.email_pick_fail';
        $subject = "(크라우드티켓) 죄송합니다. "."'".$project->title."'"."에 당첨되지 못하셨습니다.";
      }

      $data = [
        'title' => $project->title,
        'name' => $order->name,
        'payDate' => $project->getFundingOrderConcludeAt(),
        'gotoPayPageURL' => url('orders/'.$order->id),
        'gotoProjectURL' => url('projects/'.$project->id),
      ];


      if($this->isCheckEmail($to) == true)
      {
        Mail::send($mailForm, $data, function ($m) use ($subject, $to) {
            $m->from('contact@crowdticket.kr', '크라우드티켓');
            $m->to($to)->subject($subject);
        });
      }
    }

    public function sendPickSuccessSMS($project, $order)
    {
      $sms = new SmsService();
      $contact = $order->contact;
      $limit = $project->type === 'funding' ? 10 : 14;
      $titleLimit = str_limit($project->title, $limit, $end = '..');
      //$totalPrice = number_format($order->total_price);

      //[크라우드티켓] 사랑해 엄마 ‘결제 총액’원 결제 예약 완료
      $msg = sprintf('(당첨!) %s 당첨 되었습니다.', $titleLimit);

      $sms->send([$contact], $msg);
    }

    public function addY($projectId, $orderId)
    {
      $project = $this->getSecureProjectById($projectId);

      if($project->isPickedComplete())
      {
        return false;
      }

      $order = Order::findOrFail($orderId);

      $order->is_pick = "Y";
      $order->save();
    }

    public function deleteY($projectId, $orderId)
    {
      $project = $this->getSecureProjectById($projectId);

      if($project->isPickedComplete())
      {
        return false;
      }

      $order = Order::findOrFail($orderId);

      $order->is_pick = "";
      $order->save();

      $orders = $project->getOrdersWithoutPick();

      return ['state' => 'success', 'orders' => $orders];
    }

    public function isCheckEmail($email)
    {
      $check_email=preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email);

      if($check_email==true)
      {
         //echo "올바른 이메일 형식입니다.";
         return true;
      }
      else
      {
         //echo "잘못된 이메일 형식입니다.";
         return false;
      }
    }

    public function test($projectId)
    {
      /*
      //$project = Project::where('alias', '=', $projectId)->firstOrFail();
      $project = Project::findOrFail($projectId);
      
      $project->load(['category', 'city', 'tickets']);
      $project->countSessionDependentViewNum();
      $posterJson = $this->getPosterUrl($project);
      $ticketsCountInfoListJson = $project->getAmountTicketCountInfoList();
      //return view('project.detail_renew', [
      return view('test', [
          'project' => $project,
          'posters' =>$posterJson,
          //'ticketsCountInfoJson' => $ticketsCountInfoListJson,
          'ticketsCountInfoJson' => $ticketsCountInfoListJson,
          'categories_ticket' => Categories_ticket::whereNotIn('order_number', [0])->orderBy('order_number')->get(),
          'is_master' => \Auth::check() && \Auth::user()->isOwnerOf($project)
      ]);
      */
    }

    public function saveLog($message, $type)
    {
      $logURL = Model::getS3Directory(Model::S3_LOG_PROCESS_DIRECTORY).'crowdticket-process'.date("Y-m-d").'.log';

      $comma = ',';

      if(Storage::disk('s3-log')->exists($logURL) == false)
      {
        Storage::disk('s3-log')->put($logURL, '');
        $comma = '';//처음 파일 생성시 콤마를 뺀다.JSON포맷
      }

      $log = [
          'time' => date('Y-m-d H:i:s', time()),
          'type' => $type,
          'message' => $message
          ];

      $log = json_encode($log);

      //$log = $comma.$log.PHP_EOL;
      $log = $comma.$log;
      
      //Save string to log, use FILE_APPEND to append.
      Storage::disk('s3-log')->append($logURL, $log);
    }
}
