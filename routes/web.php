<?php

use App\Http\Controllers\data_prediksi;
use App\Http\Controllers\DataPrediksiController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::resource('/keloladataprediksi', DataPrediksiController::class);

Route::get('/data-prediksi', [data_prediksi::class, 'index'])->name('data-prediksi');