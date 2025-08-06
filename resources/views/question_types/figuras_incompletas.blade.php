<!--Completar manualmente qué figura sigue-->

<head>
    <style>
        .contenedor {
            width: 67px;
            height: 110px;
            border: 2px solid black;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .fila {
            flex: 1;
            border-top: 2px solid black;
            box-sizing: border-box;
        }

        .fila:first-child {
            border-top: none;
        }

        .contenedor-circulos {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .circulo {
            width: 9px;
            height: 9px;
            background-color: rgb(0, 0, 0);
            border-radius: 50%;
            position: absolute;
            transition: opacity 0.2s;
        }

        .circulo-input {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 100%;
            height: 100%;
            font-size: 20px;
            font-weight: bold;
            color: black;

            /*visualmente invisible*/
            background: transparent;
            border: none;
            outline: none;
            padding: 0;
            margin: 0;
            text-align: center;
            z-index: 2;

            caret-color: black;
        }

        .contenedor-dinamico-domino {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .contenedor-dinamico-domino.respuesta-input {
            width: 67px;
            height: 110px;
        }

        .invisible-input {
            display: none !important;
        }
        .circulo.editable {
            background-color: rgb(87, 87, 241);
        }
    </style>
</head>
@php
    $preguntaId = $pregunta->id;
@endphp

<div class="contenedor-dinamico-domino">
    @foreach ($pregunta->respuestas as $index => $respuesta)
        @php
            $respuestaId = $respuesta->id;
            $uId = uniqid();
            $fillableRaw = $respuesta->extra_data['fillable'] ?? false;
            $fillable = filter_var($fillableRaw, FILTER_VALIDATE_BOOLEAN);

            //Cargar valores si la ficha no se llena
            $top = $fillable ? null : ($respuesta->extra_data['top'] ?? 0);
            $bottom = $fillable ? null : ($respuesta->extra_data['bottom'] ?? 0);
        @endphp

        <div class="contenedor ficha" data-pregunta-id="{{ $pregunta->id }}" data-fillable="{{ $fillable ? '1' : '0' }}">
            <div class="fila" data-fila="1">
                <div class="contenedor-circulos" id="circulos-1-{{ $uId }}">
                    <input
                        class="circulo-input respuesta"
                        data-domino-posicion="top"
                        type="number"
                        id="input-f1-{{ $uId }}"
                        min="0"
                        max="6"
                        @if (!is_null($top))
                            value="{{ $top }}"
                        @endif
                        class="respuesta"
                        name="respuestas[{{ $pregunta->id }}]"
                        data-respuesta-id="{{ $respuesta->id }}"
                        data-pregunta="{{ $numPregunta }}"
                        data-pregunta-id="{{ $pregunta->id }}"
                        data-type="domino"
                    >
                </div>
            </div>
            <div class="fila" data-fila="2">
                <div class="contenedor-circulos" id="circulos-2-{{ $uId }}">
                    <input
                        class="circulo-input respuesta"
                        data-domino-posicion="bottom"
                        type="number"
                        id="input-f2-{{ $uId }}"
                        min="0"
                        max="6"
                        name="respuestas[{{ $pregunta->id }}]"
                        data-respuesta-id="{{ $respuesta->id }}"
                        data-pregunta="{{ $numPregunta }}"
                        data-pregunta-id="{{ $pregunta->id }}"
                        data-type="domino"
                        @if (!is_null($bottom))
                            value="{{ $bottom }}"
                        @endif
                    >
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="mt-3">
    <button type="button" class="btn btn-primary btn-listo-dominos" data-pregunta-id="{{ $pregunta->id }}" data-pregunta="{{ $numPregunta }}">Listo</button>
</div>