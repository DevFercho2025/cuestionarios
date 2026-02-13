<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Reset subscription counters — runs daily, job checks expiration internally
Schedule::job(new \App\Jobs\ResetSubscriptionCountersJob)->daily();
