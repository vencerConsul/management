<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    Route::get('/check-firsttime-login', [App\Http\Controllers\InformationController::class, 'checkFirstTime'])->name('check.first.timer');
    Route::get('/basic-information', [App\Http\Controllers\InformationController::class, 'createinformation'])->name('information.create');
    Route::post('/store-information', [App\Http\Controllers\InformationController::class, 'storeInformation'])->name('information.store');
    Route::post('/update-information', [App\Http\Controllers\InformationController::class, 'updateInformation'])->name('information.update');
    Route::middleware('is_old_user')->group(function(){
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/users', [App\Http\Controllers\UsersController::class, 'users'])->name('users');
        Route::get('/add-users', [App\Http\Controllers\UsersController::class, 'addUsers'])->name('users.add');
        Route::get('/show-users/{search}', [App\Http\Controllers\UsersController::class, 'showUsers'])->name('users.show');
        Route::get('/users/{userID}', [App\Http\Controllers\UsersController::class, 'manageUsers'])->name('users.manage');
        Route::post('/users/{userID}', [App\Http\Controllers\UsersController::class, 'approveUsers'])->name('users.approve');
        Route::post('/users-update/{userID}', [App\Http\Controllers\UsersController::class, 'updateUsers'])->name('users.update');
    });
});

