<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EvaluacionController extends Controller
{
    public function index()
    {
        return view('Evaluaciones.index'); // Asegúrate que la ruta del archivo sea esta
    }
}
