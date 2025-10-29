<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class IbgeService
{
    private const CACHE_KEY = 'ibge_estados';
    private const CACHE_TTL = 86400; // 24 horas

    /**
     * Retorna lista de estados do IBGE com cache
     *
     * @return array
     */
    public function getEstados(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            try {
                $response = Http::timeout(10)
                    ->retry(3, 1000)
                    ->get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');

                if ($response->successful()) {
                    return collect($response->json())
                        ->sortBy('sigla')
                        ->map(fn($estado) => [
                            'id' => $estado['id'],
                            'sigla' => $estado['sigla'],
                            'nome' => $estado['nome'],
                            'regiao' => $estado['regiao']['nome'] ?? '',
                            'label' => "{$estado['sigla']} - {$estado['nome']}",
                        ])
                        ->values()
                        ->toArray();
                }

                Log::warning('IBGE API retornou status não-sucesso: ' . $response->status());
                return $this->getFallbackEstados();
            } catch (\Exception $e) {
                Log::error('Erro ao consumir API IBGE: ' . $e->getMessage());
                return $this->getFallbackEstados();
            }
        });
    }

    /**
     * Retorna lista estática de UFs caso a API falhe
     *
     * @return array
     */
    private function getFallbackEstados(): array
    {
        return [
            [
                'id' => 11,
                'sigla' => 'RO',
                'nome' => 'Rondônia',
                'regiao' => 'Norte',
                'label' => 'RO - Rondônia',
            ],
            [
                'id' => 12,
                'sigla' => 'AC',
                'nome' => 'Acre',
                'regiao' => 'Norte',
                'label' => 'AC - Acre',
            ],
            [
                'id' => 13,
                'sigla' => 'AM',
                'nome' => 'Amazonas',
                'regiao' => 'Norte',
                'label' => 'AM - Amazonas',
            ],
            [
                'id' => 14,
                'sigla' => 'RR',
                'nome' => 'Roraima',
                'regiao' => 'Norte',
                'label' => 'RR - Roraima',
            ],
            [
                'id' => 15,
                'sigla' => 'PA',
                'nome' => 'Pará',
                'regiao' => 'Norte',
                'label' => 'PA - Pará',
            ],
            [
                'id' => 16,
                'sigla' => 'AP',
                'nome' => 'Amapá',
                'regiao' => 'Norte',
                'label' => 'AP - Amapá',
            ],
            [
                'id' => 17,
                'sigla' => 'TO',
                'nome' => 'Tocantins',
                'regiao' => 'Norte',
                'label' => 'TO - Tocantins',
            ],
            [
                'id' => 21,
                'sigla' => 'MA',
                'nome' => 'Maranhão',
                'regiao' => 'Nordeste',
                'label' => 'MA - Maranhão',
            ],
            [
                'id' => 22,
                'sigla' => 'PI',
                'nome' => 'Piauí',
                'regiao' => 'Nordeste',
                'label' => 'PI - Piauí',
            ],
            [
                'id' => 23,
                'sigla' => 'CE',
                'nome' => 'Ceará',
                'regiao' => 'Nordeste',
                'label' => 'CE - Ceará',
            ],
            [
                'id' => 24,
                'sigla' => 'RN',
                'nome' => 'Rio Grande do Norte',
                'regiao' => 'Nordeste',
                'label' => 'RN - Rio Grande do Norte',
            ],
            [
                'id' => 25,
                'sigla' => 'PB',
                'nome' => 'Paraíba',
                'regiao' => 'Nordeste',
                'label' => 'PB - Paraíba',
            ],
            [
                'id' => 26,
                'sigla' => 'PE',
                'nome' => 'Pernambuco',
                'regiao' => 'Nordeste',
                'label' => 'PE - Pernambuco',
            ],
            [
                'id' => 27,
                'sigla' => 'AL',
                'nome' => 'Alagoas',
                'regiao' => 'Nordeste',
                'label' => 'AL - Alagoas',
            ],
            [
                'id' => 28,
                'sigla' => 'SE',
                'nome' => 'Sergipe',
                'regiao' => 'Nordeste',
                'label' => 'SE - Sergipe',
            ],
            [
                'id' => 29,
                'sigla' => 'BA',
                'nome' => 'Bahia',
                'regiao' => 'Nordeste',
                'label' => 'BA - Bahia',
            ],
            [
                'id' => 31,
                'sigla' => 'MG',
                'nome' => 'Minas Gerais',
                'regiao' => 'Sudeste',
                'label' => 'MG - Minas Gerais',
            ],
            [
                'id' => 32,
                'sigla' => 'ES',
                'nome' => 'Espírito Santo',
                'regiao' => 'Sudeste',
                'label' => 'ES - Espírito Santo',
            ],
            [
                'id' => 33,
                'sigla' => 'RJ',
                'nome' => 'Rio de Janeiro',
                'regiao' => 'Sudeste',
                'label' => 'RJ - Rio de Janeiro',
            ],
            [
                'id' => 35,
                'sigla' => 'SP',
                'nome' => 'São Paulo',
                'regiao' => 'Sudeste',
                'label' => 'SP - São Paulo',
            ],
            [
                'id' => 41,
                'sigla' => 'PR',
                'nome' => 'Paraná',
                'regiao' => 'Sul',
                'label' => 'PR - Paraná',
            ],
            [
                'id' => 42,
                'sigla' => 'SC',
                'nome' => 'Santa Catarina',
                'regiao' => 'Sul',
                'label' => 'SC - Santa Catarina',
            ],
            [
                'id' => 43,
                'sigla' => 'RS',
                'nome' => 'Rio Grande do Sul',
                'regiao' => 'Sul',
                'label' => 'RS - Rio Grande do Sul',
            ],
            [
                'id' => 50,
                'sigla' => 'MS',
                'nome' => 'Mato Grosso do Sul',
                'regiao' => 'Centro-Oeste',
                'label' => 'MS - Mato Grosso do Sul',
            ],
            [
                'id' => 51,
                'sigla' => 'MT',
                'nome' => 'Mato Grosso',
                'regiao' => 'Centro-Oeste',
                'label' => 'MT - Mato Grosso',
            ],
            [
                'id' => 52,
                'sigla' => 'GO',
                'nome' => 'Goiás',
                'regiao' => 'Centro-Oeste',
                'label' => 'GO - Goiás',
            ],
            [
                'id' => 53,
                'sigla' => 'DF',
                'nome' => 'Distrito Federal',
                'regiao' => 'Centro-Oeste',
                'label' => 'DF - Distrito Federal',
            ],
        ];
    }

    /**
     * Limpa o cache dos estados
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
