<?php

use App\Http\Controllers\Api\Customer\CustomerHotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Customer\AuthController;
use App\Http\Controllers\Api\Customer\CustomerCategoryController;
use App\Http\Controllers\Api\Customer\CustomerMallController;
use App\Http\Controllers\Api\Customer\CustomerMuseumController;
use App\Http\Controllers\Api\Customer\CustomerSettingController;
use App\Http\Controllers\Api\Customer\CustomerEventController;
use App\Http\Controllers\Api\Customer\CustomerMessageController;
use App\Http\Controllers\Api\Customer\CustomerRestaurantsController;
use Illuminate\Support\Facades\Cache;

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('resend-otp', 'resendOtp');
    Route::post('forget-password' , 'forgetPassword');
    Route::post('reset-password' , 'resetPassword')->middleware(['auth:sanctum', 'ability:reset-password']);
    Route::post('google-login', 'handleGoogleLogin');
    Route::post('verify-account' , 'verifyLoginOtp');
    Route::post('verify-otp/reset-password' , 'verifyResetPasswordOtp');
});



/*|----- Customer routes |----*/
Route::prefix('customer')->as('customer.')->group(function () {
    Route::apiResource('hotels',CustomerHotelController::class)->only('show','index');
    Route::apiResource('malls',CustomerMallController::class)->only('show','index');
    Route::apiResource('museums',CustomerMuseumController::class)->only('show','index');
    Route::apiResource('events',CustomerEventController::class)->only('show','index');
    Route::apiResource('restaurants',CustomerRestaurantsController::class)->only('show','index');
    Route::apiResource('services',CustomerServiceController::class)->only('show','index');
    
    /*|----- settings routes |----*/
    Route::get('categories',[CustomerCategoryController::class,'index']);

    /*|----- settings routes |----*/
    Route::get('settings',[CustomerSettingController::class,'index']);

    /*
    |--------------------------------------------------------------------------
    | Chats routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth:sanctum'])->controller(CustomerMessageController::class)->group(function () {
        Route::get('get-all-conversations','getAllConversation');
        Route::get('get-conversation-chats/{id}','getConversationChats');
        Route::post('send-message','sendMessage');
        Route::post('update-message/{id}','updateMessage');
        Route::delete('delete-message/{id}','deleteMessage');
    });

});



/*
|--------------------------------------------------------------------------
| admin routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/admin.php';

