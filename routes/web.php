<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ListadoContableController;
use App\Http\Controllers\SolicitudController;

// Rutas de recursos (CRUD completo)
Route::resource('bodegas', BodegaController::class);
Route::resource('productos', ProductoController::class);
Route::resource('listados', ListadoContableController::class);
Route::resource('solicitudes', SolicitudController::class);