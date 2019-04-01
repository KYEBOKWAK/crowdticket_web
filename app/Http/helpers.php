<?php

if ( ! function_exists('url'))
{
	/**
	 * Generate a url for the application.
	 *
	 * @param  string  $path
	 * @param  mixed   $parameters
	 * @param  bool    $secure
	 * @return string
	 */
	function url($path = null, $parameters = array(), $secure = null)
	{
    $secure = true;
		if(env('APP_TYPE') === 'local')
    {
      $secure = false;
    }
    
		return app('Illuminate\Contracts\Routing\UrlGenerator')->to($path, $parameters, $secure);
	}
}

if ( ! function_exists('asset'))
{
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool    $secure
	 * @return string
	 */
	function asset($path, $secure = null)
	{
    $secure = true;
		if(env('APP_TYPE') === 'local')
    {
      $secure = false;
    }

		return app('url')->asset($path, $secure);
	}
}

?>
