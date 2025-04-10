@extends('layout.app')

@section('content')
    <div class="row">
        <div class="col s12 m6 offset-m3">
            <div class="card">
                <div class="card-content">
                    <span class="card-title center-align">Acceso con Código</span>

                    @if ($errors->any())
                        <div class="card-panel red lighten-4 red-text text-darken-4">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('verificar.codigo') }}">
                        @csrf

                        <div class="input-field">
                            <input id="codigo" type="text" name="codigo" value="{{ old('codigo') }}" required>
                            <label for="codigo">Código de Acceso</label>
                        </div>

                        <div class="center-align">
                            <button type="submit" class="btn waves-effect waves-light">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
