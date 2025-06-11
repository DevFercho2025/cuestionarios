<div class="d-flex justify-content-between w-100">
    @foreach ($pregunta->respuestas as $respuesta)
        <div class="form-check text-center mx-2">
            <input class="form-check-input respuesta" type="radio"
                name="respuestas[{{ $pregunta->pregunta_id }}]"
                value="{{ $respuesta->respuesta_id }}"
                data-pregunta="{{ $numPregunta }}"
                @if($pregunta->required) required @endif>
            <label class="form-check-label d-block mt-1">
                {{ $respuesta->respuesta }}
            </label>
        </div>
    @endforeach
</div>