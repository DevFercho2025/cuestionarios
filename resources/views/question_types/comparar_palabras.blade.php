@foreach ($pregunta->respuestas as $respuesta)
    @php
        $palabras = explode(' ', $respuesta->answer);
        $palabraA = $palabras[0] ?? '';
        $palabraB = $palabras[1] ?? '';
    @endphp

    <div class="form-check mb-3">
        <div class="d-flex align-items-center gap-5 flex-wrap">
            <input type="text" class="form-control form-control-sm text-center" 
                   value="{{ $palabraA }}" readonly style="width:120px;">
            <input type="text" class="form-control form-control-sm text-center" 
                   value="{{ $palabraB }}" readonly style="width:120px;">

            <div class="d-flex align-items-center gap-10 ms-3">
                <label class="d-flex align-items-center gap-3">
                    <input type="radio" 
                        name="respuestas[{{ $pregunta->id }}][{{ $respuesta->id }}]"
                        value="{{ $respuesta->id }}"
                        data-pregunta="{{ $numPregunta }}"
                        data-pregunta-id="{{ $pregunta->id }}"
                        data-answer="opposite"
                        data-type="io"
                        class="form-check-input respuesta"
                        @if($pregunta->required) required @endif>
                    Opuestas
                </label>
                <label class="d-flex align-items-center gap-3">
                    <input type="radio" 
                        name="respuestas[{{ $pregunta->id }}][{{ $respuesta->id }}]"
                        value="{{ $respuesta->id }}"
                        data-pregunta="{{ $numPregunta }}"
                        data-pregunta-id="{{ $pregunta->id }}"
                        data-answer="same"
                        data-type="io"
                        class="form-check-input respuesta"
                        @if($pregunta->required) required @endif>
                    Iguales
                </label>
            </div>
        </div>
    </div>
@endforeach
