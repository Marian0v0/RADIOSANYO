@extends('layouts.app')

@section('title', 'Listados Contables')

@section('content')
<div class="page-header">
    <h1 class="page-title">Listados Contables</h1>
    <a href="{{ route('listados.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nuevo Listado
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Registro</th>
                        <th>Productos</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($listados as $listado)
                        <tr>
                            <td><code>{{ str_pad($listado->id, 3, '0', STR_PAD_LEFT) }}</code></td>
                            <td>
                                @if($listado->fecha_registro instanceof \DateTime)
                                    <strong>{{ $listado->fecha_registro->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $listado->fecha_registro->format('h:i A') }}</small>
                                @else
                                    <strong>{{ \Carbon\Carbon::parse($listado->fecha_registro)->format('d/m/Y') }}</strong>
                                    <br>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($listado->fecha_registro)->format('h:i A') }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $listado->productos_count }} productos</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('listados.show', $listado) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('listados.edit', $listado) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('listados.destroy', $listado) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este listado?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                                <p class="mb-0 mt-2">No hay listados contables registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($listados->hasPages())
<div class="mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        {{-- Información de resultados --}}
        <div class="text-muted small">
            Mostrando 
            <span class="fw-semibold">{{ $listados->firstItem() ?? 0 }}</span> 
            a 
            <span class="fw-semibold">{{ $listados->lastItem() ?? 0 }}</span> 
            de 
            <span class="fw-semibold">{{ $listados->total() }}</span> 
            resultados
        </div>

        {{-- Navegación --}}
        <nav aria-label="Paginación de listados">
            <ul class="pagination pagination-sm mb-0">
                {{-- Enlace anterior --}}
                <li class="page-item {{ $listados->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $listados->previousPageUrl() }}" aria-label="Anterior">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>

                {{-- Elementos de paginación --}}
                @foreach($listados->getUrlRange(1, $listados->lastPage()) as $page => $url)
                    @if($page == $listados->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach

                {{-- Enlace siguiente --}}
                <li class="page-item {{ !$listados->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $listados->nextPageUrl() }}" aria-label="Siguiente">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endif
@endsection