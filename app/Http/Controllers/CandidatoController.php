<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Aplicacion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use function Ramsey\Uuid\v1;

class CandidatoController extends Controller
{
    public function index(Request $request)
    { 
        $conVacante = filter_var($request->input('conVacante', 0), FILTER_VALIDATE_BOOLEAN);

        return view('candidatos.index', compact('conVacante'));
    }

    public function datatable(Request $request)
    {
        try {
            $conVacante = filter_var($request->input('conVacante', 0), FILTER_VALIDATE_BOOLEAN);

            $candidatos = User::with(['info', 'config.role'])
            ->whereHas('config.role', function ($q) {
                $q->where('id','=', 0);
            })
            ->when($conVacante, function ($query) { #Si es true, muestra candidatos con aplicaciones
                $query->whereHas('aplicaciones');
            }, function ($query) {
                $query->whereDoesntHave('aplicaciones');
            })
            ->get();
            //agregar where para filtrar candidatos solamente de la compañía del usuario logueado
            //generar servicio


            //Formatear datos antes
            $candidatosData = $candidatos->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'fecha_nacimiento' => optional($user->info)->fecha_nacimiento ? \Carbon\Carbon::parse($user->info->fecha_nacimiento)->toDateString() : null, // Formato de fecha
                    'genero' => optional($user->info)->genero,
                    'codigo_postal' => optional($user->info)->codigo_postal,
                    'celular' => optional($user->info)->celular,
                    'created_at' => $user->created_at
                ];
            });

            return response()->json(['data' => $candidatosData]);

        } catch (\Exception $e) {

            // Retornar error con detalles
            return response()->json([
                'error' => 'Hubo un problema al obtener los candidatos.',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function crearCandidato()
    {
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
            'fecha_nacimiento' => 'nullable|date',
            'genero' => 'nullable|string',
            'codigo_postal' => 'nullable|string|max:10',
            'celular' => 'nullable|string|max:15',
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

        $user->config()->create([
            'active' => 1,
        ]);

        $user->info()->create([
            'fecha_nacimiento' => $request->input('fechaNacimiento'),
            'genero' => $request->input('genero'),
            'codigo_postal' => $request->input('codigoPostal'),
            'celular' => $request->input('celular'),
        ]);

        return redirect()->route('candidatos.index')->with('success', 'Candidato registrado correctamente');
    }

    public function show($id)
{
    $candidato = User::whereHas('config.role', function ($query) {
        $query->where(function ($subQuery) {
            $subQuery->where('id', '!=', 1) //Excluye admins
                ->where('id', '!=', 2); //Excluye superadmins
        });
    })->findOrFail($id);

    return response()->json($candidato);
}

    public function update(Request $request, $id)
    {
        try {
            // Obtener el candidato (User) por ID
            $candidato = User::whereHas('config.role', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('id', '!=', 1) //Excluye admins
                        ->where('id', '!=', 2); //Excluye superadmins
                });
            })->findOrFail($id);
            // Validación de los datos de User (nombre, email)
            $validatedUser = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'email' => 'sometimes|required|email|unique:users,email,' . $id,
            ]);

            // Actualizar el modelo User (name, email)
            if (isset($validatedUser['name']) || isset($validatedUser['email'])) {
                $candidato->update($validatedUser);
            }

            // Actualizar los campos del modelo UserInfo (codigo_postal, celular)
            $validatedInfo = $request->only(['codigo_postal', 'celular', 'fecha_nacimiento', 'genero']);

            if (count($validatedInfo) > 0) {
                // Si no existe un registro, lo crea; si existe, lo actualiza
                $info = $candidato->info()->firstOrCreate([]);
                $info->update([
                    'codigo_postal' => $validatedInfo['codigo_postal'] ?? $info->codigo_postal,
                    'celular' => $validatedInfo['celular'] ?? $info->celular,
                    'fecha_nacimiento' => $validatedInfo['fecha_nacimiento'] ?? $info->fecha_nacimiento,
                    'genero' => $validatedInfo['genero'] ?? $info->genero,
                ]);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Candidato actualizado correctamente.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un problema al actualizar el candidato.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Obtener el candidato (User) por ID, asegurándose de que no sea admin
            $candidato = User::whereHas('config.role', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('id', '!=', 1) //Excluye admins
                        ->where('id', '!=', 2); //Excluye superadmins
                });
            })->findOrFail($id);
    
            // Eliminar la información relacionada en la tabla UserInfo
            $candidato->info()->delete(); // Elimina el registro relacionado en psico_alobri_users_info
    
            // Eliminar la configuración relacionada en la tabla ConfigUser
            $candidato->config()->delete(); // Elimina el registro relacionado en config_users
    
            // Eliminar al usuario de la tabla users
            $candidato->delete();
    
            return response()->json([
                'status'  => 'success',
                'message' => 'Candidato y sus datos eliminados correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Hubo un problema al eliminar el candidato.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
    public function generarCodigo()
    {
        //código alfanumérico de 10 caracteres
        $codigo = strtoupper(Str::random(10));

        return response()->json(['code' => $codigo]);
    }

    public function guardarCodigo(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'vacante' => 'required|string|max:255',
            ]);

            $codigo = strtoupper(Str::random(10));

            $aplicacion = Aplicacion::create([
                'user_id' => $request->user_id,
                'vacante' => $request->vacante,
                'codigo' => $codigo,
            ]);

            return response()->json(['code' => $aplicacion->codigo]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function verPerfil($id){

        $candidato = User::with(['info', 'config.company', 'config.role', 'aplicaciones']) // Agrega aquí todas las relaciones que necesites
        ->whereHas('config.role', function ($query) {
            $query->whereNotIn('id', [1, 2]); // Excluye admins y superadmins
        })
        ->findOrFail($id);

    return view('candidatos.perfil', compact('candidato'));
    }
}
