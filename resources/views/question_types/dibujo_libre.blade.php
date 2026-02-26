{{-- Dibujo Libre: el candidato dibuja en un canvas y se captura como imagen --}}
<style>
    .canvas-dibujo {
        border: 2px solid #333;
        border-radius: 8px;
        background: #fff;
        cursor: crosshair;
        touch-action: none;
    }
    .canvas-toolbar {
        display: flex;
        gap: 10px;
        align-items: center;
        margin-bottom: 10px;
    }
    .canvas-toolbar button {
        padding: 6px 14px;
    }
    .canvas-toolbar input[type="color"] {
        width: 36px;
        height: 36px;
        border: none;
        padding: 0;
        cursor: pointer;
    }
    .canvas-toolbar input[type="range"] {
        width: 100px;
    }
</style>

<div class="form-group w-100">
    <div class="canvas-toolbar">
        <input type="color" class="color-picker" value="#000000" title="Color">
        <label class="small">Grosor:</label>
        <input type="range" class="grosor-picker" min="1" max="20" value="3">
        <button type="button" class="btn btn-sm btn-outline-secondary btn-borrar-canvas">Borrar</button>
    </div>

    <canvas class="canvas-dibujo" width="700" height="500"
        data-pregunta-id="{{ $pregunta->id }}"
        data-pregunta="{{ $numPregunta }}">
    </canvas>

    <input type="hidden" class="respuesta canvas-data"
        name="respuestas[{{ $pregunta->id }}][texto]"
        data-pregunta="{{ $numPregunta }}"
        data-pregunta-id="{{ $pregunta->id }}">

    <input type="hidden"
        name="respuestas[{{ $pregunta->id }}][respuesta_id]"
        value="{{ $pregunta->respuestas->first()->id ?? '' }}">
</div>

@push('scripts')
<script>
(function() {
    const canvas = document.querySelector('canvas[data-pregunta-id="{{ $pregunta->id }}"]');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    const toolbar = canvas.closest('.form-group').querySelector('.canvas-toolbar');
    const colorPicker = toolbar.querySelector('.color-picker');
    const grosorPicker = toolbar.querySelector('.grosor-picker');
    const btnBorrar = toolbar.querySelector('.btn-borrar-canvas');
    const hiddenInput = canvas.closest('.form-group').querySelector('.canvas-data');
    let drawing = false;

    ctx.fillStyle = '#fff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';

    function getPos(e) {
        const rect = canvas.getBoundingClientRect();
        const touch = e.touches ? e.touches[0] : e;
        return {
            x: (touch.clientX - rect.left) * (canvas.width / rect.width),
            y: (touch.clientY - rect.top) * (canvas.height / rect.height)
        };
    }

    function startDraw(e) {
        e.preventDefault();
        drawing = true;
        const p = getPos(e);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
    }

    function draw(e) {
        if (!drawing) return;
        e.preventDefault();
        ctx.strokeStyle = colorPicker.value;
        ctx.lineWidth = grosorPicker.value;
        const p = getPos(e);
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
    }

    function endDraw() {
        if (!drawing) return;
        drawing = false;
        hiddenInput.value = canvas.toDataURL('image/png');
    }

    canvas.addEventListener('mousedown', startDraw);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', endDraw);
    canvas.addEventListener('mouseleave', endDraw);
    canvas.addEventListener('touchstart', startDraw);
    canvas.addEventListener('touchmove', draw);
    canvas.addEventListener('touchend', endDraw);

    btnBorrar.addEventListener('click', function() {
        ctx.fillStyle = '#fff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        hiddenInput.value = '';
    });
})();
</script>
@endpush
