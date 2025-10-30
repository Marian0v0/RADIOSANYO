@extends('layouts.app')

@section('title', 'Crear Solicitud')

@section('content')
<div class="page-header">
    <h1 class="page-title">Crear Solicitud</h1>
    <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('solicitudes.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_bodega" class="form-label">Bodega *</label>
                        <select class="form-select @error('id_bodega') is-invalid @enderror" id="id_bodega" name="id_bodega" required>
                            <option value="">Seleccionar bodega...</option>
                            @foreach($bodegas as $bodega)
                                <option value="{{ $bodega->id }}" {{ old('id_bodega') == $bodega->id ? 'selected' : '' }}>
                                    {{ $bodega->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_bodega')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_solicitud" class="form-label">Fecha Solicitud</label>
                        <input type="datetime-local" class="form-control @error('fecha_solicitud') is-invalid @enderror" 
                               id="fecha_solicitud" name="fecha_solicitud" value="{{ old('fecha_solicitud') }}">
                        @error('fecha_solicitud')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Productos Solicitados</label>
                <div id="productos-container">
                    <div class="producto-item mb-3 p-3 border rounded">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Producto *</label>
                                <select name="productos[0][id]" class="form-select" required>
                                    <option value="">Seleccionar producto...</option>
                                    @foreach($productos as $producto)
                                        <option value="{{ $producto->referencia }}">{{ $producto->nombre }} ({{ $producto->referencia }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cantidad *</label>
                                <input type="number" class="form-control" name="productos[0][cantidad]" value="1" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger btn-sm mt-4 remove-producto" style="display: none;">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-producto" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Agregar Producto
                </button>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Crear Solicitud
                </button>
                <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productoCount = 1;
    
    document.getElementById('add-producto').addEventListener('click', function() {
        const container = document.getElementById('productos-container');
        const newItem = document.createElement('div');
        newItem.className = 'producto-item mb-3 p-3 border rounded';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <label class="form-label">Producto *</label>
                    <select name="productos[${productoCount}][id]" class="form-select" required>
                        <option value="">Seleccionar producto...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->referencia }}">{{ $producto->nombre }} ({{ $producto->referencia }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cantidad *</label>
                    <input type="number" class="form-control" name="productos[${productoCount}][cantidad]" value="1" min="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm mt-4 remove-producto">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        productoCount++;
        
        // Mostrar botones de eliminar en todos los items
        document.querySelectorAll('.remove-producto').forEach(btn => {
            btn.style.display = 'block';
        });
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-producto')) {
            e.target.closest('.producto-item').remove();
        }
    });
});
</script>
@endsection