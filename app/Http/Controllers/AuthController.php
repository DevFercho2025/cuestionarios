<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Client;
use App\Models\ContadorEvaluacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            'firstname'           => 'required|string|max:50', #
            'lastname'            => 'required|string|max:50', #
            'email'               => 'required|email|unique:users,email', #
            'password'            => 'required|string|min:8', #
            // paso 2
            'software_experience' => 'required|in:0,1',
            // paso 3
            'servicio'            => 'nullable|string', // JSON
            // paso 4
            'portal'              => 'nullable|string', // JSON
            // paso 5 y 6
            'industry'            => 'required|string', #
            'employees_count'     => 'required|string', #
            // paso 7
            'company_name'        => 'required|string|max:100', #
            'website'             => 'nullable|url', #
            'position'            => 'required|string', #
        ]);
        Log::info('Datos recibidos en el formulario:', $request->all());

        // 1) Crear la empresa
        $company = new Company();
        $company->fill([
            'name'            => $data['company_name'],
            'description'     => null,
            'logo'            => null,
            'active'          => 1,
            'is_pisco_alobri' => 0,
            'slug'            => null,
        ]);
        $company->save();

        // 2) Crear usuario
        $user = new User();
        $user->fill([
            'name'       => "{$data['firstname']} {$data['lastname']}",
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);
        $user->save();


        // 3) Configuración del usuario
        $user->config()->create([
            'company_id'         => $company->id,
            'role_id'            => 1,
            'is_talentina_user'  => 0,
            'user_id'            => $user->id,
            'is_psico_user'       => 1,
            'active'             => 1,
        ]);

        // 4) Registrar el “Client” con los datos del wizard
        $client = new Client();
        $client->fill([
            'name'               => $user->name,
            'email'              => $user->email,
            'software_experience'=> $data['software_experience'],
            'employees_count' => $data['employees_count'],
            'industry'        => $data['industry'],
            'website'         => $data['website'],
            'company_id'         => $company->id,
        ]);
        $client->save();

        // 5) Registrar el contador de evaluaciones predeterminado.
        ContadorEvaluacion::create([
            'user_id'            => $user->id,
            'pruebas_disponibles'=> 3,
            'pruebas_usadas'     => 0,
        ]);

        // Finalmente, loguea al usuario o rediríge
        auth()->login($user);

        return redirect()->route('admin.index');
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
