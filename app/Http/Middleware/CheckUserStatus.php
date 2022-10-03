<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //If the status is not approved redirect to login
        if (Auth::check() && Auth::user()->status != 'activé') {
            Auth::logout();
            return redirect('/login')->with('userStatus', 'votre compte est désactivé contactez votre administrateur.');
        }

        return $next($request);
    }
}
