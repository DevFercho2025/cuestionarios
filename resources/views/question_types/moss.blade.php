@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-check">
        <input class="form-check-input respuesta" type="radio"
            name="respuestas[{{ $pregunta->id }}]"
            value="{{ $respuesta->id }}"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            @if($pregunta->required) required @endif>
        <label class="form-check-label">
            {{ $respuesta->option }}&#41; {{ $respuesta->answer }}
        </label>
    </div>
@endforeach