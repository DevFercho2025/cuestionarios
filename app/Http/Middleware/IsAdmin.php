<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IsAdmin
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
        $user->load('config');
        $config = $user->config;

        // Verificar si el usuario tiene configuración y si es administrador o superadmin
        if (!$config || !$config->role || (!$config->role->isAdmin() && !$config->role->isSuperAdmin())) {
            abort(403, 'Acceso no autorizado.');
        }

        Log::info('Usuario permitido, continuando.');
        return $next($request);
    }
}
