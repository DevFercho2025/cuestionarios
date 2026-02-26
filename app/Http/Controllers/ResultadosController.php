<?php

namespace App\Http\Controllers;

use App\Models\AccessCode;
use App\Services\ScoringService;
use App\Services\ResultadosService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\History;
use App\Models\Respuesta_Usuario;
use App\Models\TokenEvaluacion;
use App\Models\UserAssignedTest;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ResultadosController extends Controller
{
    protected ScoringService $scoringService;
    protected ResultadosService $resultadosService;

    public function __construct(ScoringService $scoringService, ResultadosService $resultadosService)
    {
        $this->scoringService = $scoringService;
        $this->resultadosService = $resultadosService;
    }

    public function index()
    {
        return view('resultados.index');
    }

    public function verResultados($id)
    {
        return view('resultados.ver', ['id' => $id]);
    }

    public function datatable(){
        try{
            $companyId = Auth::user()->config->company_id;
            $user = Auth::user();
            $isSuperAdmin = $user->config->role->isSuperAdmin() ?? false;

            $candidatos = User::with([
                'info',
                'config.role',
                'config.company',
                'tokensEvaluaciones',
                'userTestsAcessCodes',
                'assignedTests.sections',
                'respuestasUsuario' => function($q) {
                    $q->join('psico_alobri_questions', 'psico_alobri_user_answers.question_id', '=', 'psico_alobri_questions.id')
                    ->select('psico_alobri_user_answers.*', 'psico_alobri_questions.section_id');
                }
            ])->whereHas('config.role', function ($q) {
                $q->where('id','=', 0);
            })
            ->when(!$isSuperAdmin, function ($q) use ($companyId) {
                $q->whereHas('config', function ($q2) use ($companyId) {
                    $q2->where('company_id', $companyId);
                });
            })->get();

            $candidatosData = [];

            foreach ($candidatos as $user) {
                $tokenEval = $user->tokensEvaluaciones->sortByDesc('created_at')->first();
                $token = $tokenEval?->token ?? 'Sin token';
                $tokenId = $tokenEval?->id;

                $respuestasDelToken = $user->respuestasUsuario->where('token_id', $tokenId);

                foreach ($user->assignedTests as $test) {
                    if (!$test) continue;

                    $seccionesCompletadasIds = $respuestasDelToken->pluck('section_id')->unique()->toArray();
                    $accessCode = $test->pivot->application_access_code_id ?? 'Sin código';
                    $secciones = $test->sections;
                    $totalSecciones = $secciones->count();

                    $seccionesCompletadas = $secciones->whereIn('id', $seccionesCompletadasIds);
                    $seccionesCompletadasNombres = $seccionesCompletadas->pluck('title')->toArray();

                    $completadas = $seccionesCompletadas->count();

                    $estado = ($totalSecciones > 0 && $completadas === $totalSecciones)
                        ? "Completado: <br> $completadas/$totalSecciones realizadas"
                        : "Pendiente: <br> $completadas/$totalSecciones realizadas";

                    $candidatosData[] = [
                        'id_candidato' => $user->id,
                        'nombre' => $user->name,
                        'cuestionario' => $test->test_title,
                        'secciones_completadas' => $seccionesCompletadasNombres,
                        'access_code' => $accessCode ?? 'Sin código de acceso',
                        'token' => $token,
                        'estado' => $estado,
                    ];
                }
            }

            return response()->json(['data' => $candidatosData]);

        }catch (\Exception $e) {
            return response()->json([
                'error' => 'Hubo un problema al obtener los tokens de evaluaciones.',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
    }

    public function buscarResultados(Request $request)
    {
        $tokenStr = $request->input('token');
        $evaluaciones = $request->input('evaluaciones', []);

        $token = TokenEvaluacion::where('token', $tokenStr)->first();
        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Token no encontrado.'
            ], 404);
        }

        $usuario = User::find($token->user_id);
        if (!$usuario) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Usuario no encontrado.'
            ], 404);
        }

        $aplicacion = AccessCode::where('user_id', $usuario->id)->first();

        $respuestas = Respuesta_Usuario::with([
            'pregunta',
            'respuesta',
        ])
            ->where('user_id', $usuario->id)
            ->where('token_id', $token->id)
            ->get();

        $scores = $this->scoringService->calculateForUser($usuario->id, $token->id);

        return response()->json([
            'status'      => 'success',
            'usuario'     => $usuario,
            'aplicacion'  => $aplicacion,
            'respuestas'  => $respuestas,
            'scores'      => $scores,
            'tokenStr'    => $tokenStr,
            'token'       => $token
        ]);
    }

    public function renderizarMetricas($id)
    {
        $token = TokenEvaluacion::findOrFail($id);
        $usuario = User::findOrFail($token->user_id);

        $scores = $this->scoringService->calculateForUser($usuario->id, $token->id);
        $metricas = $this->resultadosService->buildMetricasFromScores($scores);

        return view('pdf.imagenes_reporte', compact('metricas'))->render();
    }

    public function recibirImagenes(Request $request, $id)
    {
        $imagenesBase64 = $request->input('imagenes', []);

        session(["imagenes_pdf_{$id}" => $imagenesBase64]);
        return response()->json(['ok' => true]);
    }

    public function exportarPDF($id)
    {
        $token = TokenEvaluacion::findOrFail($id);
        $imagenesBase64 = session("imagenes_pdf_{$id}", []);
        $usuario = User::findOrFail($token->user_id);
        $aplicacion = AccessCode::where('user_id', $usuario->id)->first();

        $scores = $this->scoringService->calculateForUser($usuario->id, $token->id);
        $metricas = $this->resultadosService->buildMetricasFromScores($scores);

        $html = view('pdf.resultados', compact('usuario', 'aplicacion', 'metricas', 'scores', 'imagenesBase64'));
        $dompdf = PDF::loadHtml($html);
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isPhpEnabled', false);
        $dompdf->setPaper('A4','portrait');
        $dompdf->render();

        $testAsignados = UserAssignedTest::where('application_access_code_id', $aplicacion->id)->get();
        $idsTests = $testAsignados->pluck('test_id')->toArray();

        History::create([
            'user_id' => Auth::user()->id,
            'comment' => "Se generó un reporte en PDF para el candidato con ID $usuario->id, con los resultados de los Tests con ID: " . implode(', ', $idsTests),
        ]);

        return $dompdf->stream();
    }
}
