<?php

namespace App\Http\Controllers;

use App\Models\ListadoContable;
use App\Models\Producto;
use Illuminate\Http\Request;

class ListadoContableController extends Controller
{
    public function index()
    {
        $listados = ListadoContable::withCount('productos')
            ->orderBy('fecha_registro', 'desc')
            ->paginate(10);
        return view('listados.index', compact('listados'));
    }

    public function create()
    {
        $productos = Producto::all();
        return view('listados.create', compact('productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_registro' => 'nullable|date',
            'productos' => 'nullable|array',
            'productos.*.id' => 'required|exists:sgies_productos,referencia',
            'productos.*.cambio_precio' => 'required|boolean',
            'productos.*.nuevo_producto' => 'required|boolean',
        ]);

        $listado = ListadoContable::create([
            'fecha_registro' => $request->fecha_registro ?? now(),
        ]);

        if ($request->has('productos')) {
            foreach ($request->productos as $prod) {
                $listado->productos()->attach($prod['id'], [
                    'cambio_precio' => $prod['cambio_precio'],
                    'nuevo_producto' => $prod['nuevo_producto'],
                ]);
            }
        }

        return redirect()->route('listados.index')
            ->with('success', 'Listado contable creado exitosamente.');
    }

    public function show(ListadoContable $listado)
    {
        $listado->load('productos');
        return view('listados.show', compact('listado'));
    }

    public function edit(ListadoContable $listado)
    {
        $productos = Producto::all();
        $listado->load('productos');
        return view('listados.edit', compact('listado', 'productos'));
    }

    public function update(Request $request, ListadoContable $listado)
    {
        $request->validate([
            'fecha_registro' => 'required|date',
            'productos' => 'nullable|array',
            'productos.*.id' => 'required|exists:sgies_productos,referencia',
            'productos.*.cambio_precio' => 'required|boolean',
            'productos.*.nuevo_producto' => 'required|boolean',
        ]);

        $listado->update([
            'fecha_registro' => $request->fecha_registro,
        ]);

        $listado->productos()->detach();

        if ($request->has('productos')) {
            foreach ($request->productos as $prod) {
                $listado->productos()->attach($prod['id'], [
                    'cambio_precio' => $prod['cambio_precio'],
                    'nuevo_producto' => $prod['nuevo_producto'],
                ]);
            }
        }

        return redirect()->route('listados.index')
            ->with('success', 'Listado contable actualizado exitosamente.');
    }

    public function destroy(ListadoContable $listado)
    {
        $listado->delete();

        return redirect()->route('listados.index')
            ->with('success', 'Listado contable eliminado exitosamente.');
    }
}