
@extends('layout.admin')
@section('title', 'Gestión de Secciones')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <!-- Banner de Usuario -->
                <div class="user-profile-header-banner">
                    <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top">
                </div>

                <!-- Información del Perfil de Usuario -->
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-5">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="../../assets/img/avatars/1.png" alt="user image" class="d-block h-auto ms-0 ms-sm-5 rounded-4 user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-4 mt-sm-12">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-6">
                            <div class="user-profile-info">
                                <h4 class="mb-2">{{ Auth::user()->name }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="card-body">
                      <small class="card-text text-uppercase text-muted small">DETALLES</small>
                      <ul class="list-unstyled my-3 py-1">
                          <li class="d-flex align-items-center mb-4">
                            <i class="ri-mail-open-line ri-24px"></i><span class="fw-medium mx-2">Email:</span>
                            <span>{{ Auth::user()->email }}</span>
                          </li>
                        <li class="d-flex align-items-center mb-4">
                          <i class="ri-user-3-line ri-24px"></i><span class="fw-medium mx-2">Código de Aplicación:</span>
                          <span>{{ $aplicacion->codigo ?? 'N/A' }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                          <i class="ri-check-line ri-24px"></i><span class="fw-medium mx-2">Fecha de Registro:</span>
                          <span>{{ optional(Auth::user()->info)->created_at ? \Carbon\Carbon::parse(Auth::user()->info->created_at)->format('d/m/Y') : 'N/A' }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-4">
                          <i class="ri-flag-2-line ri-24px"></i><span class="fw-medium mx-2">Vacante a la que aplica:</span>
                          <span>{{ $aplicacion->vacante ?? 'N/A' }}</span>
                        </li>
                      </ul>  
                    </div>
            </div> <!-- End card -->
        </div>
    </div>
</div>

    <!-- /User Card -->

    <!-- jQuery y Scripts adicionales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        .user-profile-header-banner img {
            width: 100%;
            height: auto;
            object-fit: cover; /* Asegura que la imagen cubra el área sin deformarse */
        }
        
        
    </style>
@endsection
