<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProgramController;

// Public Route untuk Login
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes (Wajib menyertakan Header: Authorization: Bearer <token>)
Route::middleware('jwt.verify')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('programs', ProgramController::class);
});
