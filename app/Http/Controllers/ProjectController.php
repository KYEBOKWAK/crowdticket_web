<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;
use App\Models\Category as Category;
use App\Models\Categories_ticket as Categories_ticket;
use App\Models\Categories_channel as Categories_channel;
use App\Models\Maincarousel as Maincarousel;
use App\Models\City as City;
use App\Models\Model as Model;
use App\Models\Project as Project;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Storage as Storage;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        $file = $request->file('image');
        $originalName = $file->getClientOriginalName();
        $hashedName = md5($originalName);
        $storyUrlPartial = Model::getS3Directory(Model::S3_STORY_DIRECTORY) . $project->id . '/' . $hashedName . '.jpg';

        Storage::put(
            $storyUrlPartial,
            file_get_contents($file->getRealPath())
        );

        $imageSize = getimagesize($file);
        $imageWidth = $imageSize[0];
        $imageHeight = $imageSize[1];
        if ($imageWidth > 560) {
            $imageResizeRatio = 560 / $imageWidth;
            $imageWidth = 560;
            $imageHeight = (int)($imageHeight * $imageResizeRatio);
        }

        return [
            'image_url' => Model::S3_BASE_URL . $storyUrlPartial,
            'image_width' => $imageWidth,
            'image_height' => $imageHeight
        ];
    }

    public function uploadNewsImage(Request $request, $id)
    {
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
        $user = Auth::user();
        if($user->id == 1 || $user->id == 2)
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

        //임시로 막아놈. start
        $now = date('Y-m-d H:i:s');

        $total_suppoter = 0;
        $total_view = 0;
        $total_amount = 0;

        //$minExposedNum = 6;
        $minExposedNum = 8;

        $projects = \App\Models\Project::whereNotIn('project_order_number', [0])
            ->orderBy('project_order_number')
            ->take($minExposedNum)->get();

        $lack = $minExposedNum - count($projects);
        if ($lack > 0) {
            $additional = \App\Models\Project::where('state', 4)
                ->where('funding_closing_at', '<', $now)
                ->orderBy('id', 'desc')
                ->take($lack)->get();

            $projects = $projects->merge($additional);
        }

        $total_suppoter = \App\Models\Project::where('supporters_count', '<>', 0)->sum('supporters_count');
        $total_view = \App\Models\Project::where('view_count', '<>', 0)->sum('view_count');
        $total_amount = \App\Models\Project::where('funded_amount', '<>', 0)->sum('funded_amount');

        //maincarousel
        $main_carousel = Maincarousel::orderby('id')->get();
        //$main_carousel = Maincarousel::where('id', '=', 1)->get();

        return view('welcome_new', [
            'projects' => $projects,
            'total_suppoter' => number_format($total_suppoter),
            'total_view' => number_format($total_view),
            'total_amount' => number_format($total_amount),
            'main_carousels' => $main_carousel,
            'isNotYet' => 'TRUE'
        ]);

        ////////////
    }

    private function getPosterUrl($project){

      //$posters = $project->posters()->firstOrFail();
      $posters = $project->posters()->first();
      if(is_null($posters))
      {
        return '';
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
                throw new \App\Exceptions\OwnershipException;
            }
        }
        return $project;
    }

    public function getProjectById($id)
    {
        $project = Project::findOrFail($id);
        $project = $this->getApprovedProject($project);

        //NEW 체크
        $isArrayNew = $this->isArrayNew($project);

        return $this->getProjectDetailView($project, $isArrayNew);
    }

    public function getProjectByAlias($alias)
    {
        $project = Project::where('alias', '=', $alias)->firstOrFail();
        $project = $this->getApprovedProject($project);

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
        return $project;
    }

    private function createProject($blueprint)
    {
        $project = new Project(\Input::all());
        $project->user()->associate($blueprint->user);
        $project->setAttribute('story', ' ');
        $project->setAttribute('type', $blueprint->type);
        $project->save();
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
            return $project;
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
        return view('project.orders', [
            'project' => $project,
            'tickets' => $project->tickets()->with(['orders' => function ($query) {
                $query->withTrashed();
            }, 'orders.user'])->get()
        ]);
    }

}
