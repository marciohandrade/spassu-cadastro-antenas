<?php

namespace App\Http\Controllers;

use App\Models\Antena;
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
        $antenas = Antena::all();
        //$antenas = Antena::orderBy('id', 'desc')->paginate(10);
        $ranking = $this->repo->topRanking();
        $ufs = $ibge->getEstados();

        //var_dump(json_encode($antenas));

        return view('antenas.index', compact('antenas', 'ranking', 'ufs'));
    }

    /**
     * Exibe detalhes de uma antena específica
     * Retorna JSON para modal AJAX
     */
    public function show($id)
    {
        $antena = $this->repo->findOrFail($id);

        // Se for requisição AJAX, retorna JSON
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'antena' => [
                    'id' => $antena->id,
                    'descricao' => $antena->descricao,
                    'uf' => $antena->uf,
                    'latitude' => $antena->latitude,
                    'longitude' => $antena->longitude,
                    'altura' => $antena->altura,
                    'data_implantacao' => $antena->data_implantacao ? $antena->data_implantacao->format('d/m/Y') : 'Não informada',
                    'foto' => $antena->foto ? asset('storage/' . $antena->foto) : null,
                ]
            ]);
        }

        // Se for acesso direto, renderiza view tradicional
        return view('antenas.show', compact('antena'));
    }

    public function create(IbgeService $ibge)
    {
        $ufs = $ibge->getEstados();
        return view('antenas.create', compact('ufs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'descricao' => 'required|string|min:10|max:100|unique:antenas,descricao',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'uf' => 'required|string|size:2',
            'altura' => 'required|numeric|gt:0',
            'data_implantacao' => 'nullable|date',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('antenas', 'public');
            $data['foto'] = $path;
        }

        $antena = $this->repo->create($data);

        return redirect()->route('antenas.index')
            ->with('success', 'Antena criada com sucesso.');
    }

    public function edit($id, IbgeService $ibge)
    {
        $antena = $this->repo->findOrFail($id);
        $ufs = $ibge->getEstados();
        return view('antenas.edit', compact('antena', 'ufs'));
    }

    public function update(Request $request, $id)
    {
        $antena = $this->repo->findOrFail($id);

        $data = $request->validate([
            'descricao' => 'required|string|min:10|max:100|unique:antenas,descricao,' . $id,
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'uf' => 'required|string|size:2',
            'altura' => 'required|numeric|gt:0',
            'data_implantacao' => 'nullable|date',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // Remove foto antiga se existir
            if ($antena->foto && Storage::disk('public')->exists($antena->foto)) {
                Storage::disk('public')->delete($antena->foto);
            }
            $path = $request->file('foto')->store('antenas', 'public');
            $data['foto'] = $path;
        }

        $this->repo->update($id, $data);

        return redirect()->route('antenas.index')
            ->with('success', 'Antena atualizada com sucesso.');
    }

    public function destroy($id)
    {
        $antena = $this->repo->findOrFail($id);

        // Remove foto se existir
        if ($antena->foto && Storage::disk('public')->exists($antena->foto)) {
            Storage::disk('public')->delete($antena->foto);
        }

        $this->repo->delete($id);

        return redirect()->route('antenas.index')
            ->with('success', 'Antena excluída com sucesso.');
    }
}
