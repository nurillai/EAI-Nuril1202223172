<?php

use App\Http\Controllers\PesananMinumanController;
use Illuminate\Support\Facades\Route;

// Token CSRF
Route::get('/csrf-token', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});

// Form input pesanan (hanya untuk tampilan)
Route::get('/pesanan/form', function () {
    return view('pesanan');
});

Route::post('/pesanan', [PesananMinumanController::class, 'store'])->name('pesanan.store');
Route::get('/pesanan', [PesananMinumanController::class, 'index'])->name('pesanan.index');
Route::get('/pesanan/{id}', [PesananMinumanController::class, 'show'])->name('pesanan.show');
Route::put('/pesanan/{id}', [PesananMinumanController::class, 'update'])->name('pesanan.update');
Route::delete('/pesanan/{id}', [PesananMinumanController::class, 'destroy'])->name('pesanan.destroy');

