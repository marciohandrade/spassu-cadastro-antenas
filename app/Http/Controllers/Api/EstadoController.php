<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class EstadoController extends Controller
{
    public function index()
    {
        $estados = Cache::remember('ibge_estados', 60 * 24, function () {
            $res = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
            if ($res->ok()) {
                return collect($res->json())
                    ->sortBy('sigla')
                    ->map(fn($e) => ['sigla' => $e['sigla'], 'nome' => $e['nome']])
                    ->values()
                    ->all();
            }
            return [];
        });

        return response()->json(['data' => $estados]);
    }
}
