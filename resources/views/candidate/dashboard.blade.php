@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Perfil del Candidato -->
        <div class="col s12 m12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Perfil del Candidato</span>
                    <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Código de Aplicación:</strong> {{ $aplicacion->codigo ?? 'N/A' }}</p>
                    <p><strong>Fecha de Registro:</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Evaluaciones por hacer -->
        <div class="col s12 m12">
            <div class="card">
                <div class="card-content">
                    <span class="card-title">Evaluaciones Pendientes</span>
                    @if ($categorias->isEmpty())
                        <p>No tienes evaluaciones asignadas por el momento.</p>
                    @else
                        <ul class="collection">
                            @foreach ($categorias as $categoria)
                                <li class="collection-item">
                                    <i class="material-icons left">check_circle</i>
                                    {{ $categoria->titulo_cuestionario }}
                                    <!-- Enlace que redirige a permisos-preliminares con el categoria_id -->
                                    <a href="{{ route('permisos-preliminares') }}?categoria_id={{ $categoria->id }}" class="btn waves-effect waves-light">
                                        Iniciar Evaluación
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="">Cerrar sesión</button>
</form>
@endsection
