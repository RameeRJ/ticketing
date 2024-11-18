<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/{any}' , [AppController::class, 'index'])->where('any', '.*');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/users/store', [AdminController::class, 'UserStore']);
Route::post('/users',[AdminController::class, 'UserIndex']);
Route::delete('/users/delete/{id}',[AdminController::class, 'UserDestroy']);