@extends('layout.admin')
@section('content')

<head>
  <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.min.css" rel="stylesheet">

</head>

    <div class="card mb-4">
        <div class="d-flex align-items-end row">
          <div class="col-md-6 order-2 order-md-1">
            <div class="card-body">
              <h4 class="card-title mb-4">Bienvenido <span class="fw-bold">{{ auth()->user()->name }}</span></h4>
              <p class="card-title text-primary">Este es su panel de administración para {{ Auth::user()->config->Company->name ?? 'Sin compañía asignada' }}</p>
              <p class="mb-4">Gestione las diferentes secciones del sistema desde aquí.</p>
            </div>
          </div>
          <div class="col-md-6 text-center text-md-end order-1 order-md-2">
            <div class="card-body pb-0 px-0 pt-2">
              <img src="../../assets/img/illustrations/illustration-john-dark.png" height="186" class="scaleX-n1-rtl" alt="View Profile" data-app-light-img="illustrations/illustration-john-light.png" data-app-dark-img="illustrations/illustration-john-dark.png">
            </div>
          </div>
        </div>
      </div>


    <!--Pruebas disponibles-->
    <div class="row g-6 mb-6">
        <div class="col-sm-6 col-lg-3">
          <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-4">
                  <span class="avatar-initial rounded-3 bg-label-primary"><i class="ri-car-line ri-24px"></i></span>
                </div>
                <h4 class="mb-0">1</h4>
              </div>
              <h6 class="mb-0 fw-normal">Pruebas Psicométricas Disponibles</h6>
              <p class="mb-0">
                <!--<span class="me-1 fw-medium">+4.3%</span>-->
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-4">
                  <span class="avatar-initial rounded-3 bg-label-danger"><i class="ri-route-line ri-24px"></i></span>
                </div>
                <h4 class="mb-0">0</h4>
              </div>
              <h6 class="mb-0 fw-normal">Pruebas Piscométricas Realizadas</h6>
              <p class="mb-0">
                <!--<span class="me-1 fw-medium">+4.3%</span>-->
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card card-border-shadow-info h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-4">
                  <span class="avatar-initial rounded-3 bg-label-info"><i class="ri-time-line ri-24px"></i></span>
                </div>
                <h4 class="mb-0">0</h4>
              </div>
              <h6 class="mb-0 fw-normal">Pruebas Socioeconómicas Disponibles</h6>
              <p class="mb-0">
                <!--<span class="me-1 fw-medium">+4.3%</span>-->
              </p>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
              <div class="d-flex align-items-center mb-2">
                <div class="avatar me-4">
                  <span class="avatar-initial rounded-3 bg-label-warning"><i class="ri-alert-line ri-24px"></i></span>
                </div>
                <h4 class="mb-0">0</h4>
              </div>
              <h6 class="mb-0 fw-normal">Pruebas Socioeconómicas Realizadas</h6>
              <p class="mb-0">
                <!--<span class="me-1 fw-medium">+4.3%</span>-->
              </p>
            </div>
          </div>
        </div>

    </div>
    
    
    <div class="row">
      <!--Elemento pequeño (40%) -->
      <div class="col-md-5 col-xxl-4 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h5 class="card-title m-0 me-2">Estadísticas de Vacantes</h5>
              <div class="dropdown">
                <button class="btn btn-text-secondary rounded-pill text-muted border-0 p-1 waves-effect waves-light" type="button" id="projectStatus" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="ri-more-2-line ri-20px"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="projectStatus">
                  <a class="dropdown-item waves-effect" href="javascript:void(0);">Entry level</a>
                  <a class="dropdown-item waves-effect" href="javascript:void(0);">Senior level</a>
                  <a class="dropdown-item waves-effect" href="javascript:void(0);">Ejecutivo</a>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-between p-4 border-bottom">
              <p class="mb-0 fs-xsmall">Vacante</p>
              <p class="mb-0 fs-xsmall">Cantidad de Postulados</p>
            </div>
            <div class="card-body">
              <ul class="p-0 m-0">
                <li class="d-flex align-items-center mb-6">
                  <div class="avatar avatar-md flex-shrink-0 me-4">
                    <div class="avatar-initial bg-light-gray rounded-3">
                      <div>
                        <img src="../../assets/img/icons/misc/3d-illustration.png" alt="User" class="h-25">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-1">Especialista en CiberSeguridad</h6>
                      <small>Para área de IT</small>
                    </div>
                    <div class="badge bg-label-primary rounded-pill">30</div>
                  </div>
                </li>
                <li class="d-flex align-items-center mb-6">
                  <div class="avatar avatar-md flex-shrink-0 me-4">
                    <div class="avatar-initial bg-light-gray rounded-3">
                      <div>
                        <img src="../../assets/img/icons/misc/finance-app-design.png" alt="User" class="h-25">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-1">Diseñador UI/UX</h6>
                      <small>Para área de Tecnología</small>
                    </div>
                    <div class="badge bg-label-primary rounded-pill">20</div>
                  </div>
                </li>
                <li class="d-flex align-items-center mb-6">
                  <div class="avatar avatar-md flex-shrink-0 me-4">
                    <div class="avatar-initial bg-light-gray rounded-3">
                      <div>
                        <img src="../../assets/img/icons/misc/4-square.png" alt="User" class="h-25">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-1">Analista Contable</h6>
                      <small>Para área de Administración y Finanzasn</small>
                    </div>
                    <div class="badge bg-label-primary rounded-pill">10</div>
                  </div>
                </li>
                <li class="d-flex align-items-center mb-6">
                  <div class="avatar avatar-md flex-shrink-0 me-4">
                    <div class="avatar-initial bg-light-gray rounded-3">
                      <div>
                        <img src="../../assets/img/icons/misc/delta-web-app.png" alt="User" class="h-25">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-1">Enfermero</h6>
                      <small>Para área de Urgencias</small>
                    </div>
                    <div class="badge bg-label-primary rounded-pill">40</div>
                  </div>
                </li>
                <li class="d-flex align-items-center">
                  <div class="avatar avatar-md flex-shrink-0 me-4">
                    <div class="avatar-initial bg-light-gray rounded-3">
                      <div>
                        <img src="../../assets/img/icons/misc/ecommerce-website.png" alt="User" class="h-25">
                      </div>
                    </div>
                  </div>
                  <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                    <div class="me-2">
                      <h6 class="mb-1">Técnico en equipos biométicos</h6>
                      <small>Para área de Manteminiento biomédico</small>
                    </div>
                    <div class="badge bg-label-primary rounded-pill">5</div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
          <!--Termina Estadísticas de pruebas-->
        <div class="row">
          <!--Este row es importante-->
        </div>
      </div>

      <!-- Elemento más grande (60%) -->
      <div class="col-md-7 col-xxl-8 mb-4">
        <!-- Contenido del primero -->
        @include ('partials.form_crear_candidato')
      </div>
      <!-- Elemento más pequeño (40%) -->
      

    </div>
    

    <!--Estadísticas de vacantes-->
    <div class="row g-6 mb-6">
          <!-- Solo si el usuario es superadmin -->
        @auth
            @if(auth()->user()->config?->role?->isSuperAdmin())
                
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

  <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.2/dist/sweetalert2.all.min.js"></script>

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
