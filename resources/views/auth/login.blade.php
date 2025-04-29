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
                            <span style="color: #666cff">
                                <svg width="32" height="22" viewBox="0 0 38 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M30.0944 2.22569C29.0511 0.444187 26.7508 -0.172113 24.9566 0.849138C23.1623 1.87039 22.5536 4.14247 23.5969 5.92397L30.5368 17.7743C31.5801 19.5558 33.8804 20.1721 35.6746 19.1509C37.4689 18.1296 38.0776 15.8575 37.0343 14.076L30.0944 2.22569Z" fill="currentColor" />
                                    <path d="M30.171 2.22569C29.1277 0.444187 26.8274 -0.172113 25.0332 0.849138C23.2389 1.87039 22.6302 4.14247 23.6735 5.92397L30.6134 17.7743C31.6567 19.5558 33.957 20.1721 35.7512 19.1509C37.5455 18.1296 38.1542 15.8575 37.1109 14.076L30.171 2.22569Z" fill="url(#paint0_linear_2989_100980)" fill-opacity="0.4" />
                                    <path d="M22.9676 2.22569C24.0109 0.444187 26.3112 -0.172113 28.1054 0.849138C29.8996 1.87039 30.5084 4.14247 29.4651 5.92397L22.5251 17.7743C21.4818 19.5558 19.1816 20.1721 17.3873 19.1509C15.5931 18.1296 14.9843 15.8575 16.0276 14.076L22.9676 2.22569Z" fill="currentColor" />
                                    <path d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z" fill="currentColor" />
                                    <path d="M14.9558 2.22569C13.9125 0.444187 11.6122 -0.172113 9.818 0.849138C8.02377 1.87039 7.41502 4.14247 8.45833 5.92397L15.3983 17.7743C16.4416 19.5558 18.7418 20.1721 20.5361 19.1509C22.3303 18.1296 22.9391 15.8575 21.8958 14.076L14.9558 2.22569Z" fill="url(#paint1_linear_2989_100980)" fill-opacity="0.4" />
                                    <path d="M7.82901 2.22569C8.87231 0.444187 11.1726 -0.172113 12.9668 0.849138C14.7611 1.87039 15.3698 4.14247 14.3265 5.92397L7.38656 17.7743C6.34325 19.5558 4.04298 20.1721 2.24875 19.1509C0.454514 18.1296 -0.154233 15.8575 0.88907 14.076L7.82901 2.22569Z" fill="currentColor" />
                                    <defs>
                                        <linearGradient id="paint0_linear_2989_100980" x1="5.36642" y1="0.849138" x2="10.532" y2="24.104" gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-opacity="1" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                        <linearGradient id="paint1_linear_2989_100980" x1="5.19475" y1="0.849139" x2="10.3357" y2="24.1155" gradientUnits="userSpaceOnUse">
                                            <stop offset="0" stop-opacity="1" />
                                            <stop offset="1" stop-opacity="0" />
                                        </linearGradient>
                                    </defs>
                                </svg>
                            </span>
                        </span>
                                <span class="app-brand-text demo text-heading fw-bold">Sistema</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <!-- Tabs de navegación -->
                        <ul class="nav nav-pills mb-4 nav-fill">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-login">
                                    <i class="ri-user-line me-1"></i> Administrador
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
@endsection
