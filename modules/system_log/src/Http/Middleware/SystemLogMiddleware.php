<?php

namespace Zent\SystemLog\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SystemLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        /*
         *  Type here
         */
    }
}
