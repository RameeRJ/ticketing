<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;

Route::get('/{any}' , [AppController::class, 'index'])->where('any', '.*');

