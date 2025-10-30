@extends('layouts.app')

@section('title', 'Solicitudes')

@section('content')
<div class="page-header">
    <h1 class="page-title">Solicitudes</h1>
    <a href="{{ route('solicitudes.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nueva Solicitud
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bodega</th>
                        <th>Fecha Solicitud</th>
                        <th>Estado</th>
                        <th>Productos</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($solicitudes as $solicitud)
                        <tr>
                            <td><code>{{ str_pad($solicitud->id, 3, '0', STR_PAD_LEFT) }}</code></td>
                            <td>
                                <strong>{{ $solicitud->bodega->nombre }}</strong>
                                <br>
                                <small class="text-muted">ID: {{ str_pad($solicitud->bodega->id, 3, '0', STR_PAD_LEFT) }}</small>
                            </td>
                            <td>
                                <strong>{{ $solicitud->fecha_solicitud->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ $solicitud->fecha_solicitud->format('h:i A') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $solicitud->resuelto ? 'success' : 'warning' }}">
                                    {{ $solicitud->resuelto ? 'Resuelta' : 'Pendiente' }}
                                </span>
                                @if($solicitud->fecha_cierre)
                                    <br>
                                    <small class="text-muted">Cerrada: {{ $solicitud->fecha_cierre->format('d/m/Y') }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $solicitud->productos_count }} productos</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('solicitudes.show', $solicitud) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('solicitudes.edit', $solicitud) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('solicitudes.destroy', $solicitud) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta solicitud?')">
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
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                                <p class="mb-0 mt-2">No hay solicitudes registradas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $solicitudes->links() }}
@endsection