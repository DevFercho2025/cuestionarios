<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessCode;
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
    
        // Buscar el código
        $codigo = AccessCode::where('code', $codigoIngresado)->first();
    
        if (!$codigo || !$codigo->user) {
            return back()->withErrors(['codigo' => 'El código ingresado no es válido.']);
        }
    
        $usuario = $codigo->user;
    
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

        $aplicacion = AccessCode::where('user_id', $user->id)->first();

        $seccionesCompletadas = Respuesta_Usuario::where('user_id', $user->id)
            ->join('psico_alobri_questions', 'psico_alobri_user_answers.question_id', '=', 'psico_alobri_questions.id')
            ->pluck('psico_alobri_questions.section_id')
            ->unique()
            ->toArray();

        $tests = $user->assignedTests;
        $secciones = $tests->load('sections');

        return view('candidate.evaluaciones', compact('user', 'tests', 'secciones', 'seccionesCompletadas', 'aplicacion'));
    }

    public function perfil(){
        $user = Auth::user();
        
        $aplicacion = $user->aplicacion ?? null;
        $aplicacion = AccessCode::where('user_id', $user->id)->first();

        return view('candidate.perfil', compact('user', 'aplicacion'));
    }
}
