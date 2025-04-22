<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 1) Validación de campos
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2) Intento de autenticación
        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user */
            $user   = Auth::user();
            $config = $user->config; // hasOne, no ->first()

            //Si no hay configuración en config_users
            if (! $config) {
                Auth::logout();
                return back()->withErrors(['email' => 'Su cuenta no está configurada.']);
            }

            //Si la cuenta existe pero está desactivada
            if (! $config->active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Su cuenta está desactivada.']);
            }


            if ($config && $config->role && ($config->role->isAdmin() || $config->role->isSuperAdmin())) {
                return redirect()->route('admin.index'); 
            }

            // 4) Si la cuenta existe pero está desactivada
            if (! $config->active) {
                Auth::logout();
                return back()->withErrors(['email' => 'Su cuenta está desactivada.']);
            }

            /*// 5) Psico‑user (flag)
            if ($config->is_psico_user) {
                return redirect()->route('psico.dashboard');
            }

            // 6) Super‑admin (role_id = 1 o flag)
            if ($config->role_id == 1 || $config->is_super_admin) {
                return redirect()->route('superadmin.index');
            }

            // 7) Admin (role_id = 2 o flag)
            if ($config->role_id == 2 || $config->is_admin) {
                return redirect()->route('admin.index');
            }

            // 8) Usuario normal (role_id = 0 o cualquier otro caso)
            return redirect()->route('home');*/
        }

        //credenciales inválidas
        Auth::logout();
        return back()->withErrors([
            'email' => 'Credenciales Incorrectas.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
