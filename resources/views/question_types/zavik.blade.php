<div class="row">
    <div class="col-md-6 col-12 mb-md-0 mb-6">
        <ul class="list-group list-group-flush" id="clone-source-{{ $pregunta->id }}" data-type="{{ count($pregunta->respuestas) > 4 ? 'hartman' : 'zavic' }}">
            @foreach ($pregunta->respuestas as $respuesta)
                <li class="list-group-item drag-item cursor-move d-flex justify-content-between align-items-center"
                    data-respuesta-id="{{ $respuesta->id }}">
            
                <div class="d-flex align-items-center gap-2">
                    <input type="number"
                        class="form-control form-control-sm puntuacion-input"
                        name="puntajes[{{ $pregunta->id }}][{{ $respuesta->id }}]"
                        value=""
                        readonly
                        style="width: 60px;" />
                    <span class="mb-0">{{ $respuesta->option }}&#41; {{ $respuesta->answer }}</span>
                </div>

                @if (!empty($respuesta->imagen))
                    <img class="rounded-circle" src="{{ asset($respuesta->imagen) }}" alt="avatar-{{ $respuesta->id }}" height="32" width="32" />
                @endif
                </li>
            @endforeach
        </ul>
        <button type="button"
            class="btn btn-success mt-3 btn-listo-ordenamiento"
            data-pregunta-id="{{ $pregunta->id }}"
            data-pregunta="{{ $numPregunta }}">
            Listo
        </button>
    </div>
</div>