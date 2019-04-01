<?php

if ( ! function_exists('url'))
{

	function url($path = null, $parameters = array(), $secure = null)
	{
    $secure = true;
		if(env('APP_TYPE'))
    {
      $secure = false;
    }
    else if($_SERVER['HTTP_HOST'] === 'qa.crowdticket.kr')
    {
        $secure = true;
    }

		return app('Illuminate\Contracts\Routing\UrlGenerator')->to($path, $parameters, $secure);
	}
}

if ( ! function_exists('asset'))
{

	function asset($path, $secure = null)
	{
    $secure = true;
		if(env('APP_TYPE'))
    {
      $secure = false;
    }
    else if($_SERVER['HTTP_HOST'] === 'qa.crowdticket.kr')
    {
        $secure = true;
    }

		return app('url')->asset($path, $secure);
	}
}

?>
