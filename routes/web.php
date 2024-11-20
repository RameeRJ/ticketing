<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;



Route::get('/{any}' , [AppController::class, 'index'])->where('any', '.*');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::post('/users/store', [AdminController::class, 'UserStore']);
Route::post('/users',[AdminController::class, 'UserIndex']);
Route::delete('/users/delete/{id}',[AdminController::class, 'UserDestroy']);
Route::put('/users/update/{id}', [AdminController::class, 'UserUpdate']);

Route::post('/tickets/store', [UserController::class, 'TicketStore']); 
Route::post('/tickets', [UserController::class, 'TicketIndex']); 

