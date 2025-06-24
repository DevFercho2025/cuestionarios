@php
    $pares = collect($pregunta->respuestas)->groupBy(fn($r) => $r->extra_data['pair_id'] ?? 'sin_pair_id');

    $left = collect();
    $right = collect();

    foreach ($pares as $pair) {
        $left->push($pair[0]);
        $right->push($pair[1]);
    }

    $left = $left->shuffle(); 
    $right = $right->shuffle();
@endphp

<head>
    <style>
    .selected {
        background-color: #d0ebff;
    }
    .disabled {
        pointer-events: none;
        opacity: 0.6;
    }
    </style>
</head>

<div class="row">
    <h5>Ordene los pares.</h5>

    <div class="col-md-6">
        <ul id="column-a-{{ $numPregunta }}" class="list-group p-2 border" data-column="a">
            @foreach ($izquierda as $item)
                <li class="list-group-item"
                    id="item-a-{{ $item->id }}"
                    data-id="{{ $item->id }}">
                    {{ $item->answer }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-6">
        <ul id="column-b-{{ $numPregunta }}" class="list-group p-2 border" data-column="b">
            @foreach ($derecha as $item)
                <li class="list-group-item"
                    id="item-b-{{ $item->id }}"
                    data-id="{{ $item->id }}">
                    {{ $item->answer }}
                </li>
            @endforeach
        </ul>
    </div>
</div>

<input type="hidden"
    name="matches[{{ $pregunta->id }}]"
    id="answers-{{ $pregunta->id }}"
    data-pregunta-id="{{ $pregunta->id }}">

<script src="https://cdnjs.cloudflare.com/ajax/libs/leader-line/1.0.8/leader-line.min.js"></script>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-pregunta-id]').forEach(contenedor => {
            const preguntaId = contenedor.dataset.preguntaId;
            const Answersinput = document.getElementById('answers-' + preguntaId);

            let selectedA = null;
            let connections = [];

            //Seleccionar ítems dentro de cada columna
            const itemsA = contenedor.querySelectorAll('[data-column="a"] .list-group-item');
            const itemsB = contenedor.querySelectorAll('[data-column="b"] .list-group-item');

            function clearSelection() {
                itemsA.forEach(item => item.classList.remove('selected'));
                itemsB.forEach(item => item.classList.remove('selected'));
            }

            itemsA.forEach(item => {
                item.addEventListener("click", () => {
                    clearSelection();
                    selectedA = item;
                    item.classList.add("selected");
                });
            });

            itemsB.forEach(item => {
                item.addEventListener("click", () => {
                    if (selectedA) {
                        item.classList.add("selected");

                        const line = new LeaderLine(
                            selectedA,
                            item,
                            {
                                color: '#0d6efd',
                                size: 4,
                                path: 'straight'
                            }
                        );

                        connections.push({
                            idA: selectedA.dataset.id,
                            idB: item.dataset.id,
                            line: line
                        });

                        selectedA.classList.add("disabled");
                        item.classList.add("disabled");

                        selectedA = null;
                        clearSelection();

                        //actualiza guardado de respuestas
                        const data = connections.map(c => ({
                            left_id: c.idA,
                            right_id: c.idB
                        }));
                        input.value = JSON.stringify(data);
                    }
                });
            });
        });
    });
</script>
@endpush
