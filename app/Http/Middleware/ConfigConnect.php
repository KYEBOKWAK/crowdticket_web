<?php namespace App\Http\Middleware;

use App\Models\Model as Model;
use Symfony\Component\HttpFoundation\Cookie;
use Storage as Storage;

use Closure;

class ConfigConnect {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$configFileURL = Model::getS3Directory(Model::S3_CONFIG_DIRECTORY) . 'config.json';

		$this->initConfigCookie();

		if(Storage::disk('s3')->exists($configFileURL) == true){
			$configJSON = Storage::get($configFileURL);

			$configJSON = json_decode($configJSON);

			if(isset($configJSON->notification))
			{
				setcookie("cr_config_notification",$configJSON->notification, 0, '/');
			}
		}

		return $next($request);
	}

	protected function initConfigCookie()
	{
		setcookie("cr_config_notification",'', 0, '/');
	}

	protected function addCookieToResponse($request, $response, $key, $value)
	{
		$response->headers->setCookie(new Cookie($key, $value, 0, '/', null, false, false));

		return $response;
	}

}
