<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;

Route::get('/', [ProgramController::class, 'index'])->name('home');
Route::get('/dashboard', [ProgramController::class, 'dashboard'])->name('dashboard');
Route::get('/pengurus', [ProgramController::class, 'pengurus'])->name('pengurus');
