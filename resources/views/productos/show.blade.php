@extends('layouts.app')

@section('title', $producto->nombre)

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $producto->nombre }}</h1>
    <div class="btn-group">
        <a href="{{ route('productos.edit', $producto) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Editar
        </a>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información del Producto</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="140">Referencia:</th>
                        <td><code>{{ $producto->referencia }}</code></td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td><strong>{{ $producto->nombre }}</strong></td>
                    </tr>
                    <tr>
                        <th>Cantidad:</th>
                        <td>
                            <span class="badge bg-{{ $producto->cantidad > 10 ? 'success' : ($producto->cantidad > 0 ? 'warning' : 'danger') }}">
                                {{ $producto->cantidad }} unidades
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Precio:</th>
                        <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Bodegas Asignadas</h5>
            </div>
            <div class="card-body">
                @if($producto->bodegas->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($producto->bodegas as $bodega)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $bodega->nombre }}
                                <span class="badge bg-primary">ID: {{ str_pad($bodega->id, 3, '0', STR_PAD_LEFT) }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted mb-0">No hay bodegas asignadas</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Historial</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Listados Contables</h6>
                        @if($producto->listados->count() > 0)
                            <div class="list-group">
                                @foreach($producto->listados as $listado)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span>Listado #{{ $listado->id }}</span>
                                            <small class="text-muted">{{ $listado->fecha_registro->format('d/m/Y') }}</small>
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge bg-{{ $listado->pivot->cambio_precio ? 'warning' : 'secondary' }}">
                                                {{ $listado->pivot->cambio_precio ? 'Cambio Precio' : 'Sin Cambio' }}
                                            </span>
                                            <span class="badge bg-{{ $listado->pivot->nuevo_producto ? 'success' : 'secondary' }}">
                                                {{ $listado->pivot->nuevo_producto ? 'Nuevo' : 'Existente' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No hay listados contables asociados</p>
                        @endif
                    </div>
                    
                    <div class="col-md-6">
                        <h6>Solicitudes</h6>
                        @if($producto->solicitudes->count() > 0)
                            <div class="list-group">
                                @foreach($producto->solicitudes as $solicitud)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between">
                                            <span>Solicitud #{{ $solicitud->id }}</span>
                                            <small class="text-muted">{{ $solicitud->fecha_solicitud->format('d/m/Y') }}</small>
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge bg-info">Cantidad: {{ $solicitud->pivot->cantidad_solicitada }}</span>
                                            <span class="badge bg-{{ $solicitud->resuelto ? 'success' : 'warning' }}">
                                                {{ $solicitud->resuelto ? 'Resuelta' : 'Pendiente' }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted">No hay solicitudes asociadas</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection