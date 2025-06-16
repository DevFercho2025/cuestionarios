@extends('layout.app')
@section('content')
    <!-- Loader para procesamiento -->
    <div id="registration-loader"
         style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 9999; justify-content: center; align-items: center;">
        <div class="spinner-border text-primary" role="status"></div>
    </div>

    <!-- Layout container -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    <!-- Wizard de Registro -->
                    <div id="wizard-registro" class="bs-stepper vertical mt-2">
                        <div class="bs-stepper-header gap-lg-3 border-end">
                            <div class="step" data-target="#datos-personales">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ri-user-line"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">01</span>
                                        <span class="d-flex flex-column ms-2">
                                            <span class="bs-stepper-title">Datos personales</span>
                                            <span class="bs-stepper-subtitle">Nombre y email</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#experiencia-software">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ri-computer-line"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">02</span>
                                        <span class="d-flex flex-column ms-2">
                                            <span class="bs-stepper-title">Experiencia previa</span>
                                            <span class="bs-stepper-subtitle">Software de reclutamiento</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#servicios-seleccion">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ri-service-line"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">03</span>
                                        <span class="d-flex flex-column ms-2">
                                            <span class="bs-stepper-title">Servicios</span>
                                            <span class="bs-stepper-subtitle">Opciones de contratación</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#portales-conexion">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ri-global-line"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">04</span>
                                        <span class="d-flex flex-column ms-2">
                                            <span class="bs-stepper-title">Portales</span>
                                            <span class="bs-stepper-subtitle">Plataformas de empleo</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#empresa-industria">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ri-building-line"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">05</span>
                                        <span class="d-flex flex-column ms-2">
                                            <span class="bs-stepper-title">Industria</span>
                                            <span class="bs-stepper-subtitle">Sector empresarial</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#empresa-tamano">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ri-team-line"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">06</span>
                                        <span class="d-flex flex-column ms-2">
                                            <span class="bs-stepper-title">Tamaño de empresa</span>
                                            <span class="bs-stepper-subtitle">Número de empleados</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                            <div class="line"></div>
                            <div class="step" data-target="#empresa-detalles">
                                <button type="button" class="step-trigger">
                                    <span class="bs-stepper-circle"><i class="ri-briefcase-line"></i></span>
                                    <span class="bs-stepper-label">
                                        <span class="bs-stepper-number">07</span>
                                        <span class="d-flex flex-column ms-2">
                                            <span class="bs-stepper-title">Datos de empresa</span>
                                            <span class="bs-stepper-subtitle">Información adicional</span>
                                        </span>
                                    </span>
                                </button>
                            </div>
                        </div>

                        <div class="bs-stepper-content">
                            <form id="wizard-registro-form"
                                  method="POST"
                                  action="{{ route('register.wizard.store') }}">
                                @csrf

                                <!-- Paso 1: Datos personales -->
                                <div id="datos-personales" class="content">
                                    <div class="row g-5">
                                        <div class="col-12">
                                            <h3 class="mb-0 fw-bold">Crea una cuenta gratuita</h3>
                                            <p class="mb-4">Comienza ingresando tus datos personales</p>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="user-firstname" name="firstname"
                                                       class="form-control" placeholder="John"/>
                                                <label for="user-firstname">Nombre</label>
                                            </div>
                                            <div class="text-danger small mt-1" id="firstname-error"></div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="user-lastname" name="lastname"
                                                       class="form-control" placeholder="Doe"/>
                                                <label for="user-lastname">Apellido</label>
                                            </div>
                                            <div class="text-danger small mt-1" id="lastname-error"></div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-floating form-floating-outline">
                                                <input type="email" id="user-email" name="email" class="form-control"
                                                       placeholder="john.doe@example.com"/>
                                                <label for="user-email">Correo electrónico</label>
                                            </div>
                                            <div class="text-danger small mt-1" id="email-error"></div>
                                        </div>

                                        <div class="col-sm-6 form-password-toggle">
                                            <div class="input-group input-group-merge">
                                                <div class="form-floating form-floating-outline">
                                                    <input type="password" id="user-password" class="form-control"
                                                           name="password"
                                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                                           aria-describedby="passwordToggler"/>
                                                    <label for="user-password">Contraseña</label>
                                                </div>
                                                <span id="passwordToggler" class="input-group-text cursor-pointer"><i
                                                        class="ri-eye-off-line"></i></span>
                                            </div>
                                            <div class="progress mt-1" style="height: 6px;">
                                                <div id="password-strength" class="progress-bar" role="progressbar"
                                                     style="width: 0%"></div>
                                            </div>
                                            <small class="form-text text-muted">Mínimo 8 caracteres, incluye números y
                                                letras</small>
                                            <div class="text-danger small mt-1" id="password-error"></div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-text mb-4">
                                                Al crear tu cuenta aceptas nuestras <a href="#" class="fw-semibold">políticas
                                                    de privacidad</a> y <a href="#" class="fw-semibold">términos del
                                                    servicio</a>.
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button class="btn btn-outline-secondary btn-prev" disabled>
                                                <i class="ri-arrow-left-line ri-16px me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-next" onclick="validateUserData()">
                                                <span
                                                    class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                                <i class="ri-arrow-right-line ri-16px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paso 2: Experiencia con software de reclutamiento -->
                                <div id="experiencia-software" class="content">
                                        <div class="row g-5">
                                            <div class="col-12">
                                                <h3 class="mb-0 fw-bold">¿Has utilizado un software para reclutar y
                                                    gestionar candidatos?</h3>
                                                <p class="mb-4">Tu respuesta nos ayudará a ofrecerte la mejor
                                                    configuración.</p>
                                            </div>

                                            <div class="col-12">
                                                <div class="row row-gap-3">
                                                    {{-- Opción "Sí" --}}
                                                    <div class="col-md mb-md-0">
                                                        <div class="form-check custom-option custom-option-icon">
                                                            <input
                                                                type="radio"
                                                                class="form-check-input"
                                                                name="software_experience"
                                                                id="customRadioSi"
                                                                value="1"/>
                                                            <label class="form-check-label custom-option-content"
                                                                   for="customRadioSi">
                                                              <span class="custom-option-body">
                                                                <i class="ri-check-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Sí</span>
                                                                <small>He utilizado algún software de reclutamiento o ATS previamente.</small>
                                                              </span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    {{-- Opción "No" --}}
                                                    <div class="col-md mb-md-0">
                                                        <div class="form-check custom-option custom-option-icon">
                                                            <input
                                                                type="radio"
                                                                class="form-check-input"
                                                                name="software_experience"
                                                                id="customRadioNo"
                                                                value="0"/>
                                                            <label class="form-check-label custom-option-content"
                                                                   for="customRadioNo">
                                                              <span class="custom-option-body">
                                                                <i class="ri-close-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">No</span>
                                                                <small>Será mi primera experiencia con un software de reclutamiento.</small>
                                                              </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Navegación --}}
                                            <div class="col-12 d-flex justify-content-between mt-4">
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-secondary btn-prev"
                                                    onclick="goToForm('datos-personales')">
                                                    <i class="ri-arrow-left-line ri-16px me-sm-1"></i>
                                                    <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                                </button>
                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-next"
                                                    onclick="saveSelectionAndContinue('experiencia-software','servicios-seleccion')">
                                                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                                    <i class="ri-arrow-right-line ri-16px"></i>
                                                </button>
                                            </div>
                                        </div>
                                </div>

                                <!-- Paso 3: Selección de servicios -->
                                <div id="servicios-seleccion" class="content">
                                    <div class="row g-5">
                                        <div class="col-12">
                                            <h3 class="mb-0 fw-bold">Selecciona los servicios que necesitas</h3>
                                            <p class="mb-4">Puedes elegir varias opciones a la vez.</p>
                                        </div>

                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="servicio-publicar">
                                                            <span class="custom-option-body">
                                                                <i class="ri-briefcase-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Publicar un empleo</span>
                                                                <small>Publica tus vacantes en múltiples portales de empleo.</small>
                                                            </span>
                                                            <input name="servicio[]" class="form-check-input"
                                                                   type="checkbox" value="publicar_empleo"
                                                                   id="servicio-publicar"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="servicio-psicometrias">
                                                            <span class="custom-option-body">
                                                                <i class="ri-psychology-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">Psicometrías</span>
                                                                <small>Evaluaciones cognitivas y de personalidad para candidatos.</small>
                                                            </span>
                                                            <input name="servicio[]" class="form-check-input"
                                                                   type="checkbox" value="psicometrias"
                                                                   id="servicio-psicometrias"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="servicio-integridad">
                                                            <span class="custom-option-body">
                                                                <i class="ri-shield-check-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Evaluaciones de Integridad</span>
                                                                <small>Análisis de honestidad y valores para candidatos.</small>
                                                            </span>
                                                            <input name="servicio[]" class="form-check-input"
                                                                   type="checkbox" value="integridad"
                                                                   id="servicio-integridad"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="servicio-socioeconomicos">
                                                            <span class="custom-option-body">
                                                                <i class="ri-bar-chart-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Estudios Socioeconómicos</span>
                                                                <small>Verificación de antecedentes y estudios socioeconómicos.</small>
                                                            </span>
                                                            <input name="servicio[]" class="form-check-input"
                                                                   type="checkbox" value="socioeconomicos"
                                                                   id="servicio-socioeconomicos"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="servicio-atraccion">
                                                            <span class="custom-option-body">
                                                                <i class="ri-robot-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Talentina IA + Redes</span>
                                                                <small>Bot de IA para atracción de talento en redes sociales.</small>
                                                            </span>
                                                            <input name="servicio[]" class="form-check-input"
                                                                   type="checkbox" value="atraccion"
                                                                   id="servicio-atraccion"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="servicio-clima">
                                                            <span class="custom-option-body">
                                                                <i class="ri-group-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">Clima laboral</span>
                                                                <small>Encuestas y análisis de clima laboral para tu empresa.</small>
                                                            </span>
                                                            <input name="servicio[]" class="form-check-input"
                                                                   type="checkbox" value="clima" id="servicio-clima"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="servicio-gestion">
                                                            <span class="custom-option-body">
                                                                <i class="ri-user-search-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Gestionar Candidatos</span>
                                                                <small>Sistema completo de seguimiento de candidatos (ATS).</small>
                                                            </span>
                                                            <input name="servicio[]" class="form-check-input"
                                                                   type="checkbox" value="gestion_candidatos"
                                                                   id="servicio-gestion"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-outline-secondary btn-prev"
                                                    onclick="goToForm('experiencia-software')">
                                                <i class="ri-arrow-left-line ri-16px me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-next"
                                                    onclick="checkOptionsAndContinue('servicios-seleccion', 'portales-conexion')">
                                                <span
                                                    class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                                <i class="ri-arrow-right-line ri-16px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paso 4: Publicar Empleos - Conectar Portales -->
                                <div id="portales-conexion" class="content">
                                    <div class="row g-5">
                                        <div class="col-12">
                                            <h3 class="mb-0 fw-bold">Publicar Empleos</h3>
                                            <p class="mb-4" id="form4-subtitle">Selecciona el portal para conectar:</p>
                                        </div>

                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content"
                                                               for="portal-mplus">
                                                            <span class="custom-option-body">
                                                                <i class="ri-global-line me-2"></i>
                                                                <span>
                                                                    <span
                                                                        class="custom-option-title fw-semibold d-block">MP One Plus</span>
                                                                    <small class="text-muted">Portal especializado premium</small>
                                                                </span>
                                                            </span>
                                                            <input name="portal[]" class="form-check-input"
                                                                   type="checkbox" value="mplus" id="portal-mplus"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content"
                                                               for="portal-indeed">
                                                            <span class="custom-option-body">
                                                                <i class="ri-global-line me-2"></i>
                                                                <span>
                                                                    <span
                                                                        class="custom-option-title fw-semibold d-block">Indeed</span>
                                                                    <small class="text-muted">Plataforma global de empleo</small>
                                                                </span>
                                                            </span>
                                                            <input name="portal[]" class="form-check-input"
                                                                   type="checkbox" value="indeed" id="portal-indeed"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content"
                                                               for="portal-infojobs">
                                                            <span class="custom-option-body">
                                                                <i class="ri-global-line me-2"></i>
                                                                <span>
                                                                    <span
                                                                        class="custom-option-title fw-semibold d-block">InfoJobs</span>
                                                                    <small class="text-muted">Portal líder en habla hispana</small>
                                                                </span>
                                                            </span>
                                                            <input name="portal[]" class="form-check-input"
                                                                   type="checkbox" value="infojobs"
                                                                   id="portal-infojobs"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content"
                                                               for="portal-linkedin">
                                                            <span class="custom-option-body">
                                                                <i class="ri-linkedin-box-line me-2"></i>
                                                                <span>
                                                                    <span
                                                                        class="custom-option-title fw-semibold d-block">LinkedIn</span>
                                                                    <small
                                                                        class="text-muted">Red profesional número 1</small>
                                                                </span>
                                                            </span>
                                                            <input name="portal[]" class="form-check-input"
                                                                   type="checkbox" value="linkedin"
                                                                   id="portal-linkedin"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-basic">
                                                        <label class="form-check-label custom-option-content"
                                                               for="portal-otro">
                                                            <span class="custom-option-body">
                                                                <i class="ri-add-circle-line me-2"></i>
                                                                <span>
                                                                    <span
                                                                        class="custom-option-title fw-semibold d-block">Otro portal</span>
                                                                    <small class="text-muted">Conecta con portales adicionales</small>
                                                                </span>
                                                            </span>
                                                            <input name="portal[]" class="form-check-input"
                                                                   type="checkbox" value="otro" id="portal-otro"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-outline-secondary btn-prev"
                                                    onclick="goToForm('servicios-seleccion')">
                                                <i class="ri-arrow-left-line ri-16px me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-next"
                                                    onclick="checkOptionsAndContinue('portales-conexion', 'empresa-industria')">
                                                <span
                                                    class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                                <i class="ri-arrow-right-line ri-16px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paso 5: Información de empresa (Industria) -->
                                <div id="empresa-industria" class="content">
                                    <div class="row g-5">
                                        <div class="col-12">
                                            <h3 class="mb-0 fw-bold">Información de tu empresa</h3>
                                            <p class="mb-4">Selecciona la industria de tu empresa.</p>
                                        </div>

                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-tecnologia">
                                                            <span class="custom-option-body">
                                                                <i class="ri-computer-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Tecnología</span>
                                                                <small>Desarrollo de software, IT, telecomunicaciones.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="tecnologia"
                                                                   id="industria-tecnologia"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-financiero">
                                                            <span class="custom-option-body">
                                                                <i class="ri-bank-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Servicios financieros</span>
                                                                <small>Banca, seguros, inversiones, fintech.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="financiero"
                                                                   id="industria-financiero"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-manufactura">
                                                            <span class="custom-option-body">
                                                                <i class="ri-tools-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">Manufactura</span>
                                                                <small>Producción, fabricación, industria.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="manufactura"
                                                                   id="industria-manufactura"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-salud">
                                                            <span class="custom-option-body">
                                                                <i class="ri-heart-pulse-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Salud</span>
                                                                <small>Hospitales, farmacéuticas, equipamiento médico.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="salud" id="industria-salud"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-educacion">
                                                            <span class="custom-option-body">
                                                                <i class="ri-book-open-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Educación</span>
                                                                <small>Escuelas, universidades, formación.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="educacion"
                                                                   id="industria-educacion"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-comercio">
                                                            <span class="custom-option-body">
                                                                <i class="ri-store-2-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Comercio</span>
                                                                <small>Retail, venta minorista, comercio electrónico.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="comercio"
                                                                   id="industria-comercio"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-rrhh">
                                                            <span class="custom-option-body">
                                                                <i class="ri-team-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">Recursos Humanos</span>
                                                                <small>Consultoría de RRHH, reclutamiento, outsourcing.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="recursos_humanos"
                                                                   id="industria-rrhh"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="industria-otro">
                                                            <span class="custom-option-body">
                                                                <i class="ri-more-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Otro</span>
                                                                <small>Otra industria no incluida en las opciones anteriores.</small>
                                                            </span>
                                                            <input name="industria" class="form-check-input"
                                                                   type="radio" value="otro" id="industria-otro"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-outline-secondary btn-prev"
                                                    onclick="goToForm('portales-conexion')">
                                                <i class="ri-arrow-left-line ri-16px me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-next" id="btn-industry-next"
                                                    onclick="validateIndustry()">
                                                <span
                                                    class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                                <i class="ri-arrow-right-line ri-16px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paso 6: Información de empresa (Número de empleados) -->
                                <div id="empresa-tamano" class="content">
                                    <div class="row g-5">
                                        <div class="col-12">
                                            <h3 class="mb-0 fw-bold">Información de tu empresa</h3>
                                            <p class="mb-4">Selecciona el tamaño de tu empresa según el número de
                                                empleados.</p>
                                        </div>

                                        <div class="col-12">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="empleados-1-10">
                                                            <span class="custom-option-body">
                                                                <i class="ri-user-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">1-10 empleados</span>
                                                                <small>Microempresa o startup en crecimiento.</small>
                                                            </span>
                                                            <input name="empleados" class="form-check-input"
                                                                   type="radio" value="1-10" id="empleados-1-10"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="empleados-11-50">
                                                            <span class="custom-option-body">
                                                                <i class="ri-team-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">11-50 empleados</span>
                                                                <small>Pequeña empresa.</small>
                                                            </span>
                                                            <input name="empleados" class="form-check-input"
                                                                   type="radio" value="11-50" id="empleados-11-50"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="empleados-51-200">
                                                            <span class="custom-option-body">
                                                                <i class="ri-building-2-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">51-200 empleados</span>
                                                                <small>Mediana empresa.</small>
                                                            </span>
                                                            <input name="empleados" class="form-check-input"
                                                                   type="radio" value="51-200" id="empleados-51-200"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="empleados-201-500">
                                                            <span class="custom-option-body">
                                                                <i class="ri-building-4-line ri-28px"></i>
                                                                <span
                                                                    class="custom-option-title mb-2">201-500 empleados</span>
                                                                <small>Empresa grande.</small>
                                                            </span>
                                                            <input name="empleados" class="form-check-input"
                                                                   type="radio" value="201-500" id="empleados-201-500"/>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check custom-option custom-option-icon">
                                                        <label class="form-check-label custom-option-content"
                                                               for="empleados-501">
                                                            <span class="custom-option-body">
                                                                <i class="ri-community-line ri-28px"></i>
                                                                <span class="custom-option-title mb-2">Más de 500 empleados</span>
                                                                <small>Corporación o empresa multinacional.</small>
                                                            </span>
                                                            <input name="empleados" class="form-check-input"
                                                                   type="radio" value="501+" id="empleados-501"/>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-outline-secondary btn-prev"
                                                    onclick="goToForm('empresa-industria')">
                                                <i class="ri-arrow-left-line ri-16px me-sm-1"></i>
                                                <span class="align-middle d-sm-inline-block d-none">Anterior</span>
                                            </button>
                                            <button type="button" class="btn btn-primary btn-next" id="btn-employees-next"
                                                    onclick="validateEmployees()">
                                                <span
                                                    class="align-middle d-sm-inline-block d-none me-sm-1">Siguiente</span>
                                                <i class="ri-arrow-right-line ri-16px"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paso 7: Información de empresa (Nombre y sitio web) -->
                                <div id="empresa-detalles" class="content">
                                    <div class="row g-5">
                                        {{-- Título --}}
                                        <div class="col-12">
                                            <h3 class="mb-1 fw-bold">Finalizar registro</h3>
                                            <p class="text-muted mb-4">Completa estos últimos datos para crear tu
                                                cuenta.</p>
                                        </div>

                                        {{-- Nombre de la empresa --}}
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline mb-2">
                                                <input
                                                    type="text"
                                                    id="empresa-nombre"
                                                    name="empresa_nombre"
                                                    class="form-control"
                                                    placeholder="Mi Empresa S.A."/>
                                                <label for="empresa-nombre">Nombre de la empresa</label>
                                            </div>
                                            <div class="text-danger small" id="company-name-error"></div>
                                        </div>

                                        {{-- Sitio web --}}
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline mb-2">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text">https://</span>
                                                    <input
                                                        type="text"
                                                        id="empresa-web"
                                                        name="empresa_web"
                                                        class="form-control"
                                                        placeholder="www.miempresa.com"/>
                                                    <label for="empresa-web">Sitio web</label>
                                                </div>
                                            </div>
                                            <div class="text-danger small" id="website-error"></div>
                                        </div>

                                        {{-- Cargo --}}
                                        <div class="col-12">
                                            <label class="form-label fw-semibold mb-3">¿Qué opción describe mejor tu
                                                cargo?</label>
                                            <div class="row g-3">
                                                @php
                                                    $roles = [
                                                      ['id'=>'propietario','value'=>'Propietario','icon'=>'ri-user-star-line','label'=>'Propietario'],
                                                      ['id'=>'ceo','value'=>'CEO o directivo','icon'=>'ri-briefcase-4-line','label'=>'CEO o directivo'],
                                                      ['id'=>'marketing','value'=>'Marketing','icon'=>'ri-advertisement-line','label'=>'Marketing'],
                                                      ['id'=>'gerente','value'=>'Gerente','icon'=>'ri-user-settings-line','label'=>'Gerente'],
                                                      ['id'=>'rrhh','value'=>'Equipo RRHH','icon'=>'ri-team-line','label'=>'Recursos Humanos'],
                                                      ['id'=>'coordinador','value'=>'Coordinador','icon'=>'ri-settings-3-line','label'=>'Coordinador'],
                                                    ];
                                                @endphp

                                                @foreach($roles as $role)
                                                    <div class="col-sm-6 col-md-4">
                                                        <div class="form-check custom-option custom-option-icon">
                                                            <label class="form-check-label custom-option-content"
                                                                   for="cargo-{{ $role['id'] }}">
                                                                    <span class="custom-option-body">
                                                                      <i class="{{ $role['icon'] }} ri-28px mb-2 text-primary"></i>
                                                                      <span
                                                                          class="custom-option-title">{{ $role['label'] }}</span>
                                                                    </span>
                                                                <input
                                                                    class="form-check-input"
                                                                    type="radio"
                                                                    name="cargo"
                                                                    id="cargo-{{ $role['id'] }}"
                                                                    value="{{ $role['value'] }}"/>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Otro cargo personalizado --}}
                                            <div class="mt-3">
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-secondary btn-sm"
                                                    onclick="showCustomPositionInput();">
                                                    <i class="ri-add-line me-1"></i> Ninguna describe mi cargo
                                                </button>

                                                <div id="custom-position-container" class="mt-3 d-none">
                                                    <div class="input-group">
                                                        <input
                                                            type="text"
                                                            id="custom-position"
                                                            class="form-control"
                                                            placeholder="Escribe tu cargo"/>
                                                        <button
                                                            type="button"
                                                            class="btn btn-primary"
                                                            onclick="saveCustomPosition()">
                                                            Guardar
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Navegación --}}
                                        <div class="col-12 d-flex justify-content-between mt-5">
                                            <button
                                                type="button"
                                                class="btn btn-outline-secondary btn-prev"
                                                onclick="goToForm('empresa-tamano')">
                                                <i class="ri-arrow-left-line me-1"></i> Anterior
                                            </button>
                                            <button
                                                type="submit"
                                                class="btn btn-success btn-submit"
                                                id="btn-company-next"
                                                onclick="validateCompanyInfo()">
                                                Completar registro <i class="ri-check-line ms-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!--Inputs ocultos para guardar datos-->
                                <input type="hidden" id="input-software_experience" name="software_experience">
                                <input type="hidden" id="input-servicio" name="servicio">
                                <input type="hidden" id="input-portal" name="portal">
                                <input type="hidden" id="input-industry" name="industry">
                                <input type="hidden" id="input-employees_count" name="employees_count">
                                <input type="hidden" id="input-firstname" name="firstname">
                                <input type="hidden" id="input-lastname" name="lastname">
                                <input type="hidden" id="input-email" name="email">
                                <input type="hidden" id="input-password" name="password">
                                <input type="hidden" id="input-company_name" name="company_name">
                                <input type="hidden" id="input-website" name="website">
                                <input type="hidden" id="input-position" name="position">
                            </form>
                        </div>
                    </div>
                    <!-- / Wizard de Registro -->
                </div>
                <!-- / Content -->
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>
    <!-- / Layout wrapper -->

    <!-- Resumen de registro (modal) -->
    <div class="modal fade" id="registration-summary-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">¡Registro completado con éxito!</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <div class="avatar avatar-md bg-label-success mb-3 mx-auto">
                            <i class="ri-check-double-line fs-3"></i>
                        </div>
                        <h4 class="mb-2">Tu cuenta ha sido creada</h4>
                        <p class="text-muted">Ahora puedes acceder a la plataforma y empezar a utilizarla.</p>
                    </div>

                    <div class="card shadow-none border mb-4">
                        <div class="card-header border-bottom">
                            <h5 class="card-title mb-0">Resumen de información</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm flex-shrink-0 me-3 bg-label-primary">
                                            <i class="ri-user-line"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Nombre</small>
                                            <span id="summary-name"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm flex-shrink-0 me-3 bg-label-primary">
                                            <i class="ri-mail-line"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Email</small>
                                            <span id="summary-email"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm flex-shrink-0 me-3 bg-label-primary">
                                            <i class="ri-building-line"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Empresa</small>
                                            <span id="summary-company"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm flex-shrink-0 me-3 bg-label-primary">
                                            <i class="ri-global-line"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Sitio web</small>
                                            <span id="summary-website"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm flex-shrink-0 me-3 bg-label-primary">
                                            <i class="ri-store-2-line"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Industria</small>
                                            <span id="summary-industry"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm flex-shrink-0 me-3 bg-label-primary">
                                            <i class="ri-team-line"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Tamaño</small>
                                            <span id="summary-employees"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm flex-shrink-0 me-3 bg-label-primary">
                                            <i class="ri-user-settings-line"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted d-block">Tu cargo</small>
                                            <span id="summary-position"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="/admin/login" class="btn btn-primary">Ir al inicio de sesión</a>
                </div>
            </div>
        </div>
    </div>
    </form>
    
    <!-- Scripts del wizard -->
    <script>
        // Variables para almacenar los datos del formulario
        let formData = {
            software_experience: null,
            servicio: [],
            portal: [],
            industry: null,
            employees_count: null,
            company_name: null,
            website: null,
            position: null,

            // Datos de usuario
            firstname: null,
            lastname: null,
            email: null,
            password: null,
        };

        // Función auxiliar para abrir Select2 si se cierra sin querer
        function select2Focus(e) {
            if (e.data && e.data.api) {
                const select2 = e.data.api;
                setTimeout(() => {
                    if (!select2.isOpen()) select2.open();
                }, 10);
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            // ——————————————————————————————————————————————————————————
            // Inicializar BS-Stepper
            setTimeout(() => {
                try {
                    const wizard = document.querySelector('#wizard-registro');
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

            // ——————————————————————————————————————————————————————————
            // Toggle de contraseña
            const passwordToggler = document.getElementById('passwordToggler');
            const passwordInput = document.getElementById('user-password');
            if (passwordToggler && passwordInput) {
                passwordToggler.addEventListener('click', () => {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    const icon = passwordToggler.querySelector('i');
                    icon.classList.toggle('ri-eye-line');
                    icon.classList.toggle('ri-eye-off-line');
                });
            }

            // ——————————————————————————————————————————————————————————
            // Deshabilitar botones de "Siguiente" en industria y empleados hasta selección
            const btnIndustry = document.getElementById('btn-industry-next');
            const btnEmployees = document.getElementById('btn-employees-next');
            if (btnIndustry) btnIndustry.disabled = true;
            if (btnEmployees) btnEmployees.disabled = true;

            // ——————————————————————————————————————————————————————————
            // Campos ocultos: rellenamos antes de enviar
            const form = document.getElementById('wizard-registro-form');
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                if (!validateCompanyInfo()) {
                    return; // Si la validación falla, no seguimos adelante
                }

                document.getElementById('input-software_experience').value = formData.software_experience;
                document.getElementById('input-servicio').value = JSON.stringify(formData.servicio);
                document.getElementById('input-portal').value = JSON.stringify(formData.portal);
                document.getElementById('input-industry').value = formData.industry;
                document.getElementById('input-employees_count').value = formData.employees_count;
                document.getElementById('input-firstname').value = formData.firstname;
                document.getElementById('input-lastname').value = formData.lastname;
                document.getElementById('input-email').value = formData.email;
                document.getElementById('input-password').value = formData.password;
                document.getElementById('input-company_name').value = formData.company_name;
                document.getElementById('input-website').value = formData.website;
                document.getElementById('input-position').value = formData.position;

                document.getElementById('registration-loader').style.display = 'flex';
                setTimeout(() => {
                    document.getElementById('registration-loader').style.display = 'none';

                    form.submit();
                }, 1000);

                //Mostrar el resumen por 1 minuto
                showSummaryModal();
                setTimeout(() => {
                    closeSummaryModal();
                }, 60000);

            });

            // ——————————————————————————————————————————————————————————
            // Listeners para habilitar "Siguiente" en Industria, Empleados y capturar Cargo
            Array.from(document.querySelectorAll('input[name="industria"]')).forEach(radio => {
                radio.addEventListener('change', () => {
                    formData.industry = radio.value;
                    btnIndustry.disabled = false;
                });
            });
            Array.from(document.querySelectorAll('input[name="empleados"]')).forEach(radio => {
                radio.addEventListener('change', () => {
                    formData.employees_count = radio.value;
                    btnEmployees.disabled = false;
                });
            });
            Array.from(document.querySelectorAll('input[name="cargo"]')).forEach(radio => {
                radio.addEventListener('change', () => {
                    formData.position = radio.value;
                });
            });
        });

        // ——————————————————————————————————————————————————————————
        // Paso 1: Validar datos personales
        function validateUserData() {
            document.querySelectorAll('.text-danger.small').forEach(el => el.innerText = '');
            const fn = document.getElementById('user-firstname').value.trim();
            const ln = document.getElementById('user-lastname').value.trim();
            const em = document.getElementById('user-email').value.trim();
            const pw = document.getElementById('user-password').value;

            let ok = true;
            if (!fn) {
                document.getElementById('firstname-error').innerText = 'El nombre es obligatorio';
                ok = false;
            }
            if (!ln) {
                document.getElementById('lastname-error').innerText = 'El apellido es obligatorio';
                ok = false;
            }
            if (!em) {
                document.getElementById('email-error').innerText = 'El correo es obligatorio';
                ok = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) {
                document.getElementById('email-error').innerText = 'Correo inválido';
                ok = false;
            }
            if (!pw) {
                document.getElementById('password-error').innerText = 'La contraseña es obligatoria';
                ok = false;
            } else if (pw.length < 8) {
                document.getElementById('password-error').innerText = 'Mínimo 8 caracteres';
                ok = false;
            } else {
                const str = calculatePasswordStrength(pw);
                const bar = document.getElementById('password-strength');
                bar.style.width = str + '%';
                bar.className = str < 30 ? 'progress-bar bg-danger'
                    : str < 60 ? 'progress-bar bg-warning'
                        : 'progress-bar bg-success';
            }

            if (!ok) return;
            formData.firstname = fn;
            formData.lastname = ln;
            formData.email = em;
            formData.password = pw;
            goToForm('experiencia-software');
        }

        function calculatePasswordStrength(p) {
            let s = 0;
            if (p.length >= 8) s += 25;
            if (/[a-z]/.test(p)) s += 25;
            if (/[A-Z]/.test(p)) s += 25;
            if (/[0-9]/.test(p)) s += 25;
            return s;
        }

        // ——————————————————————————————————————————————————————————
        // Navegación genérica entre pasos
        function goToForm(formId) {
            try {
                if (!window.bsStepper) return;
                const steps = Array.from(document.querySelectorAll('#wizard-registro .step'));
                const idx = steps.findIndex(s => s.dataset.target === '#' + formId);
                if (idx !== -1) window.bsStepper.to(idx + 1);
            } catch (err) {
                console.error('Stepper navigation error:', err);
            }
        }

        // ——————————————————————————————————————————————————————————
        // Paso 2
        function saveSelectionAndContinue(cur, next) {
            if (cur === 'experiencia-software') {
                const sel = document.querySelector('input[name="software_experience"]:checked');
                if (sel) formData.software_experience = sel.value;
            }
            goToForm(next);
        }

        // ——————————————————————————————————————————————————————————
        // Paso 3 & 4
        function checkOptionsAndContinue(cur, next) {
            if (cur === 'servicios-seleccion') {
                formData.servicio = Array.from(document.querySelectorAll('input[name="servicio[]"]:checked')).map(cb => cb.value);
            }
            if (cur === 'portales-conexion') {
                formData.portal = Array.from(document.querySelectorAll('input[name="portal[]"]:checked')).map(cb => cb.value);
            }
            goToForm(next);
        }

        // ——————————————————————————————————————————————————————————
        // Paso 5
        function validateIndustry() {
            const sel = document.querySelector('input[name="industria"]:checked');
            if (!sel) return alert('Por favor, selecciona una industria');
            formData.industry = sel.value;
            goToForm('empresa-tamano');
        }

        // ——————————————————————————————————————————————————————————
        // Paso 6
        function validateEmployees() {
            const sel = document.querySelector('input[name="empleados"]:checked');
            if (!sel) return alert('Por favor, selecciona el número de empleados');
            formData.employees_count = sel.value;
            goToForm('empresa-detalles');
        }

        // ——————————————————————————————————————————————————————————
        // Paso 7: Cargo personalizado
        function showCustomPositionInput() {
            document.getElementById('custom-position-container').classList.remove('d-none');
        }

        function saveCustomPosition() {
            const cp = document.getElementById('custom-position').value.trim();
            if (!cp) return alert('Por favor, ingresa tu cargo');
            formData.position = cp;
            document.getElementById('custom-position-container').classList.add('d-none');
        }

        // ——————————————————————————————————————————————————————————
        // Validación final / envío
        function validateCompanyInfo() {
            // Validar nombre de empresa
            const cn = document.getElementById('empresa-nombre').value.trim();
            const wb = document.getElementById('empresa-web').value.trim();
            // cargo ya está en formData.position o en el radio
            const pos = document.querySelector('input[name="cargo"]:checked')
                ? document.querySelector('input[name="cargo"]:checked').value
                : formData.position;

            if (!cn) return document.getElementById('company-name-error').innerText = 'El nombre es obligatorio';
            if (!pos) return alert('Por favor, selecciona tu cargo o ingresa uno personalizado');

            formData.company_name = cn;
            formData.website = wb ? 'https://' + wb : '';
            formData.position = pos;

            //Rellenar datos de resumen antes del submit real
            document.getElementById('summary-name').innerText = formData.firstname + " " + formData.lastname;
            document.getElementById('summary-email').innerText = formData.email;
            document.getElementById('summary-company').innerText = formData.company_name;
            document.getElementById('summary-website').innerText = formData.website;
            document.getElementById('summary-industry').innerText = formData.industry;
            document.getElementById('summary-employees').innerText = formData.employees_count;
            document.getElementById('summary-position').innerText = formData.position;
            //No incluye portal, servicio, ni software_experience.* Por verificar

            return true;

        }

        //Mostrar modal de resumen
        function showSummaryModal() {
            const modal = document.getElementById('registration-summary-modal');

            // Mostrar modal
            modal.classList.add('show');
            modal.style.display = 'block';
            modal.removeAttribute('aria-hidden');
            modal.setAttribute('aria-modal', 'true');

            // Crear y agregar backdrop
            const backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            backdrop.id = 'custom-modal-backdrop';
            document.body.appendChild(backdrop);

            // Evitar scroll
            document.body.classList.add('modal-open');
        }


        // Función para cerrar el modal de resumen
        function closeSummaryModal() {
            const modal = document.getElementById('registration-summary-modal');
            modal.classList.remove('show');
            modal.style.display = 'none';
            document.body.classList.remove('modal-open');

            // Eliminar backdrop
            const backdrop = document.getElementById('custom-modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        }
    </script>

@endsection

