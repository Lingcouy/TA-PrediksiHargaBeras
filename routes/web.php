<?php

use App\Http\Controllers\DataBerasController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('/login', [LoginController::class, 'login'])->name('login');

// Dashboard routes
Route::get('/', [DataBerasController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard', [DataBerasController::class, 'dashboard'])->name('dashboard');

// Data prediksi routes
Route::get('/data-prediksi', [DataBerasController::class, 'data_prediksi'])->name('data-prediksi');

// Kelola data prediksi routes
Route::get('/keloladataprediksi', [DataBerasController::class, 'kelola_data_prediksi'])->name('keloladataprediksi.index');
Route::get('/keloladataprediksi/create', [DataBerasController::class, 'create_new'])->name('keloladataprediksi.create');
Route::get('/keloladataprediksi/{id}/edit', [DataBerasController::class, 'edit_new'])->name('keloladataprediksi.edit');
Route::post('/keloladataprediksi', [DataBerasController::class, 'store_new'])->name('keloladataprediksi.store');
Route::put('/keloladataprediksi/{id}', [DataBerasController::class, 'update_new'])->name('keloladataprediksi.update');
Route::delete('/keloladataprediksi/{id}', [DataBerasController::class, 'destroy_new'])->name('keloladataprediksi.destroy');

// Analysis and calculation routes
Route::get('/analyze', [DataBerasController::class, 'analyze'])->name('data-beras.analyze');
Route::get('/calculate-coefficients', [DataBerasController::class, 'calculateCoefficients'])->name('calculate.coefficients');
Route::get('/manual-calculation/{category}', [DataBerasController::class, 'manualCalculation'])->name('manual.calculation');
Route::get('/manual-calculation-test/{category}', [DataBerasController::class, 'manualCalculationTest'])->name('manual.calculation.test');
Route::get('/prediksi-harga', [DataBerasController::class, 'calculateCoefficients'])->name('prediksi-harga');
