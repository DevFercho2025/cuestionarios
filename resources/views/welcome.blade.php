@extends('layout.app')

@section('content')
    <head>
        <link rel="stylesheet" href="../../assets/vendor/css/pages/front-page-landing.css">
    </head>

    <nav class="layout-navbar container shadow-none py-0" style="background-color:rgba(0, 0, 0, 0.651)">
      <div class="navbar navbar-expand-lg landing-navbar border-top-0 px-4 px-md-8">
        <!-- Menu logo-->
        <div class="navbar-brand app-brand demo d-flex py-0 py-lg-2 me-6">
            <!-- Mobile menu toggle: Start-->
            <button class="navbar-toggler border-0 px-0 me-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="tf-icons ri-menu-fill ri-24px align-middle"></i>
            </button>
            <!-- Mobile menu toggle: End-->
            <a href="{{ route('home.index') }}" class="app-brand-link">
                <img style="height: 35px"
                    src="{{ asset('assets/img/Alobri/alobri-light.png') }}"
                    alt="Logo"
                    height="30px"
                    class="app-brand-img"
                    data-app-light-img="Alobri/Alobri-light.png"
                    data-app-dark-img="Alobri/Alobri-dark.png"
                />
            </a>
        </div>
        <!-- / Menu logo-->

        <!-- Menu wrapper: Start -->
        <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
          <button class="navbar-toggler border-0 text-heading position-absolute end-0 top-0 scaleX-n1-rtl" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="tf-icons ri-close-fill"></i>
          </button>
          <ul class="navbar-nav me-auto p-4 p-lg-0">
            <li class="nav-item">
              <a class="nav-link fw-medium"href="#overview">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium" href="#services">Servicios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium" href="#process">Proceso</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium" href="#testimonials">Testimonios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link fw-medium" href="#contacto">Contáctenos</a>
            </li>
          </ul>
        </div>
        <div class="landing-menu-overlay d-lg-none"></div>
        <!-- Menu wrapper: End -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- Style Switcher -->
          <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
            <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow me-sm-4 waves-effect waves-light" href="javascript:void(0);" data-bs-toggle="dropdown">
              <i class="ri-22px text-heading ri-computer-line"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
              <li>
                <a class="dropdown-item waves-effect" href="javascript:void(0);" data-theme="light">
                  <span class="align-middle"><i class="ri-sun-line ri-22px me-3"></i>Light</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item waves-effect" href="javascript:void(0);" data-theme="dark">
                  <span class="align-middle"><i class="ri-moon-clear-line ri-22px me-3"></i>Dark</span>
                </a>
              </li>
              <li>
                <a class="dropdown-item waves-effect" href="javascript:void(0);" data-theme="system">
                  <span class="align-middle"><i class="ri-computer-line ri-22px me-3"></i>System</span>
                </a>
              </li>
            </ul>
          </li>
          <!-- / Style Switcher-->
            @guest
                <li>
                    <a href="{{ route('register.wizard') }}" class="btn btn-secondary px-2 px-sm-4 px-lg-2 px-xl-4 waves-effect waves-light me-4" target="_blank">
                        <span class="tf-icons ri-user-line me-md-1"></span>
                        <span class="d-none d-md-block">Registrarse</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('login') }}" class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4 waves-effect waves-light" target="_blank">
                        <span class="ri-user-shared-2-fill me-md-1"></span>
                        <span class="d-none d-md-block">Iniciar Sesión</span>
                    </a>
                </li>
            @else
                <li>
                    <a href="/psicometricas/admin" class="btn btn-primary px-2 px-sm-4 px-lg-2 px-xl-4 waves-effect waves-light">
                        <span class="ri-dashboard-fill me-md-1"></span>
                        <span class="d-none d-md-block">Panel de Control</span>
                    </a>
                </li>
            @endguest
        </ul>
      </div>
    </nav>


     <section id="landingHero" class="section-py landing-hero position-relative">
        <img alt="hero background" class="position-absolute top-0 start-0 w-100 h-100 z-n1" data-speed="1" data-app-light-img="front-pages/backgrounds/hero-bg-light.png" data-app-dark-img="front-pages/backgrounds/hero-bg-dark.png">
        <div class="container">
          <div class="hero-text-box text-center pb-4">
            <h3 class="text-primary hero-title fs-2 pt-4">Evaluaciones psicométricas profesionales</h3>
            <h2 class="h6 mb-8 mt-4">
              Soluciones confiables para la selección y<br>desarrollo de talento con resultados validados científicamente.
            </h2>
            <a href="#contacto" class="btn btn-lg btn-primary waves-effect waves-light">Solicitar información</a>
          </div>
          <div class="position-relative hero-animation-img mb-1">
            <a href="#">
                <!--Aquí imagen principal de atrás-->
              <div class="hero-dashboard-img text-center">
                <img src="../../assets/img/front-pages/landing-page/hero-dashboard-dark.png" alt="hero dashboard" class="animation-img" data-speed="2" data-app-light-img="front-pages/landing-page/hero-dashboard-light.png" data-app-dark-img="front-pages/landing-page/hero-dashboard-dark.png" style="transform: translate(-11.97px, 6.47px);">
              </div>
              <!--Aquí imágenes encima-->
              <div class="position-absolute hero-elements-img">
                <img src="../../assets/img/front-pages/landing-page/hero-elements-dark.png" alt="hero elements" class="animation-img" data-speed="4" data-app-light-img="front-pages/landing-page/hero-elements-light.png" data-app-dark-img="front-pages/landing-page/hero-elements-dark.png" style="transform: translate(-35.93px, 0.95px);">
              </div>
            </a>
          </div>
        </div>
      </section>

    <div class="row" id="overview">
        <section id="landingFeatures" class="section-py landing-features">
            <div class="container">

            <h5 class="text-center mb-2">
                <span class="display-5 fs-4 fw-bold">Evaluación psicométrica de clase mundial</span>
            </h5>
            <p class="text-center fw-medium mb-4 mb-md-12">
                Nuestro sistema permite evaluar eficazmente las habilidades, aptitudes y rasgos de personalidad de candidatos y colaboradores <br> utilizando metodologías validadas científicamente y respaldadas por investigación internacional.
            </p>
            <div class="features-icon-wrapper row gx-0 gy-12 gx-sm-6 mt-n4 mt-sm-0">
                <div class="col-lg-3 col-sm-6 text-center features-icon-box">
                    <div class="features-icon mb-4">
                    <i class="ri-check-double-line fs-3 lh-0"></i>
                    </div>
                    <h5 class="mb-2">99.8%</h5>
                    <p class="features-icon-description">Precisión</p>
                </div>
                <div class="col-lg-3 col-sm-6 text-center features-icon-box">
                    <div class="features-icon mb-4">
                    <i class="ri-time-line fs-3 lh-0"></i>
                    </div>
                    <h5 class="mb-2">24-48h</h5>
                    <p class="features-icon-description">Entrega</p>
                </div>
                <div class="col-lg-3 col-sm-6 text-center features-icon-box">
                    <div class="features-icon mb-4">
                    <i class="ri-award-line fs-3 lh-0"></i>
                    </div>
                    <h5 class="mb-2">ISO 9001</h5>
                    <p class="features-icon-description">Certificación</p>
                </div>
                <div class="col-lg-3 col-sm-6 text-center features-icon-box">
                    <div class="features-icon mb-4">
                    <i class="ri-global-line fs-3 lh-0"></i>
                    </div>
                    <h5 class="mb-2">12+</h5>
                    <p class="features-icon-description">Países</p>
                </div>
                </div>
            </div>
      </section>  
    </div>
      

    <!-- Page Header original
    <div class="row" id="header">
        <div class="col-12">
            <div class="card bg-primary mb-4 ">
                <div class="d-flex align-items-end row">
                    <div class="col-md-7">
                        <div class="card-body">
                            <h4 class="card-title text-white mb-2">Evaluaciones psicométricas profesionales</h4>
                            <p class="card-text text-white mb-3">Soluciones confiables para la selección y desarrollo de talento con resultados validados científicamente.</p>
                            <a href="#contacto" class="btn btn-secondary waves-effect waves-light">Solicitar información</a>
                        </div>
                    </div>
                    <div class="col-md-5 text-center text-md-end">
                        <div class="card-body pb-0 px-0 px-md-4 d-none d-md-block">
                            <img src="{/{ asset('/assets/img/illustrations/man-with-laptop-light.png') }}"
                                 height="140"
                                 alt="View Profile"
                                 data-app-light-img="illustrations/man-with-laptop-light.png"
                                 data-app-dark-img="illustrations/man-with-laptop-dark.png">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->

    <!-- Overview Section
    <div class="row" id="overview">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-start mb-3">
                        <div class="badge bg-label-primary p-2 rounded me-3">
                            <i class="ri-mind-map fs-4 lh-0"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Evaluación psicométrica de clase mundial</h5>
                            <p class="mb-0">
                                Nuestro sistema permite evaluar eficazmente las habilidades, aptitudes y rasgos de personalidad
                                de candidatos y colaboradores utilizando metodologías validadas científicamente y respaldadas por
                                investigación internacional.
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row text-center">
                        <div class="col-md-3 col-6 mb-3">
                            <div class="mb-2">
                            <span class="badge rounded-pill bg-label-primary p-2">
                                <i class="ri-check-double-line fs-3 lh-0"></i>
                            </span>
                            </div>
                            <h6 class="mb-1">99.8%</h6>
                            <p class="text-muted mb-0">Precisión</p>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="mb-2">
                            <span class="badge rounded-pill bg-label-info p-2">
                                <i class="ri-time-line fs-3 lh-0"></i>
                            </span>
                            </div>
                            <h6 class="mb-1">24-48h</h6>
                            <p class="text-muted mb-0">Entrega</p>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="mb-2">
                            <span class="badge rounded-pill bg-label-success p-2">
                                <i class="ri-award-line fs-3 lh-0"></i>
                            </span>
                            </div>
                            <h6 class="mb-1">ISO 9001</h6>
                            <p class="text-muted mb-0">Certificación</p>
                        </div>
                        <div class="col-md-3 col-6 mb-3">
                            <div class="mb-2">
                            <span class="badge rounded-pill bg-label-warning p-2">
                                <i class="ri-global-line fs-3 lh-0"></i>
                            </span>
                            </div>
                            <h6 class="mb-1">12+</h6>
                            <p class="text-muted mb-0">Países</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->


    <!-- Services Section -->
    <div class="row" id="services">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Nuestros Servicios</h5>
                    <small class="text-muted float-end">Soluciones integrales de evaluación</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="card shadow-none bg-label-primary bg-hover-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ri-stack-line fs-1 me-2"></i>
                                        <h5 class="card-title mb-0">Evaluación de competencias</h5>
                                    </div>
                                    <p class="card-text">Identificamos las habilidades y capacidades clave para predecir el desempeño laboral exitoso con pruebas validadas internacionalmente.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary">Más información</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="card shadow-none bg-label-info bg-hover-info h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ri-user-heart-line fs-1 me-2"></i>
                                        <h5 class="card-title mb-0">Test de personalidad</h5>
                                    </div>
                                    <p class="card-text">Análisis profundo de rasgos de personalidad para identificar compatibilidad con roles específicos y cultura organizacional.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info">Más información</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="card shadow-none bg-label-success bg-hover-success h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ri-heart-pulse-line fs-1 me-2"></i>
                                        <h5 class="card-title mb-0">Inteligencia emocional</h5>
                                    </div>
                                    <p class="card-text">Medición de capacidades emocionales clave para liderazgo, trabajo en equipo y gestión de relaciones interpersonales.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-success">Más información</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="card shadow-none bg-label-warning bg-hover-warning h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ri-brain-line fs-1 me-2"></i>
                                        <h5 class="card-title mb-0">Evaluación cognitiva</h5>
                                    </div>
                                    <p class="card-text">Medición de aptitudes cognitivas como razonamiento lógico, verbal y numérico para roles que requieren capacidad analítica.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-warning">Más información</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="card shadow-none bg-label-danger bg-hover-danger h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ri-community-line fs-1 me-2"></i>
                                        <h5 class="card-title mb-0">Clima laboral</h5>
                                    </div>
                                    <p class="card-text">Diagnóstico del ambiente organizacional para identificar fortalezas y áreas de oportunidad en la satisfacción del personal.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger">Más información</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4 mb-3">
                            <div class="card shadow-none bg-label-secondary bg-hover-secondary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="ri-team-line fs-1 me-2"></i>
                                        <h5 class="card-title mb-0">Assessment Center</h5>
                                    </div>
                                    <p class="card-text">Evaluación integral mediante dinámicas grupales y ejercicios prácticos para medir competencias en situaciones reales.</p>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary">Más información</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card h-100">
                  <div class="card-body text-body d-flex flex-column justify-content-between text-center p-8">
                    <div class="mb-4">
                      <img src="../../assets/img/front-pages/branding/logo-4.png" alt="client logo" class="client-logo img-fluid">
                    </div>
                    <h6>
                      “I've never used a theme as versatile and flexible as Vuexy. It's my go to for building dashboard
                      sites on almost any project.”
                    </h6>
                    <div class="text-warning mb-4">
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                      <i class="tf-icons ri-star-fill ri-24px"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Eugenia Moore</h6>
                      <p class="mb-0 small">Founder of Hubspot</p>
                    </div>
                  </div>
                </div>
    <!-- Process Section -->
    <div class="row" id="process">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Nuestro Proceso</h5>
                    <small class="text-muted float-end">Metodología de 4 etapas</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="timeline">
                                <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-primary">
                                    <i class="ri-discuss-line"></i>
                                </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">1. Consulta inicial</h6>
                                        </div>
                                        <p class="mb-2">Analizamos sus necesidades específicas y definimos el perfil ideal para cada posición.</p>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-info">
                                    <i class="ri-file-list-line"></i>
                                </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">2. Selección de pruebas</h6>
                                        </div>
                                        <p class="mb-2">Diseñamos una batería de evaluaciones personalizada según los requerimientos y competencias a evaluar.</p>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-success">
                                    <i class="ri-test-tube-line"></i>
                                </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">3. Aplicación y análisis</h6>
                                        </div>
                                        <p class="mb-2">Administramos las pruebas y procesamos los resultados con algoritmos especializados.</p>
                                    </div>
                                </li>
                                <li class="timeline-item timeline-item-transparent">
                                <span class="timeline-point timeline-point-warning">
                                    <i class="ri-file-chart-line"></i>
                                </span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-1">
                                            <h6 class="mb-0">4. Entrega de resultados</h6>
                                        </div>
                                        <p class="mb-2">Proporcionamos informes detallados y asesoramiento para la toma de decisiones.</p>
                                    </div>
                                </li>
                                <li class="timeline-end-indicator">
                                    <i class="ri-check-fill"></i>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="row" id="testimonials">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Testimonios</h5>
                    <small class="text-muted float-end">Lo que dicen nuestros clientes</small>
                </div>
                <div class="card-body">
                    <div class="swiper-container swiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body text-center">
                                        <div class="avatar avatar-md mx-auto mb-3">
                                            <span class="avatar-initial rounded-circle bg-primary">MR</span>
                                        </div>
                                        <h5 class="mb-1">María Rodríguez</h5>
                                        <p class="text-muted small mb-3">Directora de RH, Tecnológica Innovadora</p>
                                        <div class="mb-3">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                        </div>
                                        <p class="mb-0">"Las evaluaciones psicométricas han sido fundamentales para mejorar nuestro proceso de selección. Hemos reducido la rotación en un 35% desde que implementamos este sistema."</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body text-center">
                                        <div class="avatar avatar-md mx-auto mb-3">
                                            <span class="avatar-initial rounded-circle bg-info">CM</span>
                                        </div>
                                        <h5 class="mb-1">Carlos Méndez</h5>
                                        <p class="text-muted small mb-3">Gerente de Talento, Grupo Financiero</p>
                                        <div class="mb-3">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                        </div>
                                        <p class="mb-0">"La precisión de los informes y la rapidez del servicio nos ha permitido optimizar nuestros procesos de reclutamiento. Un aliado estratégico para nuestro departamento."</p>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card border shadow-none h-100">
                                    <div class="card-body text-center">
                                        <div class="avatar avatar-md mx-auto mb-3">
                                            <span class="avatar-initial rounded-circle bg-success">AG</span>
                                        </div>
                                        <h5 class="mb-1">Ana Gómez</h5>
                                        <p class="text-muted small mb-3">VP de Desarrollo Organizacional, Multinacional</p>
                                        <div class="mb-3">
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                            <i class="ri-star-fill text-warning"></i>
                                        </div>
                                        <p class="mb-0">"Los assessment centers personalizados nos han ayudado a identificar líderes potenciales dentro de nuestra organización, fortaleciendo nuestro plan de sucesión."</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="row" id="cta">
        <div class="col-12">
            <div class="card bg-primary mb-4">
                <div class="card-body p-4 text-center">
                    <h4 class="text-white mb-3">Mejore sus procesos de selección y desarrollo</h4>
                    <p class="text-white mb-4">Contáctenos hoy para una consulta personalizada sobre cómo nuestras evaluaciones psicométricas pueden beneficiar a su organización.</p>
                    <a href="#contacto" class="btn btn-secondary waves-effect waves-float waves-light">Solicitar demostración gratuita</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="row" id="contacto">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Contáctenos</h5>
                    <small class="text-muted float-end">Estamos aquí para ayudarle</small>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5 mb-4 mb-md-0">
                            <div class="card shadow-none bg-label-primary h-100">
                                <div class="card-body">
                                    <h5 class="card-title">Información de contacto</h5>
                                    <p class="card-text mb-4">Nuestro equipo de expertos está disponible para atender todas sus consultas.</p>

                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                        <span class="badge bg-label-primary rounded p-2">
                                            <i class="ri-map-pin-2-line"></i>
                                        </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Dirección</h6>
                                            <small class="text-muted">Av. Insurgentes Sur 1602, Benito Juárez, 03940 CDMX</small>
                                        </div>
                                    </div>

                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                        <span class="badge bg-label-primary rounded p-2">
                                            <i class="ri-phone-line"></i>
                                        </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Teléfono</h6>
                                            <small class="text-muted">+52 (55) 5555-5555</small>
                                        </div>
                                    </div>

                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                        <span class="badge bg-label-primary rounded p-2">
                                            <i class="ri-mail-line"></i>
                                        </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Correo electrónico</h6>
                                            <small class="text-muted">contacto@psicoeval.com</small>
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                        <span class="badge bg-label-primary rounded p-2">
                                            <i class="ri-time-line"></i>
                                        </span>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">Horario de atención</h6>
                                            <small class="text-muted">Lunes a Viernes: 9:00 AM - 6:00 PM</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <form method="POST" action="#">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre completo" required>
                                            <label for="name">Nombre completo</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Correo electrónico" required>
                                            <label for="email">Correo electrónico</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="text" class="form-control" id="company" name="company" placeholder="Empresa">
                                            <label for="company">Empresa</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline">
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Teléfono">
                                            <label for="phone">Teléfono</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <select class="form-select" id="service" name="service">
                                                <option value="" selected disabled>Seleccione un servicio</option>
                                                <option value="competencias">Evaluación de competencias</option>
                                                <option value="personalidad">Test de personalidad</option>
                                                <option value="inteligencia">Inteligencia emocional</option>
                                                <option value="cognitiva">Evaluación cognitiva</option>
                                                <option value="clima">Clima laboral</option>
                                                <option value="assessment">Assessment Center</option>
                                                <option value="otro">Otro</option>
                                            </select>
                                            <label for="service">Servicio de interés</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating form-floating-outline">
                                            <textarea class="form-control" id="message" name="message" style="height: 150px" placeholder="Mensaje" required></textarea>
                                            <label for="message">Mensaje</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                                            <label class="form-check-label" for="terms">
                                                He leído y acepto los <a href="javascript:void(0)">términos y condiciones</a> y la <a href="javascript:void(0)">política de privacidad</a>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary waves-effect me-sm-3 me-1">
                                            <span class="fw-medium d-none d-sm-inline-block">Enviar mensaje</span>
                                            <i class="ri-send-plane-line"></i>
                                        </button>
                                        <button type="reset" class="btn btn-label-secondary waves-effect">Limpiar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Section -->
    <div class="row" id="clients">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Clientes que confían en nosotros</h5>
                    <small class="text-muted float-end">Empresas líderes</small>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-2 col-4 text-center">
                            <div class="client-logo">
                                <div class="client-overlay">
                                    <img src="{{ asset('/assets/img/logos/placeholder-logo-1.png') }}"
                                         class="img-fluid"
                                         alt="Client 1">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-4 text-center">
                            <div class="client-logo">
                                <div class="client-overlay">
                                    <img src="{{ asset('/assets/img/logos/placeholder-logo-2.png') }}"
                                         class="img-fluid"
                                         alt="Client 2">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-4 text-center">
                            <div class="client-logo">
                                <div class="client-overlay">
                                    <img src="{{ asset('/assets/img/logos/placeholder-logo-3.png') }}"
                                         class="img-fluid"
                                         alt="Client 3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-4 text-center">
                            <div class="client-logo">
                                <div class="client-overlay">
                                    <img src="{{ asset('/assets/img/logos/placeholder-logo-4.png') }}"
                                         class="img-fluid"
                                         alt="Client 4">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-4 text-center">
                            <div class="client-logo">
                                <div class="client-overlay">
                                    <img src="{{ asset('/assets/img/logos/placeholder-logo-5.png') }}"
                                         class="img-fluid"
                                         alt="Client 5">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-4 text-center">
                            <div class="client-logo">
                                <div class="client-overlay">
                                    <img src="{{ asset('/assets/img/logos/placeholder-logo-6.png') }}"
                                         class="img-fluid"
                                         alt="Client 6">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/front-page-landing.js"></script>

@endsection

@section('scripts')
    <script>
        $(function() {
            'use strict';

            // Initialize Swiper for testimonials
            if (document.querySelector('.swiper')) {
                new Swiper('.swiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2
                        },
                        1024: {
                            slidesPerView: 3
                        }
                    }
                });
            }

            // Smooth scrolling
            $('a[href^="#"]').on('click', function(e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if(targetId === '#') return;

                const $targetElement = $(targetId);
                if($targetElement.length) {
                    $('html, body').animate({
                        scrollTop: $targetElement.offset().top - 80
                    }, 800);
                }
            });
        });



    </script>
