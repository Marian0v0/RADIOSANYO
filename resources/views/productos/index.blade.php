@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="page-header">
    <h1 class="page-title">Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Referencia</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Bodegas</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td><code>{{ str_pad($producto->id, 3, '0', STR_PAD_LEFT) }}</code></td>
                            <td><strong>{{ $producto->referencia }}</strong></td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->cantidad }}</td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <span class="badge bg-info">{{ $producto->bodegas_count }} bodegas</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este producto?')">
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
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                                <p class="mb-0 mt-2">No hay productos registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Paginación Mejorada --}}
@if($productos->hasPages())
<div class="mt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        {{-- Información de resultados --}}
        <div class="text-muted small">
            Mostrando 
            <span class="fw-semibold">{{ $productos->firstItem() ?? 0 }}</span> 
            a 
            <span class="fw-semibold">{{ $productos->lastItem() ?? 0 }}</span> 
            de 
            <span class="fw-semibold">{{ $productos->total() }}</span> 
            resultados
        </div>

        {{-- Navegación --}}
        <nav aria-label="Paginación de productos">
            <ul class="pagination pagination-sm mb-0">
                {{-- Enlace anterior --}}
                <li class="page-item {{ $productos->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $productos->previousPageUrl() }}" aria-label="Anterior">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </li>

                {{-- Elementos de paginación --}}
                @foreach($productos->getUrlRange(1, $productos->lastPage()) as $page => $url)
                    @if($page == $productos->currentPage())
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
                <li class="page-item {{ !$productos->hasMorePages() ? 'disabled' : '' }}">
                    <a class="page-link" href="{{ $productos->nextPageUrl() }}" aria-label="Siguiente">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
@endif
@endsection