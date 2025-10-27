<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\IbgeService;

class UfController extends Controller
{
    public function index(IbgeService $ibge)
    {
        return response()->json($ibge->getEstados());
    }
}
