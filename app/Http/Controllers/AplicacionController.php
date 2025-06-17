<?php

namespace App\Http\Controllers;

use App\Models\AccessCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AplicacionController extends Controller
{
    // Vista principal
    public function index()
    {
        return view('aplicaciones.index');
    }

    // DataTable
    public function datatable()
    {
        $user = Auth::user();
        $companyId = $user->config->company_id;
        $isSuperAdmin = $user->config->role->isSuperAdmin() ?? false;

        if ($isSuperAdmin) {
            $codes = AccessCode::with('user')->get();
        } else {
            $codes = AccessCode::with([
                'user',
                'company',
                'assignedTests.companyUser',
            ])->get();
        }

        $data = $codes->map(function ($code) use ($isSuperAdmin) {
            $data = [
                'id'      => $code->id,
                'user_id' => $code->user_id,
                'nombre'  => $code->user->name,
                'email'   => $code->user->email,
                'vacante' => $code->vacancy,
                'codigo'  => $code->code,
            ];

            if ($isSuperAdmin) {

            $data['company_name'] = $code->company->name ?? 'Sin compañía';

            $asignador = $code->userCompany->name;

            $data['asignado_por'] = $asignador;
        }

        return $data;
        });
        return response()->json(['data' => $data]);
    }

    // Guardar nueva aplicación
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vacante' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        $accessCode = AccessCode::create($request->all());

        return response()->json([
            'message' => 'Aplicación creada correctamente.',
            'aplicacion' => $accessCode
        ]);
    }

    // Obtener una aplicación específica (para editar)
    public function show($id)
    {
         $accessCode = AccessCode::findOrFail($id);

        return response()->json($accessCode);
    }

    // Actualizar una aplicación
    public function update(Request $request, $id)
    {
        $code = AccessCode::findOrFail($id);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'vacante' => 'required|string|max:255',
            'codigo' => 'required|string|max:255',
        ]);

        $code->update($request->all());

        return response()->json([
            'message' => 'Aplicación actualizada correctamente.'
        ]);
    }

    // Eliminar aplicación
    public function destroy($id)
    {
        $code = AccessCode::findOrFail($id);
        $code->delete();

        return response()->json([
            'message' => 'Aplicación eliminada correctamente.'
        ]);
    }

    public function usuarios()
    {
        $usuarios = User::select('id', 'nombre')->get();
        return response()->json($usuarios);
    }

    public function vacantes()
    {
        $vacantes =  AccessCode::select('vacancy')->distinct()->get();
        return response()->json($vacantes);
    }

    public function obtenerConfiguracion($id)
    {
        $aplicacion = AccessCode::findOrFail($id);
        return response()->json([
            'camera' => $aplicacion->camera,
            'location' => $aplicacion->location,
        ]);
    }

    public function configurar(Request $request)
    {
        $request->validate([
            'aplicacion_id' => 'required|exists:psico_alobri_application_access_codes,id',  // Ajusta si el nombre de tabla es distinto
            'camera' => 'required|boolean',
            'location' => 'required|boolean',
        ]);

        $aplicacion = AccessCode::findOrFail($request->aplicacion_id);
        $aplicacion->camera = $request->camera;
        $aplicacion->location = $request->location;
        $aplicacion->save();

        return response()->json([
            'success' => true,
            'message' => 'Configuración guardada correctamente.'
        ]);
    }
}
