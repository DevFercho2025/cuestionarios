@extends('layout.app')

@section('content')
<div class="row">
    <div class="col s12 m6 offset-m3">
        <div class="card">
            <div class="card-content">
                <span class="card-title center-align">Ingrese su código</span>

                @if ($errors->any())
                    <div class="card-panel red lighten-4 red-text text-darken-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('candidate.validar.codigo') }}" method="POST">
                    @csrf
                    <div class="input-field">
                        <input type="text" name="codigo" id="codigo" required>
                        <label for="codigo">Código de aplicación</label>
                    </div>
                    <div class="center-align" style="margin-top: 20px;">
                        <button type="submit" class="btn waves-effect waves-light">Continuar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
