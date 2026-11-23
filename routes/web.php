=<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;

// Halaman Utama & Modul Existing
Route::get('/', [ProgramController::class, 'index'])->name('home');
Route::get('/dashboard', [ProgramController::class, 'dashboard'])->name('dashboard');
Route::get('/pengurus', [ProgramController::class, 'pengurus'])->name('pengurus');

// CRUD Program Kerja (Web Form)
Route::get('/programs/create', [ProgramController::class, 'create'])->name('programs.create');
Route::post('/programs', [ProgramController::class, 'store'])->name('programs.store');
Route::get('/programs/{id}/edit', [ProgramController::class, 'edit'])->name('programs.edit');
Route::put('/programs/{id}', [ProgramController::class, 'update'])->name('programs.update');
Route::delete('/programs/{id}', [ProgramController::class, 'destroy'])->name('programs.destroy');
