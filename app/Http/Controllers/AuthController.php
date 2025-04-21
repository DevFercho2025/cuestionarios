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
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

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
