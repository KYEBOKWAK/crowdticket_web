<?php namespace App\Http\Middleware;

//use Illuminate\Http\Request as Request;

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
		//\Log::info('order info ', ['before_step' => $request, 'next_step' => $request->url()]);
		//\Log::info('order info ', ['before_step' => $request->header('Referer'), 'next_step' => $request->url()]);//외부링크url 이 없음
		//\Log::info('order info ', ['before_step' => $request->getSession()->getName(), 'next_step' => $request->url()]);
		\Log::info('order info ', ['before_step' => $request->getSession()->previousUrl(), 'next_step' => $request->url()]);
		\Log::info('test', ['test' => redirect()->back()]);

		return $next($request);
	}

}
