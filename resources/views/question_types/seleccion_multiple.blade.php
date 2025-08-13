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

            @if (!empty($respuesta->extra_data['file_path']))
            <div class="mt-2">
                <img src="{{ asset('assets/img/' . $respuesta->extra_data['file_path']) }}" alt="Imagen de la respuesta" style="max-width: 100%; height: auto;">
            </div>
        @endif
        </label>
    </div>
@endforeach