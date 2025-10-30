<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Bodega;
use App\Models\Producto;
use Illuminate\Http\Request;

class SolicitudController extends Controller
{
    public function index()
    {
        $solicitudes = Solicitud::with('bodega')
            ->withCount('productos')
            ->orderBy('fecha_solicitud', 'desc')
            ->paginate(10);
        return view('solicitudes.index', compact('solicitudes'));
    }

    public function create()
    {
        $bodegas = Bodega::all();
        $productos = Producto::all();
        return view('solicitudes.create', compact('bodegas', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_bodega' => 'required|exists:sgies_bodegas,id',
            'fecha_solicitud' => 'nullable|date',
            'productos' => 'nullable|array',
            'productos.*.id' => 'required|exists:sgies_productos,referencia',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $solicitud = Solicitud::create([
            'id_bodega' => $request->id_bodega,
            'fecha_solicitud' => $request->fecha_solicitud ?? now(),
            'resuelto' => 0,
        ]);

        if ($request->has('productos')) {
            foreach ($request->productos as $prod) {
                $solicitud->productos()->attach($prod['id'], [
                    'cantidad_solicitada' => $prod['cantidad'],
                ]);
            }
        }

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud creada exitosamente.');
    }

    public function show(Solicitud $solicitud)
    {
        $solicitud->load('bodega', 'productos');
        return view('solicitudes.show', compact('solicitud'));
    }

    public function edit(Solicitud $solicitud)
    {
        $bodegas = Bodega::all();
        $productos = Producto::all();
        $solicitud->load('productos');
        return view('solicitudes.edit', compact('solicitud', 'bodegas', 'productos'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $request->validate([
            'id_bodega' => 'required|exists:sgies_bodegas,id',
            'fecha_solicitud' => 'required|date',
            'fecha_cierre' => 'nullable|date',
            'resuelto' => 'required|boolean',
            'productos' => 'nullable|array',
            'productos.*.id' => 'required|exists:sgies_productos,referencia',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $solicitud->update([
            'id_bodega' => $request->id_bodega,
            'fecha_solicitud' => $request->fecha_solicitud,
            'fecha_cierre' => $request->fecha_cierre,
            'resuelto' => $request->resuelto,
        ]);

        $solicitud->productos()->detach();

        if ($request->has('productos')) {
            foreach ($request->productos as $prod) {
                $solicitud->productos()->attach($prod['id'], [
                    'cantidad_solicitada' => $prod['cantidad'],
                ]);
            }
        }

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud actualizada exitosamente.');
    }

    public function destroy(Solicitud $solicitud)
    {
        $solicitud->delete();

        return redirect()->route('solicitudes.index')
            ->with('success', 'Solicitud eliminada exitosamente.');
    }
}