@extends('layout.admin')
@section('content')

    <!-- Encabezado del Dashboard -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="d-flex align-items-center row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bienvenido al Panel de Administración 🚀</h5>
                            <p class="mb-4">Gestione las diferentes secciones del sistema desde aquí.</p>

                            <a href="javascript:;" class="btn btn-sm btn-primary">Ver Estadísticas</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-right">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('/assets/img/illustrations/sitting-girl-with-laptop-light.png') }}"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png"
                                data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Módulos -->
    <div class="row">
        <!-- Secciones -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Secciones</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Gestión de Secciones</h4>
                            </div>
                            <p class="mb-0">Administre y organice las secciones del sistema</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="ri-dashboard-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('secciones.index') }}" class="btn btn-primary waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Preguntas -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Preguntas</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Banco de Preguntas</h4>
                            </div>
                            <p class="mb-0">Cree y administre las preguntas de las evaluaciones</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="ri-question-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('preguntas.index') }}" class="btn btn-info waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Respuestas -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Respuestas</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Opciones de Respuesta</h4>
                            </div>
                            <p class="mb-0">Configure las opciones de respuesta para cada pregunta</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="ri-message-3-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('respuestas.index') }}" class="btn btn-success waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Respuestas Correctas -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Respuestas Correctas</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Soluciones</h4>
                            </div>
                            <p class="mb-0">Defina las respuestas correctas para cada pregunta</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="ri-checkbox-circle-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('respuestas_correctas.index') }}" class="btn btn-warning waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Candidatos -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Candidatos</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Gestión de Participantes</h4>
                            </div>
                            <p class="mb-0">Administre la información de los candidatos evaluados</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="ri-user-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('candidatos.index') }}" class="btn btn-danger waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Evaluaciones -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span class="fw-medium d-block mb-1">Evaluaciones</span>
                            <div class="d-flex align-items-center my-2">
                                <h4 class="mb-0 me-2">Resultados y Estadísticas</h4>
                            </div>
                            <p class="mb-0">Visualice y analice los resultados de las evaluaciones</p>
                        </div>
                        <div class="avatar">
                        <span class="avatar-initial rounded bg-label-secondary">
                            <i class="ri-file-chart-line fs-4"></i>
                        </span>
                        </div>
                    </div>
                    <div class="d-grid mt-3">
                        <a href="{{ route('evaluaciones.index') }}" class="btn btn-secondary waves-effect waves-light">
                            <i class="ri-arrow-right-line me-1"></i> Gestionar
                        </a>
                    </div>
                </div>
            </div>
        </div>


        <!-- Solo si el usuario es superadmin -->
        @auth
        @if(auth()->user()->config?->is_super_admin)
        <div class="row">
            
        </div>
            <!-- Compañías -->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="fw-medium d-block mb-1">Compañías</span>
                                <div class="d-flex align-items-center my-2">
                                    <h4 class="mb-0 me-2">Gestión de Compañías</h4>
                                </div>
                                <p class="mb-0">Administre y organice las compañías asociadas</p>
                            </div>
                            <div class="avatar">
                            <span class="avatar-initial rounded" style="background-color:rgb(223, 223, 223); color:#4b4b4b">
                                <i class="ri-building-fill fs-4"></i>
                            </span>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ route('companias.index') }}" class="btn btn-dark waves-effect waves-light">
                                <i class="ri-arrow-right-line me-1"></i> Gestionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!--Usuarios-->
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="content-left">
                                <span class="fw-medium d-block mb-1">Usuarios</span>
                                <div class="d-flex align-items-center my-2">
                                    <h4 class="mb-0 me-2">Gestión de Usuarios</h4>
                                </div>
                                <p class="mb-0">Administre  la información de los diferentes usuarios del sistema</p>
                            </div>
                            <div class="avatar">
                            <span class="avatar-initial rounded" style="background-color: rgb(250, 212, 255); color:rgb(194, 56, 212)">
                                <i class="ri-user-settings-fill fs-4"></i>
                            </span>
                            </div>
                        </div>
                        <div class="d-grid mt-3">
                            <a href="{{ route('usuarios.index') }}" class="btn waves-effect waves-light" style="background-color: rgb(194, 56, 212); color:white">
                                <i class="ri-arrow-right-line me-1"></i> Gestionar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endauth


    </div>

    <!-- Estadísticas Rápidas -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="mb-0">Resumen del Sistema</h5>
                    <small class="text-muted float-end">Últimas 24 horas</small>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                    <i class="ri-user-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">45</h5>
                                    <small>Candidatos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-info me-3 p-2">
                                    <i class="ri-file-list-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">12</h5>
                                    <small>Evaluaciones</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-success me-3 p-2">
                                    <i class="ri-question-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">128</h5>
                                    <small>Preguntas</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                                <div class="badge rounded-pill bg-label-warning me-3 p-2">
                                    <i class="ri-time-line fs-5"></i>
                                </div>
                                <div class="card-info">
                                    <h5 class="mb-0">78%</h5>
                                    <small>Tasa de aprobación</small>
                                </div>
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
        $(function() {
            'use strict';

            // Aquí puedes agregar JavaScript adicional para el dashboard
            // Por ejemplo, animaciones para las tarjetas, actualizaciones de datos, etc.

            // Efecto hover para las tarjetas
            $('.card').hover(
                function() { $(this).addClass('shadow-lg'); },
                function() { $(this).removeClass('shadow-lg'); }
            );
        });
    </script>
@endsection
