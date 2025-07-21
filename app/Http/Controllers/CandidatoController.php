<?php

namespace App\Http\Controllers;

use App\Models\AccessCode;
use App\Models\User;
use App\Models\Position;
use App\Models\History;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CandidatoController extends Controller
{
    public function index(Request $request)
    { 
        $conVacante = filter_var($request->input('conVacante', 0), FILTER_VALIDATE_BOOLEAN);

        $companyId = Auth::user()->config->Company->id;
        $positions = Position::with('post')->where('company_id', $companyId)->get();
        return view('candidatos.index', compact('conVacante', 'positions'));
    }

    public function datatable(Request $request)
    {
        try {
            $conVacante = (bool) $request->input('conVacante', 0);
            $companyId = Auth::user()->config->company_id;
            $user = Auth::user();
            $isSuperAdmin = $user->config->role->isSuperAdmin() ?? false;

            $candidatos = User::with(['info', 'config.role', 'config.company'])
            ->whereHas('config.role', function ($q) {
                $q->where('id','=', 0);
            })
            ->when(!$isSuperAdmin, function ($query) use ($companyId) {
                $query->whereHas('config', function ($q) use ($companyId) {
                    $q->where('company_id', $companyId);
                });
            })
            ->when($conVacante, function ($query) { #Si es true, muestra candidatos con códigos de acceso
                $query->whereHas('userTestsAcessCodes');
            }, function ($query) {
                $query->whereDoesntHave('userTestsAcessCodes');
            })
            ->get();

            $candidatosData = $candidatos->map(function ($user) use ($isSuperAdmin, $conVacante) {
                 $data = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'fecha_nacimiento' => $user->info->date_of_birth ? substr($user->info->date_of_birth, 0, 10) : null,
                    'genero' => $user->info->gender,
                    'codigo_postal' => $user->info->postal_code,
                    'celular' => $user->info->phone,
                    'created_at' => $user->created_at->toDateString()
                ];

                if ($isSuperAdmin) {
                    $data['company_name'] = $user->config->company->name ?? 'Sin compañía';
                }

                 if ($conVacante) {
                    $vacante = $user->userTestsAcessCodes->pluck('vacancy')->join(', ');
                    $data['vacante'] = $vacante;
                }
                return $data;
            });

            return response()->json(['data' => $candidatosData]);

        } catch (\Exception $e) {

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
        $validator = Validator::make($request->all(), [
            'firstname'     => 'required|string',
            'lastname'      => 'required|string',
            'nacimiento'    => 'required|date',
            'genero_legal'  => 'nullable|string',
            'codigo_postal' => 'nullable|string|max:10',
            'telefono'      => 'required|string|max:15',
            'pais'          => 'required|string',
        ], [
            'email.unique' => 'Este email ya está registrado para este candidato en la misma empresa.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $nombreCompleto = $request->input('firstname').' '.$request->input('lastname');


        $user = User::firstOrNew(['email' => $request->input('email')]);
        if (!$user->exists) {
            $user->password = bcrypt(Str::random(10));
        }
        $user->name = $nombreCompleto;
        $user->save();

        $user->config()->updateOrCreate(
            ['company_id' => Auth::user()->config->company_id],
            [
                'active'   => 1,
                'role_id'  => 0,
                'is_pisco_user' => 1,
            ]
        );

        $user->info()->updateOrCreate(
            [
                'date_of_birth' => $request->input('nacimiento'),
                'gender'           => $request->input('genero_legal'),
                'postal_code'    => $request->input('codigo_postal'),
                'phone'          => $request->input('telefono'),
                'country'             => $request->input('pais'),
                'created_at'       => Carbon::now(),
            ]
        );

        History::create([
            'user_id' => Auth::user()->id,
            'comment' => "Se creó el candidato con ID {$user->id}.",
        ]);

         return response()->json([
            'success' => true,
            'message' => 'Candidato creado exitosamente.',
        ]);
    }

     public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        return response()->json(['exists' => $exists]);
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

            History::create([
                'user_id' => Auth::user()->id,
                'comment' => "Se editó la información del candidato con ID $id.",
            ]);

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
    
            // Eliminar la información del candidato (UserInfo)
            $candidato->info()->delete(); 
    
            // Eliminar la configuración del usuario del candidato (config_users)
            $candidato->config()->delete();

            //Eliminar códigos activos para el candidato
            $candidato->userTestsAcessCodes()->delete();
    
            // Eliminar al usuario del candidato
            $candidato->delete();

            History::create([
                'user_id' => Auth::user()->id,
                'comment' => "Se eliminó el candidato con ID $id.",
            ]);
    
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

    //al crear un código a un candidato
    public function guardarCodigo(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'vacante' => 'required|string|max:255',
            ]);

            $codigo = strtoupper(Str::random(10));

            $aplicacion = AccessCode::create([
                'user_id' => $request->user_id,
                'vacancy' => $request->vacante,
                'company_id' => $request->company_id,
                'user_company_id' => Auth::user()->id,
                'code' => $codigo,
            ]);

            History::create([
                'user_id' => Auth::user()->id,
                'comment' => "Se creó un código de acceso para la vacante '{$request->vacante}' al candidato con ID $request->user_id. Código: $codigo",
            ]);

            return response()->json(['code' => $aplicacion->code]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function verPerfil($id){

        $candidato = User::with(['info', 'config.company', 'config.role', 'userTestsAcessCode'])
        ->whereHas('config.role', function ($query) {
            $query->where('id', 0); 
        })
        ->findOrFail($id);

    return view('candidatos.perfil', compact('candidato'));
    }
}
