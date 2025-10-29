<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\AntenaRepositoryInterface;
use App\Services\IbgeService;
use Illuminate\Support\Facades\Log;

class AntenaController extends Controller
{
    protected AntenaRepositoryInterface $repo;
    protected IbgeService $ibge;

    public function __construct(AntenaRepositoryInterface $repo, IbgeService $ibge)
    {
        $this->repo = $repo;
        $this->ibge = $ibge;
    }

    public function index()
    {
        try {
            $antenas = $this->repo->all();
            $ranking = $this->repo->topRanking();
            $ufs = $this->ibge->getEstados();

            return view('antenas.index', compact('antenas', 'ranking', 'ufs'));
        } catch (\Exception $e) {
            Log::error('Erro ao carregar dados da antena: ' . $e->getMessage());

            return response()->view('errors.generic', [], 500);
            // Ou, se preferir redirecionar:
            // return redirect()->route('erro.padrao')->with('error', 'Não foi possível carregar os dados.');
        }
    }

    public function ranking()
    {
        try {
            $ranking = $this->repo->topRanking();
            return response()->json(['data' => $ranking]);
        } catch (\Exception $e) {
            Log::error('Erro ao carregar ranking de antenas: ' . $e->getMessage());

            return response()->json([
                'error' => 'Não foi possível carregar o ranking.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
