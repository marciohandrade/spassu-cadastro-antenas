@extends('layouts.app')

@section('content')
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --secondary: #8b5cf6;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;S
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

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
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

        .form-label .required {
            color: #ef4444;
            margin-left: 2px;
        }

        .form-input {
            padding: 0.75rem;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-input.error {
            border-color: #ef4444;
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

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-input {
            position: absolute;
            left: -9999px;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 3rem 1rem;
            border: 2px dashed #d1d5db;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9fafb;
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
            display: none;
            margin-top: 1rem;
            text-align: center;
        }

        .file-preview.show {
            display: block;
        }

        .file-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .modal-footer {
            padding: 1.5rem 2rem;
            border-top: 1px solid #e5e7eb;
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn-cancel {
            padding: 0.75rem 1.5rem;
            border: 2px solid #e5e7eb;
            background: white;
            color: #6b7280;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-cancel:hover {
            background: #f3f4f6;
            border-color: #d1d5db;
        }

        .btn-submit {
            padding: 0.75rem 2rem;
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
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .btn-submit.loading .spinner {
            display: block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Success Toast */
        .toast-container {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 10000;
        }

        .toast {
            background: white;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 300px;
            animation: slideInRight 0.3s ease;
            margin-bottom: 1rem;
        }

        .toast.success {
            border-left: 4px solid #10b981;
        }

        .toast.error {
            border-left: 4px solid #ef4444;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(100%);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .toast-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .toast.success .toast-icon {
            background: #d1fae5;
            color: #10b981;
        }

        .toast.error .toast-icon {
            background: #fee2e2;
            color: #ef4444;
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

        /* === VIEW MODAL STYLES === */
        .view-modal-content {
            background: white;
            border-radius: 20px;
            max-width: 800px;
            width: 100%;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            animation: slideUp 0.3s ease;
            position: relative;
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .detail-left {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .detail-right {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .detail-item.full-width {
            grid-column: 1 / -1;
        }

        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
        }

        .detail-value {
            font-size: 1rem;
            font-weight: 500;
            color: #1f2937;
        }

        .detail-value.large {
            font-size: 1.125rem;
        }

        .badge-uf-large {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 24px;
            font-size: 1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            letter-spacing: 1px;
        }

        .antenna-photo {
            width: 100%;
            height: 400px; /* Altura fixa */
            border-radius: 12px;
            overflow: hidden;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .antenna-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* 👈 ESSA É A MÁGICA! */
            object-position: center;
            transition: transform 0.3s ease;
        }

        .no-photo {
            background: #f3f4f6;
            padding: 3rem;
            text-align: center;
            border-radius: 12px;
            border: 2px dashed #d1d5db;
        }

        .no-photo-icon {
            font-size: 3rem;
            color: #9ca3af;
            margin-bottom: 0.5rem;
        }

        .no-photo-text {
            color: #6b7280;
            font-size: 0.875rem;
        }

        .map-container {
            width: 100%;
            height: 300px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .loading-spinner {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            gap: 1rem;
        }

        .spinner-circle {
            width: 48px;
            height: 48px;
            border: 4px solid #e5e7eb;
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        .loading-text {
            color: #6b7280;
            font-size: 0.875rem;
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

            .modal-body {
                padding: 1rem;
            }

            .form-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .detail-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .modal-footer {
                flex-direction: column;
            }

            .btn-cancel, .btn-submit {
                width: 100%;
                justify-content: center;
            }

            .toast-container {
                left: 1rem;
                right: 1rem;
                top: 1rem;
            }

            .toast {
                min-width: auto;
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

            .map-container {
                height: 250px;
            }
        }
    </style>

    <div class="antenna-container">
        <!-- Header Section -->
        <div class="header-section">
            <div class="title-group">
                <h1>
                    <div class="header-icon">📡</div>
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
                                        <button onclick="openViewModal('{{ $antena->id }}')" class="btn-action btn-view">
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

    <!-- Modal Create -->
    <div class="modal-overlay" id="modalOverlay" onclick="closeCreateModal()"></div>
    <div class="modal-container" id="modalContainer">
        <div class="modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 class="modal-title">
                    📡 Cadastrar Nova Antena
                </h2>
                <button class="modal-close" onclick="closeCreateModal()">&times;</button>
            </div>

            <form id="antennaForm" enctype="multipart/form-data">
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
                                placeholder="Ex: Antena Torre Central São Paulo"
                                minlength="10"
                                maxlength="100"
                                required
                            >
                            <span class="error-message" id="error-descricao"></span>
                        </div>

                        <!-- UF -->
                        <div class="form-group">
                            <label class="form-label">
                                UF <span class="required">*</span>
                            </label>
                            <select name="uf" id="uf" class="form-input" required>
                                <option value="">Selecione uma UF</option>
                                @foreach ($ufs as $uf)
                                    <option value="{{ $uf['sigla'] }}">{{ $uf['sigla'] }} - {{ $uf['nome'] }}</option>
                                @endforeach
                            </select>
                            <span class="error-message" id="error-uf"></span>
                        </div>

                        <!-- Altura -->
                        <div class="form-group">
                            <label class="form-label">
                                Altura (metros) <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="altura"
                                id="altura"
                                class="form-input"
                                placeholder="Ex: 45.5"
                                required
                            >
                            <span class="error-message" id="error-altura"></span>
                        </div>

                        <!-- Latitude -->
                        <div class="form-group">
                            <label class="form-label">
                                Latitude <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="latitude"
                                id="latitude"
                                class="form-input"
                                placeholder="Ex: -23.550520"
                                required
                            >
                            <span class="error-message" id="error-latitude"></span>
                        </div>

                        <!-- Longitude -->
                        <div class="form-group">
                            <label class="form-label">
                                Longitude <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                name="longitude"
                                id="longitude"
                                class="form-input"
                                placeholder="Ex: -46.633308"
                                required
                            >
                            <span class="error-message" id="error-longitude"></span>
                        </div>

                        <!-- Data de Implantação -->
                        <div class="form-group">
                            <label class="form-label">
                                Data de Implantação
                            </label>
                            <input
                                type="text"
                                name="data_implantacao"
                                id="data_implantacao"
                                class="form-input"
                                placeholder="DD/MM/AAAA"
                            >
                            <span class="error-message" id="error-data_implantacao"></span>
                        </div>

                        <!-- Foto -->
                        <div class="form-group full-width">
                            <label class="form-label">
                                Foto da Antena (PNG ou JPG)
                            </label>
                            <div class="file-upload-wrapper">
                                <input
                                    type="file"
                                    name="foto"
                                    id="foto"
                                    class="file-upload-input"
                                    accept=".png,.jpg,.jpeg"
                                    onchange="handleFileSelect(event)"
                                >
                                <label for="foto" class="file-upload-label" id="fileLabel">
                                    <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                    </svg>
                                    <div>
                                        <div style="font-weight: 600; color: #374151;">Clique para selecionar</div>
                                        <div style="font-size: 0.875rem; color: #6b7280;">PNG ou JPG (máx. 5MB)</div>
                                    </div>
                                </label>
                            </div>
                            <div class="file-preview" id="filePreview">
                                <img id="previewImage" src="" alt="Preview">
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
                        <span class="spinner"></span>
                        <span class="btn-text">Cadastrar Antena</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal View Overlay -->
    <div class="modal-overlay" id="viewModalOverlay" onclick="closeViewModal()"></div>

    <!-- Modal View Container -->
    <div class="modal-container" id="viewModalContainer">
        <div class="view-modal-content" onclick="event.stopPropagation()">
            <div class="modal-header">
                <h2 class="modal-title">
                    📡 Detalhes da Antena
                </h2>
                <button class="modal-close" onclick="closeViewModal()">&times;</button>
            </div>

            <div class="modal-body" id="viewModalBody">
                <!-- Conteúdo será carregado via JavaScript -->
                <div class="loading-spinner">
                    <div class="spinner-circle"></div>
                    <div class="loading-text">Carregando informações...</div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeViewModal()">
                    Fechar
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        // Máscaras e validações
        const Masks = {
            coordinate(value, isLatitude = false) {
                // Remove tudo exceto números, ponto e menos
                value = value.replace(/[^\d.-]/g, '');

                // Garante apenas um ponto decimal
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Garante apenas um sinal de menos no início
                if (value.indexOf('-') > 0) {
                    value = value.replace(/-/g, '');
                    value = '-' + value;
                }

                // Limita casas decimais a 6
                if (parts.length === 2 && parts[1].length > 6) {
                    value = parts[0] + '.' + parts[1].substring(0, 6);
                }

                // Valida range
                const num = parseFloat(value);
                if (!isNaN(num)) {
                    if (isLatitude && Math.abs(num) > 90) {
                        value = num > 0 ? '90' : '-90';
                    } else if (!isLatitude && Math.abs(num) > 180) {
                        value = num > 0 ? '180' : '-180';
                    }
                }

                return value;
            },

            decimal(value) {
                // Remove tudo exceto números e ponto
                value = value.replace(/[^\d.]/g, '');

                // Garante apenas um ponto decimal
                const parts = value.split('.');
                if (parts.length > 2) {
                    value = parts[0] + '.' + parts.slice(1).join('');
                }

                // Limita a 2 casas decimais
                if (parts.length === 2 && parts[1].length > 2) {
                    value = parts[0] + '.' + parts[1].substring(0, 2);
                }

                // Não permite valor 0 ou negativo
                const num = parseFloat(value);
                if (!isNaN(num) && num <= 0) {
                    value = '0.01';
                }

                return value;
            },

            date(value) {
                // Remove tudo exceto números
                value = value.replace(/\D/g, '');

                // Limita a 8 dígitos (DDMMYYYY)
                if (value.length > 8) {
                    value = value.substring(0, 8);
                }

                // Aplica máscara DD/MM/YYYY
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                }
                if (value.length >= 5) {
                    value = value.substring(0, 5) + '/' + value.substring(5, 9);
                }

                return value;
            }
        };

        // Aplicar máscaras nos campos
        document.getElementById('latitude').addEventListener('input', function(e) {
            e.target.value = Masks.coordinate(e.target.value, true);
        });

        document.getElementById('longitude').addEventListener('input', function(e) {
            e.target.value = Masks.coordinate(e.target.value, false);
        });

        document.getElementById('altura').addEventListener('input', function(e) {
            e.target.value = Masks.decimal(e.target.value);
        });

        document.getElementById('data_implantacao').addEventListener('input', function(e) {
            e.target.value = Masks.date(e.target.value);
        });

        // Validação do campo descrição
        document.getElementById('descricao').addEventListener('input', function(e) {
            const maxLength = 100;
            if (e.target.value.length > maxLength) {
                e.target.value = e.target.value.substring(0, maxLength);
            }
        });

        // Funções da Modal CREATE
        function openCreateModal() {
            document.getElementById('modalOverlay').classList.add('active');
            document.getElementById('modalContainer').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateModal() {
            document.getElementById('modalOverlay').classList.remove('active');
            document.getElementById('modalContainer').classList.remove('active');
            document.body.style.overflow = '';

            // Limpa o formulário
            document.getElementById('antennaForm').reset();
            clearErrors();
            clearFilePreview();
        }

        // Funções da Modal VIEW
        async function openViewModal(antennaId) {
            // Abre a modal
            document.getElementById('viewModalOverlay').classList.add('active');
            document.getElementById('viewModalContainer').classList.add('active');
            document.body.style.overflow = 'hidden';

            // Mostra loading
            const modalBody = document.getElementById('viewModalBody');
            modalBody.innerHTML = `
                <div class="loading-spinner">
                    <div class="spinner-circle"></div>
                    <div class="loading-text">Carregando informações...</div>
                </div>
            `;

            try {
                // Busca dados da antena
                const response = await fetch(`/antenas/${antennaId}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error('Erro ao carregar dados da antena');
                }

                const data = await response.json();

                if (data.success && data.antena) {
                    renderAntennaDetails(data.antena);
                } else {
                    throw new Error('Dados inválidos recebidos');
                }

            } catch (error) {
                console.error('Erro:', error);
                modalBody.innerHTML = `
                    <div style="text-align: center; padding: 3rem;">
                        <div style="font-size: 3rem; color: #ef4444; margin-bottom: 1rem;">⚠️</div>
                        <h3 style="color: #1f2937; margin-bottom: 0.5rem;">Erro ao carregar</h3>
                        <p style="color: #6b7280;">Não foi possível carregar os detalhes da antena.</p>
                    </div>
                `;
            }
        }

        function renderAntennaDetails(antena) {
            const modalBody = document.getElementById('viewModalBody');

            const fotoHtml = antena.foto
                ? `<div class="antenna-photo">
                       <img src="${antena.foto}" alt="${antena.descricao}" onerror="this.parentElement.innerHTML='<div class=\\'no-photo\\'><div class=\\'no-photo-icon\\'>📷</div><div class=\\'no-photo-text\\'>Imagem não disponível</div></div>'">
                   </div>`
                : `<div class="no-photo">
                       <div class="no-photo-icon">📷</div>
                       <div class="no-photo-text">Sem foto cadastrada</div>
                   </div>`;

            modalBody.innerHTML = `
                <div class="detail-grid">
                    <!-- Descrição -->
                    <div class="detail-item full-width">
                        <div class="detail-label">Descrição</div>
                        <div class="detail-value large">${antena.descricao}</div>
                    </div>

                    <!-- UF -->
                    <div class="detail-item">
                        <div class="detail-label">Unidade Federativa</div>
                        <div class="detail-value">
                            <span class="badge-uf-large">${antena.uf}</span>
                        </div>
                    </div>

                    <!-- Altura -->
                    <div class="detail-item">
                        <div class="detail-label">Altura</div>
                        <div class="detail-value">${antena.altura} metros</div>
                    </div>

                    <!-- Latitude -->
                    <div class="detail-item">
                        <div class="detail-label">Latitude</div>
                        <div class="detail-value">${antena.latitude}°</div>
                    </div>

                    <!-- Longitude -->
                    <div class="detail-item">
                        <div class="detail-label">Longitude</div>
                        <div class="detail-value">${antena.longitude}°</div>
                    </div>

                    <!-- Data de Implantação -->
                    <div class="detail-item full-width">
                        <div class="detail-label">Data de Implantação</div>
                        <div class="detail-value">${antena.data_implantacao}</div>
                    </div>

                    <!-- Mapa -->
                    <div class="detail-item full-width">
                        <div class="detail-label">Localização no Mapa</div>
                        <div class="map-container">
                            <iframe
                                width="100%"
                                height="100%"
                                frameborder="0"
                                style="border:0"
                                src="https://www.openstreetmap.org/export/embed.html?bbox=${antena.longitude-0.01},${antena.latitude-0.01},${antena.longitude+0.01},${antena.latitude+0.01}&layer=mapnik&marker=${antena.latitude},${antena.longitude}"
                                allowfullscreen>
                            </iframe>
                        </div>
                        <div style="margin-top: 0.5rem; text-align: center;">
                            <a href="https://www.openstreetmap.org/?mlat=${antena.latitude}&mlon=${antena.longitude}#map=15/${antena.latitude}/${antena.longitude}"
                               target="_blank"
                               style="color: #667eea; text-decoration: none; font-size: 0.875rem; font-weight: 600;">
                                Ver mapa completo →
                            </a>
                        </div>
                    </div>
                    <!-- Foto -->
                    <div class="detail-item full-width">
                        <div class="detail-label">Foto da Antena</div>
                        ${fotoHtml}
                    </div>
                </div>
            `;
        }

        function closeViewModal() {
            document.getElementById('viewModalOverlay').classList.remove('active');
            document.getElementById('viewModalContainer').classList.remove('active');
            document.body.style.overflow = '';
        }

        // Fecha modals ao pressionar ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCreateModal();
                closeViewModal();
            }
        });

        // Preview de imagem
        function handleFileSelect(event) {
            const file = event.target.files[0];
            const label = document.getElementById('fileLabel');
            const preview = document.getElementById('filePreview');
            const previewImg = document.getElementById('previewImage');

            if (file) {
                // Valida tipo de arquivo
                const validTypes = ['image/png', 'image/jpeg', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    showError('foto', 'Apenas arquivos PNG ou JPG são permitidos');
                    event.target.value = '';
                    return;
                }

                // Valida tamanho (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    showError('foto', 'O arquivo deve ter no máximo 5MB');
                    event.target.value = '';
                    return;
                }

                // Mostra preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.add('show');
                    label.classList.add('has-file');
                    label.innerHTML = `
                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <div>
                            <div style="font-weight: 600; color: #10b981;">${file.name}</div>
                            <div style="font-size: 0.875rem; color: #6b7280;">Clique para alterar</div>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
                clearError('foto');
            }
        }

        function clearFilePreview() {
            const label = document.getElementById('fileLabel');
            const preview = document.getElementById('filePreview');

            preview.classList.remove('show');
            label.classList.remove('has-file');
            label.innerHTML = `
                <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                <div>
                    <div style="font-weight: 600; color: #374151;">Clique para selecionar</div>
                    <div style="font-size: 0.875rem; color: #6b7280;">PNG ou JPG (máx. 5MB)</div>
                </div>
            `;
        }

        // Validações Frontend
        function validateForm() {
            clearErrors();
            let isValid = true;

            // Descrição
            const descricao = document.getElementById('descricao').value.trim();
            if (descricao.length < 10) {
                showError('descricao', 'A descrição deve ter no mínimo 10 caracteres');
                isValid = false;
            } else if (descricao.length > 100) {
                showError('descricao', 'A descrição deve ter no máximo 100 caracteres');
                isValid = false;
            }

            // UF
            const uf = document.getElementById('uf').value;
            if (!uf) {
                showError('uf', 'Selecione uma UF');
                isValid = false;
            }

            // Latitude
            const latitude = parseFloat(document.getElementById('latitude').value);
            if (isNaN(latitude) || latitude < -90 || latitude > 90) {
                showError('latitude', 'Latitude deve estar entre -90 e 90');
                isValid = false;
            }

            // Longitude
            const longitude = parseFloat(document.getElementById('longitude').value);
            if (isNaN(longitude) || longitude < -180 || longitude > 180) {
                showError('longitude', 'Longitude deve estar entre -180 e 180');
                isValid = false;
            }

            // Altura
            const altura = parseFloat(document.getElementById('altura').value);
            if (isNaN(altura) || altura <= 0) {
                showError('altura', 'Altura deve ser maior que 0');
                isValid = false;
            }

            // Data (se preenchida)
            const dataImplantacao = document.getElementById('data_implantacao').value;
            if (dataImplantacao && !isValidDate(dataImplantacao)) {
                showError('data_implantacao', 'Data inválida. Use o formato DD/MM/AAAA');
                isValid = false;
            }

            return isValid;
        }

        function isValidDate(dateString) {
            // Verifica formato DD/MM/YYYY
            if (!/^\d{2}\/\d{2}\/\d{4}$/.test(dateString)) {
                return false;
            }

            const [day, month, year] = dateString.split('/').map(Number);

            // Validações básicas
            if (year < 1900 || year > new Date().getFullYear()) return false;
            if (month < 1 || month > 12) return false;
            if (day < 1 || day > 31) return false;

            // Valida data real
            const date = new Date(year, month - 1, day);

            return date.getFullYear() === year &&
                date.getMonth() === month - 1 &&
                date.getDate() === day &&
                date <= new Date();
        }

        function showError(field, message) {
            const errorElement = document.getElementById(`error-${field}`);
            const inputElement = document.getElementById(field);

            if (errorElement) {
                errorElement.textContent = message;
                errorElement.classList.add('show');
            }

            if (inputElement) {
                inputElement.classList.add('error');
            }
        }

        function clearError(field) {
            const errorElement = document.getElementById(`error-${field}`);
            const inputElement = document.getElementById(field);

            if (errorElement) {
                errorElement.textContent = '';
                errorElement.classList.remove('show');
            }

            if (inputElement) {
                inputElement.classList.remove('error');
            }
        }

        function clearErrors() {
            const errorElements = document.querySelectorAll('.error-message');
            const inputElements = document.querySelectorAll('.form-input');

            errorElements.forEach(el => {
                el.textContent = '';
                el.classList.remove('show');
            });

            inputElements.forEach(el => {
                el.classList.remove('error');
            });
        }

        // Toast Notification
        function showToast(type, title, message) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;

            const icon = type === 'success' ? '✓' : '✕';

            toast.innerHTML = `
                <div class="toast-icon">${icon}</div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
            `;

            container.appendChild(toast);

            // Remove após 4 segundos
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        // Submit do formulário
        document.getElementById('antennaForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Valida formulário
            if (!validateForm()) {
                showToast('error', 'Erro de validação', 'Por favor, corrija os campos destacados');
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');

            // Desabilita botão e mostra loading
            submitBtn.disabled = true;
            submitBtn.classList.add('loading');
            btnText.textContent = 'Cadastrando...';

            // Prepara FormData
            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('descricao', document.getElementById('descricao').value.trim());
            formData.append('uf', document.getElementById('uf').value);
            formData.append('latitude', document.getElementById('latitude').value);
            formData.append('longitude', document.getElementById('longitude').value);
            formData.append('altura', document.getElementById('altura').value);

            // Converte data
            const dataImplantacao = document.getElementById('data_implantacao').value;
            if (dataImplantacao && dataImplantacao.length === 10) {
                const [day, month, year] = dataImplantacao.split('/');
                const dateFormatted = `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`;
                formData.append('data_implantacao', dateFormatted);
            }

            // Adiciona foto
            const fotoInput = document.getElementById('foto');
            if (fotoInput.files.length > 0) {
                formData.append('foto', fotoInput.files[0]);
            }

            try {
                const response = await fetch('/antenas', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                const data = await response.json();

                // 🔍 ADICIONE ESTES LOGS AQUI:
                console.log('==== DEBUG ====');
                console.log('Dados completos:', data);
                console.log('Antena:', data.antena);
                console.log('Foto:', data.antena?.foto);
                console.log('Foto existe?', !!data.antena?.foto);
                console.log('==============')

                if (response.ok && data.success) {
                    showToast('success', 'Sucesso!', data.message || 'Antena cadastrada com sucesso!');
                    setTimeout(() => {
                        closeCreateModal();
                        window.location.reload();
                    }, 1000);
                } else {
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            showError(field, data.errors[field][0]);
                        });
                        showToast('error', 'Erro de validação', 'Corrija os campos destacados');
                    } else {
                        showToast('error', 'Erro', data.message || 'Erro ao cadastrar antena');
                    }
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('loading');
                    btnText.textContent = 'Cadastrar Antena';
                }
            } catch (error) {
                console.error('Erro:', error);
                showToast('error', 'Erro', 'Erro ao cadastrar antena. Tente novamente.');
                submitBtn.disabled = false;
                submitBtn.classList.remove('loading');
                btnText.textContent = 'Cadastrar Antena';
            }
        });
    </script>
@endsection
