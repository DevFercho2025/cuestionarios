<head>
    <style>
        #sortable-cards {
            gap: 10px;
        }

        .drag-item {
            user-select: none;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .sortable-ghost {
            opacity: 0.5;
            background-color: #e0e0e0;
        }

        .respuesta {
            margin-bottom: 10px;
        }

        .form-check-label {
            display: block;
            text-align: left;
        }

        .form-check {
            min-height: 60px;
            display: flex;
            align-items: center;
        }
    </style>
</head>

@php
    $respuestaBase = $pregunta->respuestas[0] ?? null;
    $esOrdenable = $respuestaBase && !empty($respuestaBase->extra_data['ordenar']);
@endphp

    @if($esOrdenable)
        @php
            $palabras = explode(' ', $pregunta->question);
            shuffle($palabras);
        @endphp
        <div class="row">
            <div class="col-12">
                <div id="sortable-cards-{{ $pregunta->id }}" class="d-flex flex-wrap gap-2">
                    @foreach ($palabras as $index => $palabra)
                        <div class="drag-item card cursor-move p-2 text-center" 
                            data-palabra-index="{{ $index }}" 
                            style="min-width: 100px;">
                            <input type="hidden"
                                name="puntajes[{{ $pregunta->id }}][{{ $index }}]"
                                class="puntuacion-input"
                                value="{{ $index + 1 }}">
                            <h5 class="palabra mb-0">{{ $palabra }}</h5>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-check gap-2">
        <input class="form-check-input respuesta" type="radio"
            data-type="ToF"
            data-pregunta-id="{{ $pregunta->id }}"
            value="{{ $respuesta->id }}"
            data-pregunta="{{ $numPregunta }}"
            @if($pregunta->required) required @endif>
            <label class="form-check-label">
                {{ $respuesta->option }}&#41; {{ $respuesta->answer }}
            </label>
    </div>
@endforeach