<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\PasswordBroker $passwords
     * @return void
     */
    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;

        // $this->middleware('guest');
    }

    public function postEmail(Request $request)
    {        
      $this->validate($request, array('email' => 'required|email'));
        $response = $this->passwords->sendResetLink($request->only('email'), function ($m) {
            $m->subject('[크티] 비밀번호 재설정 안내');
        });
        switch ($response) {
            case PasswordBroker::RESET_LINK_SENT:
                // return redirect()->back()->with('status', trans($response));
                return ['state' => 'success'];
            case PasswordBroker::INVALID_USER:
                return ['state' => 'error', 'message' => '미가입된 이메일 입니다'];
                // return redirect()->back()->withErrors(array('email' => trans($response)));
        }
    }

    /**
	 * Reset the given user's password.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function postReset(Request $request)
	{
		$this->validate($request, [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed',
		]);

		$credentials = $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);

		$response = $this->passwords->reset($credentials, function($user, $password)
		{
			$user->password = bcrypt($password);

			$user->save();

			$this->auth->login($user);
		});

		switch ($response)
		{
            case PasswordBroker::PASSWORD_RESET:
                return ['state' => 'success', 'user_id' => \Auth::user()->id ,'goDirect' => ''];
				// return redirect($this->redirectPath());
            case PasswordBroker::INVALID_USER:
                return ['state' => 'error', 'message' => '가입되어 있지 않는 이메일 입니다.'];
            case PasswordBroker::INVALID_PASSWORD:
                return ['state' => 'error', 'message' => '패스워드가 다릅니다.'];
            case PasswordBroker::INVALID_TOKEN:
                return ['state' => 'error', 'message' => '유효하지 않는 토큰입니다.'];
			default:
				return redirect()->back()
							->withInput($request->only('email'))
							->withErrors(['email' => trans($response)]);
		}
	}

}
