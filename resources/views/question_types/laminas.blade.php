{{-- Láminas: se muestra una imagen (lámina) y el candidato escribe su interpretación --}}

<div class="form-group w-100">
    @if($pregunta->picture)
        <div class="text-center mb-3">
            <img src="{{ asset('storage/' . $pregunta->picture) }}"
                alt="Lámina {{ $numPregunta + 1 }}"
                class="img-fluid rounded shadow-sm"
                style="max-height: 400px;">
        </div>
    @endif

    @if($pregunta->respuestas->count() > 1)
        {{-- Si hay opciones predefinidas, mostrar como selección --}}
        @foreach ($pregunta->respuestas as $respuesta)
            <div class="form-check mb-2">
                <input class="form-check-input respuesta" type="radio"
                    name="respuestas[{{ $pregunta->id }}]"
                    value="{{ $respuesta->id }}"
                    data-pregunta="{{ $numPregunta }}"
                    data-pregunta-id="{{ $pregunta->id }}"
                    @if($pregunta->required) required @endif>
                <label class="form-check-label">
                    @if($respuesta->option)
                        {{ $respuesta->option }}&#41;
                    @endif
                    {{ $respuesta->answer }}
                </label>
            </div>
        @endforeach
    @else
        {{-- Si solo hay una respuesta (placeholder), pedir respuesta abierta --}}
        <label class="fw-bold mb-2">Describe lo que observas en la imagen:</label>
        <textarea class="form-control respuesta"
            name="respuestas[{{ $pregunta->id }}][texto]"
            rows="5"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            @if($pregunta->required) required @endif
            placeholder="Escribe tu interpretación aquí..."></textarea>

        <input type="hidden"
            name="respuestas[{{ $pregunta->id }}][respuesta_id]"
            value="{{ $pregunta->respuestas->first()->id ?? '' }}">
    @endif
</div>
