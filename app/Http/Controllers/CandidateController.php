<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessCode;
use Illuminate\Support\Facades\Auth;
use App\Models\UserTestRecord;

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
        $role = $usuario->config?->role;
        if ($role && ($role->isAdmin() || $role->isSuperAdmin())) {
            return back()->withErrors(['codigo' => 'Este código no pertenece a un candidato.']);
        }

        // Autenticar al usuario
        Auth::login($usuario);
        $request->session()->regenerate();
        session(['codigo_actual_id' => $codigo->id]);
    
        // Redirigir al dashboard
        return redirect()->route('candidate.dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $codigoActualId = session('codigo_actual_id');

        $aplicacion = AccessCode::find($codigoActualId);

        $seccionesCompletadas = UserTestRecord::userCompletedSections($user->id);
        
        $tests = $user->assignedTestsPorCodigo($codigoActualId)->get();
        
        $secciones = $tests->load('sections');

        return view('candidate.evaluaciones', compact('user', 'tests', 'secciones', 'seccionesCompletadas', 'aplicacion'));
    }

    public function perfil(){
        $user = Auth::user();
        
        $aplicacion = AccessCode::where('user_id', $user->id)->first();

        return view('candidate.perfil', compact('user', 'aplicacion'));
    }
}
