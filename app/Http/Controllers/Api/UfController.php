<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\IbgeService;
use Illuminate\Support\Facades\Log;

class UfController extends Controller
{
    public function index(IbgeService $ibge)
    {
        try {
            $ufs = $ibge->getEstados();
            return response()->json(['data' => $ufs]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar UFs do IBGE: ' . $e->getMessage());

            return response()->json([
                'error' => 'Não foi possível carregar os estados.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
