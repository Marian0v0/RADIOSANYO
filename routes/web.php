<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ListadoContableController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de recursos (CRUD completo)
Route::resource('bodegas', BodegaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('listados', ListadoContableController::class);

// Rutas para Solicitudes con parámetro personalizado
Route::resource('solicitudes', SolicitudController::class)->parameters([
    'solicitudes' => 'solicitud'
]);

// Rutas de Compras (Historias de Usuario)
Route::prefix('compras')->group(function () {
    Route::get('facturas', [ComprasController::class, 'facturas'])->name('compras.facturas');
    Route::get('proveedores', [ComprasController::class, 'proveedores'])->name('compras.proveedores');
    Route::get('mercancia-lenta', [ComprasController::class, 'mercanciaLenta'])->name('compras.mercancia-lenta');
    Route::get('mercancia-lenta/{referencia}', [ComprasController::class, 'detalleProductoLento'])->name('compras.detalle-producto-lento');
});