<?php

namespace App\Http\Middleware;

use Closure;


class IsAdmin
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
        if(!$request->user() || $request->user()->email == 'zterry@example.como') {
            return abort(401, 'Unauthorised user.');
        }

        return $next($request);
    }
}
