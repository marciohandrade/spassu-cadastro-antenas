<?php

namespace App\Repositories;

use App\Models\Antena;
use App\Repositories\Contracts\AntenaRepositoryInterface;

class AntenaRepository implements AntenaRepositoryInterface
{
    public function all()
    {
        return Antena::orderBy('created_at', 'desc')->get();
    }

    public function topRanking(int $limit = 5)
    {
        return Antena::selectRaw('uf, COUNT(*) as total')
            ->groupBy('uf')
            ->orderByDesc('total')
            ->limit($limit)
            ->get();
    }

    public function create(array $data)
    {
        return Antena::create($data);
    }

    public function findOrFail($id)
    {
        return Antena::findOrFail($id);
    }
}
