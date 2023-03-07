<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::match(['get'], 'login', function(){ return redirect('/'); })->name('login');
Route::match(['get'], 'register', function(){ return redirect('/'); })->name('register');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('landing');
    Route::get('auth/google', [App\Http\Controllers\Authentication::class, 'redirectToGoogle'])->name('login.google'); // google auth
    Route::get('login/google/callback', [App\Http\Controllers\Authentication::class, 'handleGoogleCallback']); // google callback route
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function(){
    Route::match(['get'], 'home', function(){ return redirect('/dashboard'); }); // disabled default home shit
    Route::match(['get'], 'laravel-websockets', function(){ return redirect('/dashboard'); }); // disabled default websocket statistic shit

    Route::get('/check-firsttime-login', [App\Http\Controllers\InformationController::class, 'checkFirstTime'])->name('check.first.timer');
    Route::get('/basic-information', [App\Http\Controllers\InformationController::class, 'createinformation'])->name('information.create');
    Route::post('/store-information', [App\Http\Controllers\InformationController::class, 'storeInformation'])->name('information.store');
    Route::post('/update-information', [App\Http\Controllers\InformationController::class, 'updateInformation'])->name('information.update');

    Route::middleware('is_old_user')->group(function(){
        Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard'); // view

        Route::get('/load-user-online', [App\Http\Controllers\DashboardController::class, 'loadUsersOnline']); // view

        Route::middleware('is_approved')->group(function(){
            // timesheet
            Route::get('/timesheet', [App\Http\Controllers\TimeSheetController::class, 'index'])->name('timesheet');
            Route::get('/load-time-sheet-data', [App\Http\Controllers\TimeSheetController::class, 'loadTimeSheetData']); // api call
            Route::post('/time-sheet/toggle', [App\Http\Controllers\TimeSheetController::class, 'toggleTimeSheet']); // api event toggle
        });
        
        Route::middleware('is_admin')->group(function(){
            Route::get('/users', [App\Http\Controllers\UsersController::class, 'users'])->name('users'); // view
            Route::get('/load-users', [App\Http\Controllers\UsersController::class, 'loadUsers']); // api call
            //archived
            Route::get('/users-archived', [App\Http\Controllers\UsersController::class, 'archive'])->name('archive'); // view
            Route::get('/load-users-archive', [App\Http\Controllers\UsersController::class, 'loadUsersArchive']); // api call
            // modifiy users
            Route::get('/manage/{userID}', [App\Http\Controllers\UsersController::class, 'manageUsers'])->name('users.manage'); // view
            Route::post('/users-update/{userID}', [App\Http\Controllers\UsersController::class, 'updateUsers'])->name('users.update');
            Route::post('/asign-user-role/{userID}', [App\Http\Controllers\UsersController::class, 'assignUserRoles'])->name('users.assign.role');
            Route::post('/users-update-status/{userID}', [App\Http\Controllers\UsersController::class, 'updateUserStatus'])->name('users.update.status');
            //danger actions
            Route::post('/users-archive/{userID}', [App\Http\Controllers\UsersController::class, 'archiveUsers'])->name('users.archive');
            Route::post('/users-delete/{userID}', [App\Http\Controllers\UsersController::class, 'deleteUsers'])->name('users.delete');
            Route::post('/users-unarchive/{userID}', [App\Http\Controllers\UsersController::class, 'unarchiveUsers'])->name('users.unarchive');
            //timesheet
            Route::get('/timesheet-logs', [App\Http\Controllers\HandleTimeSheetController::class, 'index'])->name('timesheet.logs'); // view
            Route::get('/load-time-sheet-data-admin', [App\Http\Controllers\HandleTimeSheetController::class, 'loadTimeSheet']); // view
        });
    });

});

