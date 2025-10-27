<?php

use Illuminate\Support\Facades\Route;
use App\Services\IbgeService;
use App\Http\Controllers\Api\UfController;


Route::get('/ufs', function (IbgeService $ibge) {
    return response()->json($ibge->getEstados());
});

Route::get('/ufs', [UfController::class, 'index']);
