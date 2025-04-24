<?php

namespace App\Http\Controllers;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function all()
    {
        return response()->json(Categoria::select('id', 'titulo_cuestionario')->get());
    }
}
