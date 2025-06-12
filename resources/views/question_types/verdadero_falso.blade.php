@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-check">
        <input class="form-check-input respuesta" type="radio"
            name="respuestas[{{ $pregunta->id }}]"
            value="{{ $respuesta->answer_id }}"
            data-pregunta="{{ $numPregunta }}"
            @if($pregunta->required) required @endif>
        <label class="form-check-label">
            {{ $respuesta->option }}&#41; {{ $respuesta->answer }}
        </label>
    </div>
@endforeach