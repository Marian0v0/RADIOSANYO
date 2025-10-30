@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="page-header">
    <h1 class="page-title">Productos</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Bodegas</th>
                        <th style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td><code>{{ $producto->referencia }}</code></td>
                            <td><strong>{{ $producto->nombre }}</strong></td>
                            <td>
                                <span class="badge bg-{{ $producto->cantidad > 10 ? 'success' : ($producto->cantidad > 0 ? 'warning' : 'danger') }}">
                                    {{ $producto->cantidad }} unidades
                                </span>
                            </td>
                            <td>${{ number_format($producto->precio, 2) }}</td>
                            <td>
                                <span class="badge bg-info">{{ $producto->bodegas_count ?? $producto->bodegas->count() }} bodegas</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('productos.show', $producto) }}" class="btn btn-sm btn-info" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar este producto?')">
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
                                <p class="mb-0 mt-2">No hay productos registrados</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{ $productos->links() }}
@endsection