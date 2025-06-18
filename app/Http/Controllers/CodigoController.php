<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccessCode;

class CodigoController extends Controller
{
    //validación de código al iniciar sesión como candidato
    public function verificar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);
    
        $codigo = $request->input('codigo');
    
        $accessCode = AccessCode::where('code', $codigo)->first();
    
        if (!$accessCode) {
            return back()->withErrors(['codigo' => 'Código no válido']);
        }
    
        // Redirigir a la vista de usuario donde podrá ver qué cuestionarios responder.
        return redirect()->route('guardar.candidato', ['codigo' => $codigo]);
    }
    
}
