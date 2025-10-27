<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class IbgeService
{
    public function getEstados(): array
    {
        $response = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');

        if ($response->successful()) {
            return collect($response->json())
                ->sortBy('sigla')
                ->map(fn($estado) => [
                    'id' => $estado['id'],
                    'sigla' => $estado['sigla'],
                    'nome' => $estado['nome'],
                    'regiao' => $estado['regiao']['nome'],
                    'label' => "{$estado['sigla']} - {$estado['nome']}",
                ])
                ->values()
                ->toArray();
        }

        return [];
    }
}
