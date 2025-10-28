<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AntenaRepositoryInterface;

class AntenaController extends Controller
{
    protected $repo;
    protected $ibge;

    public function __construct(AntenaRepositoryInterface $repo, IbgeService $ibge)
    {
        $this->repo = $repo;
        $this->ibge = $ibge;
    }

    public function index()
    {
        $antenas = $this->repo->all();
        $ranking = $this->repo->topRanking();
        $ufs = $this->ibge->getEstados();

        return view('antenas.index', compact('antenas', 'ranking', 'ufs'));
    }

    public function ranking()
    {
        $ranking = $this->repo->topRanking();
        return response()->json(['data' => $ranking]);
    }
}
