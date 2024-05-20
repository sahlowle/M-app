<?php

use App\Http\Controllers\Api\Admin\AdminAuthController;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Admin\AdminHotelController;
use App\Http\Controllers\Api\Admin\AdminOptionController;
use App\Http\Controllers\Api\Admin\AdminSliderController;
use App\Http\Controllers\Api\Admin\AdminMallController;
use App\Http\Controllers\Api\Admin\AdminMuseumController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Admin routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->as('admin.')->middleware('api')->group(function () {
    /*|----- Auth routes |----*/
    Route::controller(AdminAuthController::class)->group(function () {
        Route::post('login', 'login');
    });

    /*|----- Admin routes |----*/
    Route::middleware(['auth:sanctum', 'ability:admin-login'])->group(function () {
        Route::apiResource('hotels',AdminHotelController::class);
        Route::apiResource('categories',AdminCategoryController::class);
        Route::apiResource('malls',AdminMallController::class);
        Route::apiResource('museums',AdminMuseumController::class);
        Route::apiResource('options',AdminOptionController::class)->only(['store','destroy']);
        Route::apiResource('sliders',AdminSliderController::class)->only(['store','destroy']);
    });
});