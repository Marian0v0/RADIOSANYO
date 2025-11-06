@extends('layouts.app')

@section('title', 'Dashboard - SGIES')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Inicio</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3>Bienvenido al Sistema de Gestión Integral</h3>
                <p>Has iniciado sesión correctamente como: <strong>{{ Auth::guard('bodega')->user()->nombre }}</strong></p>
                
                <div class="row mt-4">
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #495057 0%, #6c757d 100%);">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-house-gear" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="card-title">Bodegas</h5>
                                <p class="card-text opacity-75">Gestión de bodegas</p>
                                <a href="{{ route('bodegas.index') }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-arrow-right me-1"></i>Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #6c757d 0%, #868e96 100%);">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-box-seam" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="card-title">Productos</h5>
                                <p class="card-text opacity-75">Gestión de productos</p>
                                <a href="{{ route('productos.index') }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-arrow-right me-1"></i>Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #868e96 0%, #adb5bd 100%);">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-clipboard-check" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="card-title">Solicitudes</h5>
                                <p class="card-text opacity-75">Gestión de solicitudes</p>
                                <a href="{{ route('solicitudes.index') }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-arrow-right me-1"></i>Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 text-white" style="background: linear-gradient(135deg, #adb5bd 0%, #ced4da 100%);">
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <i class="bi bi-cart-check" style="font-size: 2.5rem;"></i>
                                </div>
                                <h5 class="card-title">Compras</h5>
                                <p class="card-text opacity-75">Módulo de compras</p>
                                <a href="{{ route('compras.facturas') }}" class="btn btn-light btn-sm">
                                    <i class="bi bi-arrow-right me-1"></i>Acceder
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="mt-4 text-center">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }
    
    .card-title {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    
    .card-text {
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }
    
    .btn-light {
        background: rgba(255, 255, 255, 0.9);
        border: none;
        color: #495057;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .btn-light:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateX(3px);
    }
</style>
@endsection