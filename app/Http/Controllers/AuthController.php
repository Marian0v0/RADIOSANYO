<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('home');
    }

    public function login(Request $request)
    {
        $request->validate([
            'bodega' => 'required|string',
            'password' => 'required|string',
        ]);

        // Buscar la bodega por nombre
        $bodega = Bodega::where('nombre', $request->bodega)->first();

        if ($bodega && Hash::check($request->password, $bodega->password)) {
            // Autenticar usando el guard personalizado
            Auth::guard('bodega')->login($bodega);
            
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'bodega' => 'Las credenciales proporcionadas no son correctas.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('bodega')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}