<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $appName = env('APP_NAME');
    return view('welcome', compact('appName'));
})->name('landing');

Auth::routes();
Route::match(['get'], 'login', function(){ return redirect('/'); })->name('login');
Route::match(['get'], 'register', function(){ return redirect('/'); })->name('register');

Route::group(['middleware' => ['guest']], function () {
    Route::get('auth/google', [App\Http\Controllers\Authentication::class, 'redirectToGoogle'])->name('login.google'); // google auth
    Route::get('login/google/callback', [App\Http\Controllers\Authentication::class, 'handleGoogleCallback']); // google callback route
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
    Route::get('/check-firsttime-login', [App\Http\Controllers\CheckFirstTimeController::class, 'checkFirstTime'])->name('check.first.timer');
    Route::get('/basic-information', [App\Http\Controllers\CheckFirstTimeController::class, 'createinformation'])->name('information.create');
    Route::middleware('is_old_user')->group(function(){
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    });
});

