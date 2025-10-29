@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        .antenna-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .title-group h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0;
        }

        .title-group p {
            color: #6b7280;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .btn-new {
            padding: 12px 24px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .btn-new:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            color: white;
            text-decoration: none;
        }

        .card-modern {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table-modern {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table-modern thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .table-modern thead th {
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
            padding: 1rem;
            text-align: left;
        }

        .table-modern tbody tr {
            transition: all 0.2s ease;
            border-bottom: 1px solid #f3f4f6;
        }

        .table-modern tbody tr:hover {
            background: #f8fafc;
        }

        .table-modern tbody tr:last-child {
            border-bottom: none;
        }

        .table-modern tbody td {
            padding: 1rem;
            color: #374151;
            vertical-align: middle;
        }

        .badge-uf {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 8px 14px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            border: 1px solid;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-view {
            background: #eff6ff;
            color: #2563eb;
            border-color: #bfdbfe;
        }

        .btn-view:hover {
            background: #2563eb;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
            text-decoration: none;
        }

        .btn-edit {
            background: #fefce8;
            color: #ca8a04;
            border-color: #fef08a;
        }

        .btn-edit:hover {
            background: #ca8a04;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(202, 138, 4, 0.3);
            text-decoration: none;
        }

        .btn-delete {
            background: #fef2f2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
        }

        .coord-group {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .coord-label {
            font-size: 0.7rem;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .coord-value {
            font-weight: 600;
            color: #374151;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: #d1d5db;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: #9ca3af;
        }

        /* === MODAL STYLES === */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9998;
            animation: fadeIn 0.3s ease;
        }

        .modal-overlay.active {
            display: block;
        }

        .modal-container {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 9999;
            overflow-y: auto;
            padding: 2rem 1rem;
        }

        .modal-container.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            top: 200px;
            max-width: 1000px;
            width:80%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.3s ease;
            position: relative;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1.5rem 2rem;
            border-radius: 20px 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .modal-section {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
        }

        .modal-section h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-item {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            min-width: 140px;
        }

        .info-value {
            color: #1f2937;
            flex: 1;
        }

        .modal-photo {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 12px;
            border: 3px solid #e5e7eb;
        }

        .modal-map {
            width: 100%;
            height: 350px;
            border-radius: 12px;
            border: 3px solid #e5e7eb;
        }

        .no-photo {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 300px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 12px;
            color: #9ca3af;
            font-size: 3rem;
        }

        .loading-spinner {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: #6b7280;
        }

        .spinner {
            border: 3px solid #f3f4f6;
            border-top: 3px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .header-section {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-new {
                width: 100%;
                justify-content: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }

            .modal-container {
                padding: 0.5rem;
            }

            .modal-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .modal-body {
                padding: 1rem;
            }

            .table-modern thead {
                display: none;
            }

            .table-modern tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 1rem;
            }

            .table-modern tbody td {
                display: block;
                text-align: right;
                padding: 0.5rem 0;
                border-bottom: 1px solid #f3f4f6;
            }

            .table-modern tbody td:last-child {
                border-bottom: none;
            }

            .table-modern tbody td:before {
                content: attr(data-label);
                float: left;
                font-weight: 600;
                color: #6b7280;
                text-transform: uppercase;
                font-size: 0.75rem;
            }
        }
    </style>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <div class="antenna-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="title-group">
                <h1>
                    <div class="header-icon">
                        📡
                    </div>
                    Gestão de Antenas
                </h1>
                <p>Gerencie todas as antenas cadastradas no sistema</p>
            </div>
            <a href="{{ route('antenas.create') }}" class="btn-new">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Antena
            </a>
        </div>

        <!-- Ranking Antenas -->
        @if ($ranking->isNotEmpty())
            <section class="mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">🏆 Ranking de UFs com mais antenas</h2>
                <table class="w-full border border-gray-300 rounded shadow-sm">
                    <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">UF</th>
                        <th class="px-4 py-2 text-left">Quantidade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ranking as $item)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $item->uf}}</td>
                            <td class="px-4 py-2">{{ $item->total }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </section>
        @endif

        <!-- Table Card -->
        <div class="card-modern">
            <div class="table-responsive">
                @if($antenas->count() > 0)
                    <table class="table-modern">
                        <thead>
                        <tr>
                            <th>Descrição</th>
                            <th>UF</th>
                            <th>Coordenadas</th>
                            <th style="text-align: center;">Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($antenas as $antena)
                            <tr>
                                <td data-label="Descrição">
                                    <strong>{{ $antena->descricao }}</strong>
                                </td>
                                <td data-label="UF">
                                    <span class="badge-uf">{{ $antena->uf }}</span>
                                </td>
                                <td data-label="Coordenadas">
                                    <div class="coord-group">
                                        <div>
                                            <span class="coord-label">Lat:</span>
                                            <span class="coord-value">{{ $antena->latitude }}</span>
                                        </div>
                                        <div>
                                            <span class="coord-label">Long:</span>
                                            <span class="coord-value">{{ $antena->longitude }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="Ações">
                                    <div class="action-buttons">
                                        <button onclick="openAntennaModal({{ $antena->id }})" class="btn-action btn-view">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Ver
                                        </button>
                                        <a href="{{ route('antenas.edit', $antena->id) }}" class="btn-action btn-edit">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Editar
                                        </a>
                                        <form action="{{ route('antenas.destroy', $antena->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('⚠️ Tem certeza que deseja excluir esta antena?\n\nDescrição: {{ $antena->descricao }}\nEsta ação não pode ser desfeita.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📡</div>
                        <h3>Nenhuma antena cadastrada</h3>
                        <p>Comece adicionando sua primeira antena ao sistema</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($antenas, 'links'))
            <div style="margin-top: 2rem;">
                {{ $antenas->links() }}
            </div>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeAntennaModal()"></div>
    <div class="modal-container" id="modalContainer">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 class="modal-title">
                    📡 Detalhes da Antena
                </h2>
                <button class="modal-close" onclick="closeAntennaModal()">&times;</button>
            </div>
            <div class="modal-body" id="modalBody">
                <div class="loading-spinner">
                    <div class="spinner"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        let currentMap = null;

        function openAntennaModal(antennaId) {

            const overlay = document.getElementById('modalOverlay');
            const container = document.getElementById('modalContainer');
            const body = document.getElementById('modalBody');

            // Mostra modal com loading
            overlay.classList.add('active');
            container.classList.add('active');
            body.innerHTML = '<div class="loading-spinner"><div class="spinner"></div></div>';

            // Busca dados da antena via AJAX
            fetch(`/antenas/${antennaId}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderAntennaDetails(data.antena);
                    } else {
                        body.innerHTML = '<p style="text-align: center; color: #dc2626;">Erro ao carregar dados da antena.</p>';
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    body.innerHTML = '<p style="text-align: center; color: #dc2626;">Erro ao carregar dados da antena.</p>';
                });
        }

        function renderAntennaDetails(antena) {
            const body = document.getElementById('modalBody');

            body.innerHTML = `
                <div class="modal-grid">
                    <!-- Informações -->
                    <div>
                        <div class="modal-section">
                            <h3>
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                </svg>
                                Informações Gerais
                            </h3>
                            <div class="info-item">
                                <span class="info-label">Descrição:</span>
                                <span class="info-value">${antena.descricao}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">UF:</span>
                                <span class="info-value"><span class="badge-uf">${antena.uf}</span></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Latitude:</span>
                                <span class="info-value">${antena.latitude}°</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Longitude:</span>
                                <span class="info-value">${antena.longitude}°</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Altura:</span>
                                <span class="info-value">${antena.altura} metros</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Implantação:</span>
                                <span class="info-value">${antena.data_implantacao}</span>
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="modal-section" style="margin-top: 1rem;">
                            <h3>
                                <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/>
                                </svg>
                                Fotografia
                            </h3>
                            ${antena.foto
                ? `<img src="${antena.foto}" alt="Foto da antena" class="modal-photo" onerror="this.parentElement.innerHTML='<div class=\\'no-photo\\'>📷</div>'">`
                : '<div class="no-photo">📷</div>'
            }
                        </div>
                    </div>

                    <!-- Mapa -->
                    <div class="modal-section">
                        <h3>
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            Localização no Mapa
                        </h3>
                        <div id="antennaMap" class="modal-map"></div>
                    </div>
                </div>
            `;

            // Inicializa o mapa após renderizar o HTML
            setTimeout(() => {
                initializeMap(antena.latitude, antena.longitude, antena.descricao);
            }, 100);

            /*setTimeout(() => {
                initializeMap(antena.latitude, antena.longitude, antena.descricao);
                setTimeout(() => {
                    if (currentMap) currentMap.invalidateSize();
                }, 300);
            }, 100);*/
        }

        function initializeMap(lat, lng, description) {
            // Remove mapa anterior se existir
            if (currentMap) {
                currentMap.remove();
            }

            // Cria novo mapa
            currentMap = L.map('antennaMap').setView([lat, lng], 13);

            // Adiciona tiles do OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(currentMap);

            // Adiciona marcador customizado
            const customIcon = L.divIcon({
                html: '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 30px; height: 30px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 16px; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">📡</div>',
                className: '',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            });

            L.marker([lat, lng], { icon: customIcon })
                .addTo(currentMap)
                .bindPopup(`<strong>${description}</strong><br>Lat: ${lat}<br>Lng: ${lng}`)
                .openPopup();
        }

        function closeAntennaModal() {
            const overlay = document.getElementById('modalOverlay');
            const container = document.getElementById('modalContainer');

            overlay.classList.remove('active');
            container.classList.remove('active');

            // Remove mapa ao fechar
            if (currentMap) {
                currentMap.remove();
                currentMap = null;
            }
        }

        // Fecha modal ao pressionar ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAntennaModal();
            }
        });
    </script>
@endsection
