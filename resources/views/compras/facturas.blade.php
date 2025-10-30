@extends('layouts.app')

@section('title', 'Facturas - Área de Compras')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="bi bi-receipt me-2"></i>Facturas del Día
    </h1>
</div>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('compras.facturas') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar facturas..." value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <form action="{{ route('compras.facturas') }}" method="GET">
                    <input type="date" class="form-control" name="fecha" value="{{ request('fecha') }}" onchange="this.form.submit()">
                </form>
            </div>
            <div class="col-md-3 text-end">
                <a href="{{ route('compras.facturas') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if($facturas->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Factura</th>
                            <th>Fecha Registro</th>
                            <th>Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($facturas as $factura)
                            <tr>
                                <td><code>FACT-{{ str_pad($factura->id, 4, '0', STR_PAD_LEFT) }}</code></td>
                                <td>
                                    @if($factura->fecha_registro instanceof \DateTime)
                                        <strong>{{ $factura->fecha_registro->format('d/m/Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $factura->fecha_registro->format('h:i A') }}</small>
                                    @else
                                        <strong>{{ \Carbon\Carbon::parse($factura->fecha_registro)->format('d/m/Y') }}</strong>
                                        <br>
                                        <small class="text-muted">{{ \Carbon\Carbon::parse($factura->fecha_registro)->format('h:i A') }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $factura->productos_count }} productos</span>
                                </td>
                                <td>
                                    <a href="{{ route('listados.show', $factura) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye me-1"></i>Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $facturas->links() }}
        @else
            <div class="text-center py-5">
                <i class="bi bi-receipt-cutoff" style="font-size: 3rem; opacity: 0.3;"></i>
                <h5 class="mt-3 text-muted">No se encontraron facturas</h5>
                <p class="text-muted">
                    @if(request('search') || request('fecha'))
                        No hay facturas que coincidan con tu búsqueda.
                    @else
                        No hay facturas registradas para el día de hoy.
                    @endif
                </p>
                @if(request('search') || request('fecha'))
                    <a href="{{ route('compras.facturas') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left me-1"></i>Ver todas las facturas
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection