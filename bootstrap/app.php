<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registra el middleware is_admin con el alias 'is_admin'
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
            'is_super_admin' => \App\Http\Middleware\IsSuperAdmin::class,
            'is_candidate' => App\Http\Middleware\IsCandidate::class,
            'psico.user' => \App\Http\Middleware\CheckPsicoUser::class,
            'check.user' => \App\Http\Middleware\CustomRedirectIfAuthenticated::class,

        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
