@extends('layout.app')

@section('content')

<div class="row" style="margin-top: 5vh;">
    <div class="col s12 m8 l6 offset-m2 offset-l3">
        <div class="card z-depth-3">
            <div class="card-content">
                <span class="card-title center-align">
                    <i class="material-icons left">lock</i> Ingrese su código
                </span>

                {{-- Errores --}}
                @if ($errors->any())
                    <div class="card-panel red lighten-4 red-text text-darken-4">
                        <ul class="browser-default">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulario --}}
                <form action="{{ route('validar.codigo') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <input type="text" name="codigo" id="codigo" required>
                        <label for="codigo">Código de aplicación</label>
                    </div>

                    <div class="center-align" style="margin-top: 30px;">
                        <button type="submit" class="btn-large teal darken-2 waves-effect waves-light">
                            Continuar
                            <i class="material-icons right">arrow_forward</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
