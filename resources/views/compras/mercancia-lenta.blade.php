@extends('layouts.app')

@section('title', 'Mercancía Lenta - Área de Compras')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-exclamation-triangle me-2"></i>Alerta de Mercancía Lenta
    </h1>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('compras.mercancia-lenta') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar productos..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-warning">
                    <i class="bi bi-info-circle me-1"></i>
                    Productos con baja rotación
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($productosLentos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Referencia</th>
                            <th>Producto</th>
                            <th>Stock Actual</th>
                            <th>Solicitudes</th>
                            <th>Ratio Stock/Solicitud</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productosLentos as $producto)
                            @php
                                $ratio = $producto->total_solicitudes > 0 ? $producto->cantidad / $producto->total_solicitudes : $producto->cantidad;
                                $esCritico = $ratio > 20;
                            @endphp
                            <tr>
                                <td><code>{{ $producto->referencia }}</code></td>
                                <td><strong>{{ $producto->nombre }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $producto->cantidad > 20 ? 'warning' : 'secondary' }}">
                                        {{ $producto->cantidad }} unidades
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $producto->total_solicitudes }} solicitudes</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $esCritico ? 'danger' : 'warning' }}">
                                        {{ number_format($ratio, 1) }}:1
                                    </span>
                                </td>
                                <td>
                                    @if($esCritico)
                                        <span class="badge bg-danger">
                                            <i class="bi bi-exclamation-triangle me-1"></i>Crítico
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock me-1"></i>Lento
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('compras.detalle-producto-lento', $producto->referencia) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-graph-up me-1"></i>Estadísticas
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $productosLentos->links() }}
        @else
            <div class="text-center py-5">
                <i class="bi bi-check-circle" style="font-size: 3rem; opacity: 0.3; color: #28a745;"></i>
                <h5 class="mt-3 text-muted">No hay mercancía lenta identificada</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No hay productos que coincidan con tu búsqueda.
                    @else
                        Todos los productos tienen una rotación adecuada.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('compras.mercancia-lenta') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-1"></i>Ver toda la mercancía lenta
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection