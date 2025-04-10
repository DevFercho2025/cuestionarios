@extends('layout.app')

@section('content')
    <!-- Navbar -->
    <nav class="blue">
        <div class="nav-wrapper container">
            <a href="{{ route('admin.index') }}" class="brand-logo">Panel de Administración</a>
            <ul id="nav-mobile" class="right hide-on-med-and-down">
                <li>
                    <!-- Botón de logout -->
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-flat waves-effect waves-light white-text" style="margin-top:15px;">Salir</button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenido del Panel -->
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <!-- Tarjeta para Secciones -->
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content center">
                        <i class="material-icons large">dashboard</i>
                        <h5>Secciones</h5>
                    </div>
                    <div class="card-action center">
                        <a href="{{ route('secciones.index') }}" class="btn waves-effect waves-light">Gestionar</a>
                    </div>
                </div>
            </div>
            <!-- Tarjeta para Preguntas -->
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content center">
                        <i class="material-icons large">help_outline</i>
                        <h5>Preguntas</h5>
                    </div>
                    <div class="card-action center">
                        <a href="{{ route('preguntas.index') }}" class="btn waves-effect waves-light">Gestionar</a>
                    </div>
                </div>
            </div>
            <!-- Tarjeta para Respuestas -->
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content center">
                        <i class="material-icons large">question_answer</i>
                        <h5>Respuestas</h5>
                    </div>
                    <div class="card-action center">
                        <a href="{{ route('respuestas.index') }}" class="btn waves-effect waves-light">Gestionar</a>
                    </div>
                </div>
            </div>
            <!-- Tarjeta para Respuestas Correctas -->
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content center">
                        <i class="material-icons large">check_circle</i>
                        <h5>Respuestas Correctas</h5>
                    </div>
                    <div class="card-action center">
                        <a href="{{ route('respuestas_correctas.index') }}" class="btn waves-effect waves-light">Gestionar</a>
                    </div>
                </div>
            </div>
            <!-- Tarjeta para gestionar candidatos -->
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content center">
                        <i class="material-icons large">people</i>
                        <h5>Candidatos</h5>
                    </div>
                    <div class="card-action center">
                        <a href="{{ route('candidatos.index') }}" class="btn waves-effect waves-light">Gestionar</a>
                    </div>
                </div>
            </div>
            <!-- Tarjeta para gestionar evaluaciones -->
            <div class="col s12 m6 l4">
                <div class="card hoverable">
                    <div class="card-content center">
                        <i class="material-icons large">assignment</i>
                        <h5>Evaluaciones</h5>
                    </div>
                    <div class="card-action center">
                        <a href="{{ route('evaluaciones.index') }}" class="btn waves-effect waves-light">Gestionar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
