<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AntenaController;
use Illuminate\Support\Facades\Route;

// ============================================
// ROTAS PÚBLICAS (sem autenticação)
// ============================================

// Landing page - listagem de antenas
Route::get('/', [AntenaController::class, 'index'])->name('home');

// Rotas públicas de antenas (apenas visualização)
Route::get('/antenas', [AntenaController::class, 'index'])->name('antenas.index');
Route::get('/antenas/{antena}', [AntenaController::class, 'show'])->name('antenas.show');

// ============================================
// ROTAS DE AUTENTICAÇÃO (Breeze)
// ============================================
require __DIR__.'/auth.php';

// ============================================
// ROTAS PROTEGIDAS (requer autenticação) 🔒
// ============================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Antenas (criar, editar, excluir)
    Route::get('/antenas/create', [AntenaController::class, 'create'])->name('antenas.create');
    Route::post('/antenas', [AntenaController::class, 'store'])->name('antenas.store');
    Route::get('/antenas/{antena}/edit', [AntenaController::class, 'edit'])->name('antenas.edit');
    Route::put('/antenas/{antena}', [AntenaController::class, 'update'])->name('antenas.update');
    Route::delete('/antenas/{antena}', [AntenaController::class, 'destroy'])->name('antenas.destroy');
});
