<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsuarioController extends Controller
{
    // Métodos para el manejo de los usuarios
    public function index()
    {
        $users = User::all();
        return view('usuarios.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function datatable(Request $request)
    {
        $usuarios = User::with(['config.role', 'config.company'])
        ->whereHas('config.role', function ($q) {
            $q->whereNotIn('id', [0]);
        })->get();

        $usuariosData = $usuarios->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'rol' => optional(optional($user->config)->role)->name,
                'company_name' => optional($user->config->company)->nombre,
                'created_at' => $user->created_at ? $user->created_at->toDateTimeString() : null,
                'updated_at' => $user->updated_at ? $user->updated_at->toDateTimeString() : null,
            ];
        });

        return response()->json(['data' => $usuariosData]);
    }

    public function show($id)
    {
        $usuario = User::with(['config.role', 'config.company'])
        ->whereHas('config.role', function ($q) {
            $q->whereNotIn('id', [0]);
        })->findOrFail($id);
    
        return response()->json($usuario);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {

        $usuario = User::where('id', $id)
        ->whereHas('config.role', function ($query) {
            $query->where('id', '!=', 0); //No candidatos
        })
        ->firstOrFail();

        // Validación de los datos de User (nombre, email)
        $validatedUser = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
        ]);

        // Actualizar el modelo User (name, email)
        if (isset($validatedUser['name']) || isset($validatedUser['email'])) {
            $usuario->update($validatedUser);
        }
        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
