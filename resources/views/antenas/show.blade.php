<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Antena — {{ $antena->nome }}</title>

    <!-- Estilos simples da página -->
    <style>
        :root{--bg:#f6f8fb;--card:#fff;--accent:#0b6efd;--muted:#6b7280}
        body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,Arial;margin:0;background:var(--bg);color:#111}
        .container{max-width:1100px;margin:36px auto;padding:20px}
        .card{background:var(--card);border-radius:10px;padding:18px;box-shadow:0 6px 18px rgba(12,18,33,0.06)}
        header{display:flex;justify-content:space-between;align-items:center;gap:12px;margin-bottom:12px}
        h1{font-size:20px;margin:0}
        .muted{color:var(--muted);font-size:14px}
        .meta{display:flex;gap:12px;flex-wrap:wrap;margin-top:8px}
        .foto{max-width:420px;border-radius:8px;object-fit:cover}
        .grid{display:grid;grid-template-columns:1fr 420px;gap:18px}
        .field{margin-bottom:8px}
        .label{font-weight:600;font-size:13px;color:var(--muted)}
        .value{font-size:15px}
        .actions{display:flex;gap:8px;margin-top:12px}
        a.button{background:var(--accent);color:#fff;padding:8px 12px;border-radius:8px;text-decoration:none}
        #map{height:320px;border-radius:8px;border:1px solid #e6e9ef}
        @media(max-width:900px){.grid{grid-template-columns:1fr;}.foto{max-width:100%}}
    </style>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>
<div class="container">
    <div class="card" role="main" aria-labelledby="title">
        <header>
            <div>
                <h1 id="title">{{ $antena->nome }}</h1>
                <div class="muted">Criada em: {{ $antena->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="actions" aria-hidden="false">
                <a class="button" href="{{ route('antenas.index') }}">Voltar</a>
                <a class="button" href="{{ route('antenas.edit', $antena->id) }}">Editar</a>
            </div>
        </header>

        <div class="grid" aria-live="polite">
            <div>
                <div class="field">
                    <div class="label">Descrição</div>
                    <div class="value">{{ $antena->descricao ?? '—' }}</div>
                </div>

                <div class="meta">
                    <div>
                        <div class="label">UF</div>
                        <div class="value">{{ $antena->uf_sigla }}</div>
                    </div>
                    <div>
                        <div class="label">Cidade</div>
                        <div class="value">{{ $antena->cidade ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="label">Latitude</div>
                        <div class="value">{{ $antena->latitude ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="label">Longitude</div>
                        <div class="value">{{ $antena->longitude ?? '—' }}</div>
                    </div>
                </div>

                <h3 style="margin-top:18px;margin-bottom:8px">Localização</h3>
                <div id="map" role="region" aria-label="Mapa da antena">Carregando mapa...</div>
            </div>

            <aside>
                @if($antena->foto)
                    <img src="{{ $antena->foto }}" alt="Foto da antena {{ $antena->nome }}" class="foto" />
                @else
                    <div style="display:flex;align-items:center;justify-content:center;height:240px;border-radius:8px;background:#f3f6fa;color:var(--muted)">
                        Sem foto disponível
                    </div>
                @endif

                <div style="margin-top:12px">
                    <div class="label">ID</div>
                    <div class="value">{{ $antena->id }}</div>
                </div>
            </aside>
        </div>
    </div>
</div>

<!-- Leaflet JS e inicialização do mapa -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Use @json para injetar valores seguros do PHP para JS
    const lat = @json($antena->latitude);
    const lng = @json($antena->longitude);

    function showNoCoords() {
        const mapEl = document.getElementById('map');
        mapEl.innerHTML = 'Coordenadas não informadas.';
        mapEl.style.display = 'flex';
        mapEl.style.alignItems = 'center';
        mapEl.style.justifyContent = 'center';
        mapEl.style.color = '#6b7280';
    }

    if (!lat || !lng) {
        showNoCoords();
    } else {
        // Inicializa mapa Leaflet
        const map = L.map('map', { scrollWheelZoom: false }).setView([lat, lng], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19
        }).addTo(map);

        // Marker com popup simples
        const marker = L.marker([lat, lng]).addTo(map);
        marker.bindPopup(`<strong>{{ addslashes($antena->nome) }}</strong><br>{{ $antena->uf_sigla }}${ $antena->cidade ? ' - ' + '{{ addslashes($antena->cidade) }}' : '' }`).openPopup();
    }
</script>
</body>
</html>
