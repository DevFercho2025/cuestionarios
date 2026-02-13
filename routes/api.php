<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\TestCatalogController;
use App\Http\Controllers\Api\V1\CandidateController;
use App\Http\Controllers\Api\V1\EvaluationController;
use App\Http\Controllers\Api\V1\ResultController;
use App\Http\Controllers\Api\V1\BillingController;
use App\Http\Controllers\Api\V1\WebhookConfigController;
use App\Http\Controllers\Api\Internal\ClientProvisioningController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// ─── API v1 para Clientes Externos ────────────────────────────────
Route::prefix('v1')->middleware(['api.client.auth', 'api.rate_limit'])->group(function () {

    // Catálogo de tests
    Route::get('/tests', [TestCatalogController::class, 'index']);
    Route::get('/tests/{id}', [TestCatalogController::class, 'show']);

    // Candidatos
    Route::post('/candidates', [CandidateController::class, 'store']);
    Route::get('/candidates', [CandidateController::class, 'index']);
    Route::get('/candidates/{external_id}', [CandidateController::class, 'show']);

    // Evaluaciones
    Route::post('/evaluations', [EvaluationController::class, 'store'])
        ->middleware(['api.check_test_access', 'api.billing_quota']);
    Route::get('/evaluations', [EvaluationController::class, 'index']);
    Route::get('/evaluations/{id}', [EvaluationController::class, 'show']);

    // Resultados
    Route::get('/evaluations/{id}/results', [ResultController::class, 'results']);
    Route::get('/evaluations/{id}/pdf', [ResultController::class, 'pdf']);
    Route::post('/evaluations/{id}/pdf/webhook', [ResultController::class, 'webhookPdf']);

    // Billing
    Route::get('/billing/usage', [BillingController::class, 'usage']);
    Route::get('/billing/history', [BillingController::class, 'history']);

    // Webhook config
    Route::get('/webhook', [WebhookConfigController::class, 'show']);
    Route::put('/webhook', [WebhookConfigController::class, 'update']);
    Route::post('/webhook/test', [WebhookConfigController::class, 'test']);
});

// ─── API Interna (JobOne+ → Psicometrías) ─────────────────────────
Route::prefix('internal')->middleware('api.internal')->group(function () {
    Route::get('/clients', [ClientProvisioningController::class, 'index']);
    Route::post('/clients', [ClientProvisioningController::class, 'store']);
    Route::get('/clients/{slug}', [ClientProvisioningController::class, 'show']);
    Route::patch('/clients/{slug}/toggle', [ClientProvisioningController::class, 'toggle']);
});
