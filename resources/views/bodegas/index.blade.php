@extends('layouts.app')

@section('title', 'Bodegas')

@section('content')
<div class="page-header">
    <h1 class="page-title">Bodegas</h1>
    <a href="{{ route('bodegas.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nueva Bodega
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Productos</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bodegas as $bodega)
                        <tr>
                            <td><code>{{ str_pad($bodega->id, 3, '0', STR_PAD_LEFT) }}</code></td>
                            <td><strong>{{ $bodega->nombre }}</strong></td>
                            <td>
                                <span class="badge bg-info">{{ $bodega->productos_count }} productos</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('bodegas.show', $bodega) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('bodegas.edit', $bodega) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('bodegas.destroy', $bodega) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta bodega?')">
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
                            <td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.3;"></i>
                                <p class="mb-0 mt-2">No hay bodegas registradas</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $bodegas->links() }}
@endsection