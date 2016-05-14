<?php namespace App\Http\Middleware;

use Closure;

class AdminAuthenticate
{

    public function handle($request, Closure $next)
    {
        if (\Auth::check()) {
            if ($this->isAdmin(\Auth::user())) {
                return $next($request);
            }
        }

        return response('Unauthorized.', 401);
    }

    private function isAdmin($user)
    {
        return \DB::table('admins')->where('user_id', '=', $user->id)->count() > 0;
    }

}
