<?php

namespace Zent\Job\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class JobMiddleware
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
