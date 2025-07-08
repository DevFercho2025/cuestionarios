@extends('layout.app')
@section('content')
    <div class="container">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="javascript:void(0);" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <span>
                                    <img
                                        src="{{ asset('assets/img/Alobri/alobri-light.png') }}"
                                        alt="Logo"
                                        height="30px"
                                        class="app-brand-img"
                                        data-app-light-img="Alobri/Alobri-light.png"
                                        data-app-dark-img="Alobri/Alobri-dark.png"
                                    />
                                </span>
                            </span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <!-- Tabs de navegación -->
                        <ul class="nav nav-pills mb-4 nav-fill">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-login">
                                    <i class="ri-user-line me-1"></i> Empresas
                                </button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-candidate">
                                    <i class="ri-user-follow-line me-1"></i> Candidato
                                </button>
                            </li>
                        </ul>

                        <!-- Contenido de las pestañas -->
                        <div class="tab-content">
                            <!-- Tab Login -->
                            <div class="tab-pane fade show active" id="tab-login">
                                <h4 class="mb-2">Bienvenido 👋</h4>
                                <p class="mb-4">Inicia sesión en tu cuenta para continuar</p>

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form class="mb-3" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="form-floating form-floating-outline mb-3">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" autofocus required />
                                        <label for="email">Correo</label>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required />
                                                    <label for="password">Contraseña</label>
                                                </div>
                                                <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="remember-me" name="remember" />
                                            <label class="form-check-label" for="remember-me">Recordarme</label>
                                        </div>
                                        <a href="javascript:void(0);" class="float-end mb-1">
                                            <span>¿Olvidaste tu contraseña?</span>
                                        </a>
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary d-grid w-100" type="submit">Entrar</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Tab Candidato -->
                            <div class="tab-pane fade" id="tab-candidate">
                                <h4 class="mb-2">Acceso para candidatos 📝</h4>
                                <p class="mb-4">Ingrese el código de aplicación proporcionado</p>

                                @if ($errors->any())
                                    <div class="alert alert-danger mb-3">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('validar.codigo') }}" method="POST">
                                    @csrf
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Ingrese su código" required />
                                        <label for="codigo">Código de aplicación</label>
                                    </div>
                                    <button class="btn btn-primary d-grid w-100" type="submit">
                                        Continuar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        // Activar funcionalidad para mostrar/ocultar contraseña
        document.addEventListener('DOMContentLoaded', function() {
            const togglePasswordEle = document.querySelector('.form-password-toggle .input-group-text');
            if (togglePasswordEle) {
                togglePasswordEle.addEventListener('click', function() {
                    const passwordInput = document.querySelector('#password');
                    const eyeIcon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        eyeIcon.classList.replace('ri-eye-off-line', 'ri-eye-line');
                    } else {
                        passwordInput.type = 'password';
                        eyeIcon.classList.replace('ri-eye-line', 'ri-eye-off-line');
                    }
                });
            }

            // Si hay errores específicos para una pestaña, activar esa pestaña
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('tab') && urlParams.get('tab') === 'candidate') {
                document.querySelector('button[data-bs-target="#tab-candidate"]').click();
            }
        });
    </script>

    <script>
        //Para cuando se redirige al candidato desde un correo
        document.addEventListener('DOMContentLoaded', function () {
            const hash = window.location.hash;
            if (hash) {
                const tabTrigger = document.querySelector(`[data-bs-toggle="tab"][data-bs-target="${hash}"]`);
                if (tabTrigger) {
                    const tab = new bootstrap.Tab(tabTrigger);
                    tab.show();
                }
            }
        });
    </script>
@endsection
