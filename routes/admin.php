<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Admin\AdminCustomerController;
use App\Http\Controllers\Api\Admin\AdminHotelController;
use App\Http\Controllers\Api\Admin\AdminOptionController;
use App\Http\Controllers\Api\Admin\AdminSliderController;
use App\Http\Controllers\Api\Admin\AdminMallController;
use App\Http\Controllers\Api\Admin\AdminMuseumController;
use App\Http\Controllers\Api\Admin\AdminEventController;
use App\Http\Controllers\Api\Admin\AdministratorController;
use App\Http\Controllers\Api\Admin\AdminMessageController;
use App\Http\Controllers\Api\Admin\AdminNotificationController;
use App\Http\Controllers\Api\Admin\AdminRestaurantController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->as('admin.')->middleware(['api','cors'])->group(function () {
    /*|----- Auth routes |----*/
    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('login', 'login');
    });

    /*|----- Admin routes |----*/
    Route::middleware(['auth:sanctum', 'ability:admin-login'])->group(function () {
        
        Route::apiResource('hotels',AdminHotelController::class)->except(['update']);
        Route::post('hotels/{id}',[AdminHotelController::class,'update']);

        Route::apiResource('categories',AdminCategoryController::class)->except(['update']);
        Route::post('categories/{id}',[AdminCategoryController::class,'update']);

        Route::apiResource('malls',AdminMallController::class)->except(['update']);
        Route::post('malls/{id}',[AdminMallController::class,'update']);

        Route::apiResource('museums',AdminMuseumController::class)->except(['update','destroy']);
        Route::post('museums/{id}',[AdminMuseumController::class,'update']);

        Route::apiResource('restaurants',AdminRestaurantController::class)->except(['update']);
        Route::post('restaurants/{id}',[AdminRestaurantController::class,'update']);

        Route::apiResource('events',AdminEventController::class)->except(['update']);
        Route::post('events/{id}',[AdminEventController::class,'update']);

        Route::apiResource('options',AdminOptionController::class)->only(['store','destroy']);
        Route::post('options/{id}',[AdminOptionController::class,'update']);
        Route::apiResource('sliders',AdminSliderController::class)->only(['store','destroy']);

        Route::apiResource('customers',AdminCustomerController::class)->except(['store','update']);
        Route::post('customers/{id}',[AdminCustomerController::class,'update']);

        Route::apiResource('administrators',AdministratorController::class)->except(['update']);
        Route::post('administrators/{id}',[AdministratorController::class,'update']);


        /*
        |--------------------------------------------------------------------------
        | Chats routes
        |--------------------------------------------------------------------------
        */
        Route::controller(AdminMessageController::class)->group(function () {
            Route::get('get-all-conversations','getAllConversation');
            Route::get('get-conversation-chats/{id}','getConversationChats');
            Route::post('send-message','sendMessage');
            Route::post('update-message/{id}','updateMessage');
            Route::delete('delete-message/{id}','deleteMessage');
        });


            /*|----- send-notifications routes |----*/
            Route::get('send-notifications',[AdminNotificationController::class,'index']);

    });
});