@extends('layout.admin')
@section('title', 'Perfil de Candidato')
@section('content')
<div class="container">
    <!-- emcabezado-->
    <div class="row">
        <div class="col s12">
            <div class="card-panel dark-gradient">
                <div class="row valign-wrapper mb-0">
                    <div class="col s8">
                        <h4 class="white-text">Gestión de Candidatos</h4>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="user-profile-header-banner">
                    <img src="../../assets/img/pages/profile-banner.png" alt="Banner image" class="rounded-top">
                </div>
                <div class="user-profile-header d-flex flex-column flex-sm-row text-sm-start text-center mb-5">
                    <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                        <img src="../../assets/img/avatars/1.png" alt="user image" class="d-block h-auto ms-0 ms-sm-5 rounded-4 user-profile-img">
                    </div>
                    <div class="flex-grow-1 mt-4 mt-sm-12">
                        <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-6">
                            <div class="user-profile-info">
                                <h4 class="mb-2">John Doe</h4>
                                <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                                    <li class="list-inline-item">
                                        <i class="ri-palette-line me-2 ri-24px"></i><span class="fw-medium">UX Designer</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="ri-map-pin-line me-2 ri-24px"></i><span class="fw-medium">Vatican City</span>
                                    </li>
                                    <li class="list-inline-item">
                                        <i class="ri-calendar-line me-2 ri-24px"></i><span class="fw-medium"> Joined April 2021</span>
                                    </li>
                                </ul>
                            </div>
                            <a href="javascript:void(0)" class="btn btn-primary waves-effect waves-light">
                                <i class="ri-user-follow-line ri-16px me-2"></i>Connected
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- jQuery y Scripts adicionales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @push('scripts')
    @endpush
@endsection