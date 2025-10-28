<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\AntenaController;


Route::get('/', function () {
    return view('welcome');
});

Route::prefix('antennas')->name('antennas.')->group(function () {
    Route::get('/', [AntenaController::class, 'index'])->name('index');
    Route::get('create', [AntenaController::class, 'create'])->name('create');
    Route::post('/', [AntenaController::class, 'store'])->name('store');
    Route::get('{antenna}', [AntenaController::class, 'show'])->name('show');
    Route::get('{antenna}/edit', [AntenaController::class, 'edit'])->name('edit');
    Route::put('{antenna}', [AntenaController::class, 'update'])->name('update');
    Route::delete('{antenna}', [AntenaController::class, 'destroy'])->name('destroy');
});
Route::get('/', [AntenaController::class, 'index']); // raiz aponta para listagem


//
Route::resource('antenas', App\Http\Controllers\AntenaController::class);

//
Route::get('/antenas', [App\Http\Controllers\AntenaController::class, 'index'])->name('antenas.index');
Route::resource('antenas', AntenaController::class);


// rotas auxiliares opcionais
Route::get('antenas/export/csv', [AntenaController::class, 'exportCsv'])->name('antenas.export.csv');
Route::post('antenas/{antena}/restore', [AntenaController::class, 'restore'])->name('antenas.restore');


// Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
