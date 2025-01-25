<?php

use App\Http\Controllers\PosnetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('web')->group(function () {
    Route::post('/register-card', [PosnetController::class, 'registerCard']);
    Route::post('/process-payment', [PosnetController::class, 'processPayment']);
});

