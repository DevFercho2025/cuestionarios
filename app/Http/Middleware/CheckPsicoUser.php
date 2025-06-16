<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckPsicoUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $configUser = DB::table('config_users')
            ->where('user_id', $user->id)
            ->where('is_pisco_user', 1)
            ->where('active', 1)
            ->first();

        if (!$configUser) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'No tienes permisos para acceder al sistema de psicometría');
        }

        $company = DB::table('companies')
            ->where('id', $configUser->company_id)
            ->where('is_pisco_psico', 1)
            ->where('active', 1)
            ->first();

        if (!$company) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'La empresa a la que perteneces no tiene habilitado el acceso al sistema de psicometría');
        }

        return $next($request);
    }
}
