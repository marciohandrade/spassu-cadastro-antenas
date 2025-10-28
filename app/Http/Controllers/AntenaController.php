<?php

namespace App\Http\Controllers;

use App\Services\IbgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\AntenaRepositoryInterface;

class AntenaController extends Controller
{
    protected AntenaRepositoryInterface $repo;

    public function __construct(AntenaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(IbgeService $ibge)
    {
        $antennas = $this->repo->all();
        $ranking = $this->repo->topRanking();
        $ufs = $ibge->getEstados();

        return view('antennas.index', compact('antennas', 'ranking', 'ufs'));
    }

    public function show($id)
    {
        $antenna = $this->repo->findOrFail($id);
        return view('antennas.show', compact('antenna'));
    }

    public function create(IbgeService $ibge)
    {
        $ufs = $ibge->getEstados();
        return view('antennas.create', compact('ufs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'uf_sigla' => 'required|string|size:2',
            'cidade' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('antennas', 'public');
            $data['foto'] = Storage::url($path);
        }

        $antenna = $this->repo->create($data);

        return redirect()->route('antennas.show', $antenna->id)
            ->with('success', 'Antena criada com sucesso.');
    }
}
