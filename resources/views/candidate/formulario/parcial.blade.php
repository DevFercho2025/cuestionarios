
    @php
        $seccionActual = null;
        $numPregunta = 0;
        $conTitulo = false;
    @endphp

    <style>

        /* Títulos principales más grandes */
        h1 {
            font-size: calc(1.4rem + 1.2vw);
        }

        h4 {
            font-size: calc(1.2rem + 0.5vw);
        }

        /* Opciones o texto pequeño */
        .form-check-label, .option-label, small {
            font-size: calc(0.9rem + 0.3vw);
        }

        /* Evita que se centre verticalmente si no hay mucho contenido */
        .card-body {
            padding: 0 !important;
        }

        /* Para mantener altura consistente en tarjetas */
        .pregunta {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        @media (max-width: 768px) {
            p {
                font-size: calc(1.2rem + 2vw);
            }

            .form-check-label {
                font-size: calc(0.9rem + 1vw);
            }
        }


        .progreso-Seccion {
            display: flex;
            flex-direction: column;
            width: 420px;
            padding: 50px 0;
            border-radius: 8px;
            align-items: center;
            justify-content: center;  /*<-- asegurá que esté esto */  
            text-align: center;
            margin: 0 auto;  /*<-- esto lo centra horizontalmente */  
        }
        .circulo-Progreso{
            position: relative;
            height: 200px;
            width: 200px;
            border-radius: 50%;
            background-image: conic-gradient(blue 0deg, #ededed 0deg);
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
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 15px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1) !important;
            margin: 15px;
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
            display: flex !important;
            align-items: flex-start !important;
            justify-content: flex-start !important;
            background-color: #f8f9fa !important;
            padding: 15px !important;
            border-radius: 15px !important;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1) !important;
            height: 80% !important;
            margin: clamp(15px, 1vw, 100px) !important
        }

        input[type="radio"].form-check-input {
            appearance: auto;
            width: 1em;
            height: 1em;
            margin-top: 0.3em;
        }
    </style>

    <div class="barra-Superior d-flex align-items-center justify-content-between">
        <div class="barra-titulo-cuestionario flex-grow-1 text-center">
            <h2 style="color: rgba(51,58,153,255);">{{ $testTitulo }}</2>
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
            <div class="recording-container" style="{{ $cameraRequired == 0 ? 'display: none;' : '' }}">
                <div class="recording-indicator"></div>
            </div>
        </div>
    </div>
    <div class="contenedor-C d-flex justify-content-center align-items-center">
        <div class="col-8" style="height: 100%" >

            @php
                $mostrarDirecto = empty($seccion->test->instructions) && empty($seccion->instructions);
            @endphp

            @if (!$mostrarDirecto)
                {{-- Instrucciones del test y sección --}}
                <div id="contenedor-instrucciones" class="h-100 text-center" style="display:flex; flex-direction:column; justify-content:center;">
                    <div>
                        @if (!empty($seccion->test->instructions))
                            <div class="mb-4 instrucciones-test">
                                <h5 class="text-primary">Instrucciones del test</h5>
                                <p>{!! nl2br(e($seccion->test->instructions)) !!}</p>
                            </div>
                        @endif

                        @if (!empty($seccion->instructions))
                            <div class="mb-4 instrucciones-seccion">
                                <h5 class="text-secondary">Instrucciones de la sección</h5>
                                <p>{!! nl2br(e($seccion->instructions)) !!}</p>
                            </div>
                        @endif

                        @if (!empty($seccion->test->instructions) || !empty($seccion->instructions))
                            <button type="button" class="btn btn-primary mt-3" onclick="mostrarFormulario()">
                                Continuar
                            </button>
                        @endif
                    </div>
                    
                </div>
            @endif

                <form id="formulario-preguntas" class="{{ $mostrarDirecto ? '' : 'd-none' }}" action="{{ route('token.record') }}" method="POST" style="height: 100%;">
                    @csrf

                    @php $numPregunta = 0; @endphp

                    @foreach ($preguntas as $pregunta)
                        <div class="pregunta" id="pregunta-{{ $numPregunta }}" style="display: {{ $numPregunta == 0 ? 'block' : 'none' }};">
                            @php
                                $scaleType = $pregunta->respuestas->first()->extra_data['scale_type'] ?? null;
                            @endphp
                            <div style="display:flex; flex-direction:column; justify-content:center; height: 100%;">
                                <h4 style="color: rgba(51,58,153,255);">
                                        @if ($scaleType !== 3)
                                            @if($pregunta->required)
                                                <span style="color: red;">*</span>
                                            @endif
                                            <span>{{ $numPregunta + 1 }}</span>
                                            <span>. {{ $pregunta->question }}</span>
                                        @endif
                                        @if (!empty($pregunta->picture))
                                            <div class="mt-3 text-center">
                                                <img src="{{ asset('storage/' . $pregunta->picture) }}" alt="Imagen de la pregunta" style="max-width: 100%; height: auto;">
                                            </div>
                                        @endif
                                    </h4>
                                    <div class="d-flex" id="Respuestas" >
                                        <div class="form-check  d-block" style="width: 100%;">
                                            @if (!empty($pregunta->respuestas) && is_iterable($pregunta->respuestas))
                                            @includeIf('question_types.' . $pregunta->tipo_slug, [
                                                    'pregunta' => $pregunta,
                                                    'numPregunta' => $numPregunta
                                                ])
                                            @elseif($pregunta->required)
                                                <div class="alert alert-danger">Esta pregunta es requerida.</div>
                                            @endif
                                        </div>
                                    </div>
                            </div>
                        </div>
                        @php $numPregunta++; @endphp
                    @endforeach

                    <input type="hidden" name="tiempo_agotado" id="tiempo_agotado" value="0">
                    <input type="hidden" name="section_id" value="{{ $seccion_id }}">
                    <input type="hidden" name="test_id" value="{{ $test_id }}">

                    <div id="respuestas-hidden-container"></div>
                    <button type="submit" id="enviar" style="display: none;">Enviar</button>
                </form>
        </div>
        <div class="col-4" style="display:flex; flex-direction:column; justify-content:center; height: 100%">
            <div>
                @if($candidato)
                    <div style="text-align: center; margin-bottom: 20px;">
                        <h4 style="margin: 0; color: #333;">
                            {{ $candidato->name}}
                        </h4>
                        <p style="margin: 0; font-weight: bold;">
                            Vacante: {{ $candidato->vacante?->vacancy ?? 'No especificada' }}
                        </p>
                    </div>
                @endif
            </div>
            <div class="progreso-Seccion">
                <div class="circulo-Progreso">
                    <span class="valor-Progreso">0%</span>
                </div>

                <div class="texto-Progreso" style="text-align: center" data-id-seccion="{{ $seccion->id }}">
                    {{ $seccion->titulo }}
                </div>

                @if ($testTitulo === 'Cleaver')
                    <div id="contenedor-glosario" class="mt-4"></div>
                @endif
            </div>
        </div>
    </div>


@if ($testTitulo === 'cleaver')
    <div id="glosario-original" style="display: none;">
        @include('partials.glosario_cleaver')
    </div>
@endif

<!--Contenedor de la cámara-->
    <div class="video-container" id="videoContainer">
        <video class="video" width="420" height="420" controls></video>
    </div>
    <img src="" class="fotoUsuario" alt="foto" style="display:none">
