<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsCandidate
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->is_admin && !$user->is_super_admin) {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder a esta página.');
    }
}