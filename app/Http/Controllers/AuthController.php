<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registerFormStore(Request $request)
    {
        $data = $request->validate([
            // paso 1
            'firstname'           => 'required|string|max:50',
            'lastname'            => 'required|string|max:50',
            'email'               => 'required|email|unique:users,email',
            'password'            => 'required|string|min:8',
            // paso 2
            'software_experience' => 'required|in:0,1',
            // paso 3
            'servicio'            => 'nullable|string', // JSON
            // paso 4
            'portal'              => 'nullable|string', // JSON
            // paso 5 y 6
            'industry'            => 'required|string',
            'employees_count'     => 'required|string',
            // paso 7
            'empresa_nombre'      => 'required|string|max:100',
            'empresa_web'         => 'nullable|url',
            'cargo'               => 'required|string',
        ]);

        // 1) Crear la empresa
        $company = Company::create([
            'name'            => $data['empresa_nombre'],
            'description'     => null,
            'logo'            => null,
            'active'          => 1,
            'is_pisco_alobri' => 0,
        ]);

        // 2) Crear usuario
        $user = User::create([
            'name'       => "{$data['firstname']} {$data['lastname']}",
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'company_id' => $company->id,
        ]);

        // 3) Configuración del usuario
        $user->config()->create([
            'company_id'         => $company->id,
            'role_id'            => 1,
            'is_talentina_user'  => 0,
            'is_psico_ser'       => 1,
            'active'             => 1,
            'user_id'            => $user->id,
        ]);

        // 4) Registrar el “Client” con los datos del wizard
        Client::create([
            'name'               => $user->name,
            'email'              => $user->email,
            'software_experience'=> $data['software_experience'],
            'industry'           => $data['industry'],
            'employee_count'     => $data['employees_count'],
            'website'            => $data['empresa_web'],
            'company_id'         => $company->id,
            // … otros campos si quieres…
        ]);

        // Finalmente, loguea al usuario o redirígelo
        auth()->login($user);

        return redirect()->route('dashboard');
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
