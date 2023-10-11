<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityController;


/*--------------------------------- Auth Routes ---------------------------------*/

Route::get('/', [AuthController::class, 'index'])->name('login.view')->middleware('guest');
Route::get('/login', [AuthController::class, 'index'])->name('login.home')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');


Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

    Route::get('/user/create', [UserController::class, 'create'])->name('user-create')
        ->middleware('admin');


    Route::post('/user/store', [UserController::class, 'store'])->name('user-store')
        ->middleware('admin');

    Route::get('/users', [UserController::class, 'index'])->name('user-index')
        ->middleware('admin');

    Route::get('/user/edit/{user}', [UserController::class, 'edit'])->name('user-edit')
        ->middleware('admin');

    Route::delete('/user/destroy/{user}', [UserController::class, 'destroy'])->name('user-destroy')
        ->middleware('admin');

    Route::post('/user/update/{user}', [UserController::class, 'update'])->name('user-update')
        ->middleware('admin');


        
    /*--------------------------------- To do's ---------------------------------*/


    Route::get('/tasks', [TaskController:: class, 'index'])->name('task-index')->middleware('auth');

    Route::post('/tasks/store', [TaskController::class, 'store'])->name('task-store')->middleware('auth');

    Route::get('/tasks/edit/{task}', [TaskController:: class,'edit'])->name('task-edit')->middleware('auth');

    Route::post('/tasks/update', [TaskController::class, 'update'])->name('task-update')->middleware('auth');

    Route::post('/tasks/status_update/{task}', [TaskController::class, 'statusupdate'])->name('task-statusupdate')->middleware('auth');


    Route::delete('/tasks/destroy/{task}', [TaskController::class, 'destroy'])->name('task-destroy')->middleware('auth');
    
    /*--------------------------------- Activities ---------------------------------*/

    Route::get('/activities', [ActivityController:: class, 'index'])->name('activity-index')->middleware('auth');
    Route::post('/activities/store', [ActivityController::class, 'store'])->name('activity-store')->middleware('auth');

    Route::post('/activities/update', [ActivityController::class, 'update'])->name('activity-update')->middleware('auth');

    Route::post('/activities/status_update/{activity}', [ActivityController::class, 'statusupdate'])->name('activity-statusupdate')->middleware('auth');
    Route::delete('/activities/destroy/{activity}', [ActivityController::class, 'destroy'])->name('activity-destroy')->middleware('auth');
    

});
