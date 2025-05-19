<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\RespuestaController;
use App\Http\Controllers\RespuestaCorrectaController;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\AplicacionController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\ResultadosController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
/*Route::get('/php-info', function () {
    return view('phpinfo');
});*/
Route::get('/', [HomeController::class, 'index'])->name('home.index');


Route::get('register',  [AuthController::class, 'showRegisterForm'])->name('register.wizard');
Route::post('register/wizard', [AuthController::class, 'registerFormStore'])->name('register.wizard.store');

// Endpoints públicos
Route::get('/candidate', [CandidateController::class, 'index'])->name('candidate.index');
Route::post('/candidate/validar-codigo', [CandidateController::class, 'validarCodigo'])->name('validar.codigo');

//Route::get('postal-codes/{postalCode}/{phoneNumber}', [PostalCodeGoogleApiController::class, 'getAddressByPostalCode']);

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
    Route::get('categorias/all', [CategoriaController::class, 'all'])->name('categorias.all');

    // Rutas para Preguntas
    Route::get('preguntas', [PreguntaController::class, 'index'])->name('preguntas.index');
    Route::post('preguntas', [PreguntaController::class, 'store'])->name('preguntas.store');
    Route::get('preguntas/datatable', [PreguntaController::class, 'datatable'])->name('preguntas.datatable');
    Route::get('preguntas/{id}', [PreguntaController::class, 'show'])->name('preguntas.show');
    Route::put('preguntas/{id}', [PreguntaController::class, 'update'])->name('preguntas.update');
    Route::delete('preguntas/{id}', [PreguntaController::class, 'destroy'])->name('preguntas.destroy');
    Route::get('preguntas/categorias', [PreguntaController::class, 'categorias'])->name('admin.preguntas.categorias');

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

    // Rutas para candidatos
    Route::post('candidatos', [CandidatoController::class, 'index'])->name('candidatos.index');
    Route::get('candidatos/registrar-candidato', [CandidatoController::class, 'crearCandidato'])->name('candidatos.crear');
    Route::post('/candidatos/store', [CandidatoController::class, 'store'])->name('candidatos.store');
    Route::get('/candidatos/datatable', [CandidatoController::class, 'datatable'])->name('candidatos.datatable');
    Route::get('candidatos/{id}', [CandidatoController::class, 'show'])->name('candidatos.show');
    Route::put('candidatos/{id}', [CandidatoController::class, 'update'])->name('candidatos.update');
    Route::delete('candidatos/{id}', [CandidatoController::class, 'destroy'])->name('candidatos.destroy');
    Route::post('/generar-codigo', [CandidatoController::class, 'generarCodigo'])->name('generar.codigo');
    Route::post('candidatos/codigo', [CandidatoController::class, 'guardarCodigo'])->name('guardar.codigo');
    Route::get('candidatos/lista', [CandidatoController::class, 'listaUsuarios'])->name('candidatos.lista');
    Route::get('candidatos/perfil/{id}', [CandidatoController::class, 'verPerfil'])->name('candidatos.perfil');
    Route::post('/check-email', [CandidatoController::class, 'checkEmail'])->name('check.email');

    // Rutas para evaluaciones
    Route::get('/evaluaciones', [EvaluacionController::class, 'index'])->name('evaluaciones.index');
    Route::get('/aplicaciones/datatable', [AplicacionController::class, 'datatable'])->name('admin.aplicaciones.datatable');
    Route::get('/categorias/listar', [EvaluacionController::class, 'listarCategorias'])->name('admin.categorias.listar');
    Route::post('/evaluaciones/asignar', [EvaluacionController::class, 'asignarCategorias'])->name('admin.evaluaciones.asignar');
    Route::get('/evaluaciones/usuario/{user_id}', [EvaluacionController::class, 'evaluacionesPorUsuario']);
    Route::delete('/aplicaciones/{id}', [AplicacionController::class, 'destroy']);
    Route::post('/evaluaciones/eliminar', [EvaluacionController::class, 'eliminarAsignacion'])->name('admin.evaluaciones.eliminar');

    Route::get('resultados', [ResultadosController::class, 'index'])->name('resultados.index');
    Route::get('/buscar-Resultados', [ResultadosController::class, 'buscarResultados'])->name('admin.buscar.resultados');
    Route::get('/resultados/datatable', [ResultadosController::class, 'datatable'])->name('resultados.datatable');
    Route::get('/resultados/{id}', [ResultadosController::class, 'verResultados'])->name('admin.ver.resultados');
    Route::get('/renderizar-metricas/{id}', [ResultadosController::class, 'renderizarMetricas']);
    Route::post('/exportar-pdf/{id}', [ResultadosController::class, 'recibirImagenes']);
    Route::get('/exportar-pdf/token-id/{id}', [ResultadosController::class, 'exportarPDF'])->name('admin.exportar.pdf');

    // Select de usuarios y vacantes
    Route::get('usuarios/all', [AplicacionController::class, 'usuarios'])->name('usuarios.all');
    Route::get('vacantes/all', [AplicacionController::class, 'vacantes'])->name('vacantes.all');


    // Rutas para solo superadmin
    Route::group(['middleware' => 'is_super_admin'], function () {
        //gestionar compañías
        Route::get('companias', [CompanyController::class, 'index'])->name('companias.index');
        Route::post('companias', [CompanyController::class, 'store'])->name('companias.store');
        Route::put('companias/{id}', [CompanyController::class, 'update'])->name('companias.update');
        Route::delete('companias/{id}', [CompanyController::class, 'destroy'])->name('companias.destroy');
        Route::get('admin/companias/datatable', [CompanyController::class, 'datatable'])->name('companias.datatable');
        Route::get('companias/all', [CompanyController::class, 'all'])->name('companias.all');

        //gestionar usuarios
        Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::put('usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
        Route::get('admin/usuarios/datatable', [UsuarioController::class, 'datatable'])->name('usuarios.datatable');
        Route::get('roles/all', [UsuarioController::class, 'all'])->name('roles.all');

    });


});

Route::group([
    'prefix' => 'candidate',
    'middleware' => ['auth', 'is_candidate']
], function (){
    Route::get('/dashboard', [CandidateController::class, 'dashboard'])->name('candidate.dashboard');
    Route::get('/perfil', [CandidateController::class, 'perfil'])->name('candidate.perfil');

    Route::get('/formulario', [FormularioController::class, 'index'])->name('index');
    Route::get('/permisos-preliminares', [FormularioController::class, 'mostrarPermisos'])->name('permisos-preliminares');
    Route::get('/cargar-formulario', [FormularioController::class, 'cargarFormulario'])->name('candidate.cargar.formulario');
    //Route::post('/permisos-preliminares', [FormularioController::class, 'guardarCandidato'])->name('guardar.candidato');
    Route::post('/formulario', [FormularioController::class, 'guardarRespuestas'])->name('guardar.respuestas');
    Route::post('/guardar-foto', [FormularioController::class, 'guardarFoto'])->name('guardar.foto');
    
});
