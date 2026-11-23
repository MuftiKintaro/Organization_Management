<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// RESTful API Endpoint untuk Program Kerja (/api/programs)
Route::apiResource('programs', ProgramController::class);
