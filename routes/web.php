<?php

use App\Http\Controllers\data_prediksi;
use App\Http\Controllers\DataBerasController;
use App\Http\Controllers\DataPrediksiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\prediksi_harga;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::resource('/keloladataprediksi', DataPrediksiController::class);

Route::get('/data-prediksi', [data_prediksi::class, 'index'])->name('data-prediksi');

//Route::get('/prediksi-harga', [prediksi_harga::class, 'prediksi'])->name('prediksi-harga');

// Add a new route for the analyze method
Route::get('/analyze-prediksi', [prediksi_harga::class, 'analyze'])->name('analyze-prediksi');

// Route::get('/calculate-coefficients', [DataBerasController::class, 'calculateCoefficients']);
Route::get('/calculate-coefficients', [DataBerasController::class, 'calculateCoefficients'])->name('calculate.coefficients');

Route::get('/calculate-coefficients', [DataBerasController::class, 'calculateCoefficients'])->name('calculate.coefficients');
Route::get('/manual-calculation/{category}', [DataBerasController::class, 'manualCalculation'])->name('manual.calculation');
Route::get('/prediksi-harga', [DataBerasController::class, 'calculateCoefficients'])->name('prediksi-harga');

//Route::get('/analyze', [DataBerasController::class, 'analyze'])->name('data-beras.analyze');
Route::get('/analyze', [DataBerasController::class, 'analyze'])->name('data-beras.analyze');

Route::get('/manual-calculation-test/{category}', [DataBerasController::class, 'manualCalculationTest'])->name('manual.calculation.test');
