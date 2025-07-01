@php
    $bloques = $pregunta->respuestas->groupBy('option');
    $numBloque = 0;
@endphp

<head>
    <style>
        .bordered-row {
            border-bottom: 1px solid #e0e0e0;
        }
    </style>
</head>

@foreach ($bloques as $option => $respuestas)
    <div class="cleaver-bloque mb-4 p-2 border rounded">

        {{-- Encabezado del bloque --}}
        <div class="row align-items-center mb-2 fw-bold text-center">
            <div class="col-6 text-start"><strong>Bloque {{ ++$numBloque }}</strong></div>
            <div class="col-3">M</div>
            <div class="col-3">L</div>
        </div>
        
        @foreach ($respuestas as $i => $respuesta)
            <div class="row align-items-center mb-2 {{ $i === count($respuestas) - 1 ? '' : 'bordered-row' }}"> 
                <div class="col-6">
                    {{ chr(97 + $i) }}&#41; {{ $respuesta->answer }}
                </div>
                <div class="col-3 text-center">
                    <input type="radio"
                        class="respuesta"
                        name="respuestas[{{ $pregunta->id }}][c_bloque_{{ $option }}][M]"
                        value="{{ $respuesta->id }}"
                        data-pregunta-id="{{ $pregunta->id }}"
                        required
                    >
                </div>
                <div class="col-3 text-center">
                    <input type="radio"
                        class="respuesta"
                        name="respuestas[{{ $pregunta->id }}][c_bloque_{{ $option }}][L]"
                        value="{{ $respuesta->id }}"
                        data-pregunta-id="{{ $pregunta->id }}"
                        required
                    >
                </div>
            </div>
        @endforeach
    </div>
@endforeach