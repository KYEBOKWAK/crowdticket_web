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
use App\Services\SmsService;

use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Storage as Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
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

    public function getProjects()
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
        $isArrayNew = $this->isArrayNew($project);

        return $this->getProjectDetailView($project, $isArrayNew);
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
        $isArrayNew = $this->isArrayNew($project);

        return $this->getProjectDetailView($project, $isArrayNew);
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

    private function getProjectDetailView($project, $isArrayNew)
    {
        $project->load(['category', 'city', 'tickets']);
        $project->countSessionDependentViewNum();
        $posterJson = $this->getPosterUrl($project);
        $ticketsCountInfoListJson = $project->getAmountTicketCountInfoList();
        return view('project.detail_renew', [
            'project' => $project,
            'isArrayNew' => $isArrayNew,
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
        $orders = $project->ordersWithoutError()->withTrashed()->get();


        //주문자 정보 START
        $ordersWithTime = [];
        //최종 정리된 타임을 기준으로 주문자를 정렬한다.
        foreach($orders as $order)
        {
          $ticket = $order->ticket;
          if(!$ticket)
          {
            continue;
          }

          $ticketTimeUnix = strtotime($ticket->show_date);

          $isSameTicket = false;

          foreach($ordersWithTime as $key => $value)
          {
            //같은 티켓이면 order 데이터에 쌓아준다.
            if($ticketTimeUnix === $value['show_date_unix'] && $ticket->id === $value['ticketId'])
            {
              $isSameTicket = true;
              //중복된 값 셋팅
              array_push($ordersWithTime[$key]['orders'], $this->getSuperviseOrderList($order, $project));
              break;
            }
          }

          if($isSameTicket)
          {
            continue;
          }

          //셋팅되지 않은 티켓 정보 최초 셋팅
          $tempTicket['show_date_unix'] = $ticketTimeUnix;
          $tempTicket['show_date'] = $ticket->show_date;
          $tempTicket['ticketId'] = $ticket->id;
          $tempTicket['isPlaceTicket'] = $ticket->isPlaceTicket();

          $tempTicket['ticket_category'] = $ticket->getSeatCategory();

          //티켓 셋팅
          $tempTicket['orders'] = [];
          array_push($tempTicket['orders'], $this->getSuperviseOrderList($order, $project));

          array_push($ordersWithTime, $tempTicket);
        }

        $ordersWithTimeJson = json_encode($ordersWithTime);

        //주문자 정보 END

        //티켓 미구매 리스트
        $ordersNoBuyTicket = [];
        $tempNoTicket['orders'] = [];

        foreach($orders as $order)
        {
          $ticket = $order->ticket;
          if($ticket)
          {
            continue;
          }

          array_push($tempNoTicket['orders'], $this->getSuperviseOrderList($order, $project));
        }

        array_push($ordersNoBuyTicket, $tempNoTicket);

        $ordersNoBuyTicketJson = json_encode($ordersNoBuyTicket);

        //전체리스트

        $ordersAllTicket = [];
        $tempAllTicket['orders'] = [];

        $orderAll = $project->ordersWithoutError()->withTrashed()->get();

        foreach($orderAll as $order)
        {
          array_push($tempAllTicket['orders'], $this->getSuperviseOrderList($order, $project));
        }

        array_push($ordersAllTicket, $tempAllTicket);

        $ordersAllWithTimeJson = json_encode($ordersAllTicket);

        return view('project.orders', [
            'project' => $project,
            'ordersWithTimeJson' => $ordersWithTimeJson,
            'ordersNoTicketJson' => $ordersNoBuyTicketJson,
            'ordersAllWithTimeJson' => $ordersAllWithTimeJson,
            //'ordersAllWithTimeJson' => $orders,
        ]);
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

      //주문자 정보 START
      $pickingArray = $project->getOrdersOnlyPick();
      //최종 정리된 타임을 기준으로 주문자를 정렬한다.

      $ordersJson = json_encode($orders);
      $pickingJson = json_encode($pickingArray);

      //임시코드
      $pickingYList = $project->getOrdersWithPickY();
      $pickingYList = json_encode($pickingYList);

      return view('project.picking', [
          'project' => $project,
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
      $pickingArray = $project->getOrdersOnlyPick();
      //최종 정리된 타임을 기준으로 주문자를 정렬한다.

      $ordersJson = json_encode($orders);
      $pickingJson = json_encode($pickingArray);

      return view('project.picking_rand', [
          'project' => $project,
          'orderList' => $ordersJson,
          'pickingOldList' => $pickingJson
      ]);
    }

    public function requestPickingRandom($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      $orders = $project->getOrdersWithPickY();
      //$orders = $project->getOrdersWithoutPick();

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

    public function pickingComplete($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      if($project->isPickedComplete())
      {
        return false;
      }

      if ((int)$project->event_type === Project::EVENT_TYPE_PICK_EVENT) {
          foreach ($project->orders as $order) {
            if($order->is_pick != 'PICK')
            {
              app('App\Http\Controllers\OrderController')->deleteOrder($order->id, Order::ORDER_STATE_PROJECT_PICK_CANCEL,true);
            }
          }

      }
      else
      {
        return ["state" => "error", "message" => "추첨형 이벤트 타입이 아닙니다."];
      }

      $project->pick_state = Project::PICK_STATE_PICKED;
      $project->save();

      return ["state" => "success", "message" => ""];
    }

    public function sendMailAfterPickComplete($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      $orders = $project->getOrdersWithPickCancel();

      if ((int)$project->event_type === Project::EVENT_TYPE_PICK_EVENT) {
          foreach ($orders as $order) {
            if($order->is_pick == 'PICK')
            {
              $this->sendMailPick("success", $project, $order);
            }
            else
            {
              $this->sendMailPick("fail", $project, $order);
            }
          }

      }
      else
      {
        return ["state" => "error", "message" => "추첨형 이벤트 타입이 아닙니다."];
      }


      return ["state" => "success", "message" => ''];
    }

    public function sendSMSAfterPickComplete($projectId)
    {
      $project = $this->getSecureProjectById($projectId);

      $orders = $project->getOrdersOnlyPick();

      if ((int)$project->event_type === Project::EVENT_TYPE_PICK_EVENT) {
          foreach ($orders as $order) {
            if($order->is_pick == 'PICK')
            {
              $this->sendPickSuccessSMS($project, $order);
            }
          }
      }
      else
      {
        return ["state" => "error", "message" => "추첨형 이벤트 타입이 아닙니다."];
      }

      return ["state" => "success", "message" => ""];
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
      return view('test', [
          'project' => "abc"]);
      //$project = Project::findOrFail($projectId);
      //$project->increment('view_count');
      //return "success";
    }
}
