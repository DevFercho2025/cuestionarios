@extends('layout.app')
@section('content')
    <style>
        .login-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0d1a 0%, #1a1530 40%, #0d1a2d 100%);
            display: flex; align-items: center; justify-content: center;
            padding: 2rem 1rem;
            position: relative; overflow: hidden;
        }
        .login-page::before {
            content: ''; position: absolute;
            top: -25%; right: -15%; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.1), transparent 70%);
            border-radius: 50%;
        }
        .login-page::after {
            content: ''; position: absolute;
            bottom: -20%; left: -8%; width: 450px; height: 450px;
            background: radial-gradient(circle, rgba(139,92,246,0.07), transparent 70%);
            border-radius: 50%;
        }
        .login-card {
            position: relative; z-index: 1;
            background: rgba(255,255,255,0.97);
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15), 0 0 0 1px rgba(0,0,0,0.04);
            max-width: 440px; width: 100%;
            padding: 2.5rem;
        }
        .login-logo { text-align: center; margin-bottom: 2rem; }
        .login-logo img { height: 36px; }
        .login-tabs {
            display: flex; gap: 4px; background: #f3f4f6; border-radius: 12px;
            padding: 4px; margin-bottom: 2rem;
        }
        .login-tab {
            flex: 1; padding: 10px 0; border: none; border-radius: 10px;
            font-weight: 600; font-size: 0.88rem;
            background: transparent; color: #6b7280;
            cursor: pointer; transition: all 0.25s;
            display: flex; align-items: center; justify-content: center; gap: 6px;
        }
        .login-tab.active {
            background: #fff; color: #1f2937;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .login-tab:hover:not(.active) { color: #4b5563; }
        .login-pane { display: none; }
        .login-pane.active { display: block; }
        .login-title {
            font-size: 1.35rem; font-weight: 700; color: #111827;
            margin-bottom: 4px; letter-spacing: -0.02em;
        }
        .login-subtitle {
            font-size: 0.9rem; color: #9ca3af; margin-bottom: 1.8rem;
        }
        .login-group { margin-bottom: 1rem; }
        .login-group label {
            display: block; font-size: 0.82rem; font-weight: 600; color: #4b5563;
            margin-bottom: 6px;
        }
        .login-group input {
            width: 100%; padding: 12px 14px; border-radius: 12px;
            border: 1.5px solid #e5e7eb; font-size: 0.9rem;
            color: #1f2937; background: #fafbfc;
            outline: none; font-family: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .login-group input:focus {
            border-color: #818cf8;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
            background: #fff;
        }
        .login-group input::placeholder { color: #c0c5ce; }
        .login-pw-wrap { position: relative; }
        .login-pw-wrap input { padding-right: 44px; }
        .login-pw-toggle {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: #9ca3af; cursor: pointer;
            font-size: 1.1rem; padding: 4px;
        }
        .login-pw-toggle:hover { color: #6b7280; }
        .login-row {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 1.5rem; font-size: 0.85rem;
        }
        .login-row label { margin: 0; display: flex; align-items: center; gap: 6px; color: #6b7280; cursor: pointer; }
        .login-row a { color: #6366f1; text-decoration: none; font-weight: 500; }
        .login-row a:hover { text-decoration: underline; }
        .btn-login {
            width: 100%; padding: 13px; border-radius: 12px;
            font-weight: 650; font-size: 0.92rem;
            color: #fff; border: none; cursor: pointer;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            box-shadow: 0 4px 16px rgba(99,102,241,0.2);
            transition: all 0.3s;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(99,102,241,0.3);
        }
        .login-footer {
            text-align: center; margin-top: 1.5rem;
            font-size: 0.85rem; color: #9ca3af;
        }
        .login-footer a { color: #6366f1; font-weight: 600; text-decoration: none; }
        .login-footer a:hover { text-decoration: underline; }
        .login-back {
            position: absolute; top: 24px; left: 24px; z-index: 10;
            display: flex; align-items: center; gap: 6px;
            color: rgba(255,255,255,0.5); text-decoration: none;
            font-size: 0.85rem; font-weight: 500;
            transition: color 0.2s;
        }
        .login-back:hover { color: rgba(255,255,255,0.8); }
        .login-alert {
            padding: 10px 14px; border-radius: 10px;
            background: #fef2f2; border: 1px solid #fecaca;
            color: #991b1b; font-size: 0.85rem;
            margin-bottom: 1.2rem;
        }
        .login-alert ul { margin: 0; padding-left: 16px; }
    </style>

    <div class="login-page">
        <a href="{{ route('home.index') }}" class="login-back">
            <i class="ri-arrow-left-line"></i> Inicio
        </a>

        <div class="login-card">
            <div class="login-logo">
                <a href="{{ route('home.index') }}">
                    <img src="{{ asset('assets/img/Alobri/Alobri-light.png') }}" alt="Alobri">
                </a>
            </div>

            <div class="login-tabs">
                <button class="login-tab active" data-target="pane-login" onclick="switchTab(this)">
                    <i class="ri-building-line"></i> Empresas
                </button>
                <button class="login-tab" data-target="pane-candidate" onclick="switchTab(this)">
                    <i class="ri-user-follow-line"></i> Candidato
                </button>
            </div>

            <!-- Tab Empresas -->
            <div class="login-pane active" id="pane-login">
                <div class="login-title">Bienvenido</div>
                <div class="login-subtitle">Inicia sesi&oacute;n para acceder a tu panel</div>

                @if(session('error'))
                    <div class="login-alert">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="login-alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="login-group">
                        <label for="email">Correo electr&oacute;nico</label>
                        <input type="email" id="email" name="email" placeholder="tu@empresa.com" autofocus required>
                    </div>
                    <div class="login-group">
                        <label for="password">Contrase&ntilde;a</label>
                        <div class="login-pw-wrap">
                            <input type="password" id="password" name="password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;" required>
                            <button type="button" class="login-pw-toggle" id="togglePw">
                                <i class="ri-eye-off-line"></i>
                            </button>
                        </div>
                    </div>
                    <div class="login-row">
                        <label>
                            <input type="checkbox" name="remember"> Recordarme
                        </label>
                    </div>
                    <button type="submit" class="btn-login">Iniciar sesi&oacute;n</button>
                </form>

                <div class="login-footer">
                    &iquest;No tienes cuenta? <a href="{{ route('register.wizard') }}">Reg&iacute;strate</a>
                </div>
            </div>

            <!-- Tab Candidato -->
            <div class="login-pane" id="pane-candidate">
                <div class="login-title">Acceso candidato</div>
                <div class="login-subtitle">Ingresa el c&oacute;digo que te proporcionaron</div>

                @if ($errors->any())
                    <div class="login-alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('validar.codigo') }}" method="POST">
                    @csrf
                    <div class="login-group">
                        <label for="codigo">C&oacute;digo de acceso</label>
                        <input type="text" id="codigo" name="codigo" placeholder="Ej: ABCD123XYZ" required
                               style="text-transform: uppercase; letter-spacing: 0.1em; font-weight: 600;">
                    </div>
                    <button type="submit" class="btn-login" style="margin-top: 1rem;">Continuar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function switchTab(btn) {
            document.querySelectorAll('.login-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.login-pane').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById(btn.dataset.target).classList.add('active');
        }

        // Toggle password
        const togglePw = document.getElementById('togglePw');
        const pwInput = document.getElementById('password');
        if (togglePw && pwInput) {
            togglePw.addEventListener('click', () => {
                const isPassword = pwInput.type === 'password';
                pwInput.type = isPassword ? 'text' : 'password';
                togglePw.querySelector('i').className = isPassword ? 'ri-eye-line' : 'ri-eye-off-line';
            });
        }

        // Auto-switch to candidate tab if hash or param indicates it
        document.addEventListener('DOMContentLoaded', () => {
            const hash = window.location.hash;
            const params = new URLSearchParams(window.location.search);
            if (hash === '#tab-candidate' || params.get('tab') === 'candidate') {
                const candTab = document.querySelector('[data-target="pane-candidate"]');
                if (candTab) switchTab(candTab);
            }
        });
    </script>
@endsection
