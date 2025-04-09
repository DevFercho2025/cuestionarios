<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\RespuestaCorrectaController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    // Página de inicio o redirección
});

// Endpoints públicos
Route::get('/formulario', [FormularioController::class, 'index'])->name('index');
Route::post('/permisos-preliminares', [FormularioController::class, 'guardarCandidato'])->name('guardar.candidato');
Route::post('/formulario', [FormularioController::class, 'guardarRespuestas'])->name('guardar.respuestas');
Route::post('/guardar-foto', [FormularioController::class, 'guardarFoto'])->name('guardar.foto');
Route::get('/cargar-formulario', [FormularioController::class, 'cargarFormulario'])->name('cargar.formulario');
Route::get('/gracias', function () {
    return view('gracias');
})->name('gracias');
Route::post('/generar-token', [FormularioController::class, 'generarToken'])->name('generar.token');
Route::get('/buscador-resultados', [FormularioController::class, 'verResultados'])->name('ver.resultados');
Route::get('/buscar-resultados', [FormularioController::class, 'buscarResultados'])->name('buscar.resultados');
Route::get('/exportar-pdf/token-id/{id}', [FormularioController::class, 'exportarPDF'])->name('exportar.pdf');
Route::get('postal-codes/{postalCode}/{phoneNumber}', [PostalCodeGoogleApiController::class, 'getAddressByPostalCode']);

Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth', 'is_admin']
], function () {

    // Panel de administración principal
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Rutas para Secciones
    Route::get('secciones', [SeccionController::class, 'index'])->name('secciones.index');
    Route::post('secciones', [SeccionController::class, 'store'])->name('secciones.store');
    Route::put('secciones/{id}', [SeccionController::class, 'update'])->name('secciones.update');
    Route::delete('secciones/{id}', [SeccionController::class, 'destroy'])->name('secciones.destroy');
    Route::get('secciones/datatable', [SeccionController::class, 'datatable'])->name('secciones.datatable');
    Route::get('secciones/all', [SeccionController::class, 'all'])->name('secciones.all');

    // Rutas para Preguntas
    Route::get('preguntas', [PreguntaController::class, 'index'])->name('preguntas.index');
    Route::post('preguntas', [PreguntaController::class, 'store'])->name('preguntas.store');
    Route::get('preguntas/datatable', [PreguntaController::class, 'datatable'])->name('preguntas.datatable');
    Route::get('preguntas/{id}', [PreguntaController::class, 'show'])->name('preguntas.show');
    Route::put('preguntas/{id}', [PreguntaController::class, 'update'])->name('preguntas.update');
    Route::delete('preguntas/{id}', [PreguntaController::class, 'destroy'])->name('preguntas.destroy');

    // Rutas para Respuestas
    Route::get('respuestas', [RespuestaController::class, 'index'])->name('respuestas.index');
    Route::post('respuestas', [RespuestaController::class, 'store'])->name('respuestas.store');
    Route::get('respuestas/datatable', [RespuestaController::class, 'datatable'])->name('respuestas.datatable');
    Route::get('respuestas/{id}', [RespuestaController::class, 'show'])->name('respuestas.show');
    Route::put('respuestas/{id}', [RespuestaController::class, 'update'])->name('respuestas.update');
    Route::delete('respuestas/{id}', [RespuestaController::class, 'destroy'])->name('respuestas.destroy');

    // Rutas para Respuestas Correctas
    Route::get('respuestas_correctas', [RespuestaCorrectaController::class, 'index'])->name('respuestas_correctas.index');
    Route::post('respuestas_correctas', [RespuestaCorrectaController::class, 'store'])->name('respuestas_correctas.store');
    Route::get('respuestas_correctas/datatable', [RespuestaCorrectaController::class, 'datatable'])->name('respuestas_correctas.datatable');
    Route::get('respuestas_correctas/{id}', [RespuestaCorrectaController::class, 'show'])->name('respuestas_correctas.show');
    Route::put('respuestas_correctas/{id}', [RespuestaCorrectaController::class, 'update'])->name('respuestas_correctas.update');
    Route::delete('respuestas_correctas/{id}', [RespuestaCorrectaController::class, 'destroy'])->name('respuestas_correctas.destroy');
});
