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
        Route::get('/attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance');
        
        
        Route::middleware('is_admin')->group(function(){
            Route::get('/users', [App\Http\Controllers\UsersController::class, 'users'])->name('users');
            Route::get('/show-users', [App\Http\Controllers\UsersController::class, 'showUsers'])->name('users.show');
            //archived
            Route::get('/users-archived', [App\Http\Controllers\UsersController::class, 'archive'])->name('archive');
            Route::get('/show-users-archive', [App\Http\Controllers\UsersController::class, 'showUsersArchive'])->name('users.show.archive');
            // modifiy users
            Route::get('/users/{userID}', [App\Http\Controllers\UsersController::class, 'manageUsers'])->name('users.manage');
            Route::post('/users-assign/{userID}', [App\Http\Controllers\UsersController::class, 'assignRoles'])->name('users.assign');
            Route::post('/users-approve/{userID}', [App\Http\Controllers\UsersController::class, 'approveUsers'])->name('users.approve');
            Route::post('/users-update/{userID}', [App\Http\Controllers\UsersController::class, 'updateUsers'])->name('users.update');
            Route::post('/users-unarchive/{userID}', [App\Http\Controllers\UsersController::class, 'unarchiveUsers'])->name('users.unarchive');
            //danger actions
            Route::post('/users-archive/{userID}', [App\Http\Controllers\UsersController::class, 'archiveUsers'])->name('users.archive');
            Route::post('/users-delete/{userID}', [App\Http\Controllers\UsersController::class, 'deleteUsers'])->name('users.delete');
            // attendance
            Route::get('/attendance-logs', [App\Http\Controllers\HandleAttendanceController::class, 'index'])->name('attendance.logs');
        });
    });

});

