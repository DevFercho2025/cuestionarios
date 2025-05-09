@extends('layout.admin')
@section('content')

<head>
  <link rel="stylesheet" href="../../assets/vendor/libs/bs-stepper/bs-stepper.css" />
</head>

    <div class="card mb-4">
        <div class="d-flex align-items-end row">
          <div class="col-md-6 order-2 order-md-1">
            <div class="card-body">
              <h4 class="card-title mb-4">Bienvenido <span class="fw-bold">{{ auth()->user()->name }}</span></h4>
              <p class="card-title text-primary">Este es su panel de administración para {{ auth()->user()->company?->name ?? 'Sin compañía asignada' }}</p>
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
      <div class="col-md-5 col-xxl-4 mb-4">
        <!-- Contenido del segundo -->
        
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
      </div>
      </div>
      <!-- Elemento más grande (60%) -->
      <div class="col-md-7 col-xxl-8 mb-4">
        <!-- Contenido del primero -->
        <h4>Añade un candidato</h4>
      <small class="text-light fw-medium">Validation</small>
      <div id="wizard-validation" class="bs-stepper mt-2 linear">
        <div class="bs-stepper-header">
          <div class="step active" data-target="#account-details-validation">
            <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0" aria-selected="true">
              <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
              <span class="bs-stepper-label ms-lg-0">
                <span class="d-flex flex-column gap-1 text-lg-center">
                  <span class="bs-stepper-title">Account Details</span>
                  <span class="bs-stepper-subtitle">Setup Account Details</span>
                </span>
              </span>
            </button>
          </div>
          <div class="line mt-lg-n4 mb-lg-3"></div>
          <div class="step" data-target="#personal-info-validation">
            <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0" aria-selected="false" disabled="disabled">
              <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
              <span class="bs-stepper-label ms-lg-0">
                <span class="d-flex flex-column gap-1 text-lg-center">
                  <span class="bs-stepper-title">Personal Info</span>
                  <span class="bs-stepper-subtitle">Add personal info</span>
                </span>
              </span>
            </button>
          </div>
          <div class="line mt-lg-n4 mb-lg-3"></div>
          <div class="step" data-target="#social-links-validation">
            <button type="button" class="step-trigger flex-lg-wrap gap-lg-2 px-lg-0" aria-selected="false" disabled="disabled">
              <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
              <span class="bs-stepper-label ms-lg-0">
                <span class="d-flex flex-column gap-1 text-lg-center">
                  <span class="bs-stepper-title">Social Links</span>
                  <span class="bs-stepper-subtitle">Add social links</span>
                </span>
              </span>
            </button>
          </div>
        </div>
        <div class="bs-stepper-content">
          <form id="wizard-validation-form" onsubmit="return false">
            <!-- Account Details -->
            <div id="account-details-validation" class="content active dstepper-block fv-plugins-bootstrap5 fv-plugins-framework">
              <div class="content-header mb-4">
                <h6 class="mb-0">Account Details</h6>
                <small>Enter Your Account Details.</small>
              </div>
              <div class="row g-5">
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="text" name="formValidationUsername" id="formValidationUsername" class="form-control" placeholder="johndoe">
                    <label for="formValidationUsername">Username</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="email" name="formValidationEmail" id="formValidationEmail" class="form-control" placeholder="john.doe@email.com" aria-label="john.doe">
                    <label for="formValidationEmail">Email</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 form-password-toggle fv-plugins-icon-container">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="formValidationPass" name="formValidationPass" class="form-control" placeholder="············" aria-describedby="formValidationPass2">
                      <label for="formValidationPass">Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer" id="formValidationPass2"><i class="ri-eye-off-line"></i></span>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 form-password-toggle fv-plugins-icon-container">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="formValidationConfirmPass" name="formValidationConfirmPass" class="form-control" placeholder="············" aria-describedby="formValidationConfirmPass2">
                      <label for="formValidationConfirmPass">Confirm Password</label>
                    </div>
                    <span class="input-group-text cursor-pointer" id="formValidationConfirmPass2"><i class="ri-eye-off-line"></i></span>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-12 d-flex justify-content-between">
                  <button class="btn btn-outline-secondary btn-prev waves-effect" disabled="">
                    <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                  </button>
                  <button class="btn btn-primary btn-next waves-effect waves-light">
                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                    <i class="ri-arrow-right-line"></i>
                  </button>
                </div>
              </div>
            </div>
            <!-- Personal Info -->
            <div id="personal-info-validation" class="content fv-plugins-bootstrap5 fv-plugins-framework">
              <div class="content-header mb-4">
                <h6 class="mb-0">Personal Info</h6>
                <small>Enter Your Personal Info.</small>
              </div>
              <div class="row g-5">
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="formValidationFirstName" name="formValidationFirstName" class="form-control" placeholder="John">
                    <label for="formValidationFirstName">First Name</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="text" id="formValidationLastName" name="formValidationLastName" class="form-control" placeholder="Doe">
                    <label for="formValidationLastName">Last Name</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline form-floating-select2">
                    <div class="position-relative"><div class="position-relative"><select class="select2 select2-hidden-accessible" id="formValidationCountry" name="formValidationCountry" tabindex="-1" aria-hidden="true" data-select2-id="formValidationCountry">
                      <option label=" " data-select2-id="27"></option>
                      <option>UK</option>
                      <option>USA</option>
                      <option>Spain</option>
                      <option>France</option>
                      <option>Italy</option>
                      <option>Australia</option>
                    </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="26" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-formValidationCountry-container"><span class="select2-selection__rendered" id="select2-formValidationCountry-container" role="textbox" aria-readonly="true"><span class="select2-selection__placeholder">Select value</span></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span></div></div>
                    <label for="formValidationCountry">Country</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline form-floating-bootstrap-select">
                    <div class="dropdown bootstrap-select show-tick w-auto"><select class="selectpicker w-auto" id="formValidationLanguage" data-style="btn-transparent" data-tick-icon="ri-check-line text-white" name="formValidationLanguage" multiple="">
                      <option>English</option>
                      <option>French</option>
                      <option>Spanish</option>
                    </select><button type="button" tabindex="-1" class="btn dropdown-toggle bs-placeholder btn-transparent" data-bs-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="false" title="Nothing selected" data-id="formValidationLanguage"><div class="filter-option"><div class="filter-option-inner"><div class="filter-option-inner-inner">Nothing selected</div></div> </div></button><div class="dropdown-menu "><div class="inner show" role="listbox" id="bs-select-2" tabindex="-1" aria-multiselectable="true"><ul class="dropdown-menu inner show" role="presentation"></ul></div></div></div>
                    <label for="formValidationLanguage">Language</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-12 d-flex justify-content-between">
                  <button class="btn btn-outline-secondary btn-prev waves-effect">
                    <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                  </button>
                  <button class="btn btn-primary btn-next waves-effect waves-light">
                    <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                    <i class="ri-arrow-right-line"></i>
                  </button>
                </div>
              </div>
            </div>
            <!-- Social Links -->
            <div id="social-links-validation" class="content fv-plugins-bootstrap5 fv-plugins-framework">
              <div class="content-header mb-4">
                <h6 class="mb-0">Social Links</h6>
                <small>Enter Your Social Links.</small>
              </div>
              <div class="row g-5">
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="text" name="formValidationTwitter" id="formValidationTwitter" class="form-control" placeholder="https://twitter.com/abc">
                    <label for="formValidationTwitter">Twitter</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="text" name="formValidationFacebook" id="formValidationFacebook" class="form-control" placeholder="https://facebook.com/abc">
                    <label for="formValidationFacebook">Facebook</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="text" name="formValidationGoogle" id="formValidationGoogle" class="form-control" placeholder="https://plus.google.com/abc">
                    <label for="formValidationGoogle">Google+</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-sm-6 fv-plugins-icon-container">
                  <div class="form-floating form-floating-outline">
                    <input type="text" name="formValidationLinkedIn" id="formValidationLinkedIn" class="form-control" placeholder="https://linkedin.com/abc">
                    <label for="formValidationLinkedIn">LinkedIn</label>
                  </div>
                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback"></div></div>
                <div class="col-12 d-flex justify-content-between">
                  <button class="btn btn-outline-secondary btn-prev waves-effect">
                    <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                    <span class="align-middle d-sm-inline-block d-none">Previous</span>
                  </button>
                  <button class="btn btn-primary btn-next btn-submit waves-effect waves-light">Submit</button>
                </div>
              </div>
            </div>
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

        const select2 = $('.select2'),
          selectPicker = $('.selectpicker');

        const wizardValidation = document.querySelector('#wizard-validation');

        if (typeof wizardValidation !== undefined && wizardValidation !== null) {
          // Wizard form
          const wizardValidationForm = wizardValidation.querySelector('#wizard-validation-form');
          // Wizard steps
          const wizardValidationFormStep1 = wizardValidationForm.querySelector('#account-details-validation');
          const wizardValidationFormStep2 = wizardValidationForm.querySelector('#personal-info-validation');
          const wizardValidationFormStep3 = wizardValidationForm.querySelector('#social-links-validation');
          // Wizard next prev button
          const wizardValidationNext = [].slice.call(wizardValidationForm.querySelectorAll('.btn-next'));
          const wizardValidationPrev = [].slice.call(wizardValidationForm.querySelectorAll('.btn-prev'));

          let validationStepper = new Stepper(wizardValidation, {
            linear: true
          });

          // Account details
          const FormValidation1 = FormValidation.formValidation(wizardValidationFormStep1, {
            fields: {
              formValidationUsername: {
                validators: {
                  notEmpty: {
                    message: 'The name is required'
                  },
                  stringLength: {
                    min: 6,
                    max: 30,
                    message: 'The name must be more than 6 and less than 30 characters long'
                  },
                  regexp: {
                    regexp: /^[a-zA-Z0-9 ]+$/,
                    message: 'The name can only consist of alphabetical, number and space'
                  }
                }
              },
              formValidationEmail: {
                validators: {
                  notEmpty: {
                    message: 'The Email is required'
                  },
                  emailAddress: {
                    message: 'The value is not a valid email address'
                  }
                }
              },
              formValidationPass: {
                validators: {
                  notEmpty: {
                    message: 'The password is required'
                  }
                }
              },
              formValidationConfirmPass: {
                validators: {
                  notEmpty: {
                    message: 'The Confirm Password is required'
                  },
                  identical: {
                    compare: function() {
                      return wizardValidationFormStep1.querySelector('[name="formValidationPass"]').value;
                    },
                    message: 'The password and its confirm are not the same'
                  }
                }
              }
            },
            plugins: {
              trigger: new FormValidation.plugins.Trigger(),
              bootstrap5: new FormValidation.plugins.Bootstrap5({
                // Use this for enabling/changing valid/invalid class
                // eleInvalidClass: '',
                eleValidClass: ''
              }),
              autoFocus: new FormValidation.plugins.AutoFocus(),
              submitButton: new FormValidation.plugins.SubmitButton()
            }
            init: instance => {
              instance.on('plugins.message.placed', function(e) {
                //* Move the error message out of the `input-group` element
                if (e.element.parentElement.classList.contains('input-group')) {
                  e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
                }
              });
            }
          }).on('core.form.valid', function() {
            // Jump to the next step when all fields in the current step are valid
            validationStepper.next();
          });

          // Personal info
          const FormValidation2 = FormValidation.formValidation(wizardValidationFormStep2, {
            fields: {
              formValidationFirstName: {
                validators: {
                  notEmpty: {
                    message: 'The first name is required'
                  }
                }
              },
              formValidationLastName: {
                validators: {
                  notEmpty: {
                    message: 'The last name is required'
                  }
                }
              },
              formValidationCountry: {
                validators: {
                  notEmpty: {
                    message: 'The Country is required'
                  }
                }
              },
              formValidationLanguage: {
                validators: {
                  notEmpty: {
                    message: 'The Languages is required'
                  }
                }
              }
            },
            plugins: {
              trigger: new FormValidation.plugins.Trigger(),
              bootstrap5: new FormValidation.plugins.Bootstrap5({
                // Use this for enabling/changing valid/invalid class
                // eleInvalidClass: '',
                eleValidClass: ''
              }),
              autoFocus: new FormValidation.plugins.AutoFocus(),
              submitButton: new FormValidation.plugins.SubmitButton()
            }
          }).on('core.form.valid', function() {
            // Jump to the next step when all fields in the current step are valid
            validationStepper.next();
          });

          // Bootstrap Select (i.e Language select)
          if (selectPicker.length) {
            selectPicker.each(function() {
              var $this = $(this);
              $this.selectpicker().on('change', function() {
                FormValidation2.revalidateField('formValidationLanguage');
              });
            });
          }

          // Select 2 (i.e Country select)
          if (select2.length) {
            select2
              .select2({
                placeholder: 'Select an country'
              })
              .on('change.select2', function() {
                // Revalidate the color field when an option is chosen
                FormValidation2.revalidateField('formValidationCountry');
              });
          }

          // Social links
          const FormValidation3 = FormValidation.formValidation(wizardValidationFormStep3, {
            fields: {
              formValidationTwitter: {
                validators: {
                  notEmpty: {
                    message: 'The Twitter URL is required'
                  },
                  uri: {
                    message: 'The URL is not proper'
                  }
                }
              },
              formValidationFacebook: {
                validators: {
                  notEmpty: {
                    message: 'The Facebook URL is required'
                  },
                  uri: {
                    message: 'The URL is not proper'
                  }
                }
              },
              formValidationGoogle: {
                validators: {
                  notEmpty: {
                    message: 'The Google URL is required'
                  },
                  uri: {
                    message: 'The URL is not proper'
                  }
                }
              },
              formValidationLinkedIn: {
                validators: {
                  notEmpty: {
                    message: 'The LinkedIn URL is required'
                  },
                  uri: {
                    message: 'The URL is not proper'
                  }
                }
              }
            },
            plugins: {
              trigger: new FormValidation.plugins.Trigger(),
              bootstrap5: new FormValidation.plugins.Bootstrap5({
                // Use this for enabling/changing valid/invalid class
                // eleInvalidClass: '',
                eleValidClass: ''
              }),
              autoFocus: new FormValidation.plugins.AutoFocus(),
              submitButton: new FormValidation.plugins.SubmitButton()
            }
          }).on('core.form.valid', function() {
            // You can submit the form
            // wizardValidationForm.submit()
            // or send the form data to server via an Ajax request
            // To make the demo simple, I just placed an alert
            alert('Submitted..!!');
          });

          wizardValidationNext.forEach(item => {
            item.addEventListener('click', event => {
              // When click the Next button, we will validate the current step
              switch (validationStepper._currentIndex) {
                case 0:
                  FormValidation1.validate();
                  break;

                case 1:
                  FormValidation2.validate();
                  break;

                case 2:
                  FormValidation3.validate();
                  break;

                default:
                  break;
              }
            });
          });

          wizardValidationPrev.forEach(item => {
            item.addEventListener('click', event => {
              switch (validationStepper._currentIndex) {
                case 2:
                  validationStepper.previous();
                  break;

                case 1:
                  validationStepper.previous();
                  break;

                case 0:

                default:
                  break;
              }
            });
          });
        }
        
    </script>
    <script src="../../assets/vendor/libs/bs-stepper/bs-stepper.js">
@endsection
