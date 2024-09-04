<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TabbyController;
use App\Mail\SendOtp;
use App\Models\User;
use App\Services\FirebaseService;
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


Route::any('/run', function () {
    return FirebaseService::getAccessToken();
});
Route::any('/run-websockets', function () {
    return User::all()->map(function (User $user) {
        $user->type ='1';
        return $user;
    });
    Artisan::call('websockets:serve',[
        '--port'=>'6002'
    ]);


    return "<h1> websockets run successful </h1>";
});

Route::get('/', function () {

    Artisan::call('optimize:clear');

    Artisan::call('config:cache');

    Artisan::call('config:clear');

    // $mail = Mail::to('sah@mid.com')->send(new SendOtp(1234));
    // return dd($mail);

    // Artisan::call('migrate');

    return now()->toDateTimeString();

    return config()->get('app.timezone');
    
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route::get('/send', [EventController::class, 'send'])->name('event.send');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
