@php
    $likertLabels = {
        1: ['Totalmente en desacuerdo', 'En desacuerdo', 'De acuerdo', 'Totalmente de acuerdo'],
        2: ['Totalmente en desacuerdo', 'En desacuerdo', 'Neutral', 'De acuerdo', 'Totalmente de acuerdo'],
        3: ['Completamente falso para mí', 'Bastante falso para mí', 'Ni verdadero ni falso para mí', 'Bastante verdadero para mí', 'Completamente verdadro para mí'], //BFQ
        4: ['En absoluto', 'Levemente', 'Moderadamente', 'Severamente'], //BAI
        5: ['Me desagrada mucho', 'no me gusta','Me es indiferente','Me gusta','Me gusta mucho'], //Hereford
        6: ['Me gusta','Me es indiferente o tengo dudas','No me gusta','No conozco esa actividad o profesión'], //IPP
        7: ['Mucho','Poco','Nada']
    };
@endphp

<div class="form-group mb-4">
    <div class="d-flex flex-column gap-2">
        @php
            $respuestas = $pregunta->respuestas->sortBy(fn($r) => $r->extra_data['label_index']);
            $scaleType = $respuestas->first()->extra_data['scale_type'] ?? null;
            $labels = $likertLabels[$scaleType] ?? [];
        @endphp
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