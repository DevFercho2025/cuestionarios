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
</div>
    <!-- jQuery y Scripts adicionales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @push('scripts')
    @endpush
@endsection