<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'El usuario es obligatorio',
            'password.required' => 'La contraseña es obligatoria',
        ]);

        $user = User::where('username', $request->username)->first();

        // Verificar que el usuario existe
        if (!$user) {
            return back()->with('error', 'Usuario o contraseña incorrectos');
        }

        // Verificar que el usuario está activo
        if (!$user->isActive()) {
            return back()->with('error', 'Usuario inactivo. Contacte al administrador');
        }

        // Verificar la contraseña
        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Usuario o contraseña incorrectos');
        }

        // Actualizar last_login
        $user->update(['last_login' => now()]);

        // Iniciar sesión
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Bienvenido ' . $user->name);
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente');
    }
}
