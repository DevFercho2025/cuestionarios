@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title center-align">Iniciar Sesión</span>
                    @if ($errors->any())
                        <div class="card-panel red lighten-4 red-text text-darken-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="input-field">
                            <input id="email" type="email" name="email" class="validate" required autofocus>
                            <label for="email">Correo</label>
                        </div>
                        <div class="input-field">
                            <input id="password" type="password" name="password" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="center-align">
                            <button type="submit" class="btn waves-effect waves-light">
                                Entrar
                            </button>
                        </div>
                    </form>
                    <div class="center-align" style="margin-top: 20px;">
                        <a 
                            href="{{ route('candidate.index') }}"
                            class="btn grey lighten-1 black-text waves-effect waves-light">
                            Soy candidato
                        </a>

                    </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
