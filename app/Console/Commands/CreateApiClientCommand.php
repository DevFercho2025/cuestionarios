<?php

namespace App\Console\Commands;

use App\Models\ApiClient;
use App\Models\ApiClientBilling;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateApiClientCommand extends Command
{
    protected $signature = 'api:create-client
        {name : Client name}
        {--type=token : Client type (token, government, subscription)}
        {--email= : Contact email}
        {--phone= : Contact phone}
        {--company= : Company ID to associate with this client}
        {--tokens=0 : Initial token balance (for token type)}
        {--plan= : Subscription plan name (for subscription type)}
        {--eval-limit=100 : Evaluations per period (for subscription type)}
        {--days=30 : Subscription period in days (for subscription type)}';

    protected $description = 'Create a new API client and generate an access token';

    public function handle(): int
    {
        $name = $this->argument('name');
        $type = $this->option('type');
        $email = $this->option('email') ?? $this->ask('Contact email?');

        if (!in_array($type, ['token', 'government', 'subscription'])) {
            $this->error("Invalid client type: {$type}. Must be token, government, or subscription.");
            return self::FAILURE;
        }

        $slug = Str::slug($name);

        if (ApiClient::where('slug', $slug)->exists()) {
            $this->error("A client with slug '{$slug}' already exists.");
            return self::FAILURE;
        }

        $companyId = $this->option('company');

        $client = ApiClient::create([
            'name' => $name,
            'slug' => $slug,
            'contact_email' => $email,
            'contact_phone' => $this->option('phone'),
            'company_id' => $companyId,
            'client_type' => $type,
            'is_active' => true,
        ]);

        // Create billing record for token and subscription types
        if ($type === 'token') {
            ApiClientBilling::create([
                'api_client_id' => $client->id,
                'token_balance' => (int) $this->option('tokens'),
            ]);
            $this->info("Token balance: {$this->option('tokens')}");
        }

        if ($type === 'subscription') {
            $days = (int) $this->option('days');
            ApiClientBilling::create([
                'api_client_id' => $client->id,
                'subscription_plan' => $this->option('plan') ?? 'default',
                'subscription_eval_limit' => (int) $this->option('eval-limit'),
                'subscription_evals_used' => 0,
                'subscription_starts_at' => now(),
                'subscription_ends_at' => now()->addDays($days),
                'subscription_auto_renew' => true,
            ]);
            $this->info("Subscription: {$this->option('eval-limit')} evals / {$days} days");
        }

        // Generate Sanctum token
        $token = $client->createToken($slug . '-api-token');

        $this->newLine();
        $this->info('API Client created successfully!');
        $this->table(
            ['Field', 'Value'],
            [
                ['ID', $client->id],
                ['Name', $client->name],
                ['Slug', $client->slug],
                ['Type', $client->client_type],
                ['Email', $client->contact_email],
            ]
        );

        $this->newLine();
        $this->warn('API Token (save it, it won\'t be shown again):');
        $this->line($token->plainTextToken);
        $this->newLine();

        return self::SUCCESS;
    }
}
