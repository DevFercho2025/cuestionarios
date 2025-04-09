@extends('layout.app')

@section('content')
<div class="container text-center mt-5">
    <h2>¡Gracias por completar el formulario!</h2>
    <p>Haz clic en el botón de abajo para ver tus resultados.</p>
    
    <a href="{{ route('ver.resultados') }}" class="btn btn-primary mt-3">Ver Resultados</a>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        console.log("URL generada:", "{{ route('generar.token') }}");  // Imprime la URL generada
        fetch("{{ route('generar.token') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            },
            body: JSON.stringify({})
        })
        .then(response => response.text())
        .then(data => console.log("Token generado:", data))
        .catch(error => console.error("Error al generar token:", error));
    });
</script>
@endSection