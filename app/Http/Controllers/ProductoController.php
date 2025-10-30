<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Bodega;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::with('bodegas')->paginate(15);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $bodegas = Bodega::all();
        return view('productos.create', compact('bodegas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'referencia' => 'required|string|max:255|unique:sgies_productos,referencia',
            'nombre' => 'required|string',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'bodegas' => 'nullable|array',
            'bodegas.*' => 'exists:sgies_bodegas,id',
        ]);

        $producto = Producto::create($request->only(['referencia', 'nombre', 'cantidad', 'precio']));

        if ($request->has('bodegas')) {
            $producto->bodegas()->attach($request->bodegas);
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    public function show(Producto $producto)
    {
        $producto->load('bodegas', 'listados', 'solicitudes');
        return view('productos.show', compact('producto'));
    }

    public function edit(Producto $producto)
    {
        $bodegas = Bodega::all();
        return view('productos.edit', compact('producto', 'bodegas'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string',
            'cantidad' => 'required|integer|min:0',
            'precio' => 'required|numeric|min:0',
            'bodegas' => 'nullable|array',
            'bodegas.*' => 'exists:sgies_bodegas,id',
        ]);

        $producto->update($request->only(['nombre', 'cantidad', 'precio']));

        if ($request->has('bodegas')) {
            $producto->bodegas()->sync($request->bodegas);
        } else {
            $producto->bodegas()->detach();
        }

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente.');
    }
}