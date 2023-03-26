<?php

namespace App\Http\Middleware;

use Closure;

class isCustomerLogin
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
        if (session('isCustomerLogin')) {
            return $next($request);
        } else {
            return redirect('/login');
        }
    }
}
