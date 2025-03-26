<?php

use App\Http\Controllers\PesananMinumanController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/pesanan', [PesananMinumanController::class, 'index']);
    Route::get('/pesanan/{id}', [PesananMinumanController::class, 'show']);
    Route::post('/pesanan', [PesananMinumanController::class, 'store']);
    Route::put('/pesanan/{id}', [PesananMinumanController::class, 'update']);
    Route::delete('/pesanan/{id}', [PesananMinumanController::class, 'destroy']);
});
