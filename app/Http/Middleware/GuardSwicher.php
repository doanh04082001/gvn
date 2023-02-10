<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;

class GuardSwicher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if ($guard && in_array($guard, array_keys(config('auth.guards')))) {
            Auth::setDefaultDriver($guard);
        }

        return $next($request);
    }
}
