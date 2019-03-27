<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User as User;
use Laravel\Socialite\Facades\Socialite as Socialite;
use Illuminate\Http\Request as Request;

class SocialAuthController extends Controller
{
    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
    }

    public function redirect()
    {
        return Socialite::with('facebook')->redirect();
    }

    //public function gologin($facebookid, $facebookName, $facebookEmail, $previousURL)
    public function goSocialLogin(Request $request)
    {
      $socialType = '';

      $socialUser = $request->all();

      $user = $this->findOrCreateUser($socialUser);

      \Auth::login($user, true);

      return ['state' => 'success', 'test' => $user];

    }

    public function callback(Request $request)
    {
      \Log::info('facebook callback : ' . $request);

      //return $request;
        //$facebookUser = Socialite::with('facebook')->user();
        //$user = $this->findOrCreateUser($facebookUser);

        //print($user);
        //\Auth::login($user, true);

        //return \Redirect::to('/');
    }

    private function findOrCreateUser($socialUser)
    {
      //페이스북 아이디가 있으면 해당 계정을 넘겨준다.
      $email = $socialUser['email'];
      $socialType = $socialUser['type'];
      if($socialType === 'FACEBOOK')
      {
        if ($user = User::where('facebook_id', $socialUser['id'])->first()) {
            return $user;
        }

        //이메일을 찾았는데, 이메일이 있으면 페이스북 id를 등록해준다.
        if ($user = User::where('email', $email)->first()) {
            $user->facebook_id = $socialUser['id'];
            if(!$user->profile_photo_url)
            {
              $user->profile_photo_url = $socialUser['profile_photo_url'];
            }
            else
            {
              if($this->isSocialPhotoURL($user->profile_photo_url))
              {
                //자체 이미지인 경우에는 저장하지 않는다.
                $user->profile_photo_url = $socialUser['profile_photo_url'];
              }
            }

            $user->save();
            return $user;
        }

        //둘다 없으면 email 을 가져온다.
        $email = $this->getFacebookEmail($socialUser);
      }
      else if($socialType === 'GOOGLE')
      {
        if ($user = User::where('google_id', $socialUser['id'])->first()) {
          $photoURL = $this->updateSocialPhotoURL($user->profile_photo_url, $socialUser['profile_photo_url']);
          if($photoURL)
          {
            $user->profile_photo_url = $photoURL;
            $user->save();
          }
          return $user;
        }

        //이메일을 찾았는데, 이메일이 있으면 페이스북 id를 등록해준다.
        if ($user = User::where('email', $email)->first()) {
            $user->google_id = $socialUser['id'];

            if(!$user->profile_photo_url)
            {
              $user->profile_photo_url = $socialUser['profile_photo_url'];
            }
            else
            {
              if($this->isSocialPhotoURL($user->profile_photo_url))
              {
                //자체 이미지인 경우에는 저장하지 않는다.
                $user->profile_photo_url = $socialUser['profile_photo_url'];
              }
            }

            $user->save();

            return $user;
        }

      }

      //위의 둘다 없으면 아이디를 새로 가입해준다.
      $user = User::create([
          'email' => $email,
          'name' => $socialUser['name'],
          'profile_photo_url' => $socialUser['profile_photo_url'],
          'password' => $socialUser['id']
      ]);

      if($socialType === 'FACEBOOK')
      {
        //유저 새로 생성후 소셜 ID 값 셋팅
        $user->facebook_id = $socialUser['id'];
      }
      else if($socialType === 'GOOGLE')
      {
        $user->google_id = $socialUser['id'];
      }

      return $user;

      /*
      //페이스북 아이디가 있으면 해당 계정을 넘겨준다.
      if ($user = User::where('facebook_id', $facebookUser['id'])->first()) {
          return $user;
      }

      //이메일을 찾았는데, 이메일이 있으면 페이스북 id를 등록해준다.
      $email = $facebookUser['email'];
      if ($user = User::where('email', $email)->first()) {
          $user->facebook_id = $facebookUser['id'];
          $user->profile_photo_url = $facebookUser['avatar'];
          $user->save();
          return $user;
      }

      //위의 둘다 없으면 아이디를 새로 가입해준다.
      $user = User::create([
          'email' => $this->getFacebookEmail($facebookUser),
          'name' => $facebookUser['name'],
          'profile_photo_url' => $facebookUser['avatar'],
          'password' => $facebookUser['id']
      ]);
      $user->facebook_id = $facebookUser['id'];
      return $user;
      */
    }

    private function updateSocialPhotoURL($nowURL, $newURL)
    {
      if(!$nowURL)
      {
        $nowURL = $newURL;
        return $nowURL;
      }
      else
      {
        if($this->isSocialPhotoURL($nowURL))
        {
          //자체 이미지인 경우에는 저장하지 않는다.
          if($nowURL != $newURL)
          {
            $nowURL = $newURL;
            return $nowURL;
          }
        }
      }

      return false;
    }

    private function getFacebookEmail($facebookUser) {
        if ($facebookUser['email']) {
            return $facebookUser['email'];
        }
        return $facebookUser['id'] . '@facebook.com';
    }

    private function isSocialPhotoURL($profile_photo_url){
      $result = strstr($profile_photo_url, 'crowdticket0');
      if($result)
      {
        return false;
      }

      return true;
    }
/*
    public function __construct(Socialite $socialite)
    {
        $this->socialite = $socialite;
    }

    public function redirect()
    {
        return Socialite::with('facebook')->redirect();
    }

    public function callback()
    {
        $facebookUser = Socialite::with('facebook')->user();
        $user = $this->findOrCreateUser($facebookUser);

        //print($user);
        \Auth::login($user, true);

        return \Redirect::to('/');
    }

    private function findOrCreateUser($facebookUser)
    {
        if ($user = User::where('facebook_id', $facebookUser->id)->first()) {
            return $user;
        }

        $user = User::create([
            'email' => $this->getFacebookEmail($facebookUser),
            'name' => $facebookUser->name,
            'profile_photo_url' => $facebookUser->avatar,
            'password' => $facebookUser->id
        ]);
        $user->facebook_id = $facebookUser->id;
        return $user;
    }

    private function getFacebookEmail($facebookUser) {
        if ($facebookUser->email) {
            return $facebookUser->email;
        }
        return $facebookUser->id . '@facebook.com';
    }
*/
}
