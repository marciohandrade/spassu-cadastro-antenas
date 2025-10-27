<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class UfsEndpointTest extends TestCase
{
    public function test_ufs_endpoint_returns_states_json()
    {
        Http::fake([
            'servicodados.ibge.gov.br/*' => Http::response([
                [
                    'id' => 35,
                    'sigla' => 'SP',
                    'nome' => 'São Paulo',
                    'regiao' => ['nome' => 'Sudeste'],
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/ufs');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['id', 'sigla', 'nome', 'regiao', 'label']
        ]);
        $this->assertEquals('SP - São Paulo', $response->json()[0]['label']);
    }
}
