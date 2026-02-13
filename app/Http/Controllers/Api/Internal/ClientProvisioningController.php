<?php

namespace App\Http\Controllers\Api\Internal;

use App\Http\Controllers\Controller;
use App\Models\ApiClient;
use App\Models\ApiClientBilling;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientProvisioningController extends Controller
{
    use ApiResponses;

    /**
     * POST /api/internal/clients
     * Crea un ApiClient (gobierno) y retorna el token Sanctum.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'company_id' => 'nullable|integer',
            'client_type' => 'sometimes|string|in:token,government,subscription',
            'employer_id' => 'nullable|integer',
        ]);

        $slug = Str::slug($request->name);

        // Si ya existe, reactivar y regenerar token
        $existing = ApiClient::withTrashed()->where('slug', $slug)->first();

        if ($existing) {
            $existing->restore();
            $existing->update([
                'is_active' => true,
                'contact_email' => $request->email,
                'company_id' => $request->company_id,
                'notes' => $request->employer_id ? "employer_id:{$request->employer_id}" : $existing->notes,
            ]);

            // Revocar tokens anteriores y crear uno nuevo
            $existing->tokens()->delete();
            $token = $existing->createToken($slug . '-api-token');

            return $this->successResponse([
                'client_id' => $existing->id,
                'slug' => $existing->slug,
                'client_type' => $existing->client_type,
                'is_active' => true,
                'api_token' => $token->plainTextToken,
            ], 'Client reactivated with new token.');
        }

        $type = $request->input('client_type', 'government');

        $client = ApiClient::create([
            'name' => $request->name,
            'slug' => $slug,
            'contact_email' => $request->email,
            'company_id' => $request->company_id,
            'client_type' => $type,
            'is_active' => true,
            'notes' => $request->employer_id ? "employer_id:{$request->employer_id}" : null,
        ]);

        // Crear billing si es token o suscripción
        if ($type === 'token') {
            ApiClientBilling::create([
                'api_client_id' => $client->id,
                'token_balance' => $request->input('token_balance', 0),
            ]);
        }

        if ($type === 'subscription') {
            $days = $request->input('subscription_days', 30);
            ApiClientBilling::create([
                'api_client_id' => $client->id,
                'subscription_plan' => $request->input('subscription_plan', 'default'),
                'subscription_eval_limit' => $request->input('subscription_eval_limit', 100),
                'subscription_evals_used' => 0,
                'subscription_starts_at' => now(),
                'subscription_ends_at' => now()->addDays($days),
                'subscription_auto_renew' => true,
            ]);
        }

        $token = $client->createToken($slug . '-api-token');

        return $this->createdResponse([
            'client_id' => $client->id,
            'slug' => $client->slug,
            'client_type' => $client->client_type,
            'is_active' => true,
            'api_token' => $token->plainTextToken,
        ], 'Client created.');
    }

    /**
     * PATCH /api/internal/clients/{slug}/toggle
     * Activa o desactiva un ApiClient.
     */
    public function toggle(Request $request, string $slug)
    {
        $client = ApiClient::withTrashed()->where('slug', $slug)->first();

        if (!$client) {
            return $this->notFoundResponse('Client not found.');
        }

        $enable = (bool) $request->input('enable', !$client->is_active);

        if ($enable) {
            $client->restore();
            $client->update(['is_active' => true]);
        } else {
            $client->update(['is_active' => false]);
        }

        $data = [
            'client_id' => $client->id,
            'slug' => $client->slug,
            'is_active' => $client->is_active,
        ];

        // Si se reactiva y no tiene tokens válidos, generar uno nuevo
        if ($enable && $client->tokens()->count() === 0) {
            $token = $client->createToken($slug . '-api-token');
            $data['api_token'] = $token->plainTextToken;
        }

        $message = $enable ? 'Client activated.' : 'Client deactivated.';
        return $this->successResponse($data, $message);
    }

    /**
     * GET /api/internal/clients/{slug}
     * Consultar estado de un ApiClient.
     */
    public function show(string $slug)
    {
        $client = ApiClient::withTrashed()->where('slug', $slug)->first();

        if (!$client) {
            return $this->notFoundResponse('Client not found.');
        }

        $data = [
            'client_id' => $client->id,
            'slug' => $client->slug,
            'name' => $client->name,
            'client_type' => $client->client_type,
            'is_active' => $client->is_active,
            'company_id' => $client->company_id,
            'contact_email' => $client->contact_email,
            'has_token' => $client->tokens()->count() > 0,
            'created_at' => $client->created_at?->toIso8601String(),
        ];

        if ($client->billing) {
            $billing = $client->billing;
            $data['billing'] = [
                'token_balance' => $billing->token_balance,
                'subscription_plan' => $billing->subscription_plan,
                'subscription_eval_limit' => $billing->subscription_eval_limit,
                'subscription_evals_used' => $billing->subscription_evals_used,
                'subscription_ends_at' => $billing->subscription_ends_at?->toIso8601String(),
            ];
        }

        return $this->successResponse($data, 'Client details.');
    }

    /**
     * GET /api/internal/clients
     * Listar todos los clientes API.
     */
    public function index(Request $request)
    {
        $clients = ApiClient::withTrashed()
            ->when($request->employer_id, fn($q) => $q->where('notes', 'like', "%employer_id:{$request->employer_id}%"))
            ->get()
            ->map(fn($c) => [
                'client_id' => $c->id,
                'slug' => $c->slug,
                'name' => $c->name,
                'client_type' => $c->client_type,
                'is_active' => $c->is_active,
                'company_id' => $c->company_id,
                'deleted_at' => $c->deleted_at?->toIso8601String(),
            ]);

        return $this->successResponse($clients, 'Clients list.');
    }
}
