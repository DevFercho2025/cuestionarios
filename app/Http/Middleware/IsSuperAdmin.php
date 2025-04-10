<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSuperAdmin
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
        // Verifica si el usuario está autenticado y si su propiedad is_admin es igual a 1
        if (!auth()->check() || auth()->user()->is_super_admin != 1) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
