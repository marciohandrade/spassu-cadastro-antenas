<?php

namespace App\Http\Controllers;

use App\Models\Antena;
use App\Services\IbgeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\AntenaRepositoryInterface;
use Illuminate\Support\Facades\Validator;

class AntenaController extends Controller
{
    protected AntenaRepositoryInterface $repo;

    public function __construct(AntenaRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index(IbgeService $ibge)
    {
        $antenas = Antena::query()->orderBy('id', 'desc')->paginate(50);
        $ranking = $this->repo->topRanking();

        try {
            $ufs = $ibge->getEstados();
        } catch (\Exception $e) {
            $ufs = [];
        }

        return view('antenas.index', compact('antenas', 'ranking', 'ufs'));
    }

    public function show($id)
    {
        $antena = $this->repo->findOrFail($id);

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

        return view('antenas.show', compact('antena'));
    }

    public function create(IbgeService $ibge)
    {
        try {
            $ufs = $ibge->getEstados();
        } catch (\Exception $e) {
            $ufs = [];
        }
        return view('antenas.create', compact('ufs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|min:10|max:100|unique:antenas,descricao',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'uf' => 'required|string|size:2',
            'altura' => 'required|numeric|gt:0',
            'data_implantacao' => 'nullable|date',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('antenas', 'public');
            $data['foto'] = $path;
        }

        try {
            $antena = $this->repo->create($data);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Antena cadastrada com sucesso!',
                    'antena' => [
                        'id' => $antena->id,
                        'descricao' => $antena->descricao,
                        'uf' => $antena->uf,
                        'latitude' => $antena->latitude,
                        'longitude' => $antena->longitude,
                        'altura' => $antena->altura,
                    ]
                ], 201);
            }

            return redirect()->route('antenas.index')
                ->with('success', 'Antena criada com sucesso.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao cadastrar antena: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Erro ao cadastrar antena.')
                ->withInput();
        }
    }

    public function edit($id, IbgeService $ibge)
    {
        $antena = $this->repo->findOrFail($id);
        try {
            $ufs = $ibge->getEstados();
        } catch (\Exception $e) {
            $ufs = [];
        }
        return view('antenas.edit', compact('antena', 'ufs'));
    }

    public function update(Request $request, $id)
    {
        $antena = $this->repo->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'descricao' => 'required|string|min:10|max:100|unique:antenas,descricao,' . $id,
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'uf' => 'required|string|size:2',
            'altura' => 'required|numeric|gt:0',
            'data_implantacao' => 'nullable|date',
            'foto' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();

        if ($request->hasFile('foto')) {
            if ($antena->foto && Storage::disk('public')->exists($antena->foto)) {
                Storage::disk('public')->delete($antena->foto);
            }
            $path = $request->file('foto')->store('antenas', 'public');
            $data['foto'] = $path;
        }

        try {
            $this->repo->update($id, $data);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Antena atualizada com sucesso!'
                ]);
            }

            return redirect()->route('antenas.index')
                ->with('success', 'Antena atualizada com sucesso.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Erro ao atualizar antena'
                ], 500);
            }
            return back()->with('error', 'Erro ao atualizar antena.');
        }
    }

    public function destroy($id)
    {
        $antena = $this->repo->findOrFail($id);

        if ($antena->foto && Storage::disk('public')->exists($antena->foto)) {
            Storage::disk('public')->delete($antena->foto);
        }

        $this->repo->delete($id);

        return redirect()->route('antenas.index')
            ->with('success', 'Antena excluída com sucesso.');
    }
}
