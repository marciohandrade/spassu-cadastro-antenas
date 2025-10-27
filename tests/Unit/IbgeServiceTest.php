<?php

namespace Tests\Unit;

use App\Services\IbgeService;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class IbgeServiceTest extends TestCase
{
    public function test_get_estados_returns_formatted_array_when_api_successful()
    {
        Http::fake([
            'servicodados.ibge.gov.br/*' => Http::response([
                [
                    'id' => 35,
                    'sigla' => 'SP',
                    'nome' => 'São Paulo',
                    'regiao' => ['nome' => 'Sudeste'],
                ],
                [
                    'id' => 31,
                    'sigla' => 'MG',
                    'nome' => 'Minas Gerais',
                    'regiao' => ['nome' => 'Sudeste'],
                ],
            ], 200),
        ]);

        $service = new IbgeService();
        $result = $service->getEstados();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('MG', $result[0]['sigla']); // ordenado por sigla
        $this->assertEquals('MG - Minas Gerais', $result[0]['label']);
        $this->assertArrayHasKey('regiao', $result[0]);
    }

    public function test_get_estados_returns_empty_array_on_failure()
    {
        Http::fake([
            'servicodados.ibge.gov.br/*' => Http::response([], 500),
        ]);

        $service = new IbgeService();
        $result = $service->getEstados();

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }
}
