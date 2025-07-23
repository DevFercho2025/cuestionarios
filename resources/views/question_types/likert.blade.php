<style>
    /*BFQ*/
    .BFQ .select-cell {
        position: relative;
        cursor: pointer;
        height: 60px;
        text-align: center;
    }

    .BFQ .select-cell input[type="radio"] {
        opacity: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        position: absolute;
        inset: 0;
        z-index: 2;
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
    }

    .BFQ .select-cell .x-mark {
        font-size: 1.5rem;
        color: #333;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    .BFQ .select-cell input[type="radio"]:checked + .x-mark {
        opacity: 1;
    }

    .respuesta-label {
        font-size: 0.8rem;
        text-align: center;
        line-height: 1.2;
        word-break: break-word;
    }
</style>

@php
    $respuestas = $pregunta->respuestas->sortBy(fn($r) => $r->extra_data['label_index']);
    $scaleType = $respuestas->first()->extra_data['scale_type'] ?? null;

    $likertLabels = [
        1 => ['Totalmente en desacuerdo', 'En desacuerdo', 'De acuerdo', 'Totalmente de acuerdo'],
        2 => ['Totalmente en desacuerdo', 'En desacuerdo', 'Neutral', 'De acuerdo', 'Totalmente de acuerdo'],
        3 => ['Completamente falso para mí', 'Bastante falso para mí', 'Ni verdadero ni falso para mí', 'Bastante verdadero para mí', 'Completamente verdadero para mí'], //BFQ,
        4 => ['En absoluto', 'Levemente', 'Moderadamente', 'Severamente'], //BAI
        5 => ['Me desagrada mucho', 'No me gusta','Me es indiferente','Me gusta','Me gusta mucho'], //Hereford
        6 => ['Me gusta','Me es indiferente o tengo dudas','No me gusta','No conozco esa actividad o profesión'],//IPP
        7 => ['Mucho','Poco','Nada'], //IPP vocacional
        9 => ['Nunca','Poco','A veces','Frecuentemente','Siempre'],
    ];

    $labels = $likertLabels[$scaleType] ?? [];
@endphp

@switch($scaleType)
    @case(3)
        {{--Big Five Questionnaire--}}
        <div class="container my-4 BFQ">
            <div class="row mb-3">
                <div class="col-1 d-flex align-items-center justify-content-center bg-light">
                    <span>P{{ $numPregunta }}</span>
                </div>
                <div class="col-11 bg-white border">
                    <span>{{ $pregunta->question }}</span>
                </div>
            </div>

            <div class="table-responsive">
                <div class="d-flex flex-column">

                    {{--Texto respuesta--}}
                    <div class="d-flex text-center gap-0 mt-2">
                        @foreach ($respuestas as $respuesta)
                            <div class="flex-fill px-1">
                                <div class="respuesta-label">
                                    {{ $respuesta->answer }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{--Radios ocultos--}}
                    <div class="d-flex text-center gap-0">
                        @foreach ($respuestas as $respuesta)
                            <div class="flex-fill border bg-white select-cell">
                                <input
                                    type="radio"
                                    class="respuesta"
                                    name="respuestas[{{ $pregunta->id }}]"
                                    id="respuesta_{{ $respuesta->id }}"
                                    value="{{ $respuesta->id }}"
                                    data-pregunta="{{ $numPregunta }}"
                                    data-pregunta-id="{{ $pregunta->id }}"
                                    data-type="likertBFQ"
                                    @if($pregunta->required) required @endif
                                >
                                <span class="x-mark">X</span>
                            </div>
                        @endforeach
                    </div>

                    {{--Índices--}}
                    <div class="d-flex text-center gap-0 mt-2">
                        @foreach ($respuestas as $index => $respuesta)
                            <div class="flex-fill border py-1 small">
                                {{ $index + 1 }}
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        @break

    @case(4)
        {{--BAI / Inventario de Ansiedad de Beck--}}
        <div class="container my-4">
            {{-- Encabezado de respuestas --}}
            <div class="row fw-bold border-bottom text-center" style="min-height: 60px;">
                @foreach($respuestas as $respuesta)
                    <div class="col-3 d-flex justify-content-center align-items-center">
                        <div class="respuesta-label text-center" style="font-size: 0.85rem; white-space: normal;">
                            {{ $respuesta->answer }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Espaciado visual entre texto y radios --}}
            <div class="row align-items-center" style="min-height: 60px; margin-top: 12px;">
                @foreach($respuestas as $respuesta)
                    <div class="col-3 text-center">
                            <input
                                type="radio"
                                class="respuesta"
                                name="respuestas[{{ $pregunta->id }}]"
                                value="{{ $respuesta->id }}"
                                data-pregunta="{{ $numPregunta }}"
                                data-pregunta-id="{{ $pregunta->id }}"
                                @if($pregunta->required) required @endif
                            >
                    </div>
                @endforeach
            </div>
        </div>
        @break
    @case(5)
        {{--Hereford--}}
        <div class="form-group mb-4">
            <input
                type="number"
                min="1"
                max="5"
                class="respuesta"
                name="respuesta_likert[{{ $pregunta->id }}]"
                id="respuesta_{{ $pregunta->id }}"
                data-pregunta="{{ $numPregunta }}"
                data-pregunta-id="{{ $pregunta->id }}"
                data-type="respuesta-likert-escrita"
                @if($pregunta->required) required @endif
                placeholder="1-5"
            >

            <br>
            <h4>Escriba el número correspondiente a la respuesta:</h4>
            @foreach ($respuestas as $respuesta)
                @php
                    $labelIndex = $respuesta->extra_data['label_index'] ?? null;
                    $label = $labels[$labelIndex] ?? $respuesta->answer;
                @endphp
                <label class="small d-block" for="respuesta_{{ $respuesta->id }}">
                   {{$labelIndex}}. {{ $label }}
                </label>
            @endforeach
        </div>
        @break
    @default
        <div class="form-group mb-4">
            <div class="d-flex flex-column gap-2">
                @foreach($respuestas as $respuesta)
                    @php
                        $labelIndex = $respuesta->extra_data['label_index'] ?? null;
                        $label = $labels[$labelIndex] ?? $respuesta->answer;
                    @endphp
                    <div class="form-check form-check-inline text-start">
                        <input
                            class="form-check-input respuesta"
                            type="radio"
                            name="respuestas[{{ $pregunta->id }}]"
                            id="respuesta_{{ $respuesta->id }}"
                            value="{{ $respuesta->id }}"
                            data-pregunta="{{ $numPregunta }}"
                            data-pregunta-id="{{ $pregunta->id }}"
                            @if($pregunta->required) required @endif
                        >
                        <label class="form-check-label small d-block" for="respuesta_{{ $respuesta->id }}">
                            {{ $label }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        @break
@endswitch

@push('sctripts')
    <script>
        window.respuestasLikertIds = window.respuestasLikertIds || {};
        window.respuestasLikertIds[{{ $pregunta->id }}] = {
            @foreach($respuestas as $respuesta)
                {{ $respuesta->extra_data['label_index'] ?? 'null' }}: {{ $respuesta->id }},
            @endforeach
        };
    </script>
@endpush