<?php

namespace App\Repositories\Contracts;

interface AntenaRepositoryInterface
{
    public function all();
    public function topRanking(int $limit = 5);
    public function create(array $data);
}
