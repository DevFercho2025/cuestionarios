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
              <p class="card-title text-primary">Este es su panel de administración para {{ Auth::user()->config->company_id?->name ?? 'Sin compañía asignada' }}</p>
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
        <h4>Añade un candidato</h4>
        <div id="wizard-registro-candidato" class="bs-stepper mt-2 linear">
          <div class="bs-stepper-header">

            <div class="step" data-target="#identificacion">
              <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                <span class="bs-stepper-label ms-lg-0">
                  <span class="d-flex flex-column gap-1 text-lg-center">
                    <span class="bs-stepper-title">Identificación</span>
                    <span class="bs-stepper-subtitle">Nombre del candidato</span>
                  </span>
                </span>
              </button>
            </div>
            <!-- aria-selected="false" o true-->
            <div class="line mt-lg-n4 mb-lg-3"></div>
            <div class="step" data-target="#detalles-personales">
              <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                <span class="bs-stepper-label ms-lg-0">
                  <span class="d-flex flex-column gap-1 text-lg-center">
                    <span class="bs-stepper-title">Detalles</span>
                    <span class="bs-stepper-subtitle">Otra información personal</span>
                  </span>
                </span>
              </button>
            </div>
            
            <div class="line mt-lg-n4 mb-lg-3"></div>
            <div class="step" data-target="#ubicacion-contacto">
              <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0">
                <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                <span class="bs-stepper-label ms-lg-0">
                  <span class="d-flex flex-column gap-1 text-lg-center">
                    <span class="bs-stepper-title">Contexto adicional</span>
                    <span class="bs-stepper-subtitle">Añade ubicación y contacto</span>
                  </span>
                </span>
              </button>
            </div>
          </div>


          <div class="bs-stepper-content">
            <form id="wizard-registro-candidato-form"
              method="POST"
              action="{{ route('candidatos.store') }}">
              @csrf

              <!--Paso 1: Nombre del candidato-->
              <div id="identificacion" class="content dstepper-block fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="content-header mb-4">
                  <h6 class="mb-0">Identificación</h6>
                </div>

                <div class="row g-5">
                  <div class="col-sm-12 fv-plugins-icon-container">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="candidate-firstName" name="firstname"
                             class="form-control" placeholder="Ingrese el nombre del candidato">
                      <label for="candidate-firstName">Nombre</label>
                    </div>
                  <div id="firstname-error" class="invalid-feedback"></div></div>
                  
                  <div class="col-sm-6">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="candidate-lastname-1" name="lastname-1"
                               class="form-control" placeholder="Ingrese el apellido paterno">
                        <label for="candidate-lastname-1">Apellido Paterno</label>
                      </div>
                    </div>
                  <div id="lastname-error" class="invalid-feedback"></div></div>
                  
                  <div class="col-sm-6">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input type="text" id="candidate-lastname-2" name="lastname-2"
                               class="form-control" placeholder="Ingrese el apellido materno">
                        <label for="candidate-lastname-2">Apellido Materno</label>
                      </div>
                      <span class="input-group-text cursor-pointer" id="NoAplica">N/A</span>
                    </div>
                  <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>


                  <div class="col-12 d-flex justify-content-between">
                    <button class="btn btn-outline-secondary btn-prev waves-effect" disabled>
                      <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-next waves-effect waves-light" id="next-step-nombre"
                      onclick="saveDataAndContinue('identificacion','detalles-personales')">
                      <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                      <i class="ri-arrow-right-line"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!-- Paso 2: Otros detalles personales -->
              <div id="detalles-personales" class="content fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="content-header mb-4">
                  <h6 class="mb-0">Detalles personales</h6>
                </div>

                <div class="row g-5">
                  <div class="col-sm-12">
                    <div class="form-floating form-floating-outline">
                      <input type="email" id="user-email" name="email"
                      class="form-control" placeholder="nombre@ejemplo.com"/>
                      <label for="user-email">Correo electrónico</label>
                    </div>
                  <div id="email-error" class="invalid-feedback"></div></div>

                  <div class="col-sm-6 fv-plugins-icon-container">
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="form-select" id="candidate-genero-legal" name="gen">
                          <option selected="">Elija una opción</option>
                          <option value="F">Femenino</option>
                          <option value="M">Masculino</option>
                        </select>
                        <label for="candidate-genero-legal">Género Legal</label>
                      </div>
                  <div id="genero-error" class="invalid-feedback"></div></div>
                  
                  <div class="col-sm-6 fv-plugins-icon-container">
                    <div class="form-floating form-floating-outline mb-6">
                      <input  type="date" id="nacimiento-candidato" name="birthdate" class="form-control">
                      <label for="nacimiento-candidato">Fecha de Nacimiento</label>
                    </div>
                  <div id="nacimiento-error" class="invalid-feedback"></div></div>

                 <div class="col-12 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary btn-prev waves-effect"
                      onclick="goToForm('identificacion')">
                      <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                    </button>
                    <button type="button" class="btn btn-primary btn-next waves-effect waves-light"
                      onclick="saveDataAndContinue('detalles-personales','ubicacion-contacto')">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                        <i class="ri-arrow-right-line"></i>
                    </button>
                  </div>
                </div>
              </div>

              <!--Paso 3: Ubicación y contacto -->
              <div id="ubicacion-contacto" class="content fv-plugins-bootstrap5 fv-plugins-framework">
                <div class="content-header mb-4">
                  <h6 class="mb-0">Contexto adicional</h6>
                  <small>Ubicación y contacto</small>
                </div>
                <div class="row g-5">
                  <div class="col-sm-12">
                    <div class="form-floating form-floating-outline mb-6">
                        <select class="form-select" id="pais-candidato" name="pais">
                          <option selected="">Elija una opción</option>
                          <option value="MX">México</option>
                          <option value="US">Estados Unidos</option>
                          <option value="ES">España</option>
                          <option value="AR">Argentina</option>
                          <option value="CO">Colombia</option>
                          <option value="CL">Chile</option>
                          <option value="PE">Perú</option>
                        </select>
                        <label for="pais-candidato">Pais</label>
                      </div>
                  <div id="pais-error" class="invalid-feedback"></div></div>
                  

                  <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                      <input type="text" id="candidate-postalcode" name="postalcode"
                      class="form-control" placeholder="Ingrese el código postal del candidato">
                      <label for="candidate-postalcode">Código Postal</label>
                    </div>
                  <div id="postalcode-error" class="invalid-feedback"></div></div>


                  <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                      <div class="input-group input-group-merge">
                        <span id="basic-icon-default-phone2" class="input-group-text"><i class="ri-phone-fill"></i></span>
                        <input type="tel" id="candidate-cellphone" name="cellphone"
                          pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/\D/g, '')"
                          class="form-control" placeholder="Ingrese el celular del candidato">
                      </div>
                    <div id="cellphone-error" class="invalid-feedback"></div></div>
                  </div>

                 <div class="col-12 d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary btn-prev waves-effect"
                      onclick="goToForm('detalles-personales')">
                      <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                      <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                    </button>
                    <button type="submit" class="btn btn-primary btn-next waves-effect waves-light"
                        onclick="validateInfo()">
                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                        <i class="ri-arrow-right-line"></i>
                    </button>
                  </div>

                </div>
              </div>

              <input type="hidden" id="input-genero_legal"     name="genero_legal" />
              <input type="hidden" id="input-nacimiento"       name="nacimiento" />
              <input type="hidden" id="input-pais"             name="pais" />
              <input type="hidden" id="input-codigo_postal"    name="codigo_postal" />
              <input type="hidden" id="input-telefono"         name="telefono" />
              <input type="hidden" id="input-firstname"        name="firstname" />
              <input type="hidden" id="input-lastname"         name="lastname" />
              <input type="hidden" id="input-email"            name="email" />
            </form>
          </div>
        </div>
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

        let formData = {
            //info adicional candidato
            genero_legal: null,
            nacimiento: null,
            pais: null,
            codigo_postal: null,
            telefono: null,

            // Datos de usuario
            firstname: null,
            lastname: null,
            email: null,
        };

      document.addEventListener('DOMContentLoaded', () => {

        // Inicializar BS-Stepper
        setTimeout(() => {
          try {
            const wizard = document.querySelector('#wizard-registro-candidato');
            if (wizard) {
              window.bsStepper = new window.Stepper(wizard, {linear: true});
              Array.from(wizard.querySelectorAll('.btn-next'))
              .filter(btn => !btn.hasAttribute('onclick'))
              .forEach(btn => btn.addEventListener('click', () => window.bsStepper.next()));
              Array.from(wizard.querySelectorAll('.btn-prev'))
              .filter(btn => !btn.hasAttribute('onclick'))
              .forEach(btn => btn.addEventListener('click', () => window.bsStepper.previous()));
            }
          } catch (err) {
            console.error('Error al inicializar el stepper:', err);
          }
        }, 500);

        // Campos ocultos: rellenar antes de enviar
        const form = document.getElementById('wizard-registro-candidato-form');
        form.addEventListener('submit', (e) => {
          e.preventDefault();
          if (!validateInfo()) {
            return;
          }
          //info adicional candidato
          document.getElementById('input-genero_legal').value = formData.genero_legal;
          document.getElementById('input-nacimiento').value = formData.nacimiento;
          document.getElementById('input-pais').value = formData.pais;
          document.getElementById('input-codigo_postal').value = formData.codigo_postal;
          document.getElementById('input-telefono').value = formData.telefono;

          // Datos de usuario
          document.getElementById('input-firstname').value = formData.firstname;
          document.getElementById('input-lastname').value = formData.lastname;
          document.getElementById('input-email').value = formData.email;
          console.log("Enviando formulario...");
          const formDataObj = new FormData(form);

          fetch(form.action, {
            method: 'POST',
            body: formDataObj, // Enviar los datos del formulario
            headers: {
              'Accept': 'application/json', // Esperamos una respuesta JSON
            }
          })
          .then(response => response.json()) // Parsear la respuesta JSON
          .then(data => {
            if (data.success) {
              // Mostrar un mensaje de éxito con SweetAlert2
              Swal.fire({
                icon: 'success',
                title: '¡Candidato creado exitosamente!',
                text: 'El candidato ha sido creado correctamente.',
                confirmButtonText: 'Aceptar'
              });
            } else {
              // Si ocurre un error, mostrar el mensaje de error con SweetAlert2
              Swal.fire({
                icon: 'error',
                title: 'Error al crear al candidato',
                text: 'Hubo un error al crear al candidato: ' + data.message,
                confirmButtonText: 'Aceptar'
              });
            }
          })
          .catch(error => {
            console.error('Error al enviar el formulario:', error);
            // Mostrar un error con SweetAlert2 en caso de que algo falle en la petición
            Swal.fire({
              icon: 'error',
              title: 'Hubo un error al enviar el formulario',
              text: 'Inténtalo nuevamente más tarde.',
              confirmButtonText: 'Aceptar'
            });
          });
        });


        const nextButtonNombre = document.getElementById('next-step-nombre');
        if (nextButtonNombre) {
          nextButtonNombre.addEventListener('click', () => {
            saveDataAndContinue('identificacion', 'detalles-personales');
          });
        }

        document.getElementById('NoAplica').addEventListener('click', function() {
          const lastname2Input = document.getElementById('candidate-lastname-2');
          lastname2Input.value = 'N/A';
        });

      });

      function goToForm(formId) {
        try {
          if (!window.bsStepper) return;
            const steps = Array.from(document.querySelectorAll('#wizard-registro-candidato .step'));
            const idx = steps.findIndex(s => s.dataset.target === '#' + formId);
          if (idx !== -1) window.bsStepper.to(idx + 1);
        } catch (err) {
          console.error('Stepper navigation error:', err);
        }
      }

      function saveDataAndContinue(cur, next) {
        let ok = true;
        if (cur === 'identificacion') {
          const fn = document.getElementById('candidate-firstName').value.trim();
          const ln1 = document.getElementById('candidate-lastname-1').value.trim();
          const ln2 = document.getElementById('candidate-lastname-2').value.trim();

          document.getElementById('firstname-error').innerText = '';
          document.getElementById('lastname-error').innerText = '';

          if (!fn) {
            document.getElementById('firstname-error').innerText = 'El nombre es obligatorio';
            ok = false;
          }
          if (!ln1) {
            document.getElementById('lastname-error').innerText = 'El primer apellido es obligatorio';
            ok = false;
          }

          formData.firstname = fn;

          if (ln2 && ln2 !== 'N/A') {
            formData.lastname = `${ln1} ${ln2}`;
          } else {
            formData.lastname = ln1;
          }
        }
        if(cur === 'detalles-personales'){
          const email = document.getElementById('user-email').value.trim();
          const genero = document.getElementById('candidate-genero-legal').value.trim();
          const nacimiento = document.getElementById('nacimiento-candidato').value.trim();

          document.getElementById('email-error').innerText = '';
          document.getElementById('genero-error').innerText = '';
          document.getElementById('nacimiento-error').innerText = '';

          if (!email) {
            document.getElementById('email-error').innerText = 'El correo electrónico es obligatorio';
            ok = false;
          }
          if (!genero || genero === 'Elija una opción') {
            document.getElementById('genero-error').innerText = 'El género es obligatorio';
            ok = false;
          }
          if (!nacimiento) {
            document.getElementById('nacimiento-error').innerText = 'La fecha de nacimiento es obligatoria';
            ok = false;
          }

          // Si todo es correcto, guarda los datos
          if (ok) {
            formData.email = email;
            formData.genero_legal = genero;
            formData.nacimiento = nacimiento;
          }
        }
        if(ok){
          goToForm(next);
        }
      }

      function validateInfo(){
        let ok=true;

          const pais = document.getElementById('pais-candidato').value.trim();
          const postalcode = document.getElementById('candidate-postalcode').value.trim();
          const cellphone = document.getElementById('candidate-cellphone').value.trim();

          document.getElementById('pais-error').innerText = '';
          document.getElementById('postalcode-error').innerText = '';
          document.getElementById('cellphone-error').innerText = '';

          if (!pais || pais === 'Elija una opción') {
            document.getElementById('pais-error').innerText = 'El país es obligatorio';
            ok = false;
          }
          if (!postalcode) {
            document.getElementById('postalcode-error').innerText = 'El código postal es obligatorio';
            ok = false;
          }
          if (!cellphone) {
            document.getElementById('cellphone-error').innerText = 'El número de celular es obligatorio';
            ok = false;
          } else if (!/^\d{10}$/.test(cellphone)) {
            document.getElementById('cellphone-error').innerText = 'El número de celular debe tener 10 dígitos';
            ok = false;
          }

          if (ok) {
            formData.pais = pais;
            formData.codigo_postal = postalcode;
            formData.telefono = cellphone;
          }

          return ok;
      }
     </script>
    
@endsection
