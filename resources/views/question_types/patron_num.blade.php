<style>
    .respuesta-item {
        display: inline-flex;
        align-items: center;
    }
</style>


<!-- Rellenar los números que faltan -->
<div class="d-flex flex-wrap align-items-center gap-3">

    @foreach ($pregunta->respuestas as $respuesta)
        @php
            $isFillable = filter_var($respuesta->extra_data['fillable'] ?? false, FILTER_VALIDATE_BOOLEAN);
        @endphp

        <div class="respuesta-item">
            @if ($isFillable)
                <input class="form-control p-1 text-center" type="text"
                    style="width: auto; min-height: 40px; max-width: 60px; display: inline-block;"
                    name="respuestas[{{ $pregunta->id }}]"
                    data-pregunta="{{ $numPregunta }}"
                    data-pregunta-id="{{ $pregunta->id }}"
                    placeholder="#"
                     
                    @if($pregunta->required) required @endif>
            @else
                <span class="badge bg-light text-dark px-2 py-1 border p-1 text-center"
                    style="display:inline-block; min-width: 60px; min-height: 40px; "
                    data-pregunta-id="{{ $pregunta->id }}"
                    data-pregunta="{{ $numPregunta }}">
                    {{ $respuesta->answer }}
                </span>
            @endif
        </div>
    @endforeach
</div>