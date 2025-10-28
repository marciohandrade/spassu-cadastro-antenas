@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">📡 Detalhes da Antena</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            {{-- Dados da antena --}}
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informações</h3>
                <ul class="text-gray-600 space-y-1">
                    <li><strong>Descrição:</strong> {{ $antena->descricao }}</li>
                    <li><strong>UF:</strong> {{ $antena->uf }}</li>
                    <li><strong>Latitude:</strong> {{ $antena->latitude }}</li>
                    <li><strong>Longitude:</strong> {{ $antena->longitude }}</li>
                    <li><strong>Altura:</strong> {{ $antena->altura }} m</li>
                    <li><strong>Data de implantação:</strong> {{ $antena->data_implantacao ?? 'Não informada' }}</li>
                </ul>
            </div>

            {{-- Foto da antena --}}
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Foto</h3>
                @if ($antena->foto)
                    <img src="{{ asset('storage/' . $antena->foto) }}" alt="Foto da antena" class="w-full h-auto rounded">
                @else
                    <p class="text-gray-500">Nenhuma foto disponível.</p>
                @endif
            </div>

        </div>

        {{-- Mapa --}}
        <div class="mt-8 bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Localização no mapa</h3>
            <div id="map" class="w-full h-64 rounded"></div>
        </div>

    </div>

    {{-- Script do mapa usando Leaflet.js --}}
    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

        <script>
            const latitude = {{ $antena->latitude }};
            const longitude = {{ $antena->longitude }};

            const map = L.map('map').setView([latitude, longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Antena: {{ $antena->descricao }}')
                .openPopup();
        </script>
    @endpush
@endsection
