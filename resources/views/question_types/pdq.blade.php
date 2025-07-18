@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-check">
        <input class="form-check-input respuesta" type="checkbox"
            name="respuestas[{{ $pregunta->id }}][]"
            value="{{ $respuesta->id }}"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            data-type="severalChars"
            @if($pregunta->required) required @endif>
        <label class="form-check-label">
            {{ $respuesta->option }}&#41; {{ $respuesta->answer }}
        </label>
    </div>
@endforeach
<!-- Botón Listo -->
<div class="mt-3">
    <button type="button" class="btn btn-primary btn-listo">Listo</button>
</div>