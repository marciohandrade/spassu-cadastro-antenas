@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">

        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('antenas.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar para listagem
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">✏️ Editar Antena</h1>
            <p class="text-gray-600 mt-1">{{ $antena->descricao }}</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Corrija os seguintes erros:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Formulário (2/3) -->
            <div class="lg:col-span-2">
                <form action="{{ route('antenas.update', $antena->id) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Descrição -->
                        <div class="md:col-span-2">
                            <label for="descricao" class="block text-sm font-medium text-gray-700 mb-2">
                                Descrição *
                            </label>
                            <input
                                type="text"
                                name="descricao"
                                id="descricao"
                                value="{{ old('descricao', $antena->descricao) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                                minlength="10"
                                maxlength="100"
                                placeholder="Mínimo 10, máximo 100 caracteres"
                            >
                        </div>

                        <!-- UF -->
                        <div>
                            <label for="uf" class="block text-sm font-medium text-gray-700 mb-2">
                                UF *
                            </label>
                            <select
                                name="uf"
                                id="uf"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                            >
                                <option value="">Selecione uma UF</option>
                                @foreach ($ufs as $uf)
                                    <option value="{{ $uf['sigla'] }}" {{ old('uf', $antena->uf) == $uf['sigla'] ? 'selected' : '' }}>
                                        {{ $uf['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Altura -->
                        <div>
                            <label for="altura" class="block text-sm font-medium text-gray-700 mb-2">
                                Altura (metros) *
                            </label>
                            <input
                                type="number"
                                step="0.01"
                                name="altura"
                                id="altura"
                                value="{{ old('altura', $antena->altura) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                                min="0.01"
                                placeholder="Ex: 50.5"
                            >
                        </div>

                        <!-- Latitude -->
                        <div>
                            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-2">
                                Latitude *
                            </label>
                            <input
                                type="number"
                                step="0.0000001"
                                name="latitude"
                                id="latitude"
                                value="{{ old('latitude', $antena->latitude) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                                min="-90"
                                max="90"
                                placeholder="-23.5505"
                            >
                        </div>

                        <!-- Longitude -->
                        <div>
                            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-2">
                                Longitude *
                            </label>
                            <input
                                type="number"
                                step="0.0000001"
                                name="longitude"
                                id="longitude"
                                value="{{ old('longitude', $antena->longitude) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required
                                min="-180"
                                max="180"
                                placeholder="-46.6333"
                            >
                        </div>

                        <!-- Data de Implantação -->
                        <div class="md:col-span-2">
                            <label for="data_implantacao" class="block text-sm font-medium text-gray-700 mb-2">
                                Data de Implantação
                            </label>
                            <input
                                type="date"
                                name="data_implantacao"
                                id="data_implantacao"
                                value="{{ old('data_implantacao', $antena->data_implantacao ? $antena->data_implantacao->format('Y-m-d') : '') }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                        </div>

                        <!-- Foto -->
                        <div class="md:col-span-2">
                            <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto da Antena
                            </label>

                            @if ($antena->foto)
                                <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm text-gray-600 mb-2">Foto atual:</p>
                                    <img
                                        src="{{ asset('storage/' . $antena->foto) }}"
                                        alt="{{ $antena->descricao }}"
                                        class="w-full max-w-md h-48 object-cover rounded-lg shadow-sm"
                                    >
                                </div>
                            @endif

                            <input
                                type="file"
                                name="foto"
                                id="foto"
                                accept=".png,.jpg,.jpeg"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <p class="text-xs text-gray-500 mt-1">PNG ou JPG, máximo 2MB</p>
                        </div>

                    </div>

                    <!-- Botões de Ação -->
                    <div class="mt-8 flex flex-wrap gap-3">
                        <button
                            type="submit"
                            class="flex-1 md:flex-none bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-lg transition duration-200 ease-in-out transform hover:scale-105"
                        >
                            💾 Salvar Alterações
                        </button>

                        <a
                            href="{{ route('antenas.index') }}"
                            class="flex-1 md:flex-none bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-6 py-3 rounded-lg text-center transition duration-200"
                        >
                            Cancelar
                        </a>
                    </div>
                </form>

                <!-- Botão de Excluir (separado) -->
                <div class="mt-6">
                    <form action="{{ route('antenas.destroy', $antena->id) }}" method="POST" onsubmit="return confirm('⚠️ Tem certeza que deseja excluir esta antena?\n\nEsta ação não pode ser desfeita!');" class="bg-red-50 border border-red-200 rounded-lg p-4">
                        @csrf
                        @method('DELETE')
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-red-800">Zona de Perigo</h3>
                                <p class="text-sm text-red-600 mt-1">Esta ação é irreversível</p>
                            </div>
                            <button
                                type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition duration-200"
                            >
                                🗑️ Excluir Antena
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar - Mapa e Info (1/3) -->
            <div class="lg:col-span-1 space-y-6">

                <!-- Mapa -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📍 Localização</h3>
                    <div id="map" class="w-full h-64 rounded-lg border border-gray-300"></div>
                    <div class="mt-3 text-sm text-gray-600">
                        <p><strong>Lat:</strong> {{ $antena->latitude }}</p>
                        <p><strong>Long:</strong> {{ $antena->longitude }}</p>
                    </div>
                </div>

                <!-- Informações Adicionais -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">ℹ️ Informações</h3>
                    <dl class="space-y-3 text-sm">
                        <div>
                            <dt class="font-medium text-gray-700">ID</dt>
                            <dd class="text-gray-600">#{{ $antena->id }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">Criada em</dt>
                            <dd class="text-gray-600">{{ $antena->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="font-medium text-gray-700">Atualizada em</dt>
                            <dd class="text-gray-600">{{ $antena->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                </div>

            </div>

        </div>
    </div>

    <!-- Leaflet JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar mapa
            const lat = {{ $antena->latitude }};
            const lng = {{ $antena->longitude }};

            const map = L.map('map').setView([lat, lng], 13);

            // Adicionar tile layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);

            // Adicionar marcador
            const marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup('<b>{{ $antena->descricao }}</b><br>{{ $antena->uf }}').openPopup();

            // Atualizar mapa quando latitude/longitude mudarem
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');

            function updateMap() {
                const newLat = parseFloat(latInput.value);
                const newLng = parseFloat(lngInput.value);

                if (!isNaN(newLat) && !isNaN(newLng)) {
                    marker.setLatLng([newLat, newLng]);
                    map.setView([newLat, newLng], 13);
                }
            }

            latInput.addEventListener('change', updateMap);
            lngInput.addEventListener('change', updateMap);
        });
    </script>
@endsection
