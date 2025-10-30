@extends('layouts.app')

@section('title', 'Editar Listado Contable')

@section('content')
<div class="page-header">
    <h1 class="page-title">Editar Listado Contable #{{ $listado->id }}</h1>
    <a href="{{ route('listados.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('listados.update', $listado) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fecha_registro" class="form-label">Fecha de Registro *</label>
                        <input type="datetime-local" class="form-control @error('fecha_registro') is-invalid @enderror" 
                               id="fecha_registro" name="fecha_registro" 
                               value="{{ old('fecha_registro', $listado->fecha_registro instanceof \DateTime ? $listado->fecha_registro->format('Y-m-d\TH:i') : \Carbon\Carbon::parse($listado->fecha_registro)->format('Y-m-d\TH:i')) }}" required>
                        @error('fecha_registro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label">Productos en el Listado</label>
                <div id="productos-container">
                    @foreach($listado->productos as $index => $producto)
                        <div class="producto-item mb-3 p-3 border rounded">
                            <div class="row">
                                <div class="col-md-5">
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
                                <div class="col-md-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" 
                                               name="productos[{{ $index }}][cambio_precio]" value="1"
                                               {{ $producto->pivot->cambio_precio ? 'checked' : '' }}>
                                        <label class="form-check-label">Cambio de Precio</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" 
                                               name="productos[{{ $index }}][nuevo_producto]" value="1"
                                               {{ $producto->pivot->nuevo_producto ? 'checked' : '' }}>
                                        <label class="form-check-label">Nuevo Producto</label>
                                    </div>
                                </div>
                                <div class="col-md-1">
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
                    <i class="bi bi-check-circle me-2"></i>Actualizar Listado
                </button>
                <a href="{{ route('listados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productoCount = {{ $listado->productos->count() }};
    
    document.getElementById('add-producto').addEventListener('click', function() {
        const container = document.getElementById('productos-container');
        const newItem = document.createElement('div');
        newItem.className = 'producto-item mb-3 p-3 border rounded';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-5">
                    <label class="form-label">Producto *</label>
                    <select name="productos[${productoCount}][id]" class="form-select" required>
                        <option value="">Seleccionar producto...</option>
                        @foreach($productos as $producto)
                            <option value="{{ $producto->referencia }}">{{ $producto->nombre }} ({{ $producto->referencia }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="productos[${productoCount}][cambio_precio]" value="1">
                        <label class="form-check-label">Cambio de Precio</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-check mt-4">
                        <input class="form-check-input" type="checkbox" name="productos[${productoCount}][nuevo_producto]" value="1">
                        <label class="form-check-label">Nuevo Producto</label>
                    </div>
                </div>
                <div class="col-md-1">
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