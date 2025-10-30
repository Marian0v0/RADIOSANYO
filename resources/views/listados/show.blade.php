@extends('layouts.app')

@section('title', 'Listado Contable #' . $listado->id)

@section('content')
<div class="page-header">
    <h1 class="page-title">Listado Contable #{{ $listado->id }}</h1>
    <div class="btn-group">
        <a href="{{ route('listados.edit', $listado) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Editar
        </a>
        <a href="{{ route('listados.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información del Listado</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="140">ID:</th>
                        <td><code>{{ str_pad($listado->id, 3, '0', STR_PAD_LEFT) }}</code></td>
                    </tr>
                    <tr>
                        <th>Fecha Registro:</th>
                        <td>
                            <strong>
                                @if($listado->fecha_registro instanceof \DateTime)
                                    {{ $listado->fecha_registro->format('d/m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($listado->fecha_registro)->format('d/m/Y') }}
                                @endif
                            </strong>
                            <br>
                            <small class="text-muted">
                                @if($listado->fecha_registro instanceof \DateTime)
                                    {{ $listado->fecha_registro->format('h:i A') }}
                                @else
                                    {{ \Carbon\Carbon::parse($listado->fecha_registro)->format('h:i A') }}
                                @endif
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <th>Total Productos:</th>
                        <td><span class="badge bg-info">{{ $listado->productos->count() }} productos</span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Resumen</h5>
            </div>
            <div class="card-body">
                @php
                    $nuevosProductos = $listado->productos->where('pivot.nuevo_producto', 1)->count();
                    $cambiosPrecio = $listado->productos->where('pivot.cambio_precio', 1)->count();
                @endphp
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-success">{{ $nuevosProductos }}</h4>
                        <small class="text-muted">Nuevos Productos</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning">{{ $cambiosPrecio }}</h4>
                        <small class="text-muted">Cambios de Precio</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title">Productos en el Listado</h5>
    </div>
    <div class="card-body">
        @if($listado->productos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Referencia</th>
                            <th>Producto</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($listado->productos as $producto)
                            <tr>
                                <td><code>{{ $producto->referencia }}</code></td>
                                <td><strong>{{ $producto->nombre }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $producto->cantidad > 10 ? 'success' : ($producto->cantidad > 0 ? 'warning' : 'danger') }}">
                                        {{ $producto->cantidad }} unidades
                                    </span>
                                </td>
                                <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                                <td>
                                    @if($producto->pivot->nuevo_producto)
                                        <span class="badge bg-success me-1">Nuevo</span>
                                    @endif
                                    @if($producto->pivot->cambio_precio)
                                        <span class="badge bg-warning">Cambio Precio</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                <p class="text-muted mb-0 mt-2">No hay productos en este listado</p>
            </div>
        @endif
    </div>
</div>
@endsection