<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCandidate
{
    /**
     * Maneja la petición entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()) {
            abort(403, 'Acceso no autorizado.');
        }

        $user = $request->user();
        $user->load('config'); // Si tienes una relación 'config', cargala (similar al middleware IsAdmin)
        $config = $user->config;

        // Verificar si el usuario tiene configuración y si es un candidato, admin o superadmin es 0
        if (!$config || $config->is_admin !== 0 || $config->is_super_admin !== 0) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
