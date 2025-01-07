<?php

use App\Http\Controllers\DataPrediksiController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});


Route::get('/login', [LoginController::class, 'login']);

Route::resource('/dataPrediksi', DataPrediksiController::class);