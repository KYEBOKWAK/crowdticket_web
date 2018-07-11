<?php namespace App\Http\Controllers;

use App\Models\Blueprint as Blueprint;
use App\Models\Category as Category;
use App\Models\City as City;
use App\Models\Model as Model;
use App\Models\Project as Project;
use Illuminate\Http\Request as Request;
use Illuminate\Http\Response;
use Storage as Storage;

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
            $posterUrl = $this->uploadPosterImage($request, $project);
            $project->setAttribute('poster_url', $posterUrl);
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
        if ($project->isUnderConstruction()) {
            return view('project.form_not_permitted');
        } else {
            $project->load('tickets');
            $tab = $this->getValidUpdateFormTab();
            return view('project.form', [
                'selected_tab' => $tab,
                'project' => $project,
                'categories' => Category::orderBy('id')->get(),
                'cities' => City::orderBy('id')->get()
            ]);
        }
    }

    private function getValidUpdateFormTab()
    {
        $tab = \Input::get('tab');
        switch ($tab) {
            case 'base':
            case 'reward':
            case 'ticket':
            case 'poster':
            case 'story':
            case 'creator':
                return $tab;
            default:
                return 'base';
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

      //var_dump($isNewArray);
      return $isNewArray;
    }

    private function getProjectDetailView($project, $isArrayNew)
    {
        $project->load(['category', 'city', 'tickets']);
        $project->countSessionDependentViewNum();
        return view('project.detail', [
            'project' => $project,
            'isArrayNew' => $isArrayNew,
            'is_master' => \Auth::check() && \Auth::user()->isOwnerOf($project)
        ]);
    }

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
