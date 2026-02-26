{{-- Mancha (Rorschach-like): se muestra una imagen de mancha y el candidato describe lo que ve --}}

<div class="form-group w-100">
    @if($pregunta->picture)
        <div class="text-center mb-3">
            <img src="{{ asset('storage/' . $pregunta->picture) }}"
                alt="Lámina {{ $numPregunta + 1 }}"
                class="img-fluid rounded"
                style="max-height: 400px; background: #f5f5f5; padding: 10px;">
        </div>
    @endif

    @if($pregunta->respuestas->count() > 1)
        {{-- Opciones predefinidas --}}
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
        {{-- Respuesta abierta --}}
        <label class="fw-bold mb-2">¿Qué ves en esta imagen?</label>
        <textarea class="form-control respuesta"
            name="respuestas[{{ $pregunta->id }}][texto]"
            rows="5"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            @if($pregunta->required) required @endif
            placeholder="Describe lo que observas..."></textarea>

        <input type="hidden"
            name="respuestas[{{ $pregunta->id }}][respuesta_id]"
            value="{{ $pregunta->respuestas->first()->id ?? '' }}">
    @endif
</div>
