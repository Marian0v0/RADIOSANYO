@extends('layouts.app')

@section('title', 'Editar Solicitud')

@section('content')
<div class="page-header">
    <h1 class="page-title">Editar Solicitud #{{ $solicitud->id }}</h1>
    <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('solicitudes.update', $solicitud) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="id_bodega" class="form-label">Bodega *</label>
                        <select class="form-select @error('id_bodega') is-invalid @enderror" id="id_bodega" name="id_bodega" required>
                            <option value="">Seleccionar bodega...</option>
                            @foreach($bodegas as $bodega)
                                <option value="{{ $bodega->id }}" {{ $solicitud->id_bodega == $bodega->id ? 'selected' : '' }}>
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
                        <label for="fecha_solicitud" class="form-label">Fecha Solicitud *</label>
                        <input type="datetime-local" class="form-control @error('fecha_solicitud') is-invalid @enderror" 
                               id="fecha_solicitud" name="fecha_solicitud" 
                               value="{{ old('fecha_solicitud', $solicitud->fecha_solicitud instanceof \DateTime ? $solicitud->fecha_solicitud->format('Y-m-d\TH:i') : \Carbon\Carbon::parse($solicitud->fecha_solicitud)->format('Y-m-d\TH:i')) }}" required>
                        @error('fecha_solicitud')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_cierre" class="form-label">Fecha Cierre</label>
                        <input type="datetime-local" class="form-control @error('fecha_cierre') is-invalid @enderror" 
                               id="fecha_cierre" name="fecha_cierre" 
                               value="{{ old('fecha_cierre', $solicitud->fecha_cierre ? ($solicitud->fecha_cierre instanceof \DateTime ? $solicitud->fecha_cierre->format('Y-m-d\TH:i') : \Carbon\Carbon::parse($solicitud->fecha_cierre)->format('Y-m-d\TH:i')) : '') }}">
                        @error('fecha_cierre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="resuelto" value="1" 
                                   id="resuelto" {{ $solicitud->resuelto ? 'checked' : '' }}>
                            <label class="form-check-label" for="resuelto">
                                Solicitud Resuelta
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Productos Solicitados</label>
                <div id="productos-container">
                    @foreach($solicitud->productos as $index => $producto)
                        <div class="producto-item mb-3 p-3 border rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Producto *</label>
                                    <select name="productos[{{ $index }}][id]" class="form-select" required>
                                        <option value="">Seleccionar producto...</option>
                                        @foreach($productos as $prod)
                                            <option value="{{ $prod->referencia }}" 
                                                {{ $prod->referencia == $producto->referencia ? 'selected' : '' }}>
                                                {{ $prod->nombre }} ({{ $prod->referencia }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Cantidad *</label>
                                    <input type="number" class="form-control" name="productos[{{ $index }}][cantidad]" 
                                           value="{{ $producto->pivot->cantidad_solicitada }}" min="1" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm mt-4 remove-producto">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-producto" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-plus-circle me-1"></i>Agregar Producto
                </button>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Actualizar Solicitud
                </button>
                <a href="{{ route('solicitudes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productoCount = {{ $solicitud->productos->count() }};
    
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
                        @foreach($productos as $prod)
                            <option value="{{ $prod->referencia }}">{{ $prod->nombre }} ({{ $prod->referencia }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cantidad *</label>
                    <input type="number" class="form-control" name="productos[${productoCount}][cantidad]" 
                           value="1" min="1" required>
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
    });
    
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-producto')) {
            e.target.closest('.producto-item').remove();
        }
    });
});
</script>
@endsection