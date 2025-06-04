<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Personalizar redirección para usuarios autenticados
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            $user = Auth::user();

            // Si está en la app de cuestionarios (psicometrías)
            if ($request->is('psicometricas/*') || $request->is('login')) {
                // Verificar permisos de psico
                if ($user->config && $user->config->is_psico_user && $user->config->active) {
                    return '/psicometricas/admin';
                }

                Auth::logout();
                return null; // Permite continuar al formulario de login
            }

            return '/dashboard';
        });
    }
}
