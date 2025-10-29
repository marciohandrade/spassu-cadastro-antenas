<?php

namespace App\Repositories;

use App\Models\Antena;
use App\Repositories\Contracts\AntenaRepositoryInterface;

class AntenaRepository implements AntenaRepositoryInterface
{
    public function all()
    {
        return Antena::query()->orderBy('created_at', 'desc')->get();
    }

    public function topRanking(int $limit = 5)
    {
        return Antena::query()
            ->selectRaw('uf, COUNT(*) as total')
            ->groupBy('uf')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    public function create(array $data)
    {
        return Antena::query()->create($data);
    }

    public function update($id, array $data)
    {
        $antena = Antena::query()->findOrFail($id);
        $antena->update($data);
        return $antena;
    }

    public function delete($id)
    {
        $antena = Antena::query()->findOrFail($id);
        return $antena->delete();
    }

    public function findOrFail($id)
    {
        return Antena::query()->findOrFail($id);
    }
}
