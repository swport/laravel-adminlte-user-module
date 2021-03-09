<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Auth\LoginController as Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function redirectPath()
    {
        return '/admin';
    }
}
