<?php

use App\Http\Controllers\AppController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/process-queue', [AppController::class, 'addUsers'])->name('addUsers');
