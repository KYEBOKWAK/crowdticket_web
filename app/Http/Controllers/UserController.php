<?php namespace App\Http\Controllers;

use Storage as Storage;
use App\Models\Model as Model;
use App\Models\User as User;
use App\Models\Ticket as Ticket;
use App\Models\Project as Project;
use App\Models\Channel as Channel;
use App\Models\Order as Order;
use App\Models\Categories_channel as Categories_channel;
use Illuminate\Http\Request as Request;

class UserController extends Controller
{
  public function updateUserInfo(Request $request, $id)
  {
    $user = $this->ensureLoginUser($id);

    if ($request->file('photo')) {
      $photoUrl = $this->uploadPosterImage($request, $user);
      $user->setAttribute('profile_photo_url', $photoUrl);
    }

    if ($request->has('name')) {
      $user->setAttribute('name', \Input::get('name'));
    }

    if ($request->has('contact')) {
      $user->setAttribute('contact', \Input::get('contact'));
    }

    if ($request->has('email')) {
      $user->setAttribute('email', \Input::get('email'));
    }

    if ($request->has('bank')) {
      $user->setAttribute('bank', \Input::get('bank'));
    }

    if ($request->has('account')) {
      $user->setAttribute('account', \Input::get('account'));
    }

    if ($request->has('account_holder')) {
      $user->setAttribute('account_holder', \Input::get('account_holder'));
    }

    if ($request->has('introduce')) {
      $introduce = \Input::get('introduce');
      $user->setAttribute('introduce', $introduce);
    }
    //channel_category
    //channel_category_url_input

    $channelArray = '';
    for($i = 0 ; $i < 6 ; $i++)
    {
      $channelCategory_Input = 'channel_category'.$i;
      $channelCategoryURL_Input = 'channel_category_url_input'.$i;
      $channelID_Input = 'channelId'.$i;

      if ($request->has($channelCategory_Input) &&
          $request->has($channelCategoryURL_Input)) {
            $channelID = \Input::get($channelID_Input);
            $channelCategoryID = \Input::get($channelCategory_Input);
            $channelCategoryURL = \Input::get($channelCategoryURL_Input);
            $channel = Channel::find($channelID);
            $channelCategory = Categories_channel::findOrFail($channelCategoryID);

            if($channelID == ''){
              //빈값이면 새로 생성
              $channel = new Channel();
            }

            $channel->categories_channel()->associate($channelCategory);
            $channel->user()->associate($user);
            $channel->setAttribute('url', $channelCategoryURL);
            $channel->save();

            $channelArray[$channelID_Input] = $channel->id;
      }
    }

    $channelsJson = json_encode($channelArray);

    $user->save();

    return $channelsJson;
  }

    public function getUser($id)
    {
        $user = User::findOrFail($id);
        return view('user.detail', [
            'user' => $user,
            'orders' => $this->getProjectsByOrders($this->getValidUniqueOrders($user)),
            'created' => $user->projects()->where('state', Project::STATE_APPROVED)->orderBy('id', 'desc')->get(),
            'creating' => $this->getCreatingProject($user)
        ]);
    }

    private function getCreatingProject($user)
    {
        if (\Auth::check()) {
            if ($user->id === \Auth::user()->id) {
                return $user->projects()->where('state', '!=', Project::STATE_APPROVED)->orderBy('id', 'desc')->get();
            }
        }
        return [];
    }

    public function getUpdateForm($id)
    {
        $user = $this->ensureLoginUser($id);
        return $this->getUpdateView($user);
    }

    private function getUpdateView($user, $toast = null)
    {
        return view('user.modify', [
            'user' => $user,
            'toast' => $toast
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = $this->ensureLoginUser($id);
        if ($this->isTryChangePassword()) {
            if ($this->validateUserCredential($user)) {
                $user->password = bcrypt(\Input::get('new_password'));
            } else {
                return $this->getUpdateView($user, $this->messageError('잘못된 비밀번호입니다.'));
            }
        }
        if ($request->file('photo')) {
            $photoUrl = $this->uploadPosterImage($request, $user);
            $user->setAttribute('profile_photo_url', $photoUrl);
        }
        $user->update(\Input::all());
        $user->save();

        return $this->getUpdateView($user, $this->messageSuccess('변경되었습니다.'));
    }

    public function getUserOrders($id)
    {
        $user = $this->ensureLoginUser($id);
        $orders = $this->getFullOrders($user);
        $orders->load('project');
        return view('user.orders', [
            'user' => $user,
            'orders' => $orders
        ]);
    }

    private function getValidUniqueOrders($user)
    {
        return $user->orders()->groupBy('project_id')->get();
    }

    private function getProjectsByOrders($orders)
    {
        $projectIds = [];
        foreach ($orders as $order) {
            array_push($projectIds, $order->project_id);
        }
        return Project::whereIn('id', $projectIds)->get();
    }

    private function getFullOrders($user)
    {
        return $user->orders()->withTrashed()->where('state', '!=', Order::ORDER_STATE_STANDBY)->where('state', '<', Order::ORDER_STATE_ERROR_START)->orderBy('created_at', 'desc')->get();
    }

    private function uploadPosterImage($request, $user)
    {
        $photoUrlPartial = Model::getS3Directory(Model::S3_USER_DIRECTORY) . $user->id . '.jpg';

        Storage::put(
            $photoUrlPartial,
            file_get_contents($request->file('photo')->getRealPath())
        );

        return Model::S3_BASE_URL . $photoUrlPartial;
    }

    private function isTryChangePassword()
    {
        $this->blockDirectChangePassword();
        return \Input::has('new_password');
    }

    private function validateUserCredential($user)
    {
        $credential = [
            'email' => $user->email,
            'password' => \Input::get('old_password')
        ];
        return \Auth::validate($credential);
    }

    private function blockDirectChangePassword()
    {
        if (\Input::has('password')) {
            throw new \App\Exceptions\UnapprovedAccessException;
        }
    }

    private function ensureLoginUser($id)
    {
        $user = User::findOrFail($id);
        $loginUser = \Auth::user();
        if ($user->id === $loginUser->id) {
            return $user;
        }
        throw new \App\Exceptions\OwnershipException;
    }

}
