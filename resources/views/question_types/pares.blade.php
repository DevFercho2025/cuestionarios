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

<div class="row" data-pregunta-id="{{ $numPregunta }}" data-role="pregunta">
    <h5>Ordene los pares.</h5>

    <div class="col-md-6">
        <ul id="column-a-{{ $numPregunta }}" class="list-group p-2 border" data-column="a">
            @foreach ($left as $item)
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
            @foreach ($right as $item)
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
    name="matches[{{ $numPregunta }}]"
    id="answers-{{$numPregunta }}"
    data-pregunta-id="{{ $numPregunta }}">