{{-- Patrones Múltiple: se muestra una secuencia de patrones y el candidato elige cuál sigue --}}

@if($pregunta->picture)
    <div class="text-center mb-3">
        <img src="{{ asset('storage/' . $pregunta->picture) }}"
            alt="Patrón {{ $numPregunta + 1 }}"
            class="img-fluid rounded shadow-sm"
            style="max-height: 350px;">
    </div>
@endif

<div class="form-group w-100">
    @php
        $tieneImagenes = $pregunta->respuestas->contains(fn($r) => !empty($r->extra_data['file_path'] ?? null));
    @endphp

    @if($tieneImagenes)
        {{-- Respuestas con imágenes (seleccionar el patrón correcto) --}}
        <div class="row g-3">
            @foreach ($pregunta->respuestas as $respuesta)
                <div class="col-6 col-md-3">
                    <label class="card h-100 text-center p-2" for="patron_{{ $respuesta->id }}"
                        style="cursor: pointer; border: 2px solid #e0e0e0; transition: border-color 0.2s;">
                        <input class="form-check-input respuesta" type="radio"
                            name="respuestas[{{ $pregunta->id }}]"
                            id="patron_{{ $respuesta->id }}"
                            value="{{ $respuesta->id }}"
                            data-pregunta="{{ $numPregunta }}"
                            data-pregunta-id="{{ $pregunta->id }}"
                            @if($pregunta->required) required @endif
                            style="position: absolute; top: 8px; right: 8px;">
                        @if(!empty($respuesta->extra_data['file_path']))
                            <img src="{{ asset('assets/img/' . $respuesta->extra_data['file_path']) }}"
                                alt="Opción {{ $respuesta->option }}"
                                class="img-fluid rounded mb-1"
                                style="max-height: 120px;">
                        @endif
                        <span class="small">{{ $respuesta->option }}&#41; {{ $respuesta->answer }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    @else
        {{-- Respuestas de texto --}}
        @foreach ($pregunta->respuestas as $respuesta)
            <div class="form-check mb-2">
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
    @endif
</div>
