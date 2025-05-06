<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Verificamos si el usuario está autenticado y si es superadmin
        if ($user && $user->config && $user->config->role->isSuperAdmin()) {
            return $next($request); // Si es superadmin, permite continuar con la petición
        }

        // Si no es superadmin, devuelve un error 403
        abort(403, 'No tienes permiso para acceder a esta página.');
    }
}
