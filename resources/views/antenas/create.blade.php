<?php

@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">📡 Cadastrar nova antena</h2>

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

        <form action="{{ route('antennas.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="descricao" class="block font-medium text-gray-700">Descrição</label>
                    <input type="text" name="descricao" id="descricao" value="{{ old('descricao') }}" class="mt-1 block w-full border-gray-300 rounded" required minlength="10" maxlength="100">
                </div>

                <div>
                    <label for="uf" class="block font-medium text-gray-700">UF</label>
                    <select name="uf" id="uf" class="mt-1 block w-full border-gray-300 rounded" required>
                        <option value="">Selecione uma UF</option>
                        @foreach ($ufs as $uf)
                            <option value="{{ $uf['sigla'] }}" {{ old('uf') == $uf['sigla'] ? 'selected' : '' }}>
                                {{ $uf['sigla'] }} - {{ $uf['nome'] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="latitude" class="block font-medium text-gray-700">Latitude</label>
                    <input type="number" step="0.000001" name="latitude" id="latitude" value="{{ old('latitude') }}" class="mt-1 block w-full border-gray-300 rounded" required min="-90" max="90">
                </div>

                <div>
                    <label for="longitude" class="block font-medium text-gray-700">Longitude</label>
                    <input type="number" step="0.000001" name="longitude" id="longitude" value="{{ old('longitude') }}" class="mt-1 block w-full border-gray-300 rounded" required min="-180" max="180">
                </div>

                <div>
                    <label for="altura" class="block font-medium text-gray-700">Altura (m)</label>
                    <input type="number" step="0.01" name="altura" id="altura" value="{{ old('altura') }}" class="mt-1 block w-full border-gray-300 rounded" required min="0.01">
                </div>

                <div>
                    <label for="data_implantacao" class="block font-medium text-gray-700">Data de implantação</label>
                    <input type="date" name="data_implantacao" id="data_implantacao" value="{{ old('data_implantacao') }}" class="mt-1 block w-full border-gray-300 rounded">
                </div>

                <div class="md:col-span-2">
                    <label for="foto" class="block font-medium text-gray-700">Foto da antena (PNG ou JPG)</label>
                    <input type="file" name="foto" id="foto" accept=".png,.jpg,.jpeg" class="mt-1 block w-full border-gray-300 rounded">
                </div>

            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Salvar antena
                </button>
            </div>
        </form>

    </div>
@endsection

