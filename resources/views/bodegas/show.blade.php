@extends('layouts.app')

@section('title', 'Detalle de Bodega')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">{{ $bodega->nombre }}</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('bodegas.index') }}">Bodegas</a></li>
                <li class="breadcrumb-item active">Detalle</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('bodegas.edit', $bodega) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Editar
        </a>
        <a href="{{ route('bodegas.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Volver
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-building" style="font-size: 3rem; color: var(--gray-400);"></i>
                <h3 class="mt-3 mb-1">ID {{ str_pad($bodega->id, 3, '0', STR_PAD_LEFT) }}</h3>
                <p class="text-muted mb-0">Identificador</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-box" style="font-size: 3rem; color: var(--gray-400);"></i>
                <h3 class="mt-3 mb-1">{{ $bodega->productos->count() }}</h3>
                <p class="text-muted mb-0">Productos</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-clipboard-check" style="font-size: 3rem; color: var(--gray-400);"></i>
                <h3 class="mt-3 mb-1">{{ $bodega->solicitudes->count() }}</h3>
                <p class="text-muted mb-0">Solicitudes</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-hourglass-split" style="font-size: 3rem; color: var(--gray-400);"></i>
                <h3 class="mt-3 mb-1">{{ $bodega->solicitudes->where('resuelto', 0)->count() }}</h3>
                <p class="text-muted mb-0">Pendientes</p>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-box me-2"></i>Productos en esta Bodega
            </div>
            <div class="card-body">
                @if($bodega->productos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Referencia</th>
                                    <th>Nombre</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bodega->productos as $producto)
                                    <tr>
                                        <td><code>{{ $producto->referencia }}</code></td>
                                        <td>{{ $producto->nombre }}</td>
                                        <td>{{ $producto->cantidad }}</td>
                                        <td><strong>${{ number_format($producto->precio, 2) }}</strong></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="mt-3 mb-0">No hay productos asignados a esta bodega</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-clipboard-check me-2"></i>Solicitudes de esta Bodega
            </div>
            <div class="card-body">
                @if($bodega->solicitudes->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Fecha Solicitud</th>
                                    <th>Fecha Cierre</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bodega->solicitudes as $solicitud)
                                    <tr>
                                        <td><code>#{{ str_pad($solicitud->id, 4, '0', STR_PAD_LEFT) }}</code></td>
                                        <td>{{ $solicitud->fecha_solicitud->format('d/m/Y H:i') }}</td>
                                        <td>{{ $solicitud->fecha_cierre ? $solicitud->fecha_cierre->format('d/m/Y H:i') : '—' }}</td>
                                        <td>
                                            @if($solicitud->resuelto)
                                                <span class="badge bg-success">Resuelta</span>
                                            @else
                                                <span class="badge bg-warning">Pendiente</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="mt-3 mb-0">No hay solicitudes para esta bodega</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection