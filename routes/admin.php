<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\User\UserController;

Route::get('/login', [AdminLoginController::class, 'showLoginForm']);

Route::post('/login', [AdminLoginController::class, 'login'])
    ->name('admin.login');

// protected admin routes
Route::group([
    'middleware' => ['auth', 'admin.auth'],
    'as' => 'admin.'
], function() {

    Route::get('/', [AdminController::class, 'index'])
        ->name('dashboard');

    Route::resource('users', UserController::class);

});