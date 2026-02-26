<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomRedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Lógica personalizada para psicometrías
                if ($user->config && $user->config->is_pisco_user && $user->config->active) {
                    return redirect('/psicometricas/admin');
                }

                // Si no tiene permisos, logout
                Auth::logout();
            }
        }

        return $next($request);
    }
}
