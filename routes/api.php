<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\AuthController;

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('forget-password' , 'forgetPassword');
    Route::post('reset-password' , 'resetPassword')->middleware(['auth:sanctum', 'ability:reset-password']);
    Route::get('login-google-callback', 'handleGoogleCallback');
    Route::post('verify-otp/login' , 'verifyLoginOtp');
    Route::post('verify-otp/reset-password' , 'verifyResetPasswordOtp');
});



/*
|--------------------------------------------------------------------------
| admin routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/admin.php';

