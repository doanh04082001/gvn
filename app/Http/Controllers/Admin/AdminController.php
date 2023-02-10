<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    /**
     * The path to the "dashboard" route for your admin.
     *
     * This is used by Laravel authentication of admin page to redirect users after login.
     *
     * @var string
     */
    public const HOME = 'admin/';
}
