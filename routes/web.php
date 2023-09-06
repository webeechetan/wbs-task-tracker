<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OurClientController;

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



});


