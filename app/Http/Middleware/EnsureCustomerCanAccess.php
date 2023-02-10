<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Exceptions\UserAccess\UserBlockException;
use App\Exceptions\UserAccess\UserUnverifiedException;

class EnsureCustomerCanAccess
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
        if (auth()->user()->status == Customer::STATUS_INACTIVE) {
            throw new UserBlockException();
        }

        if (!auth()->user()->verified_at) {
            throw new UserUnverifiedException();
        }
        
        return $next($request);
    }
}
