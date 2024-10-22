<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class InitialPwdChangedMiddleware
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
        if(Auth::user()->init_pwd_changed == 0)
        {
            return redirect()->route('passwordreset');
        }
        return $next($request);
//        return $next($request);
    }
}
