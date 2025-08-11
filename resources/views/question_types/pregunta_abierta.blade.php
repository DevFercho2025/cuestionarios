<div class="form-group w-100">
    @if (in_array($pregunta->id, [1071, 1052, 1042]))
       @php
            $texto = $pregunta->question;

            //quita todo lo que esté hasta "?"
            $pos = strpos($texto, '?');
            if ($pos !== false) {
                $texto = substr($texto, $pos + 1);
            }

            //separar por secuencias de dos+ espacios o tab
            $partes = preg_split('/\s{2,}|\t/', trim($texto));
            $pares = array_chunk($partes, 2);
        @endphp

        @foreach($pares as $par)
            <div class="d-flex justify-content-between mb-1">
                <span>{{ $par[0] ?? '' }}</span>
                <span>{{ $par[1] ?? '' }}</span>
            </div>
        @endforeach
    @endif
        <textarea class="form-control respuesta"
            name="respuestas[{{ $pregunta->id }}][texto]"
            rows="5"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            @if($pregunta->required) required @endif
            placeholder="Escribe tu respuesta aquí"></textarea>

        <input type="hidden"
            name="respuestas[{{ $pregunta->id }}][respuesta_id]"
            value="{{ $pregunta->respuestas->first()->id ?? '' }}">
</div>