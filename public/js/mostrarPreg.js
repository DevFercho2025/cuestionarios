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
console.log("Script de mostrar preguntas inicializado.");

function inicializarMostrarPreguntas() {
    document.body.removeEventListener("change", manejarCambioRespuesta); // Evita duplicar eventos
    document.body.addEventListener("change", manejarCambioRespuesta);

    document.querySelectorAll('.respuesta').forEach(r => {
        r.style.opacity = '1';
        r.style.pointerEvents = 'auto'; // Habilita interacción con radios de respuestas
        r.disabled = false; 
    });
}

let respuestasEnGrupo = 0; // Contador de respuestas dentro del bloque de 3
const LIMITE_PREGUNTAS_POR_BLOQUE = 3; // Tamaño del bloque

function manejarCambioRespuesta(event) {
    if (event.target.classList.contains("respuesta")) {
        let preguntaActual = parseInt(event.target.dataset.pregunta);
        let siguientePreguntaDiv = document.getElementById(`pregunta-${preguntaActual + 1}`);

        console.log(`Respondida pregunta: ${preguntaActual}`);
        console.log(`Mostrando pregunta: ${preguntaActual + 1}`);

        //guardar la respuesta en el backend
        let preguntaId = event.target.name.match(/\d+/)[0];
        let respuestaId = event.target.value;

        let container = document.getElementById('respuestas-hidden-container');
        let existing = container.querySelector(`input[name="respuestas[${preguntaId}]"]`);

        if (existing) {
            existing.value = respuestaId;
        } else {
            let hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = `respuestas[${preguntaId}]`;
            hiddenInput.value = respuestaId;
            container.appendChild(hiddenInput);
        }

        //mostrar respuestas seleccionada en la consola
        let todasLasRespuestas = {};
        document.querySelectorAll('#respuestas-hidden-container input[type="hidden"]').forEach(input => {
            todasLasRespuestas[input.name] = input.value;
        });
        console.log("📋 Respuestas guardadas hasta ahora:", todasLasRespuestas);


        respuestasEnGrupo++; // Aumentamos el contador

        if (siguientePreguntaDiv) {
            siguientePreguntaDiv.style.display = "block";
        } else {
            let botonEnviar = document.getElementById("enviar");
            if (botonEnviar) {
                botonEnviar.style.display = "block";
            }
        }

        // Si ya respondimos 3 preguntas, ocultamos las anteriores
        if (respuestasEnGrupo === LIMITE_PREGUNTAS_POR_BLOQUE) {
            let preguntaInicialDelGrupo = preguntaActual - (LIMITE_PREGUNTAS_POR_BLOQUE - 1);
            
            for (let i = preguntaInicialDelGrupo; i <= preguntaActual; i++) {
                let preguntaDiv = document.getElementById(`pregunta-${i}`);
                if (preguntaDiv) {
                    preguntaDiv.style.display = "none";
                }
            }

            respuestasEnGrupo = 0; // Reiniciar el contador
        }
    }
}
inicializarMostrarPreguntas();