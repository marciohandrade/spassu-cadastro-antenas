<?php

use Illuminate\Support\Facades\Route;
use App\Services\IbgeService;
use App\Http\Controllers\Api\UfController;
//use App\Http\Controllers\Api\AntenaController as ApiAntenaController;
//use App\Http\Controllers\Api\EstadoController as ApiEstadoController


// testar depois
/*use App\Http\Controllers\Api\AntenaController as ApiAntenaController;
use App\Http\Controllers\Api\EstadoController as ApiEstadoController;

Route::get('antenas', [ApiAntenaController::class, 'index'])->name('api.antenas.index');
Route::get('antenas/{id}', [ApiAntenaController::class, 'show'])->name('api.antenas.show');
Route::post('antenas', [ApiAntenaController::class, 'store'])->name('api.antenas.store');
Route::match(['put','patch'],'antenas/{id}', [ApiAntenaController::class, 'update'])->name('api.antenas.update');
Route::delete('antenas/{id}', [ApiAntenaController::class, 'destroy'])->name('api.antenas.destroy');*/

Route::get('estados', [ApiEstadoController::class, 'index'])->name('api.estados.index');
Route::get('antenas/ranking', [ApiAntenaController::class, 'ranking'])->name('api.antenas.ranking');

Route::get('antenas', [ApiAntenaController::class, 'index'])->name('api.antenas.index');
Route::get('antenas/ranking', [ApiAntenaController::class, 'ranking'])->name('api.antenas.ranking');
Route::get('estados', [ApiEstadoController::class, 'index'])->name('api.estados.index');



// funcionando..

Route::get('/ufs', function (IbgeService $ibge) {
    return response()->json($ibge->getEstados());
});

Route::get('/ufs', [UfController::class, 'index']);
