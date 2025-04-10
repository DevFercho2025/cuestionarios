<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aplicacion;

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

        $aplicacion = Aplicacion::where('codigo', $codigoIngresado)->first();

        if (!$aplicacion) {
            return back()->withErrors(['codigo' => 'El código ingresado no es válido.']);
        }

        session(['aplicacion_id' => $aplicacion->id]);

        return redirect('/formulario');
    }

}
