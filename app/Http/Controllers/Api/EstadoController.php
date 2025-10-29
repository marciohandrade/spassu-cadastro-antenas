<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EstadoController extends Controller
{
    public function index()
    {
        try {
            $estados = Cache::remember('ibge_estados', 60 * 24, function () {
                $res = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');

                if ($res->ok()) {
                    return collect($res->json())
                        ->sortBy('sigla')
                        ->map(fn($e) => ['sigla' => $e['sigla'], 'nome' => $e['nome']])
                        ->values()
                        ->all();
                }

                Log::warning('Resposta inválida da API do IBGE: ' . $res->status());
                return [];
            });

            return response()->json(['data' => $estados]);
        } catch (\Exception $e) {
            Log::error('Erro ao buscar estados do IBGE: ' . $e->getMessage());

            return response()->json([
                'error' => 'Não foi possível carregar os estados.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
