<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Antena;
use App\Models\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AntenaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_antena_com_dados_invalidos()
    {
        // Autentica um usuário
        $user = User::factory()->create();
        $this->actingAs($user);

        // Cria uma antena para testar unicidade
        Antena::create([
            'descricao' => 'Antena Duplicada',
            'latitude' => -10.0,
            'longitude' => -50.0,
            'uf' => 'SP',
            'altura' => 30.0,
            'data_implantacao' => now(),
        ]);

        // Envia dados inválidos (exceto UF)
        $response = $this->postJson('/antenas', [
            'descricao' => 'Antena Duplicada', // já existe
            'latitude' => 999,                 // inválido
            'longitude' => -999,               // inválido
            'uf' => 'SP',                      // válida
            'altura' => -10,                   // inválido
            'data_implantacao' => 'data-invalida', // inválido
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'descricao',
            'latitude',
            'longitude',
            'altura',
            'data_implantacao',
        ]);
    }

    /**
     * Testa o cadastro de uma antena com dados válidos.
     *
     * Este teste verifica se o método store do AntenaController:
     * - Aceita uma requisição autenticada com todos os campos válidos
     * - Retorna status HTTP 201 (Created)
     * - Retorna uma resposta JSON com os dados da antena cadastrada
     * - Persiste corretamente os dados no banco de dados
     */
    public function test_store_antena_com_dados_validos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->postJson('/antenas', [
            'descricao' => 'Antena Nova SP',
            'latitude' => -23.5505,
            'longitude' => -46.6333,
            'uf' => 'SP',
            'altura' => 45.0,
            'data_implantacao' => '2023-10-01',
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Antena cadastrada com sucesso!',
            'antena' => [
                'descricao' => 'Antena Nova SP',
                'uf' => 'SP',
                'latitude' => -23.5505,
                'longitude' => -46.6333,
                'altura' => 45.0,
            ]
        ]);

        $this->assertDatabaseHas('antenas', [
            'descricao' => 'Antena Nova SP',
            'uf' => 'SP',
            'latitude' => -23.5505,
            'longitude' => -46.6333,
            'altura' => 45.0,
        ]);
    }

    /**
     * Testa a atualização de uma antena com dados válidos.
     *
     * Este teste verifica se o método update do AntenaController:
     * - Aceita uma requisição autenticada com dados válidos
     * - Atualiza corretamente os campos da antena no banco de dados
     * - Retorna uma resposta JSON com status 200 e mensagem de sucesso
     */
    public function test_update_antena_com_dados_validos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $antena = Antena::create([
            'descricao' => 'Antena Original',
            'latitude' => -10.0,
            'longitude' => -50.0,
            'uf' => 'SP',
            'altura' => 30.0,
            'data_implantacao' => '2023-01-01',
        ]);

        $response = $this->putJson("/antenas/{$antena->id}", [
            'descricao' => 'Antena Atualizada',
            'latitude' => -22.0,
            'longitude' => -43.0,
            'uf' => 'RJ',
            'altura' => 50.0,
            'data_implantacao' => '2023-10-10',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Antena atualizada com sucesso!',
        ]);

        $this->assertDatabaseHas('antenas', [
            'id' => $antena->id,
            'descricao' => 'Antena Atualizada',
            'uf' => 'RJ',
            'latitude' => -22.0,
            'longitude' => -43.0,
            'altura' => 50.0,
        ]);
    }

    /**
     * Testa a atualização de uma antena com dados inválidos.
     *
     * Este teste verifica se o método update do AntenaController:
     * - Rejeita uma requisição autenticada com dados inválidos
     * - Retorna status HTTP 422 (Unprocessable Entity)
     * - Retorna os erros de validação esperados no JSON
     */
    public function test_update_antena_com_dados_invalidos()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $antena = Antena::create([
            'descricao' => 'Antena Original',
            'latitude' => -10.0,
            'longitude' => -50.0,
            'uf' => 'SP',
            'altura' => 30.0,
            'data_implantacao' => '2023-01-01',
        ]);

        // Cria outra antena para testar duplicidade de descrição
        Antena::create([
            'descricao' => 'Antena Existente',
            'latitude' => -20.0,
            'longitude' => -40.0,
            'uf' => 'RJ',
            'altura' => 25.0,
            'data_implantacao' => '2023-02-02',
        ]);

        $response = $this->putJson("/antenas/{$antena->id}", [
            'descricao' => 'Antena Existente', // duplicada
            'latitude' => 999,                 // inválida
            'longitude' => -999,               // inválida
            'uf' => 'SP',                      // válida
            'altura' => -5,                    // inválida
            'data_implantacao' => 'data-invalida', // inválida
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'descricao',
            'latitude',
            'longitude',
            'altura',
            'data_implantacao',
        ]);
    }

    /**
     * Testa a exclusão de uma antena existente.
     *
     * Este teste verifica se o método destroy do AntenaController:
     * - Aceita uma requisição autenticada para deletar uma antena existente
     * - Retorna status HTTP 200 e mensagem de sucesso (via JSON)
     * - Remove a antena do banco de dados
     */
    public function test_destroy_antena_existente()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(), // Garante que o middleware 'verified' não redirecione
        ]);
        $this->actingAs($user);

        $antena = Antena::create([
            'descricao' => 'Antena para Remover',
            'latitude' => -15.0,
            'longitude' => -47.0,
            'uf' => 'DF',
            'altura' => 35.0,
            'data_implantacao' => '2023-05-05',
        ]);

        $response = $this->delete("/antenas/{$antena->id}", [], [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Antena removida com sucesso!',
        ]);

        $this->assertSoftDeleted('antenas', [
            'id' => $antena->id,
        ]);
    }

    /**
     * Testa a visualização de uma antena existente.
     *
     * Este teste verifica se o método show do AntenaController:
     * - Retorna status HTTP 200 quando a antena existe
     * - Responde com JSON contendo os dados da antena
     * - Formata corretamente a data de implantação
     */
    public function test_show_antena_existente()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);
        $this->actingAs($user);

        $antena = Antena::create([
            'descricao' => 'Antena de Teste',
            'latitude' => -23.5,
            'longitude' => -46.6,
            'uf' => 'SP',
            'altura' => 42.0,
            'data_implantacao' => '2023-10-10',
        ]);

        $response = $this->get("/antenas/{$antena->id}", [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'antena' => [
                'id' => $antena->id,
                'descricao' => $antena->descricao,
                'uf' => $antena->uf,
                'latitude' => $antena->latitude,
                'longitude' => $antena->longitude,
                'altura' => $antena->altura,
                'data_implantacao' => '10/10/2023',
            ],
        ]);
    }

    /**
     * Testa a visualização de uma antena inexistente.
     *
     * Este teste verifica se o método show retorna erro 404 quando a antena não existe.
     */
    public function test_show_antena_inexistente()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $response = $this->get('/antenas/9999', ['Accept' => 'application/json']);

        $response->assertStatus(404);
    }

    /**
     * Testa a listagem de antenas com usuário autenticado.
     *
     * Verifica se a view correta é retornada com status 200.
     */
    public function test_index_antenas_autenticado()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $response = $this->get('/antenas');

        $response->assertStatus(200);
        $response->assertViewIs('antenas.index');
    }

    /**
     * Testa o upload de foto ao criar uma antena.
     *
     * Verifica se a imagem é salva e o caminho é armazenado.
     */
    public function test_store_antena_com_foto()
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('foto.jpg');

        $response = $this->post('/antenas', [
            'descricao' => 'Antena com Foto',
            'latitude' => -10.0,
            'longitude' => -50.0,
            'uf' => 'GO',
            'altura' => 30,
            'data_implantacao' => '2023-01-01',
            'foto' => $file,
        ]);

        $response->assertRedirect('/antenas');
        Storage::disk('public')->assertExists('antenas/' . $file->hashName());
        $this->assertDatabaseHas('antenas', ['descricao' => 'Antena com Foto', 'foto' => 'antenas/' . $file->hashName()]);
    }

    /**
     * Testa a exclusão de uma antena com foto.
     *
     * Verifica se a imagem é removida do disco após o soft delete.
     */
    public function test_destroy_antena_com_foto_remove_arquivo()
    {
        Storage::fake('public');

        $user = User::factory()->create(['email_verified_at' => now()]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('foto.jpg');
        $path = $file->store('antenas', 'public');

        $antena = Antena::create([
            'descricao' => 'Antena com Foto',
            'latitude' => -10.0,
            'longitude' => -50.0,
            'uf' => 'GO',
            'altura' => 30,
            'data_implantacao' => '2023-01-01',
            'foto' => $path,
        ]);

        Storage::disk('public')->assertExists($path);

        $response = $this->delete("/antenas/{$antena->id}", [], ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $this->assertSoftDeleted('antenas', ['id' => $antena->id]);
        Storage::disk('public')->assertMissing($path);
    }

    /**
     * Testa se um usuário não autenticado consegue visualizar a listagem de antenas.
     *
     * Verifica se a rota pública retorna status 200 e a view correta.
     */
    public function test_acesso_nao_autenticado_visualiza_antenas()
    {
        $response = $this->get('/antenas');
        $response->assertStatus(200);
        $response->assertViewIs('antenas.index');
    }
}
