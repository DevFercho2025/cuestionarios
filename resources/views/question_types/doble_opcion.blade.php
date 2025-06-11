@foreach ($pregunta->respuestas->take(2) as $respuesta)
    <div class="form-check">
        <input class="form-check-input respuesta" type="radio"
            name="respuestas[{{ $pregunta->pregunta_id }}]"
            value="{{ $respuesta->respuesta_id }}"
            data-pregunta="{{ $numPregunta }}"
            @if($pregunta->required) required @endif>
        <label class="form-check-label">
            {{ $respuesta->opcion }}&#41; {{ $respuesta->respuesta }}
        </label>
    </div>
@endforeach