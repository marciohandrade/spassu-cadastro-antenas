<?php

@extends('layouts.app')

@section('content')
    <div class="container">

        <!-- Ranking das 5 UFs -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Ranking - Top 5 UFs por quantidade de antenas</strong>
            </div>
            <div class="card-body">
                @if($ranking->isEmpty())
                    <p class="text-muted mb-0">Nenhuma antena cadastrada ainda.</p>
                @else
                    <ol class="mb-0">
                        @foreach($ranking as $item)
                            <li>
                                <strong>{{ $item->uf }}</strong> — <span class="text-muted">{{ $item->total }} antena{{ $item->total > 1 ? 's' : '' }}</span>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>

        <!-- Ações/topbar -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Listagem de antenas (total: {{ $antenas->count() }})</h5>
            <a href="{{ route('antenas.create') }}" class="btn btn-primary">Nova antena</a>
        </div>

        <!-- Tabela com todas as antenas -->
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr>
                            <th>Sigla</th>
                            <th>Nome</th>
                            <th>Cidade</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Criada em</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($antenas as $antena)
                            <tr>
                                <td>{{ $antena->uf }}</td>
                                <td>{{ $antena->nome }}</td>
                                <td>{{ $antena->cidade }}</td>
                                <td>{{ $antena->latitude }}</td>
                                <td>{{ $antena->longitude }}</td>
                                <td>{{ optional($antena->created_at)->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('antenas.show', $antena) }}" class="btn btn-sm btn-outline-secondary">Ver</a>
                                    <a href="{{ route('antenas.edit', $antena) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                                    <form action="{{ route('antenas.destroy', $antena) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirma exclusão?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">Nenhuma antena encontrada.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

