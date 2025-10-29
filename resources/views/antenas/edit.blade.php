@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">✏️ Editar antena</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <strong>Erro!</strong> Corrija os campos abaixo:
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('antenas.update', $antena->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="descricao" class="block font-medium text-gray-700">Descrição</label>
                    <input type="text" name="descricao" id="descricao" value="{{ old('descricao', $antena->descricao) }}" class="mt-1 block w-full border-gray-300 rounded" required minlength="10" maxlength="100">
                </div>

                <div>
                    <label for="uf" class="block font-medium text-gray-700">UF</label>
                    <select name="uf" id="uf" class="mt-1 block w-full border-gray-300 rounded" required>
                        <option value="">Selecione uma UF</option>
                        @foreach ($ufs as $uf)
                            <option value="{{ $uf['sigla'] }}" {{ old('uf', $antena->uf) == $uf['sigla'] ? 'selected' : '' }}>
                                {{ $uf['sigla'] }} - {{ $uf['nome'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="latitude" class="block font-medium text-gray-700">Latitude</label>
                    <input type="number" step="0.000001" name="latitude" id="latitude" value="{{ old('latitude', $antena->latitude) }}" class="mt-1 block w-full border-gray-300 rounded" required min="-90" max="90">
                </div>

                <div>
                    <label for="longitude" class="block font-medium text-gray-700">Longitude</label>
                    <input type="number" step="0.000001" name="longitude" id="longitude" value="{{ old('longitude', $antena->longitude) }}" class="mt-1 block w-full border-gray-300 rounded" required min="-180" max="180">
                </div>

                <div>
                    <label for="altura" class="block font-medium text-gray-700">Altura (m)</label>
                    <input type="number" step="0.01" name="altura" id="altura" value="{{ old('altura', $antena->altura) }}" class="mt-1 block w-full border-gray-300 rounded" required min="0.01">
                </div>

                <div>
                    <label for="data_implantacao" class="block font-medium text-gray-700">Data de implantação</label>
                    <input type="date" name="data_implantacao" id="data_implantacao" value="{{ old('data_implantacao', $antena->data_implantacao) }}" class="mt-1 block w-full border-gray-300 rounded">
                </div>

                <div class="md:col-span-2">
                    <label for="foto" class="block font-medium text-gray-700">Foto da antena (PNG ou JPG)</label>
                    <input type="file" name="foto" id="foto" accept=".png,.jpg,.jpeg" class="mt-1 block w-full border-gray-300 rounded">
                    @if ($antena->foto)
                        <p class="text-sm text-gray-500 mt-1">Foto atual: <a href="{{ asset('storage/' . $antena->foto) }}" target="_blank" class="text-blue-600 underline">ver imagem</a></p>
                    @endif
                </div>

            </div>

            <div class="mt-6 flex items-center justify-between">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Atualizar antena
                </button>

                <form action="{{ route('antennas.destroy', $antena->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta antena?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline ml-4">
                        Excluir antena
                    </button>
                </form>
            </div>
        </form>

    </div>
@endsection
