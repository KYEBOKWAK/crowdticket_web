<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Mail;
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

    public function postRegister(Request $request)
    {
      $email = \Input::get('email');

      $validator = $this->registrar->validator($request->all());
      if ($validator->fails()) {
          //return ['request' => 'error', 'message' => $validator->messages()];
          return ['state' => 'error', 'message' => $validator->messages()];
      }
      $this->auth->login($this->registrar->create($request->all()));

      //\Redirect::action('MailSendController@sendEmailRegister', ['email' => $email, 'redirectPath'=>$this->redirectPath()]);
      //email send
      $from = 'contact@crowdticket.kr';
      $fromName = '크라우드티켓';
      $to = $email;
      $email_subject = "크라우드티켓 회원이 되어 주셔서 감사합니다!"; // 메일 제목에 해당하는 부분
      $email_body = [];
      Mail::send('template.emailform.email_register', $email_body, function ($m) use ($email_subject, $to, $from, $fromName)
      {
                $m->from($from, $fromName);
                $m->to($to)->subject($email_subject);
      });

      //end end

      //return ['request' => 'success', 'email' => $email];
      return ['state' => 'success', 'email' => $email, 'user_id' => Auth::user()->id];

    }

    public function postLogin(Request $request)
  	{
      $message = $this->getFailedLoginMessage();

      if($this->socialIdCheck() == 'isFacebook')
      {
        $message = [];
        array_push($message, '해당 이메일은 페이스북 계정으로 가입되어 있습니다.');
        array_push($message, '페이스북 계정으로 계속 하시거나, 비밀번호 찾기로 비밀번호를 등록 후 사용해주세요.');
      }

  		$this->validate($request, [
  			//'email' => 'required|email', 'password' => 'required'
        'email' => 'required', 'password' => 'required'
  		]);

  		$credentials = $request->only('email', 'password');

      //기존 로그인
      if ($this->auth->attempt($credentials, $request->has('remember')))
      {
        if($request->has('ispopup'))
        {
          //팝업 로그인
          return ['state' => 'success', 'user_id' => Auth::user()->id ,'goDirect' => ''];
        }
        else
        {
          return redirect()->intended($this->redirectPath());
        }
      }

      //로그인 실패시
      if($request->has('ispopup'))
      {
        $hasSocialType = $this->socialIdCheck();
        if($hasSocialType == 'isAllSocial')
        {
          $message = '페이스북, 구글 계정으로 가입되어 있는 이메일 입니다. 소셜 계정으로 계속 하시거나, 비밀번호 찾기로 비밀번호를 등록 후 사용해주세요.';
        }
        else if($hasSocialType == 'isGoogle')
        {
          $message = '이미 구글으로 가입되어 있습니다. 구글 계정으로 계속 하시거나, 비밀번호 찾기로 비밀번호를 등록 후 사용해주세요.';
        }
        else if($hasSocialType == 'isFacebook')
        {
          $message = '이미 페이스북으로 가입되어 있습니다. 페이스북 계정으로 계속 하시거나, 비밀번호 찾기로 비밀번호를 등록 후 사용해주세요.';
        }

        return ['state' => 'fail', 'message' => $message];
      }
      else
      {
        return redirect($this->loginPath())
              ->withInput($request->only('email', 'remember'))
              ->withErrors([
                'email' => $message,
              ]);
      }


      //return view('test', ['project'=>$this->socialIdCheck()]);

  	}

    public function socialIdCheck()
    {
      $email = \Input::get('email');

      if ($user = User::where('email', $email)->first()) {
        //가입되어 있는 아이디가 있다면, 페이스북으로 가입 되어 있는지 확인한다.
        if($user->facebook_id && $user->google_id)
        {
          return 'isAllSocial';
        }
        else if($user->facebook_id)
        {
          return 'isFacebook';
        }
        else if($user->google_id)
        {
          return 'isGoogle';
        }
      }

      return '';
    }


    protected function getFailedLoginMessage()
    {
        return '가입되어 있지 않은 이메일이거나 비밀번호가 일치하지 않습니다.';
    }

    public function getLogin()
    {
      return view('auth.login', ['redirectPath' => redirect()->back()->getTargetUrl()]);
    }

    /*

    public function getLogin()
    {
      $previousUrl = app('url')->previous();

      $previousUrl = strtok($previousUrl, '?');

      return redirect()->to($previousUrl.'?'. http_build_query(['loginState'=>'login']));
    }

    public function getRegister()
    {
      $previousUrl = app('url')->previous();

      $previousUrl = strtok($previousUrl, '?');

      return redirect()->to($previousUrl.'?'. http_build_query(['loginState'=>'loginRegister']));
    }
    */

}
