<?php

namespace App\Repositories;

use App\Models\Antena;
use App\Repositories\Contracts\AntenaRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AntenaRepository implements AntenaRepositoryInterface
{
    public function all()
    {
        try {
            return Antena::query()->orderBy('created_at', 'desc')->get();
        } catch (QueryException $e) {
            Log::error('Erro ao buscar todas as antenas', ['exception' => $e]);
            throw new \RuntimeException('Não foi possível carregar a lista de antenas.');
        }
    }

    public function topRanking(int $limit = 5)
    {
        try {
            return Antena::query()
                ->selectRaw('uf, COUNT(*) as total')
                ->groupBy('uf')
                ->orderByDesc('total')
                ->limit($limit)
                ->get();
        } catch (QueryException $e) {
            Log::error('Erro ao gerar ranking de UFs', ['exception' => $e]);
            throw new \RuntimeException('Não foi possível gerar o ranking de antenas por UF.');
        }
    }

    public function create(array $data)
    {
        try {
            return Antena::query()->create($data);
        } catch (QueryException $e) {
            Log::error('Erro ao criar antena', ['exception' => $e]);
            throw new \RuntimeException('Falha ao cadastrar antena.');
        }
    }

    public function update($id, array $data)
    {
        try {
            $antena = Antena::query()->findOrFail($id);
            $antena->update($data);
            return $antena;
        } catch (QueryException $e) {
            Log::error("Erro ao atualizar antena ID {$id}", ['exception' => $e]);
            throw new \RuntimeException('Falha ao atualizar antena.');
        }
    }

    public function delete($id)
    {
        try {
            $antena = Antena::query()->findOrFail($id);
            return $antena->delete();
        } catch (QueryException $e) {
            Log::error("Erro ao excluir antena ID {$id}", ['exception' => $e]);
            throw new \RuntimeException('Falha ao excluir antena.');
        }
    }

    public function findOrFail($id)
    {
        return Antena::query()->findOrFail($id);
    }
}
