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
use Illuminate\Support\Str;

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
            'firstname'           => 'required|string|max:50', #
            'lastname'            => 'required|string|max:50', #
            'email'               => 'required|email|unique:users,email', #
            'password'            => 'required|string|min:8', #
            'software_experience' => 'required|in:0,1',
            'servicio'            => 'nullable|string', // JSON
            'portal'              => 'nullable|string', // JSON
            'industry'            => 'required|string', #
            'employees_count'     => 'required|string', #
            'company_name'        => 'required|string|max:100', #
            'website'             => 'nullable|url', #
            'position'            => 'required|string', #
        ]);
        Log::info('Datos recibidos en el formulario:', $request->all());

        // 1) Crear la empresa
        $company = new Company();
        $company->fill([
            'name'            => $data['company_name'],
            'description'     => 'No proporcionada',
            'logo'            => null,
            'active'          => 1,
            'is_pisco_alobri' => 0,
            'is_pisco_psico'  => 1,
            'slug'            => Str::slug($data['company_name']),
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
            'role_id'            => 2,
            'is_talentina_user'  => 0,
            'user_id'            => $user->id,
            'is_pisco_user'       => 1,
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
            'available_tests'=> 3,
            'used_tests'     => 0,
        ]);

        auth()->login($user);

        return redirect()->route('admin.index');
    }

    
    public function correoEmpresaCreada($user_id, $newCompany)
    {
        Log::info('Entró a funcion para redirigir a correo');
        //prueba con vista
        $loginURL = route('login') . '#tab-login';

        $url = route('enviar.correoEmpresa', [
            'userId' => $user_id,
            'companyId' => $newCompany->id,
            'loginURL' => $loginURL,
        ]);

        Log::info('Redirigiendo a URL: ' . $url);

        return redirect($url);
    }

    public function correoEmpresaRegistrada(Request $request)
    {
        Log::info('Datos recibidos para correo', $request->all());
        $company = Company::findOrFail($request->companyId);
        $user = User::with('TestCounter')->findOrFail($request->userId);
        $loginURL = $request->loginURL;

        return new \App\Mail\EmpresaRegistrada($company, $user, $loginURL);
    }

    public function login(Request $request)
    {
        // 1) Validación de campos
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
        }
        // 2) Intento de autenticación
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user   = Auth::user();
            $config = $user->config;

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
                 Log::info('Usuario tiene el rol correcto:', ['rol' => $config->role->name]);
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
