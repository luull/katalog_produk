<?php

namespace App\Http\Middleware;

use Closure;

class isBackEndLogin
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
        if (session('isBackendLogin')) {
            return $next($request);
        } else {
            return redirect('/backend/login');
        }
    }
}
