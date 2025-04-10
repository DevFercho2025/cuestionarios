<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aplicacion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CandidatoController extends Controller
{
    public function index()
    {
        $candidatos = User::where('is_admin', 0)->get();
        return view('candidatos.index', compact('candidatos'));
    }

    public function datatable(Request $request)
    {
        $candidatos = User::with('info')
            ->where('is_admin', 0)
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'fecha_nacimiento' => optional($user->info)->fecha_nacimiento,
                    'genero' => optional($user->info)->genero,
                    'codigo_postal' => optional($user->info)->codigo_postal,
                    'celular' => optional($user->info)->celular,
                    'created_at' => $user->created_at->toDateTimeString(),
                ];
            });
    
        return response()->json(['data' => $candidatos]);
    }
    


    public function crearCandidato(){
        return view('candidatos.registro.registro-candidato');
    }

    public function store(Request $request)
    {
        // Validación con mensaje personalizado
        $validator = Validator::make($request->all(), [
            'correo' => 'required|email|unique:users,email',
            'nombre' => 'required|string',
            'apellidoPaterno' => 'required|string',
            'apellidoMaterno' => 'nullable|string',
        ], [
            'correo.unique' => 'Este email ya está registrado para un candidato.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nombreCompleto = $request->input('nombre') . ' ' . $request->input('apellidoPaterno');
        $apellidoMaterno = $request->input('apellidoMaterno');

        if (strtolower(trim($apellidoMaterno)) !== 'no aplica') {
            $nombreCompleto .= ' ' . $apellidoMaterno;
        } else {
            $apellidoMaterno = null;
        }

        // Crea el usuario
        $user = User::create([
            'name' => $nombreCompleto,
            'email' => $request->input('correo'),
            'password' => bcrypt(Str::random(10)),
        ]);

        return redirect()->route('candidatos.index')->with('success', 'Candidato registrado correctamente');
    }

    public function show($id)
    {
        $candidato = User::where('is_admin', 0)->findOrFail($id);
        return response()->json($candidato);
    }

    public function update(Request $request, $id)
{
    $candidato = User::where('is_admin', 0)->findOrFail($id);

    $data = $request->only(['name', 'email', 'codigo_postal', 'celular']);

    // Actualizar campos del modelo User
    if (isset($data['name']) || isset($data['email'])) {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
        ]);
        $candidato->update($validated);
    }

    // Actualizar campos del modelo UserInfo
    if (isset($data['codigo_postal']) || isset($data['celular'])) {
        $info = $candidato->info()->firstOrCreate([]);
        $info->update([
            'codigo_postal' => $data['codigo_postal'] ?? $info->codigo_postal,
            'celular' => $data['celular'] ?? $info->celular,
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Candidato actualizado correctamente.'
    ]);
}



    public function destroy($id)
    {
        $candidato = User::where('is_admin', 0)->findOrFail($id);
        $candidato->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Candidato eliminado correctamente'
        ]);
    }

    public function generarCodigo()
    {
        //código alfanumérico de 10 caracteres
        $codigo = strtoupper(Str::random(10));

        return response()->json(['code' => $codigo]);
    }

        public function listaUsuarios()
    {
        $usuarios = User::where('is_admin', 0)->get(['id', 'name', 'email']);
        return response()->json($usuarios);
    }

    public function guardarCodigo(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $codigo = strtoupper(Str::random(10));

        $aplicacion = Aplicacion::create([
            'user_id' => $request->user_id,
            'vacante' => null, // si luego necesitas agregar una vacante puedes actualizarlo
            'codigo' => $codigo,
        ]);

        return response()->json(['code' => $aplicacion->codigo]);
    }


}