@php
    $pares = collect($pregunta->respuestas)->groupBy(fn($r) => $r->extra_data['pair_id'] ?? 'sin_pair_id');

    $izquierda = collect();
    $derecha = collect();

    foreach ($pares as $pair) {
        $izquierda->push($pair[0]);
        $derecha->push($pair[1]);
    }

    $izquierda = $izquierda->shuffle(); 
    $derecha = $derecha->shuffle();
@endphp
<div class="row">
    <h5>Ordene los pares.</h5>

    <div class="col-md-6">
        <ul id="columna-a-{{ $numPregunta }}" class="list-group p-2 border" data-columna="a">
            @foreach ($izquierda as $item)
                <li class="list-group-item"
                    draggable="true"
                    data-id="{{ $item->id }}">
                    {{ $item->answer }}
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-6">
        <ul id="columna-b-{{ $numPregunta }}" class="list-group p-2 border" data-columna="b">
            @foreach ($derecha as $item)
                <li class="list-group-item"
                    draggable="true"
                    data-id="{{ $item->id }}">
                    {{ $item->answer }}
                </li>
            @endforeach
        </ul>
    </div>
</div>

<input type="hidden"
    name="pareamientos[{{ $pregunta->id }}]"
    id="respuestas-{{ $pregunta->id }}"
    data-pregunta-id="{{ $pregunta->id }}">

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const columnaA = document.getElementById('columna-a-{{ $numPregunta }}');
    const columnaB = document.getElementById('columna-b-{{ $numPregunta }}');
    const inputRespuestas = document.getElementById('respuestas-{{ $pregunta->id }}');

    const opcionesSortable = {
        group: 'pares-{{ $numPregunta }}',
        animation: 150,
        onEnd: actualizarOrden
    };

    Sortable.create(columnaA, opcionesSortable);
    Sortable.create(columnaB, opcionesSortable);

    function actualizarOrden() {
        const ordenA = [...columnaA.children].map(el => el.dataset.id);
        const ordenB = [...columnaB.children].map(el => el.dataset.id);

        // Emparejar según la posición (índice)
        const pares = [];
        for (let i = 0; i < Math.min(ordenA.length, ordenB.length); i++) {
            pares.push({
                source_id: ordenA[i],
                target_id: ordenB[i]
            });
        }

        inputRespuestas.value = JSON.stringify(pares);
        console.log("🔗 Pareamientos actualizados:", pares);
    }
});
</script>
@endpush
