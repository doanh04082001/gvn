<?php

namespace App\Http\Controllers\Admin\Auth;

trait AdminRedirectsUsers
{
    /**
     * Redirect to admin dashboard
     * @return string
     */
    public function redirectTo()
    {
        return route('admin.dashboard');
    }
}
