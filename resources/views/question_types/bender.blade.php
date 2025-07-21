{{$pregunta->picture}}
@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-group w-100">
        <textarea class="form-control respuesta"
            name="respuestas[{{ $pregunta->id }}][texto]"
            rows="5"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            @if($pregunta->required) required @endif
            placeholder="Escribe tu respuesta aquí">
        </textarea>

        <input type="hidden"
            name="respuestas[{{ $pregunta->id }}][respuesta_id]"
            value="{{ $pregunta->respuestas->first()->id ?? '' }}">
    </div>
@endforeach