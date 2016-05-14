<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User as User;
use Laravel\Socialite\Facades\Socialite as Socialite;

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

    public function callback()
    {
        $facebookUser = Socialite::with('facebook')->user();
        $user = $this->findOrCreateUser($facebookUser);

        \Auth::login($user, true);

        return \Redirect::to('/');
    }

    private function findOrCreateUser($facebookUser)
    {
        if ($user = User::where('facebook_id', $facebookUser->id)->first()) {
            return $user;
        }

        $user = User::create([
            'email' => $facebookUser->email,
            'name' => $facebookUser->name,
            'profile_photo_url' => $facebookUser->avatar,
            'password' => $facebookUser->id
        ]);
        $user->facebook_id = $facebookUser->id;
        return $user;
    }

}
