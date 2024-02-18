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
});

/*
|--------------------------------------------------------------------------
| Returns All Users
|--------------------------------------------------------------------------
*/
// Route::get('/auth/users', [AuthController::class, 'users']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/auth/users', [AuthController::class, 'users']);
});

