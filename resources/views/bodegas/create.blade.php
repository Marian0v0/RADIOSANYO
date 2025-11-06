@extends('layouts.app')

@section('title', 'Nueva Bodega')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Nueva Bodega</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('bodegas.index') }}">Bodegas</a></li>
                <li class="breadcrumb-item active">Nueva</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información de la Bodega</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('bodegas.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nombre" class="form-label">
                            Nombre de la Bodega 
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               class="form-control @error('nombre') is-invalid @enderror" 
                               id="nombre" 
                               name="nombre" 
                               value="{{ old('nombre') }}" 
                               placeholder="Ej: Bodega Principal"
                               required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            Contraseña 
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Ingrese la contraseña para esta bodega"
                                   required
                                   minlength="6">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">
                                <i class="bi bi-eye" id="passwordIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">
                            La contraseña debe tener al menos 6 caracteres.
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">
                            Confirmar Contraseña 
                            <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   placeholder="Confirme la contraseña"
                                   required
                                   minlength="6">
                            <button type="button" class="btn btn-outline-secondary" onclick="togglePasswordConfirmation()">
                                <i class="bi bi-eye" id="passwordConfirmationIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Guardar Bodega
                        </button>
                        <a href="{{ route('bodegas.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información Importante</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="bi bi-info-circle me-2"></i>Instrucciones:</h6>
                    <ul class="mb-0">
                        <li>El nombre de la bodega debe ser único y descriptivo</li>
                        <li>La contraseña será utilizada para el acceso al sistema</li>
                        <li>Guarde la contraseña en un lugar seguro</li>
                        <li>La contraseña debe tener al menos 6 caracteres</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="bi bi-exclamation-triangle me-2"></i>Nota:</h6>
                    <p class="mb-0">Una vez creada la bodega, los usuarios podrán acceder al sistema utilizando el nombre de la bodega y la contraseña proporcionada.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'bi bi-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'bi bi-eye';
    }
}

function togglePasswordConfirmation() {
    const passwordInput = document.getElementById('password_confirmation');
    const passwordIcon = document.getElementById('passwordConfirmationIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.className = 'bi bi-eye-slash';
    } else {
        passwordInput.type = 'password';
        passwordIcon.className = 'bi bi-eye';
    }
}

// Validación de contraseñas coincidentes
document.querySelector('form').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const passwordConfirmation = document.getElementById('password_confirmation').value;
    
    if (password !== passwordConfirmation) {
        e.preventDefault();
        alert('Las contraseñas no coinciden. Por favor, verifique.');
        document.getElementById('password').focus();
    }
});
</script>

<style>
.card {
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    font-weight: 600;
}

.form-control:focus {
    border-color: #6c757d;
    box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
}

.btn-primary {
    background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #3d4348 0%, #5a6268 100%);
    transform: translateY(-1px);
}

.alert {
    border: none;
    border-left: 4px solid;
}

.alert-info {
    border-left-color: #17a2b8;
}

.alert-warning {
    border-left-color: #ffc107;
}
</style>
@endsection