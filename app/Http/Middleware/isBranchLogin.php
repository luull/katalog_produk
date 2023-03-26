<?php

namespace App\Http\Middleware;

use Closure;

class isBranchLogin
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
        if (session('isBranchLogin')) {
            return $next($request);
        } else {
            return redirect('/branch/login');
        }
    }
}
