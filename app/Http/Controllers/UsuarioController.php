<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $q->where('id', '!=', 0);
        })->get();

        $usuarios = $usuarios->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'rol' => $user->config->role->name ?? 'Rol no asignado',
                'company_name' => $user->config->company->name ?? 'Sin empresa',
                'created_at' => $user->created_at->format('Y-m-d H:i'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i'),
            ];
        });
        Log::debug('usuarios cargados', ['usuarios' => $usuarios]);
        return response()->json(['data' => $usuarios]);
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

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
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
        $currentUser = Auth::user();
        $companyId = $currentUser->config->company_id;

        $user = User::whereHas('config', fn($q) => $q->where('company_id', $companyId))
            ->whereHas('config.role', fn($q) => $q->where('id', '!=', 0))
            ->findOrFail($id);

        if ($user->id === $currentUser->id) {
            return response()->json(['message' => 'No puedes eliminar tu propia cuenta.'], 403);
        }

        $user->delete();

        return response()->json([
            'message' => 'Usuario eliminado exitosamente.',
        ]);
    }

    public function all()
    {
        $roles = Role::all();
        return response()->json($roles);
    }
}
