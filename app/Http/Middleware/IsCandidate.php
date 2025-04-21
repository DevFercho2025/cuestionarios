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
        $user->load('config');
        $config = $user->config;


        if (!$config || !$config->role || !$config->role->isCandidate() ) {
            abort(403, 'Acceso no autorizado.');
        }

        return $next($request);
    }
}
