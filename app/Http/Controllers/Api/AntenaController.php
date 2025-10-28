<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AntenaRepositoryInterface;

class AntenaController extends Controller
{
    protected AntenaRepositoryInterface $repo;

    public function __construct(AntenaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $antenas = $this->repo->all();
        return response()->json(['data' => $antenas]);
    }

    public function ranking()
    {
        $ranking = $this->repo->topRanking();
        return response()->json(['data' => $ranking]);
    }
}
