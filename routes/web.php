<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Login & Register routes (Filament handles these via its provider)
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::get('/register', function () {
    return redirect('/admin/register');
})->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/dokumen', [DokumenController::class, 'index'])->name('dokumen.index');
    Route::get('/dokumen/{dokumen}', [DokumenController::class, 'show'])->name('dokumen.show');

    // Payment routes
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('/permohonan/{permohonan}', [PaymentController::class, 'show'])->name('show');
        Route::post('/permohonan/{permohonan}/process', [PaymentController::class, 'process'])->name('process');
        Route::get('/permohonan/{permohonan}/history', [PaymentController::class, 'history'])->name('history');
        Route::get('/invoice/{pembayaran}', [PaymentController::class, 'invoice'])->name('invoice');
        Route::get('/{pembayaran}/nota', [PaymentController::class, 'downloadNota'])->name('nota');
    });
});

// Payment callback (tanpa auth middleware)
Route::post('/api/payment/callback', [PaymentController::class, 'callback']);
Route::get('/payment/return', [PaymentController::class, 'return'])->name('payment.return');
