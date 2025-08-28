<style>
    .video {
        width: 800px;
        height: 600px;
        object-fit: cover;
        display: block;
        margin-bottom: 10px;
    }

    .answer-photo {
        width: 800px;
        height: 600px;
        object-fit: cover;
        margin-top: 10px;
        display: none;
    }

    .actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 800px;
        margin-top: 5px;
    }

    @keyframes pulseAnim {
        0%   { transform: scale(1); }
        50%  { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .pulse {
        animation: pulseAnim 0.3s ease;
    }
</style>
@foreach ($pregunta->respuestas as $respuesta)
    <div class="form-group w-100">
        <div class="video-wrap">
            <video class="video" autoplay playsinline></video>
        </div>

        <div class="actions">
            <button type="button" class="btn btn-secondary answer-photo-btn">Tomar foto</button>
            <button type="button" class="btn btn-secondary toggle-photo-btn">Ver foto</button>
        </div>

        <img src="" class="answer-photo"
            name="respuestas[{{ $pregunta->id }}][foto]"
            data-pregunta="{{ $numPregunta }}"
            data-pregunta-id="{{ $pregunta->id }}"
            @if($pregunta->required) required @endif
        >

        <input type="hidden" 
            name="respuestas[{{ $pregunta->id }}][respuesta_id]"
            value="{{ $pregunta->respuestas->first()->id ?? '' }}">
    </div>
@endforeach