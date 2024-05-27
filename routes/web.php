<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TabbyController;
use App\Mail\SendOtp;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::any('/get-webhook', function () {
    
    $data = Cache::get('webhook');

    return $data;
});

Route::get('/', function () {

    Artisan::call('optimize:clear');
    // $mail = Mail::to('sah@mid.com')->send(new SendOtp(1234));
    // return dd($mail);

    // Artisan::call('migrate');
    
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
