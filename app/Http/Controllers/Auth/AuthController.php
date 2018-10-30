<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request as Request;
use App\Models\User as User;

use Auth;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard $auth
     * @param  \Illuminate\Contracts\Auth\Registrar $registrar
     * @return void
     */
    public function __construct(Guard $auth, Registrar $registrar)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;

        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function postLogin(Request $request)
  	{
      $message = $this->getFailedLoginMessage();

      if($this->socialIdCheck() == 'isFacebook')
      {
        $message = [];
        array_push($message, '해당 이메일은 페이스북 계정으로 가입되어 있습니다. ');
        array_push($message, '로그인을 원하시면 비밀번호 찾기로 새로운 비밀번호를 등록 후 사용해주세요.');
      }

  		$this->validate($request, [
  			'email' => 'required|email', 'password' => 'required',
  		]);

  		$credentials = $request->only('email', 'password');

  		if ($this->auth->attempt($credentials, $request->has('remember')))
  		{
  			return redirect()->intended($this->redirectPath());
  		}

  		return redirect($this->loginPath())
  					->withInput($request->only('email', 'remember'))
  					->withErrors([
  						'email' => $message,
  					]);

      //return view('test', ['project'=>$this->socialIdCheck()]);
  	}

    public function socialIdCheck()
    {
      $email = \Input::get('email');

      if ($user = User::where('email', $email)->first()) {
        //가입되어 있는 아이디가 있다면, 페이스북으로 가입 되어 있는지 확인한다.
        if($user->facebook_id)
        {
          return 'isFacebook';
        }
      }

      return '';
    }


    protected function getFailedLoginMessage()
    {
        return '가입되어 있지 않은 이메일이거나 비밀번호가 일치하지 않습니다.';
    }

}
