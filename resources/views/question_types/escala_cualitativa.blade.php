{{-- Escala Cualitativa: escala tipo rúbrica con niveles descriptivos (Excelente, Bueno, Regular, Deficiente, etc.) --}}
<style>
    .escala-cualitativa .escala-option {
        display: flex;
        align-items: center;
        padding: 10px 14px;
        margin-bottom: 6px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .escala-cualitativa .escala-option:hover {
        border-color: #90caf9;
        background-color: #f5f9ff;
    }
    .escala-cualitativa input[type="radio"]:checked + .escala-label {
        font-weight: bold;
    }
    .escala-cualitativa input[type="radio"]:checked ~ .escala-option,
    .escala-cualitativa .escala-option.selected {
        border-color: #1976d2;
        background-color: #e3f2fd;
    }
    .escala-nivel {
        display: inline-block;
        width: 28px;
        height: 28px;
        line-height: 28px;
        text-align: center;
        border-radius: 50%;
        background-color: #e0e0e0;
        font-weight: bold;
        font-size: 0.85rem;
        margin-right: 12px;
        flex-shrink: 0;
    }
</style>

<div class="escala-cualitativa form-group w-100">
    @foreach ($pregunta->respuestas as $index => $respuesta)
        <label class="escala-option" for="escala_{{ $respuesta->id }}">
            <input class="form-check-input respuesta" type="radio"
                name="respuestas[{{ $pregunta->id }}]"
                id="escala_{{ $respuesta->id }}"
                value="{{ $respuesta->id }}"
                data-pregunta="{{ $numPregunta }}"
                data-pregunta-id="{{ $pregunta->id }}"
                @if($pregunta->required) required @endif
                style="margin-right: 12px;">
            <span class="escala-nivel">{{ $index + 1 }}</span>
            <span class="escala-label">
                @if($respuesta->option)
                    <strong>{{ $respuesta->option }})</strong>
                @endif
                {{ $respuesta->answer }}
            </span>
        </label>
    @endforeach
</div>
