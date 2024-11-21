<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\FlashSaleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request; // Pastikan Request diimport

// Rute untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute yang membutuhkan autentikasi menggunakan Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->apiResource('/products', ProductController::class);
    Route::apiResource('/flash-sales', FlashSaleController::class);
});
