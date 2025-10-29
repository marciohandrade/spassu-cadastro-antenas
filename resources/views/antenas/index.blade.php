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

        /* === FILTRO DE BUSCA === */
        .filter-section {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .filter-wrapper {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .filter-input-group {
            flex: 1;
            position: relative;
        }

        .filter-input {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 3rem;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .filter-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .filter-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .btn-filter {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .btn-clear {
            padding: 0.75rem 1.5rem;
            background: #f3f4f6;
            color: #374151;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-clear:hover {
            background: #e5e7eb;
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
            max-width: 900px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.3s ease;
            position: relative;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
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
            flex-shrink: 0;
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
            overflow-y: auto;
            flex: 1;
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

        /* === FORM STYLES === */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .required {
            color: #ef4444;
        }

        .form-input {
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
        }

        .form-input.success {
            border-color: #10b981;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .success-message {
            color: #10b981;
            font-size: 0.75rem;
            margin-top: 0.25rem;
            display: none;
        }

        .success-message.show {
            display: block;
        }

        /* File Upload */
        .file-upload-wrapper {
            position: relative;
        }

        .file-upload-input {
            display: none;
        }

        .file-upload-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9fafb;
            gap: 1rem;
        }

        .file-upload-label:hover {
            border-color: #667eea;
            background: #f3f4f6;
        }

        .file-upload-label.has-file {
            border-color: #10b981;
            background: #f0fdf4;
        }

        .file-preview {
            margin-top: 1rem;
            display: none;
        }

        .file-preview.show {
            display: block;
        }

        .file-preview img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e5e7eb;
        }

        /* Modal Footer */
        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            flex-shrink: 0;
        }

        .btn-cancel {
            padding: 0.75rem 1.5rem;
            background: #f3f4f6;
            color: #374151;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #e5e7eb;
        }

        .btn-submit {
            padding: 0.75rem 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-submit:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-submit .spinner {
            width: 16px;
            height: 16px;
            border-width: 2px;
            display: none;
        }

        .btn-submit.loading .spinner {
            display: block;
        }

        .btn-submit.loading .btn-text {
            display: none;
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .toast {
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 300px;
            animation: slideInRight 0.3s ease;
            border-left: 4px solid;
        }

        .toast.success {
            border-color: #10b981;
        }

        .toast.error {
            border-color: #ef4444;
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .toast.success .toast-icon {
            background: #d1fae5;
            color: #059669;
        }

        .toast.error .toast-icon {
            background: #fee2e2;
            color: #dc2626;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .toast-close {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast-close:hover {
            color: #374151;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
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

            .filter-wrapper {
                flex-direction: column;
            }

            .btn-filter,
            .btn-clear {
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

            .modal-content {
                max-height: 95vh;
            }

            .modal-grid, .form-grid {
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

            .toast-container {
                left: 1rem;
                right: 1rem;
                top: 1rem;
            }

            .toast {
                min-width: auto;
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
            <button onclick="openCreateModal()" class="btn-new">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nova Antena
            </button>
        </div>

        <!-- FILTRO DE BUSCA -->
        <div class="filter-section">
            <form method="GET" action="{{ route('antenas.index') }}" id="filterForm">
                <div class="filter-wrapper">
                    <div class="filter-input-group">
                        <svg class="filter-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input
                            type="text"
                            name="descricao"
                            id="filterDescricao"
                            class="filter-input"
                            placeholder="Buscar por descrição da antena..."
                            value="{{ request('descricao') }}"
                        >
                    </div>
                    <button type="submit" class="btn-filter">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Buscar
                    </button>
                    @if(request('descricao'))
                        <a href="{{ route('antenas.index') }}" class="btn-clear">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Limpar
                        </a>
                    @endif
                </div>
            </form>
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
                                        <button onclick="openEditModal('{{ $antena->id }}')" class="btn-action btn-edit">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Editar
                                        </button>
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
                        <h3>{{ request('descricao') ? 'Nenhuma antena encontrada' : 'Nenhuma antena cadastrada' }}</h3>
                        <p>{{ request('descricao') ? 'Tente buscar com outro termo' : 'Comece adicionando sua primeira antena ao sistema' }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($antenas, 'links'))
            <div style="margin-top: 2rem;">
                {{ $antenas->appends(['descricao' => request('descricao')])->links() }}
            </div>
        @endif
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- Modal VIEW (Ver Detalhes) -->
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

    <!-- Modal CREATE (Nova Antena) -->
    <div class="modal-overlay" id="createModalOverlay" onclick="closeCreateModal()"></div>
    <div class="modal-container" id="createModalContainer">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 class="modal-title">
                    ➕ Nova Antena
                </h2>
                <button class="modal-close" onclick="closeCreateModal()">&times;</button>
            </div>

            <form id="createAntennaForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-grid">
                        <!-- Descrição -->
                        <div class="form-group full-width">
                            <label class="form-label">
                                Descrição <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="descricao"
                                id="descricao"
                                class="form-input"
                                placeholder="Digite a descrição da antena"
                                minlength="10"
                                maxlength="100"
                                required
                            >
                            <small class="text-muted">Mínimo 10 caracteres, máximo 100</small>
                            <span class="error-message" id="error-descricao"></span>
                            <span class="success-message" id="success-descricao">✓ Descrição válida</span>
                        </div>

                        <!-- UF -->
                        <div class="form-group">
                            <label class="form-label">
                                UF <span class="required">*</span>
                            </label>
                            <select name="uf" id="uf" class="form-input" required>
                                <option value="">Selecione uma UF</option>
                                @foreach($ufs as $uf)
                                    <option value="{{ $uf['sigla'] }}">{{ $uf['sigla'] }} - {{ $uf['nome'] }}</option>
                                @endforeach
                            </select>
                            <span class="error-message" id="error-uf"></span>
                            <span class="success-message" id="success-uf">✓ UF selecionada</span>
                        </div>

                        <!-- Altura -->
                        <div class="form-group">
                            <label class="form-label">
                                Altura (metros) <span class="required">*</span>
                            </label>
                            <input
                                type="number"
                                name="altura"
                                id="altura"
                                class="form-input"
                                placeholder="Ex: 45.5"
                                step="0.01"
                                min="0.01"
                                required
                            >
                            <span class="error-message" id="error-altura"></span>
                            <span class="success-message" id="success-altura">✓ Altura válida</span>
                        </div>

                        <!-- Latitude -->
                        <div class="form-group">
                            <label class="form-label">
                                Latitude <span class="required">*</span>
                            </label>
                            <input
                                type="number"
                                name="latitude"
                                id="latitude"
                                class="form-input"
                                placeholder="Ex: -23.5505"
                                step="0.000001"
                                min="-90"
                                max="90"
                                required
                            >
                            <small class="text-muted">Entre -90 e 90</small>
                            <span class="error-message" id="error-latitude"></span>
                            <span class="success-message" id="success-latitude">✓ Latitude válida</span>
                        </div>

                        <!-- Longitude -->
                        <div class="form-group">
                            <label class="form-label">
                                Longitude <span class="required">*</span>
                            </label>
                            <input
                                type="number"
                                name="longitude"
                                id="longitude"
                                class="form-input"
                                placeholder="Ex: -46.6333"
                                step="0.000001"
                                min="-180"
                                max="180"
                                required
                            >
                            <small class="text-muted">Entre -180 e 180</small>
                            <span class="error-message" id="error-longitude"></span>
                            <span class="success-message" id="success-longitude">✓ Longitude válida</span>
                        </div>

                        <!-- Data de Implantação -->
                        <div class="form-group full-width">
                            <label class="form-label">
                                Data de Implantação
                            </label>
                            <input
                                type="date"
                                name="data_implantacao"
                                id="data_implantacao"
                                class="form-input"
                            >
                            <span class="error-message" id="error-data_implantacao"></span>
                        </div>

                        <!-- Foto -->
                        <div class="form-group full-width">
                            <label class="form-label">
                                Foto da Antena
                            </label>
                            <div class="file-upload-wrapper">
                                <input
                                    type="file"
                                    name="foto"
                                    id="foto"
                                    class="file-upload-input"
                                    accept="image/png,image/jpeg,image/jpg"
                                    onchange="handleFileSelect(event)"
                                >
                                <label for="foto" class="file-upload-label" id="fileUploadLabel">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <div>
                                        <strong>Clique para selecionar</strong> ou arraste a foto aqui
                                    </div>
                                    <small style="color: #9ca3af;">PNG ou JPG (máx. 5MB)</small>
                                </label>
                                <div class="file-preview" id="filePreview">
                                    <img id="previewImage" src="" alt="Preview">
                                </div>
                            </div>
                            <span class="error-message" id="error-foto"></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeCreateModal()">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <div class="spinner"></div>
                        <span class="btn-text">
                            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Cadastrar Antena
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // ============================================
        // FUNÇÕES DE MODAL (VIEW - Ver Detalhes)
        // ============================================

        function openAntennaModal(id) {
            const overlay = document.getElementById('modalOverlay');
            const modal = document.getElementById('modalContainer');
            const body = document.getElementById('modalBody');

            overlay.classList.add('active');
            modal.classList.add('active');

            body.innerHTML = '<div class="loading-spinner"><div class="spinner"></div></div>';

            fetch(`/antenas/${id}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayAntennaDetails(data.antena);
                    }
                })
                .catch(error => {
                    body.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">⚠️</div>
                        <h3>Erro ao carregar dados</h3>
                        <p>Não foi possível carregar os detalhes da antena</p>
                    </div>
                `;
                });
        }

        function displayAntennaDetails(antena) {
            const body = document.getElementById('modalBody');

            body.innerHTML = `
                <div class="modal-grid">
                    <div>
                        <div class="modal-section">
                            <h3>📋 Informações Gerais</h3>
                            <div class="info-item">
                                <span class="info-label">Descrição:</span>
                                <span class="info-value">${antena.descricao}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">UF:</span>
                                <span class="info-value"><span class="badge-uf">${antena.uf}</span></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Altura:</span>
                                <span class="info-value">${antena.altura} metros</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Data Implantação:</span>
                                <span class="info-value">${antena.data_implantacao}</span>
                            </div>
                        </div>

                        <div class="modal-section" style="margin-top: 1.5rem;">
                            <h3>📍 Coordenadas</h3>
                            <div class="info-item">
                                <span class="info-label">Latitude:</span>
                                <span class="info-value">${antena.latitude}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Longitude:</span>
                                <span class="info-value">${antena.longitude}</span>
                            </div>
                        </div>

                        ${antena.foto ? `
                            <div class="modal-section" style="margin-top: 1.5rem;">
                                <h3>📸 Foto</h3>
                                <img src="${antena.foto}" alt="Foto da antena" class="modal-photo">
                            </div>
                        ` : `
                            <div class="modal-section" style="margin-top: 1.5rem;">
                                <h3>📸 Foto</h3>
                                <div class="no-photo">📷</div>
                            </div>
                        `}
                    </div>

                    <div>
                        <div class="modal-section">
                            <h3>🗺️ Localização</h3>
                            <div id="map" class="modal-map"></div>
                        </div>
                    </div>
                </div>
            `;

            setTimeout(() => {
                const map = L.map('map').setView([antena.latitude, antena.longitude], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([antena.latitude, antena.longitude])
                    .addTo(map)
                    .bindPopup(`<b>${antena.descricao}</b><br>UF: ${antena.uf}`)
                    .openPopup();
            }, 100);
        }

        function closeAntennaModal() {
            document.getElementById('modalOverlay').classList.remove('active');
            document.getElementById('modalContainer').classList.remove('active');
        }

        // ============================================
        // FUNÇÕES DE MODAL (CREATE - Nova Antena)
        // ============================================

        function openCreateModal() {
            document.getElementById('createModalOverlay').classList.add('active');
            document.getElementById('createModalContainer').classList.add('active');
            document.getElementById('createAntennaForm').reset();
            clearAllValidations();
        }

        function closeCreateModal() {
            document.getElementById('createModalOverlay').classList.remove('active');
            document.getElementById('createModalContainer').classList.remove('active');
            document.getElementById('createAntennaForm').reset();
            clearAllValidations();
        }

        // ============================================
        // VALIDAÇÃO EM TEMPO REAL
        // ============================================

        // Descrição
        document.getElementById('descricao')?.addEventListener('input', function(e) {
            const value = e.target.value;
            const field = e.target;

            if (value.length === 0) {
                setFieldNeutral(field);
            } else if (value.length < 10) {
                setFieldError(field, 'Mínimo 10 caracteres');
            } else if (value.length > 100) {
                setFieldError(field, 'Máximo 100 caracteres');
            } else {
                setFieldSuccess(field);
            }
        });

        // UF
        document.getElementById('uf')?.addEventListener('change', function(e) {
            const field = e.target;
            if (e.target.value) {
                setFieldSuccess(field);
            } else {
                setFieldError(field, 'Selecione uma UF');
            }
        });

        // Altura
        document.getElementById('altura')?.addEventListener('input', function(e) {
            const value = parseFloat(e.target.value);
            const field = e.target;

            if (e.target.value === '') {
                setFieldNeutral(field);
            } else if (value <= 0) {
                setFieldError(field, 'Altura deve ser maior que 0');
            } else {
                setFieldSuccess(field);
            }
        });

        // Latitude
        document.getElementById('latitude')?.addEventListener('input', function(e) {
            const value = parseFloat(e.target.value);
            const field = e.target;

            if (e.target.value === '') {
                setFieldNeutral(field);
            } else if (value < -90 || value > 90) {
                setFieldError(field, 'Latitude deve estar entre -90 e 90');
            } else {
                setFieldSuccess(field);
            }
        });

        // Longitude
        document.getElementById('longitude')?.addEventListener('input', function(e) {
            const value = parseFloat(e.target.value);
            const field = e.target;

            if (e.target.value === '') {
                setFieldNeutral(field);
            } else if (value < -180 || value > 180) {
                setFieldError(field, 'Longitude deve estar entre -180 e 180');
            } else {
                setFieldSuccess(field);
            }
        });

        // ============================================
        // FUNÇÕES DE VALIDAÇÃO VISUAL
        // ============================================

        function setFieldError(field, message) {
            const fieldName = field.name;
            field.classList.remove('success');
            field.classList.add('error');

            const errorEl = document.getElementById(`error-${fieldName}`);
            const successEl = document.getElementById(`success-${fieldName}`);

            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.add('show');
            }
            if (successEl) {
                successEl.classList.remove('show');
            }
        }

        function setFieldSuccess(field) {
            const fieldName = field.name;
            field.classList.remove('error');
            field.classList.add('success');

            const errorEl = document.getElementById(`error-${fieldName}`);
            const successEl = document.getElementById(`success-${fieldName}`);

            if (errorEl) {
                errorEl.classList.remove('show');
            }
            if (successEl) {
                successEl.classList.add('show');
            }
        }

        function setFieldNeutral(field) {
            const fieldName = field.name;
            field.classList.remove('error', 'success');

            const errorEl = document.getElementById(`error-${fieldName}`);
            const successEl = document.getElementById(`success-${fieldName}`);

            if (errorEl) errorEl.classList.remove('show');
            if (successEl) successEl.classList.remove('show');
        }

        function clearAllValidations() {
            document.querySelectorAll('.form-input').forEach(input => {
                setFieldNeutral(input);
            });

            // Limpar preview de foto
            const fileLabel = document.getElementById('fileUploadLabel');
            const filePreview = document.getElementById('filePreview');
            if (fileLabel) fileLabel.classList.remove('has-file');
            if (filePreview) filePreview.classList.remove('show');
        }

        // ============================================
        // UPLOAD DE FOTO
        // ============================================

        function handleFileSelect(event) {
            const file = event.target.files[0];
            const fileLabel = document.getElementById('fileUploadLabel');
            const filePreview = document.getElementById('filePreview');
            const previewImage = document.getElementById('previewImage');

            if (file) {
                // Validar tipo
                const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    setFieldError(event.target, 'Apenas arquivos PNG ou JPG são permitidos');
                    event.target.value = '';
                    return;
                }

                // Validar tamanho (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    setFieldError(event.target, 'Arquivo muito grande. Máximo 5MB');
                    event.target.value = '';
                    return;
                }

                // Preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    filePreview.classList.add('show');
                    fileLabel.classList.add('has-file');
                };
                reader.readAsDataURL(file);

                setFieldSuccess(event.target);
            } else {
                fileLabel.classList.remove('has-file');
                filePreview.classList.remove('show');
                setFieldNeutral(event.target);
            }
        }

        // ============================================
        // SUBMIT DO FORMULÁRIO
        // ============================================

        document.getElementById('createAntennaForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitBtn = document.getElementById('submitBtn');
            const formData = new FormData(this);

            // Desabilitar botão e mostrar loading
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');

            // Limpar erros anteriores
            document.querySelectorAll('.error-message').forEach(el => el.classList.remove('show'));

            fetch('{{ route("antenas.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Sucesso
                        showToast('Sucesso!', data.message || 'Antena cadastrada com sucesso!', 'success');
                        closeCreateModal();

                        // Recarregar página após 1.5 segundos
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        // Erros de validação
                        if (data.errors) {
                            Object.keys(data.errors).forEach(field => {
                                const input = document.querySelector(`[name="${field}"]`);
                                const errorEl = document.getElementById(`error-${field}`);

                                if (input) {
                                    setFieldError(input, data.errors[field][0]);
                                }
                            });
                            showToast('Erro de Validação', 'Por favor, corrija os erros no formulário', 'error');
                        } else {
                            showToast('Erro', data.message || 'Erro ao cadastrar antena', 'error');
                        }
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    showToast('Erro', 'Erro ao processar requisição', 'error');
                })
                .finally(() => {
                    // Reabilitar botão
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                });
        });

        // ============================================
        // TOAST NOTIFICATIONS
        // ============================================

        function showToast(title, message, type = 'success') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            const icon = type === 'success' ? '✔' : '✕';

            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="this.parentElement.remove()">✕</button>
            `;

            container.appendChild(toast);

            // Auto-remover após 5 segundos
            setTimeout(() => {
                toast.style.animation = 'slideInRight 0.3s ease reverse';
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        // ============================================
        // MENSAGENS FLASH (Laravel)
        // ============================================

        @if(session('success'))
        showToast('Sucesso!', '{{ session("success") }}', 'success');
        @endif

        @if(session('error'))
        showToast('Erro!', '{{ session("error") }}', 'error');
        @endif

        // ============================================
        // FECHAR MODAIS COM ESC
        // ============================================

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeAntennaModal();
                closeCreateModal();
            }
        });

        // ============================================
        // FUNÇÃO PARA EDIÇÃO (PLACEHOLDER)
        // ============================================

        function openEditModal(id) {
            // Redirecionar para a página de edição por enquanto
            window.location.href = `/antenas/${id}/edit`;
        }
    </script>

    <style>
        .text-muted {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-top: 0.25rem;
            display: block;
        }
    </style>
@endsection
