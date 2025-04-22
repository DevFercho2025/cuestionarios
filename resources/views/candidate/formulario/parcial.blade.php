<!--@extends('layout.app')-->
    @php
        $seccionActual = null;
        $numPregunta = 0;
        $conTitulo = false;
    @endphp

    <h1 visibility: hidden>Valor de Rango Inicio: {{ $rango_inicio }}</h1>

    <style>

        .progreso-Seccion {
            display: flex;
            flex-direction: column;
            width: 420px;
            padding: 50px 0;
            border-radius: 8px;
            align-items: center;
            justify-content: center; /* <-- asegurá que esté esto */
            text-align: center;
            margin: 0 auto; /* <-- esto lo centra horizontalmente */
        }
        .circulo-Progreso{
            position: relative;
            height: 200px;
            width: 200px;
            border-radius: 50%;
            background-image: conic-gradient(blue 4.6deg, #ededed 0deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .circulo-Progreso::before{
            content: "";
            position: absolute;
            height: 160px;
            width: 160px;
            border-radius: 50%;
            background-color: white;
        }
        .valor-progreso{
            position: relative;
            font-size: 50px;
            font-weight: 600;
            color: blue;
        }
        .texto-progreso{
            font-size: 30px;
            font-weight: 500;
            padding: 5%;
        }

        .recording-container {
            width: 90px;
            height: 40px;
            border-radius: 10px;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            border: 2px solid #ffffff;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .barra-indicador-video {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
        }

        .recording-indicator {
            width: 12px;
            height: 12px;
            background-color: red;
            border-radius: 50%;
            position: relative;
        }

        .recording-indicator::after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            width: 22px;
            height: 22px;
            border: 2px solid red;
            border-radius: 50%;
        }

        .video-container {
            display: none;
            margin-top: 20px;
        }

        .barra-Superior {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-top: 40px;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .barra-titulo-cuestionario {
            flex-grow: 2; /* El título ocupa más espacio */
        }

        .barra-temporizador,
        .barra-indicador-video {
            flex-grow: 1; /* Temporizador y grabación ocupan menos espacio */
            text-align: center;
        }

        .separador {
            width: 2px;
            height: 50px;
            background-color: #ccc;
        }

        .contenedor-C{
            display: flex;
            align-items: flex-start;
            justify-content: flex-start;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            margin-top: 20px;
            max-width: 80%;
            max-height: 80%;
            margin-left: auto;
            margin-right: auto;
        }

    </style>


    <div class="barra-Superior d-flex align-items-center justify-content-between">
        <div class="barra-titulo-cuestionario flex-grow-1 text-center">
            @foreach ($preguntas as $pregunta)
                @if ($loop->first)
                    <h1 style="color: rgba(51,58,153,255);">{{ $pregunta->cuestionario }}</h1>
                @endif
            @endforeach
        </div>

        <div class="separador"></div>

        <div class="barra-temporizador">
            @php
                $seccionesTemporizador = [];
            @endphp

            @foreach ($preguntas as $pregunta)
                @php
                    $idSeccion = $pregunta->seccion->id;
                @endphp

                @if (!in_array($idSeccion, $seccionesTemporizador))
                    @php
                        $seccionesTemporizador[] = $idSeccion;
                    @endphp
                    <p id="temporizador-{{ $idSeccion }}" class="temporizador" data-tiempo="{{ $pregunta->tiempoRestante }}" style="display: none;">
                        Tiempo restante: {{ $pregunta->tiempoRestante }}
                    </p>
                @endif
            @endforeach
        </div>

        <div class="separador"></div>

        <div class="barra-indicador-video d-flex justify-content-center align-items-center">
            <div class="recording-container">
                <div class="recording-indicator"></div>
            </div>
        </div>
    </div>

    <!--Contenedor de la cámara-->
    <div class="video-container" id="videoContainer">
        <video class="video" width="420" height="420" controls></video>
    </div>
    <img src="" class="fotoUsuario" alt="foto" style="display:none">

<div class="contenedor-C d-flex justify-content-center align-items-center vh-100">
    <div class="card quiz-card">
        <div class="card-body">
            <form action="{{ route('guardar.respuestas') }}" method="POST">
                @csrf
                @php $numPregunta = 0; @endphp

                @foreach ($preguntas as $pregunta)

                    <div class="pregunta" id="pregunta-{{ $numPregunta }}" style="display: {{ $numPregunta == 0 ? 'block' : 'none' }};">
                        <div class="card shadow rounded p-3 m-4">
                            <div class="card-body">
                                <h4 style="color: rgba(51,58,153,255);">
                                    @if($pregunta->required)
                                        <span style="color: red;">*</span>
                                    @endif
                                    <span>{{ $numPregunta + 1 }}</span>
                                    <span>. {{ $pregunta->pregunta ?? 'Texto de la pregunta' }}</span>
                                </h4>
                                <div class="d-flex" id="Respuestas">
                                    <div class="form-check d-block">
                                        @if (!empty($pregunta->respuestas) && is_iterable($pregunta->respuestas))
                                            @foreach ($pregunta->respuestas as $respuesta)
                                                <div class="form-check">
                                                    <input class="form-check-input respuesta" type="radio"
                                                        name="respuestas[{{$pregunta->pregunta_id}}]"
                                                        value="{{ $respuesta->respuesta_id }}"
                                                        data-pregunta="{{ $numPregunta }}"
                                                        @if($pregunta->required) required @endif>
                                                    <label class="form-check-label">
                                                        {{ $respuesta->opcion }}&#41; {{ $respuesta->respuesta }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        @elseif($pregunta->required)
                                            <div class="alert alert-danger">Esta pregunta es requerida.</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php $numPregunta++; @endphp
                @endforeach

                <input type="hidden" name="rango_inicio" value="{{ request('rango_inicio', 1) }}">
                <input type="hidden" name="rango_fin" value="{{ request('rango_fin', 35) }}">
                <input type="hidden" name="tiempo_agotado" id="tiempo_agotado" value="0">


                <div id="respuestas-hidden-container"></div>
                <button type="submit" id="enviar" style="display: none;">Enviar</button>
            </form>

        </div>
    </div>
    <div class="w-50 mb-3">

        <div>
            @php
                $candidato = session('candidato');
            @endphp

            @if($candidato)
                <div style="text-align: center; margin-bottom: 20px;">
                    <h4 style="margin: 0; color: #333;">
                        {{ $candidato['nombre'] ?? '' }} {{ $candidato['apellidoPaterno'] ?? '' }} {{ $candidato['apellidoMaterno'] ?? '' }}
                    </h4>
                    <p style="margin: 0; font-weight: bold;">
                        Vacante: {{ $candidato['cargoAlQueAplica'] ?? '' }}
                    </p>
                </div>
            @endif
        </div>
        <div class="progreso-Seccion">
            <div class="circulo-Progreso">
                <span class="valor-Progreso">0%</span>
            </div>
            @php
                $idSeccionActual = $preguntas->first()->seccion->id;
            @endphp

            <div class="texto-Progreso" style="text-align: center" data-id-seccion="{{ $idSeccionActual }}">
                {{ $preguntas->first()->seccion->titulo }}
            </div>
        </div>

    </div>
</div>
    

