@php
    $bloques = $pregunta->respuestas->groupBy('option');
    $numBloque = 0;
@endphp

@foreach ($bloques as $option => $respuestas)
    <div class="cleaver-bloque mb-4 p-2 border rounded">
        <strong>Bloque {{ ++$numBloque }} ({{ $option }})</strong>

        @foreach ($respuestas as $i => $respuesta)
            <div class="row align-items-center mb-2">
                <div class="col-6">
                    {{ chr(97 + $i) }}&#41; {{ $respuesta->answer }}
                </div>
                <div class="col-3 text-center">
                    <input type="radio"
                        class="respuesta"
                        name="respuestas[{{ $pregunta->id }}][c_bloque_{{ $option }}][M]"
                        value="{{ $respuesta->id }}"
                        data-pregunta-id="{{ $pregunta->id }}"
                        required>
                    <label class="form-check-label">M</label>
                </div>
                <div class="col-3 text-center">
                    <input type="radio"
                         class="respuesta"
                            name="respuestas[{{ $pregunta->id }}][c_bloque_{{ $option }}][L]"
                            value="{{ $respuesta->id }}"
                            data-pregunta-id="{{ $pregunta->id }}"
                            required>
                    <label class="form-check-label">L</label>
                </div>
            </div>
        @endforeach
    </div>
@endforeach