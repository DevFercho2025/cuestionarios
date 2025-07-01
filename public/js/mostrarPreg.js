/*//muestra de a una pregunta
console.log("Script de mostrar preguntas inicializado.");

function inicializarMostrarPreguntas() {
    console.log("`inicializarMostrarPreguntas()` ejecutado.");

    document.body.removeEventListener("change", manejarCambioRespuesta); // Evita duplicar eventos
    document.body.addEventListener("change", manejarCambioRespuesta);
}
/*
function manejarCambioRespuesta(event) {
    if (event.target.classList.contains("respuesta")) {
        let preguntaActual = parseInt(event.target.dataset.pregunta);
        let preguntaActualDiv = document.getElementById(`pregunta-${preguntaActual}`);
        let siguientePreguntaDiv = document.getElementById(`pregunta-${preguntaActual + 1}`);

        console.log(`Respondida pregunta: ${preguntaActual}`);
        console.log(`Mostrando pregunta: ${preguntaActual + 1}`);

        if (preguntaActualDiv) {
            preguntaActualDiv.style.display = "none";
        }
        if (siguientePreguntaDiv) {
            siguientePreguntaDiv.style.display = "block";
        } else {
            let botonEnviar = document.getElementById("enviar");
            if (botonEnviar) {
                botonEnviar.style.display = "block";
            }
        }
    }
}

// Ejecutar cuando el script se cargue
inicializarMostrarPreguntas();*/

//para mostrar de a 3 preguntas c:

let respuestasEnGrupo = 0; // Contador de respuestas dentro del bloque de 3
const LIMITE_PREGUNTAS_POR_BLOQUE = 2; // Tamaño del bloque


if (document.readyState === "complete") {
    inicializarMostrarPreguntas();
    iniciarTemporizador();
    console.log(document.querySelector('input[name="rango_inicio"]'));
    console.log(document.querySelector('input[name="rango_fin"]'));
}

function inicializarMostrarPreguntas() {
    document.body.removeEventListener("change", manejarCambioRespuesta); // Evita duplicar eventos
    document.body.addEventListener("change", manejarCambioRespuesta);

    document.querySelectorAll('.respuesta').forEach(r => {
        r.style.opacity = '1';
        r.style.pointerEvents = 'auto'; // Habilita interacción con radios de respuestas
        r.disabled = false; 
    });
}

function manejarCambioRespuesta(event) {
    if (event.target.classList.contains("respuesta")) {
        const preguntaId = event.target.dataset.preguntaId;
        const respuestaId = event.target.value;

        if (!preguntaId) {
            console.warn("No se encontró data-pregunta-id en el input:", event.target);
            return;
        }

        const container = document.getElementById('respuestas-hidden-container');

        // Detectar si es Cleaver
        const isCleaver = event.target.name.includes('bloque_');
        if (isCleaver) {
            // Extraer tipo (M o L)
            let tipoSeleccion = null;
            let optionB = null;
            const tipoMatch = event.target.name.match(/\[([ML])\]$/);

            if (tipoMatch) {
                tipoSeleccion = tipoMatch[1]; 
            }

            //option de bloque (a, b...)
            const bloqueMatch = event.target.name.match(/\[.*bloque_([^\]]+)\]/);
            if (bloqueMatch) {
                optionB = bloqueMatch[1];
            }

            const hiddenName = `respuestas[${preguntaId}][bloque_${optionB}][${tipoSeleccion}]`;

            // Reemplazar o agregar input oculto para este bloque y tipo
            let existing = container.querySelector(`input[name="${hiddenName}"]`);
            if (existing) {
                existing.value = respuestaId;
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = hiddenName;
                hiddenInput.value = respuestaId;
                container.appendChild(hiddenInput);
            }

        } else {
            // Pregunta normal (abierta o selección)
            const hiddenName = `respuestas[${preguntaId}]`;
            let existing = container.querySelector(`input[name="${hiddenName}"]`);
            if (existing) {
                existing.value = respuestaId;
            } else {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = hiddenName;
                hiddenInput.value = respuestaId;
                container.appendChild(hiddenInput);
            }
        }

        // Mostrar en consola
        const todasLasRespuestas = {};
        document.querySelectorAll('#respuestas-hidden-container input[type="hidden"]').forEach(input => {
            todasLasRespuestas[input.name] = input.value;
        });
        console.log("📋 Respuestas guardadas hasta ahora:", todasLasRespuestas);

        // Avanzar pregunta
        const preguntaActual = parseInt(event.target.dataset.pregunta);
        const siguientePreguntaDiv = document.getElementById(`pregunta-${preguntaActual + 1}`);

        if (siguientePreguntaDiv) {
            siguientePreguntaDiv.style.display = "block";
        } else {
            const botonEnviar = document.getElementById("enviar");
            if (botonEnviar) {
                botonEnviar.style.display = "block";
            }
        }

        // Control de grupo
        respuestasEnGrupo++;
        if (respuestasEnGrupo === LIMITE_PREGUNTAS_POR_BLOQUE) {
            const inicio = preguntaActual - (LIMITE_PREGUNTAS_POR_BLOQUE - 1);
            for (let i = inicio; i <= preguntaActual; i++) {
                const preguntaDiv = document.getElementById(`pregunta-${i}`);
                if (preguntaDiv) preguntaDiv.style.display = "none";
            }
            respuestasEnGrupo = 0;
        }
    }
}

function iniciarTemporizador() {
    console.log("script para temporizador de evaluación cargado");

    const progresoTexto = document.querySelector(".texto-Progreso");
    const idSeccion = progresoTexto.dataset.idSeccion;

    const temporizadorElemento = document.getElementById("temporizador-" + idSeccion);
    let tiempoAgotadoInput = document.getElementById("tiempo_agotado");
    temporizadorElemento.style.display = "block";

    let tiempoTexto = temporizadorElemento.textContent.match(/\d{1,2}:\d{2}/);
    let [minutos, segundos] = tiempoTexto[0].split(":").map(num => parseInt(num, 10)); //guarda min y seg por separado, los pone entre :
    let tiempoRestante = (minutos * 60) + segundos; //convierte el tiempo a segundos

    let intervalo = setInterval(() => {
        if (tiempoRestante > 0) {
            tiempoRestante--;
            let min = Math.floor(tiempoRestante / 60);
            let seg = tiempoRestante % 60;
            temporizadorElemento.textContent = `Tiempo restante: ${min}:${seg.toString().padStart(2, '0')}`;
        } else {
            clearInterval(intervalo);
            temporizadorElemento.textContent = "Tiempo agotado";
            tiempoAgotadoInput.value = "1";

            //desabilitar respuestas
            let respuestas = document.querySelectorAll(".pregunta .respuesta");
            document.querySelectorAll(".pregunta .form-check-input").forEach(input => {
                input.disabled = true;
            });


            //alert("Se agotó el tiempo para esta sección.");
            document.querySelector("form").submit(); //click a siguiente automáticamente
        }
    }, 1000);
}

document.querySelectorAll('.cleaver-bloque').forEach((bloque, index) => {
    if (index > 1) {
        bloque.style.display = 'none';
    }
});