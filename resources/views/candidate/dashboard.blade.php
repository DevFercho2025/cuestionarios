@extends('layout.app')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row gy-6 gy-md-0">
      

      <!-- User Content -->
      <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        <div class="card mb-6">
            <h5 class="card-header">Evaluaciones Pendientes</h5>
            @if ($categorias->isEmpty())
                <p>No tienes evaluaciones asignadas por el momento.</p>
            @else
                <div class="table-responsive table-border-bottom-0">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-truncate">Prueba</th>
                                <th class="text-truncate">Estado</th>
                                <th class="text-truncate">Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categorias as $categoria)
                                <tr>
                                    <td class="text-truncate">
                                        <i class="ri-question-answer-line" class="me-2" width="22" height="22"></i>
                                        <span class="text-heading">{{ $categoria->titulo_cuestionario }}</span>
                                    </td>
                                    <td class="text-truncate">
                                        Pendiente
                                    </td>
                                    <td class="text-truncate">
                                        <a href="{{ route('permisos-preliminares') }}?categoria_id={{ $categoria->id }}" class="btn btn-sm btn-primary">
                                            Iniciar Evaluación
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
      </div>
      <!--/ User Content -->

      <!-- Info Usuario -->
      <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        <!-- User Card -->
        <div class="card mb-6">
          <div class="card-body pt-12">
            <div class="user-avatar-section">
              <div class="d-flex align-items-center flex-column">
                <img class="img-fluid rounded-3 mb-4" src="../../assets/img/avatars/1.png" height="120" width="120" alt="User avatar">
                <div class="user-info text-center">
                  <h5>{{ Auth::user()->name }}</h5>
                </div>
              </div>
            </div>
            <div class="d-flex justify-content-around flex-wrap my-6 gap-0 gap-md-3 gap-lg-4">

            </div>
            <h5 class="pb-4 border-bottom mb-4">Detalles</h5>
            <div class="info-container">
              <ul class="list-unstyled mb-6">
                <li class="mb-2">
                  <span class="fw-medium text-heading me-2">Email:</span>
                  <span>{{ Auth::user()->email }}</span>
                </li>
                <li class="mb-2">
                  <span class="fw-medium text-heading me-2">Código de Aplicación:</span>
                  <span>{{ $aplicacion->codigo ?? 'N/A' }}</span>
                </li>
                <li class="mb-2">
                  <span class="fw-medium text-heading me-2">Fecha de Registro:</span>
                  <span>{{ optional(Auth::user()->info)->created_at ? \Carbon\Carbon::parse(Auth::user()->info->created_at)->format('d/m/Y') : 'N/A' }}</span>
                </li>
                <li class="mb-2">
                  <span class="fw-medium text-heading me-2">Vacante a la que aplica:</span>
                  <span>{{ $aplicacion->vacante ?? 'N/A' }}</span>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- /User Card -->
        
      </div>
      <!--/ Info Usuario -->
    </div>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="">Cerrar sesión</button>
</form>
@endsection
