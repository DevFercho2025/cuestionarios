<div class="form-group w-100">
    <textarea class="form-control respuesta"
        name="respuestas[{{ $pregunta->pregunta_id }}]"
        rows="5"
        data-pregunta="{{ $numPregunta }}"
        @if($pregunta->required) required @endif
        placeholder="Escribe tu respuesta aquí">
    </textarea>
</div>