<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Listar usuarios
     */
    public function index()
    {
        // Verificar que el usuario sea admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
        
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Mostrar formulario para cambiar contraseña
     */
    public function editPassword($id)
    {
        // Verificar que el usuario sea admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
        
        $user = User::findOrFail($id);
        return view('users.change-password', compact('user'));
    }

    /**
     * Actualizar contraseña
     */
    public function updatePassword(Request $request, $id)
    {
        // Verificar que el usuario sea admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
        
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Contraseña actualizada correctamente para ' . $user->name);
    }

    /**
     * Cambiar estado del usuario
     */
    public function toggleStatus($id)
    {
        // Verificar que el usuario sea admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
        
        $user = User::findOrFail($id);
        
        // No permitir desactivar al propio usuario
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propio usuario');
        }

        $user->update([
            'status' => $user->status === 1 ? 0 : 1
        ]);

        $status = $user->status === 1 ? 'activado' : 'desactivado';
        return back()->with('success', "Usuario {$status} correctamente");
    }
}
