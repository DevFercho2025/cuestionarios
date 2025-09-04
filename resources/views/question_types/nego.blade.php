@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-check mb-3">
        <input class="form-check-input respuesta" type="radio"
            name="respuestas[{{ $pregunta->id }}]"
            value="{{ $respuesta->id }}"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            @if($pregunta->required) required @endif>

        <label class="form-check-label d-block">
            {{ $respuesta->option }}&#41; {{ $respuesta->answer }}

            @if (!empty($respuesta->extra_data['file_path']))
                <div class="relative mt-3" style="position: relative; display: inline-block;">
                    <img src="{{ asset('assets/img/' . $respuesta->extra_data['file_path']) }}" 
                        alt="Imagen de la respuesta" 
                        style="max-width: 100%; height: auto; display: block;">

                    @php
                        $quadrant = $respuesta->extra_data['quadrant'] ?? null;
                        $positions = [
                            'tl' => 'top: 5%; left: 5%;',
                            'tr' => 'top: 5%; right: 5%;',
                            'bl' => 'bottom: 5%; left: 5%;',
                            'br' => 'bottom: 5%; right: 5%;',
                        ];
                    @endphp

                    @if ($quadrant && isset($positions[$quadrant]))
                        <textarea name="comentarios[{{ $respuesta->id }}]" 
                            placeholder="Escribe tu comentario aquí..."
                            style="position: absolute; {{ $positions[$quadrant] }} 
                                   width: 40%; height: 60px; resize: none;
                                   background: rgba(255,255,255,0.8); 
                                   border: 1px solid #ccc; border-radius: 6px; padding: 5px;">
                        </textarea>
                    @endif
                </div>
            @endif
        </label>
    </div>
@endforeach
