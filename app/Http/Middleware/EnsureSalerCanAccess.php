<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use App\Exceptions\UserAccess\UserBlockException;

class EnsureSalerCanAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->status == User::STATUS_INACTIVE) {
            throw new UserBlockException();
        }

        return $next($request);
    }
}
