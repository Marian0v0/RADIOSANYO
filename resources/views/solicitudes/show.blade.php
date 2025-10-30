@extends('layouts.app')

@section('title', 'Solicitud #' . $solicitud->id)

@section('content')
<div class="page-header">
    <h1 class="page-title">Solicitud #{{ $solicitud->id }}</h1>
    <div class="btn-group">
        <a href="{{ route('solicitudes.edit', $solicitud) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Editar
        </a>
        <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Información de la Solicitud</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="140">ID:</th>
                        <td><code>{{ str_pad($solicitud->id, 3, '0', STR_PAD_LEFT) }}</code></td>
                    </tr>
                    <tr>
                        <th>Bodega:</th>
                        <td>
                            <strong>{{ $solicitud->bodega->nombre }}</strong>
                            <br>
                            <small class="text-muted">ID: {{ str_pad($solicitud->bodega->id, 3, '0', STR_PAD_LEFT) }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Fecha Solicitud:</th>
                        <td>
                            <strong>
                                @if($solicitud->fecha_solicitud instanceof \DateTime)
                                    {{ $solicitud->fecha_solicitud->format('d/m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('d/m/Y') }}
                                @endif
                            </strong>
                            <br>
                            <small class="text-muted">
                                @if($solicitud->fecha_solicitud instanceof \DateTime)
                                    {{ $solicitud->fecha_solicitud->format('h:i A') }}
                                @else
                                    {{ \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('h:i A') }}
                                @endif
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <th>Estado:</th>
                        <td>
                            <span class="badge bg-{{ $solicitud->resuelto ? 'success' : 'warning' }}">
                                {{ $solicitud->resuelto ? 'Resuelta' : 'Pendiente' }}
                            </span>
                        </td>
                    </tr>
                    @if($solicitud->fecha_cierre)
                    <tr>
                        <th>Fecha Cierre:</th>
                        <td>
                            <strong>
                                @if($solicitud->fecha_cierre instanceof \DateTime)
                                    {{ $solicitud->fecha_cierre->format('d/m/Y') }}
                                @else
                                    {{ \Carbon\Carbon::parse($solicitud->fecha_cierre)->format('d/m/Y') }}
                                @endif
                            </strong>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Resumen de Productos</h5>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <h3 class="text-primary">{{ $solicitud->productos->count() }}</h3>
                    <small class="text-muted">Total Productos Solicitados</small>
                </div>
                <div class="mt-3">
                    @php
                        $totalCantidad = $solicitud->productos->sum('pivot.cantidad_solicitada');
                    @endphp
                    <small class="text-muted">Cantidad total solicitada: <strong>{{ $totalCantidad }} unidades</strong></small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="card-title">Productos Solicitados</h5>
    </div>
    <div class="card-body">
        @if($solicitud->productos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Referencia</th>
                            <th>Producto</th>
                            <th>Stock Actual</th>
                            <th>Precio</th>
                            <th>Cantidad Solicitada</th>
                            <th>Disponibilidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($solicitud->productos as $producto)
                            @php
                                $suficienteStock = $producto->cantidad >= $producto->pivot->cantidad_solicitada;
                            @endphp
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
                                    <span class="badge bg-info">{{ $producto->pivot->cantidad_solicitada }} unidades</span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $suficienteStock ? 'success' : 'danger' }}">
                                        {{ $suficienteStock ? 'Stock Suficiente' : 'Stock Insuficiente' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                <p class="text-muted mb-0 mt-2">No hay productos en esta solicitud</p>
            </div>
        @endif
    </div>
</div>
@endsection