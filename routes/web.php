<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show');

    // Payment routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/permohonan/{permohonan}', [PaymentController::class, 'show'])->name('show');
        Route::post('/permohonan/{permohonan}/process', [PaymentController::class, 'process'])->name('process');
        Route::get('/permohonan/{permohonan}/history', [PaymentController::class, 'history'])->name('history');
        Route::get('/invoice/{pembayaran}', [PaymentController::class, 'invoice'])->name('invoice');
    });
});

// Payment callback (tanpa auth middleware)
Route::post('/api/payment/callback', [PaymentController::class, 'callback']);
Route::get('/payment/return', [PaymentController::class, 'return'])->name('payment.return');
