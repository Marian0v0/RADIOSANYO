@extends('layouts.app')

@section('title', 'Información Proveedores - Área de Compras')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-building me-2"></i>Información de Proveedores
    </h1>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $nuevosProductos }}</h4>
                        <small>Nuevos Productos (30 días)</small>
                    </div>
                    <i class="bi bi-box-seam" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="mb-0">{{ $productos->total() }}</h4>
                        <small>Total Productos</small>
                    </div>
                    <i class="bi bi-clipboard-data" style="font-size: 2rem; opacity: 0.7;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('compras.proveedores') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar productos/proveedores..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <span class="badge bg-info">
                    <i class="bi bi-info-circle me-1"></i>
                    Datos de productos y convenios
                </span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($productos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Referencia</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Solicitudes</th>
                            <th>Listados</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productos as $producto)
                            @php
                                $esNuevo = $producto->listados()->where('nuevo_producto', 1)
                                    ->where('fecha_registro', '>=', now()->subDays(30))
                                    ->exists();
                            @endphp
                            <tr>
                                <td><code>{{ $producto->referencia }}</code></td>
                                <td>
                                    <strong>{{ $producto->nombre }}</strong>
                                    @if($esNuevo)
                                        <span class="badge bg-success ms-1">Nuevo</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $producto->cantidad > 10 ? 'success' : ($producto->cantidad > 0 ? 'warning' : 'danger') }}">
                                        {{ $producto->cantidad }} unidades
                                    </span>
                                </td>
                                <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                                <td>
                                    <span class="badge bg-info">{{ $producto->solicitudes_count }} solicitudes</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $producto->listados_count }} listados</span>
                                </td>
                                <td>
                                    @if($esNuevo)
                                        <span class="badge bg-success">
                                            <i class="bi bi-star me-1"></i>Nuevo Proveedor
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock me-1"></i>Proveedor Estable
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
            {{ $productos->links() }}
        @else
            <div class="text-center py-5">
                <i class="bi bi-building" style="font-size: 3rem; opacity: 0.3;"></i>
                <h5 class="mt-3 text-muted">No se encontraron productos/proveedores</h5>
                <p class="text-muted">
                    @if(request('search'))
                        No hay productos que coincidan con tu búsqueda.
                    @else
                        No hay productos registrados en el sistema.
                    @endif
                </p>
                @if(request('search'))
                    <a href="{{ route('compras.proveedores') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-1"></i>Ver todos los productos
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection