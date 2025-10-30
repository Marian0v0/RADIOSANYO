@extends('layouts.app')

@section('title', $producto->nombre . ' - Mercancía Lenta')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-graph-up me-2"></i>{{ $producto->nombre }}
    </h1>
    <a href="{{ route('compras.mercancia-lenta') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Estadísticas del Producto</h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-{{ $producto->cantidad > 10 ? 'warning' : 'success' }}">{{ $producto->cantidad }}</h3>
                            <small class="text-muted">Stock Actual</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-info">{{ $totalSolicitudes }}</h3>
                            <small class="text-muted">Total Solicitudes</small>
                        </div>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="border rounded p-3">
                            <h3 class="text-{{ $esLento ? 'danger' : 'success' }}">{{ number_format($ratio, 1) }}:1</h3>
                            <small class="text-muted">Ratio Stock/Solicitud</small>
                        </div>
                    </div>
                </div>

                <div class="alert alert-{{ $esLento ? 'danger' : 'success' }}">
                    <i class="bi bi-{{ $esLento ? 'exclamation-triangle' : 'check-circle' }} me-2"></i>
                    <strong>
                        @if($esLento)
                            Este producto es considerado mercancía lenta
                        @else
                            Este producto tiene una rotación adecuada
                        @endif
                    </strong>
                    <br>
                    <small class="mb-0">
                        Stock: {{ $producto->cantidad }} unidades | 
                        Solicitudes: {{ $totalSolicitudes }} | 
                        Ratio: {{ number_format($ratio, 1) }}:1
                    </small>
                </div>

                <h6>Últimas Solicitudes</h6>
                @if($producto->solicitudes->count() > 0)
                    <div class="list-group">
                        @foreach($producto->solicitudes->take(5) as $solicitud)
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>Solicitud #{{ $solicitud->id }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            @if($solicitud->fecha_solicitud instanceof \DateTime)
                                                {{ $solicitud->fecha_solicitud->format('d/m/Y') }}
                                            @else
                                                {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}
                                            @endif
                                             - Cantidad: {{ $solicitud->pivot->cantidad_solicitada }}
                                        </small>
                                    </div>
                                    <span class="badge bg-{{ $solicitud->resuelto ? 'success' : 'warning' }}">
                                        {{ $solicitud->resuelto ? 'Resuelta' : 'Pendiente' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">No hay solicitudes registradas para este producto.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información del Producto</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Referencia:</th>
                        <td><code>{{ $producto->referencia }}</code></td>
                    </tr>
                    <tr>
                        <th>Nombre:</th>
                        <td><strong>{{ $producto->nombre }}</strong></td>
                    </tr>
                    <tr>
                        <th>Precio:</th>
                        <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                    </tr>
                    <tr>
                        <th>Bodegas:</th>
                        <td>
                            <span class="badge bg-info">{{ $producto->bodegas->count() }} bodegas</span>
                        </td>
                    </tr>
                </table>

                <h6 class="mt-4">Recomendaciones</h6>
                @if($esLento)
                    <div class="alert alert-warning">
                        <small>
                            <i class="bi bi-lightbulb me-1"></i>
                            Considerar estrategias de promoción o revisar niveles de inventario.
                        </small>
                    </div>
                @else
                    <div class="alert alert-success">
                        <small>
                            <i class="bi bi-check-circle me-1"></i>
                            El producto mantiene una rotación saludable.
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection