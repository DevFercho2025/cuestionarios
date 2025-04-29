<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplicacion;
use Illuminate\Support\Facades\Auth;
use App\Models\Respuesta_Usuario;

class CandidateController extends Controller
{
    public function index()
    {
        return view('candidate.index');
    }

    public function validarCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);
    
        $codigoIngresado = $request->codigo;
    
        // Buscar la aplicación con el código
        $aplicacion = Aplicacion::where('codigo', $codigoIngresado)->first();
    
        if (!$aplicacion || !$aplicacion->usuario) {
            return back()->withErrors(['codigo' => 'El código ingresado no es válido.']);
        }
    
        $usuario = $aplicacion->usuario;
    
        // Verificar si es candidato (no admin)
        if ($usuario->is_admin || $usuario->is_super_admin) {
            return back()->withErrors(['codigo' => 'Este código no pertenece a un candidato.']);
        }
    
        // Autenticar al usuario
        Auth::login($usuario);
    
        // Redirigir al dashboard
        return redirect()->route('candidate.dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();

        $seccionesCompletadas = Respuesta_Usuario::where('user_id', $user->id)
        ->join('psico_alobri_preguntas', 'psico_alobri_respuestas_usuario.pregunta_id', '=', 'psico_alobri_preguntas.pregunta_id')
        ->pluck('psico_alobri_preguntas.seccion_id')
        ->unique()
        ->toArray();
        //categorias asignadas al usuario
        $categorias = $user->categorias;
        //secciones que pertenecen a esa categoría
        $secciones = $categorias->load('secciones');

        //id de la seccion completada.
        //$seccion_completada = session('seccion_completada', null);

        return view('candidate.evaluaciones', compact('user', 'categorias', 'secciones','seccionesCompletadas'));
    }

    public function perfil(){
        $user = Auth::user();
        
        $aplicacion = $user->aplicacion ?? null;
        $aplicacion = Aplicacion::where('user_id', $user->id)->first();

        return view('candidate.perfil', compact('user', 'aplicacion'));
    }
}
