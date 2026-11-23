<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;

// Week 11 - Task 01: Public Login API
Route::post('/login', [AuthController::class, 'login']);

// Week 11 - Task 02: Protected Routes (Wajib Bearer Token JWT)
Route::middleware('auth:api')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Endpoint Program API dari Week 10 yang diproteksi JWT
    Route::apiResource('programs', ProgramController::class);
});
