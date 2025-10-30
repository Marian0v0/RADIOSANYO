<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Solicitud;
use App\Models\ListadoContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComprasController extends Controller
{
    // HU-C01: Obtener Datos Facturas
    public function facturas(Request $request)
    {
        $query = ListadoContable::withCount('productos')
            ->orderBy('fecha_registro', 'desc');
            
        // Búsqueda
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                  ->orWhere('fecha_registro', 'LIKE', "%{$search}%")
                  ->orWhereHas('productos', function($q) use ($search) {
                      $q->where('nombre', 'LIKE', "%{$search}%")
                        ->orWhere('referencia', 'LIKE', "%{$search}%");
                  });
            });
        }
        
        // Filtrar por fecha
        if ($request->has('fecha') && $request->fecha) {
            $query->whereDate('fecha_registro', $request->fecha);
        }
        
        $facturas = $query->paginate(10);
        
        return view('compras.facturas', compact('facturas'));
    }
    
    // HU-C02: Información de proveedores
    public function proveedores(Request $request)
    {
        $query = Producto::query();
        
        // Búsqueda de productos por "proveedor" (simulado)
        if ($request->has('search') && $request->search) {
            $query->where('nombre', 'LIKE', "%{$request->search}%")
                  ->orWhere('referencia', 'LIKE', "%{$request->search}%");
        }
        
        $productos = $query->withCount(['solicitudes', 'listados'])
            ->orderBy('nombre')
            ->paginate(15);
            
        // Estadísticas para nuevos productos (últimos 30 días)
        $nuevosProductos = Producto::whereHas('listados', function($q) {
            $q->where('nuevo_producto', 1)
              ->where('fecha_registro', '>=', now()->subDays(30));
        })->count();
        
        return view('compras.proveedores', compact('productos', 'nuevosProductos'));
    }
    
    // HU-C03: Alerta de mercancía lenta
    public function mercanciaLenta(Request $request)
    {
        // Productos con baja rotación (pocas solicitudes en relación al stock)
        $query = Producto::select('sgies_productos.*')
            ->leftJoin('sgies_productos_solicitud', 'sgies_productos.referencia', '=', 'sgies_productos_solicitud.referencia_producto')
            ->selectRaw('COUNT(sgies_productos_solicitud.id_solicitud) as total_solicitudes')
            ->selectRaw('(sgies_productos.cantidad / NULLIF(COUNT(sgies_productos_solicitud.id_solicitud), 0)) as ratio_stock_solicitud')
            ->groupBy('sgies_productos.referencia', 'sgies_productos.nombre', 'sgies_productos.cantidad', 'sgies_productos.precio')
            ->having('total_solicitudes', '<', 5)
            ->having('cantidad', '>', 10)
            ->orderBy('ratio_stock_solicitud', 'desc');
            
        if ($request->has('search') && $request->search) {
            $query->where('sgies_productos.nombre', 'LIKE', "%{$request->search}%")
                ->orWhere('sgies_productos.referencia', 'LIKE', "%{$request->search}%");
        }
        
        $productosLentos = $query->paginate(15);
        
        return view('compras.mercancia-lenta', compact('productosLentos'));
    }
    
    // Detalle de producto lento
    public function detalleProductoLento($referencia)
    {
        $producto = Producto::with(['solicitudes', 'listados', 'bodegas'])
            ->withCount('solicitudes')
            ->findOrFail($referencia);
            
        // Calcular métricas
        $totalSolicitudes = $producto->solicitudes->count();
        $ratio = $totalSolicitudes > 0 ? $producto->cantidad / $totalSolicitudes : $producto->cantidad;
        $esLento = $totalSolicitudes < 5 && $producto->cantidad > 10;
        
        return view('compras.detalle-producto-lento', compact('producto', 'totalSolicitudes', 'ratio', 'esLento'));
    }
}