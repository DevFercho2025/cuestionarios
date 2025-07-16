<head>
    <style>
        #sortable-cards {
            min-height: 100px;
            position: relative;
        }

        #sortable-cards .drag-item {
            position: relative;
            cursor: grab;
            user-select: none;
        }

        .sortable-ghost {
            opacity: 0.4;
            background-color: #eee;
            border: 2px dashed #aaa;
        }
    </style>
</head>

@php
    $respuestaBase = $pregunta->respuestas[0] ?? null;
    $esOrdenable = $respuestaBase && !empty($respuestaBase->extra_data['ordenar']);
    $palabras = explode(' ', $pregunta->question);
@endphp

    @if($esOrdenable)
        <div id="sortable-cards" class="row gap-3">
            @foreach ($palabras as $index => $palabra)
                <div class="col-auto drag-item" style="width: 18rem;">
                    <div class="card cursor-move p-1">
                        <div class="card-body text-center">
                            <h4>{{ $palabra }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-check">
        <input class="form-check-input respuesta" type="radio"
            data-pregunta-id="{{ $pregunta->id }}"
            value="{{ $respuesta->id }}"
            data-pregunta="{{ $numPregunta }}"
            @if($pregunta->required) required @endif>
            <label class="form-check-label">
                {{ $respuesta->option }}&#41; {{ $respuesta->answer }}
            </label>
    </div>
@endforeach