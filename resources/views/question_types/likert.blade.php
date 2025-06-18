<div class="form-group mb-4">
    <div class="d-flex flex-column gap-2">
       @foreach($pregunta->respuestas->sortBy(fn($r) => $r->extra_data['label_index']) as $respuesta)
            <div class="form-check form-check-inline text-start">
                <input
                    class="form-check-input respuesta"
                    type="radio"
                    name="respuestas[{{ $pregunta->id }}]"
                    id="respuesta_{{ $respuesta->id }}"
                    value="{{ $respuesta->id }}"
                    data-pregunta="{{ $numPregunta }}"
                    data-pregunta-id="{{ $pregunta->id }}"
                    @if($pregunta->required) required @endif
                >
                <label class="form-check-label small d-block" for="respuesta_{{ $respuesta->id }}">
                    {{ $respuesta->answer }}
                </label>
            </div>
        @endforeach
    </div>
</div>