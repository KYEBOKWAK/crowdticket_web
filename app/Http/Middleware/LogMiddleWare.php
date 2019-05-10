<?php namespace App\Http\Middleware;

use Illuminate\Http\Request as Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Model as Model;
use Storage as Storage;

use Closure;

class LogMiddleWare {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$userip = $this->getUserIP();
		if(strpos((string)$userip, env('ADMIN_IP', '')))
		{	
			//회사에서 접속할 경우는 제외
			return $next($request);
		}

		$goURL = str_replace(url(), '', $request->url());
		if($goURL === '/ping')
		{
			return $next($request);
		}
		
		$ga_id = '';
		$cr_id = '';

		if(isset($_COOKIE['_ga']))
		{
			$ga_id = $_COOKIE['_ga'];
		}
		else
		{
			//ga 정보가 없으면 우선 다음 url 로 request 한다.
			//ga쿠키정보가 없다면, 신규 사용자임.

			setcookie("cr_newuser", true, 0, '/');
			return $next($request);
		}

		$isNewUser = false;

		if(isset($_COOKIE['cr_newuser']))
		{
			$isNewUser = true;
			setcookie("cr_newuser", false, 0, '/');
		}

		//$logURL = storage_path().'/logs'.'/crowdticket-'.date("Y-m-d").'.log';

		$logURL = Model::getS3Directory(Model::S3_LOG_DIRECTORY).'crowdticket-'.date("Y-m-d").'.log';

		$comma = ',';

		if(Storage::disk('s3-log')->exists($logURL) == false)
		{
			Storage::disk('s3-log')->put($logURL, '');
			$comma = '';//처음 파일 생성시 콤마를 뺀다.JSON포맷
		}

		if(!Auth::guest())
		{
			$cr_id = Auth::id();
		}

		//기기
		//$AppFrom = $request->header('x-requested-with');
		$fromLink = '';
		$useragent = $request->header('user-agent');
		$device = 'PC';
		$deviceOS = "";
		$previousURL = str_replace(url(), '', $request->header('referer'));

		//앱 링크타고 왔는지,
		if(strpos($useragent, 'KAKAOTALK'))
		{
			$fromLink = 'kakaotalk';
		}
		else if(strpos($useragent, 'FB_IAB'))
		{
			$fromLink = 'facebook_app';
		}
		
		if(strpos($previousURL, 'm.facebook.com'))
		{
			$fromLink = 'facebook_mobile_web';
		}
		else if(strpos($previousURL, 'facebook.com'))
		{
			$fromLink = 'facebook_pc_web';
		}
		
		//디바이스 정보 가져오기 START
		if(strpos($useragent, 'Windows'))
		{
			$device = "pc";
			$deviceOS = 'windows';
		}
		else if(strpos($useragent, 'Macintosh'))
		{
			$device = "pc";
			$deviceOS = 'mac';
		}
		else if(strpos($useragent, 'Android'))
		{
			$device = "mobile";
			$deviceOS = 'android';
		}
		else if(strpos($useragent, 'iPhone'))
		{
			$device = "mobile";
			$deviceOS = 'iphone';
		}
		//디바이스 정보 가져오기 END

		$log = [
				'time' => date('Y-m-d H:i:s', time()),
				'userip' => $userip,
				'ga_user' => $ga_id,
				'cr_user' => $cr_id,
				'step_previous' => $previousURL,
				'step_go' => $goURL, //원본
				//'appfrom' => $request->header('x-requested-with'),
				'fromlink' => $fromLink,
				'device' => $device,
				'deviceOS' => $deviceOS,
				'isNewUser' => $isNewUser
				//'useragent' => $useragent,
				];

		$log = json_encode($log);

		//$log = $comma.$log.PHP_EOL;
		$log = $comma.$log;
		
		//Save string to log, use FILE_APPEND to append.
		Storage::disk('s3-log')->append($logURL, $log);

		return $next($request);
	}

	protected function getUserIP()
	{
		// Get real visitor IP behind CloudFlare network
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
				$_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
				$_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
		}
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];

		if(filter_var($client, FILTER_VALIDATE_IP))
		{
			$ip = $client;
		}
		elseif(filter_var($forward, FILTER_VALIDATE_IP))
		{
			$ip = $forward;
		}
		else
		{
			$ip = $remote;
		}

		return $ip;
	}

}
