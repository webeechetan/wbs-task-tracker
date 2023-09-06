<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('admin.layouts.app');
});

/*--------------------------------- Auth Routes ---------------------------------*/

Route::get('/login', [AuthController::class, 'index'])->name('login.view')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/user/create', [AuthController::class, 'createUser'])
            ->name('user-create')
            ->middleware('admin');

    /*--------------------------------- Team Routes ---------------------------------*/

    Route::get('/teams',[TeamController::class,'index'])
            ->name('teams-index')
            ->middleware('admin'); 
    Route::post('/teams',[TeamController::class,'store'])
            ->name('teams-store')
            ->middleware('admin');
    Route::post('/teams/update',[TeamController::class,'update'])
            ->name('teams-update')
            ->middleware('admin');
    Route::get('/teams/delete/{team}',[TeamController::class,'destroy'])
            ->name('teams-destroy')
            ->middleware('admin');

    
    /*--------------------------------- User Routes ---------------------------------*/
    
    Route::get('/user/create', [UserController::class, 'create'])
            ->name('user-create')
            ->middleware('admin');


    Route::post('/user/store', [UserController::class,'store'])
            ->name('user-store')
            ->middleware('admin');

    Route::get('/users', [UserController::class,'index'])
            ->name('user-index')
            ->middleware('admin');
    
    Route::get('/user/edit/{user}', [UserController::class,'edit'])
            ->name('user-edit')
            ->middleware('admin');

    Route::delete('/user/destroy/{user}', [UserController::class,'destroy'])
            ->name('user-destroy')
            ->middleware('admin');

    Route::put('/user/update/{user}', [UserController::class,'update'])
            ->name('user-update')
            ->middleware('admin');

});


