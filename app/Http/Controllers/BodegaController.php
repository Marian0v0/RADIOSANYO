<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    public function index()
    {
        $bodegas = Bodega::withCount('productos')->paginate(10);
        return view('bodegas.index', compact('bodegas'));
    }

    public function create()
    {
        return view('bodegas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Bodega::create($request->all());

        return redirect()->route('bodegas.index')
            ->with('success', 'Bodega creada exitosamente.');
    }

    public function show(Bodega $bodega)
    {
        $bodega->load('productos', 'solicitudes');
        return view('bodegas.show', compact('bodega'));
    }

    public function edit(Bodega $bodega)
    {
        return view('bodegas.edit', compact('bodega'));
    }

    public function update(Request $request, Bodega $bodega)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $bodega->update($request->all());

        return redirect()->route('bodegas.index')
            ->with('success', 'Bodega actualizada exitosamente.');
    }

    public function destroy(Bodega $bodega)
    {
        $bodega->delete();

        return redirect()->route('bodegas.index')
            ->with('success', 'Bodega eliminada exitosamente.');
    }
}