<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Estados do Brasil — Landing</title>
    <style>
        :root{--bg:#f5f7fb;--card:#ffffff;--accent:#0b6efd;--muted:#6b7280}
        body{font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto,"Helvetica Neue",Arial;margin:0;background:var(--bg);color:#111}
        .container{max-width:1100px;margin:36px auto;padding:20px}
        .card{background:var(--card);border-radius:12px;padding:18px;box-shadow:0 6px 18px rgba(12,18,33,0.06)}
        header{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
        h1{font-size:20px;margin:0}
        p.lead{margin:6px 0 0;color:var(--muted)}
        .controls{display:flex;gap:12px;align-items:center;margin:14px 0}
        select, input[type="search"]{padding:8px 10px;border:1px solid #e6e9ef;border-radius:8px}
        button{background:var(--accent);color:#fff;border:none;padding:9px 12px;border-radius:8px;cursor:pointer}
        table{width:100%;border-collapse:collapse;margin-top:12px}
        th,td{padding:10px 8px;text-align:left;border-bottom:1px solid #eef2f7}
        th{background:#fbfdff;color:var(--muted);font-weight:600}
        .muted{color:var(--muted);font-size:13px}
        .center{display:flex;align-items:center;justify-content:center;padding:24px}
        .error{color:#b91c1c}
        @media(max-width:700px){.controls{flex-direction:column;align-items:stretch}}
    </style>
</head>
<body>
<div class="container">
    <div class="card" role="main" aria-labelledby="title">
        <header>
            <div>
                <h1 id="title">Estados do Brasil</h1>
                <p class="lead">Lista de UFs fornecida pela API interna /api/ufs</p>
            </div>
            <div class="muted">Status: <span id="status">—</span></div>
        </header>

        <div class="controls" aria-hidden="false">
            <label for="filter" class="sr-only">Filtrar</label>
            <input id="filter" type="search" placeholder="Filtrar por sigla ou nome" aria-label="Filtrar estados" />
            <select id="regionFilter" aria-label="Filtrar por região">
                <option value="">Todas as regiões</option>
            </select>
            <button id="refresh">Atualizar</button>
        </div>

        <div id="content">
            <div id="loader" class="center">Carregando...</div>
            <div id="error" class="center error" style="display:none"></div>

            <table id="table" style="display:none" aria-live="polite" aria-busy="false">
                <thead>
                <tr>
                    <th>Sigla</th>
                    <th>Nome</th>
                    <th>Região</th>
                </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
    const api = '/api/ufs';
    const statusEl = document.getElementById('status');
    const loader = document.getElementById('loader');
    const table = document.getElementById('table');
    const tbody = document.getElementById('tbody');
    const errorEl = document.getElementById('error');
    const filterInput = document.getElementById('filter');
    const regionFilter = document.getElementById('regionFilter');
    const refreshBtn = document.getElementById('refresh');

    let estados = [];

    function showLoading(on) {
        loader.style.display = on ? 'block' : 'none';
        table.style.display = on ? 'none' : (tbody.children.length ? 'table' : 'none');
        errorEl.style.display = 'none';
    }

    function setStatus(text, color) {
        statusEl.textContent = text;
        statusEl.style.color = color || 'inherit';
    }

    function renderTable(list) {
        tbody.innerHTML = '';
        if (!list.length) {
            tbody.innerHTML = '<tr><td colspan="3" class="muted">Nenhum estado encontrado</td></tr>';
        } else {
            const fragment = document.createDocumentFragment();
            list.forEach(e => {
                const tr = document.createElement('tr');
                tr.innerHTML = `<td>${escapeHtml(e.sigla)}</td><td>${escapeHtml(e.nome)}</td><td>${escapeHtml(e.regiao)}</td>`;
                fragment.appendChild(tr);
            });
            tbody.appendChild(fragment);
        }
        table.style.display = 'table';
    }

    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, s => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[s]));
    }

    function populateRegions(list) {
        const regions = [...new Set(list.map(i => i.regiao))].sort();
        regionFilter.innerHTML = '<option value="">Todas as regiões</option>' + regions.map(r => `<option value="${r}">${r}</option>`).join('');
    }

    function applyFilters() {
        const q = filterInput.value.trim().toLowerCase();
        const region = regionFilter.value;
        const filtered = estados.filter(e => {
            const matchesQ = !q || e.sigla.toLowerCase().includes(q) || e.nome.toLowerCase().includes(q);
            const matchesRegion = !region || e.regiao === region;
            return matchesQ && matchesRegion;
        });
        renderTable(filtered);
    }

    async function loadEstados() {
        showLoading(true);
        setStatus('Carregando...', '#0471e6');
        try {
            const res = await fetch(api, { headers: { 'Accept': 'application/json' }});
            if (!res.ok) throw new Error('HTTP ' + res.status);
            const data = await res.json();
            estados = Array.isArray(data) ? data : [];
            populateRegions(estados);
            applyFilters();
            setStatus('OK', 'green');
        } catch (err) {
            errorEl.style.display = 'block';
            errorEl.textContent = 'Erro ao carregar estados: ' + err.message;
            setStatus('Erro', '#b91c1c');
            table.style.display = 'none';
        } finally {
            showLoading(false);
        }
    }

    // Events
    filterInput.addEventListener('input', () => applyFilters());
    regionFilter.addEventListener('change', () => applyFilters());
    refreshBtn.addEventListener('click', () => loadEstados());

    // Initial load
    loadEstados();
</script>
</body>
</html>
