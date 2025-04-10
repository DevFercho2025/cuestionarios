<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplicacion;

class CodigoController extends Controller
{
    public function verificar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);
    
        $codigo = $request->input('codigo');
    
        $aplicacion = Aplicacion::where('codigo', $codigo)->first();
    
        if (!$aplicacion) {
            return back()->withErrors(['codigo' => 'Código no válido']);
        }
    
        // Redirigir a la vista de usuario donde podrá ver qué cuestionarios responder.
        return redirect()->route('guardar.candidato', ['codigo' => $codigo]);
    }
    
}
