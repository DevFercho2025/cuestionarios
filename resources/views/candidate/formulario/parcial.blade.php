
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
            padding: 50px 0;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            text-align: center;
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

        .recording-container {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
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

        .container-progress-bar {
            height: 20px;
            background-color: #ccc;
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }
        .progress-bar {
            position: absolute;
            height: 100%;
            width: 0%; /* inicial */
            background-color: blue;
            border-radius: 8px;
            transition: width 0.5s ease;
        }
        .valor-progreso{
            position: relative;
            font-size: 20px;
            font-weight: 600;
            color: blue;
        }
        .texto-progreso{
            font-size: 20px;
            font-weight: 500;
            padding: 5%;
        }

        .separador {
            width: 2px;
            height: 20px;
            background-color: #ccc;
        }
    </style>

    <div class="barra-Superior position-relative d-flex align-items-center" style="height: 60px;">
        <!-- Izquierda: Indicador cámara -->
        <div class="position-absolute start-0 d-flex align-items-center ps-3">
            <div class="recording-container" style="{{ $cameraRequired == 0 ? 'display: none;' : '' }}">
                <div class="recording-indicator"></div>
            </div>
            <h5 class="mb-0">Tomando Fotos</h5>
        </div>

        <!-- Centro: Logo -->
        <div class="mx-auto d-flex justify-content-center align-items-center">
            <img
                src="{{ asset('assets/img/Alobri/alobri-light.png') }}"
                alt="Logo"
                height="30px"
                class="app-brand-img"
                data-app-light-img="Alobri/Alobri-light.png"
                data-app-dark-img="Alobri/Alobri-dark.png"
            />
        </div>

        <!-- Derecha: Temporizador -->
        <div class="position-absolute end-0 d-flex align-items-center pe-3">
            <i class="ri-time-line me-2 fs-4" style="color:#666cff; width:22px; height:22px;"></i>
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
                    <h5 id="temporizador-{{ $idSeccion }}" class="temporizador mb-0 mr-1" data-tiempo="{{ $pregunta->tiempoRestante }}" style="display: none; padding-right:8px;">
                        Tiempo restante: {{ $pregunta->tiempoRestante }}
                    </h5>
                @endif
            @endforeach
        </div>
    </div>

    <!--Barra de progreso-->
    <div class="d-flex justify-content-center align-items-center" style="position: relative; width: 100%;">
        <div class="container-progress-bar" style="width: 92%;height:20px;">
            <div class="progress-bar"></div>
        </div>
        <span class="valor-Progreso" style="padding-left:10px;">0%</span>
    </div>
    
    <!--Contenedor de Evaluación-->
    <div class="contenedor-C d-flex justify-content-center align-items-center">
        <!--Instrucciones y preguntas-->
        <div class="col-md-11 col-lg-8 mx-auto mt-5 mb-5" style="height: 100%" >

            <div class="barra-titulo-cuestionario flex-grow-1 text-center">
                <h2 style="color: rgba(51,58,153,255);">{{ $testTitulo }}</2>
            </div>

            @php
                $mostrarDirecto = empty($seccion->test->instructions) && empty($seccion->instructions);
            @endphp

            @if (!$mostrarDirecto)
                {{-- Instrucciones del test y sección --}}
                <div id="contenedor-instrucciones" class="text-center" style="height: 70% !important; width:100%; display:flex; flex-direction:column; justify-content:center;">
                    <div style="heigh:100%">
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

                <form id="formulario-preguntas" class="{{ $mostrarDirecto ? '' : 'd-none' }}" action="{{ route('token.record') }}" method="POST" style="height: 90%; width:100%">
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
                                        <span>{{ $numPregunta + 1 }}.</span>
                                        <span>
                                            @if (in_array($pregunta->id, [1071, 1052, 1042]))
                                                @php
                                                    $pos = strpos($pregunta->question, '?');
                                                    $textoPregunta = $pos !== false
                                                        ? substr($pregunta->question, 0, $pos + 1)
                                                        : $pregunta->question;
                                                @endphp
                                                {{ $textoPregunta }}
                                            @else
                                                {{ $pregunta->question }}
                                            @endif
                                        </span>
                                    @endif

                                    @if (!empty($pregunta->picture))
                                        <div class="mt-3 text-center">
                                            <img src="{{ asset('assets/img/' . $pregunta->picture) }}" alt="Imagen de la pregunta" style="max-width: 100%; height: auto;">
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
    </div>

    <div class="d-flex justify-content-center align-items-start" style="position: relative; width: 100%; height:10px;">
    <div style="text-align: center;">
       @if($candidato)
            <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                <p style="margin: 0; color: #333;">
                    <span style="font-weight: bold;">Candidato:</span>
                    {{ $candidato->name }}
                </p>
                <div class="separador"></div>
                <p style="margin: 0;">
                    <span style="font-weight: bold;">Vacante:</span>
                     {{ $candidato->vacante?->vacancy ?? 'No especificada' }}
                </p>
            </div>
        @endif
    </div>

    <div class="progreso-Seccion">
        <div class="texto-Progreso" data-id-seccion="{{ $seccion->id }}" style="display:none;"></div>
        @if ($testTitulo === 'Cleaver')
            <div id="contenedor-glosario" class="mt-4"></div>
        @endif
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
