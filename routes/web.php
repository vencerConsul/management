<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
});

// @user routes
// Route::middleware(['auth', 'is_user'])->group(function(){
//     Route::post('/submit-testimonial', [App\Http\Controllers\User\UserController::class, 'addTestimonials'])->name('submit.testimonial');
// });

// @admin routes
// Route::middleware(['auth', 'is_admin'])->group(function(){
//     Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'dashboard'])->name('dashboard');
// });
