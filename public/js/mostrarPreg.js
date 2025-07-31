let respuestasEnGrupo = 0; // Contador de respuestas dentro del bloque de 3
const LIMITE_PREGUNTAS_POR_BLOQUE = 1; // Tamaño del bloque

if (document.readyState === "complete") {
    inicializarMostrarPreguntas();
    iniciarTemporizador();
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


document.addEventListener('input', function(event) {
    if (event.target.dataset?.type === 'respuesta-likert-escrita') {
        const input = event.target;
        let valor = parseInt(input.value, 10);

        if (isNaN(valor)) {
            input.value = '';
            return;
        }

        if (valor < 1) {
            input.value = 1;
        } else if (valor > 5) {
            input.value = 5;
        }
    }
});

let listo = false;
function manejarCambioRespuesta(event) {
    if (event.target.classList.contains("respuesta")) {
        console.log("entró");
        const preguntaId = event.target.dataset.preguntaId;
        const respuestaId = event.target.value;

        if (!preguntaId) {
            console.warn("No se encontró data-pregunta-id en el input:", event.target);
            return;
        }

        const container = document.getElementById('respuestas-hidden-container');
        const isCleaver = event.target.name.includes('bloque_');
        const tipo = event.target.dataset.type;
        let avanzar = false;
        if (tipo === 'severalChars') {
            if (listo) {
                const prevHidden = container.querySelectorAll(`input[name="respuestas[${preguntaId}][]"]`);
                prevHidden.forEach(input => input.remove());

                const checkboxes = document.querySelectorAll(`input[data-pregunta-id="${preguntaId}"]:checked`);
                checkboxes.forEach(cb => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = `respuestas[${preguntaId}][pdq][]`;
                    hiddenInput.value = cb.value;

                    container.appendChild(hiddenInput);
                });
                avanzar=true;
            } else {
                avanzar=false;
                return;
            }
        } else if(tipo === 'respuesta-likert-escrita'){
            const valueLt = parseInt(event.target.value.trim());
            const respuestasData = window.respuestasLikertIds?.[preguntaId]; // {1: 101, ..., 5: 105}
            const respuestaId = respuestasData?.[valueLt];

                if (!respuestaId) {
                    console.warn(`No se encontró respuesta para valor ${valueLt} en pregunta ${preguntaId}`);
                    return;
                }

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

                avanzar = true;
        } else if (isCleaver) {
            // Extraer tipo (M o L)
            let tipoSeleccion = null;
            let optionB = null;
            const tipoMatch = event.target.name.match(/\[([ML])\]$/);
            if (tipoMatch) {
                tipoSeleccion = tipoMatch[1];
            }

            const bloqueMatch = event.target.name.match(/\[.*bloque_([^\]]+)\]/);
            if (bloqueMatch) {
                optionB = bloqueMatch[1];
            }

            const hiddenName = `respuestas[${preguntaId}][bloque_${optionB}][${tipoSeleccion}]`;

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

            //Verificar si hay M y L para ese bloque
            const mInputChecked = document.querySelector(`input[name="respuestas[${preguntaId}][bloque_${optionB}][M]"]:checked`);
            const lInputChecked = document.querySelector(`input[name="respuestas[${preguntaId}][bloque_${optionB}][L]"]:checked`);
            if (mInputChecked && lInputChecked) {
                // Buscar el contenedor actual del bloque
                const bloqueActual = event.target.closest('.cleaver-bloque');
                const siguienteBloque = bloqueActual?.nextElementSibling;

                if (siguienteBloque && siguienteBloque.classList.contains('cleaver-bloque')) {
                    siguienteBloque.style.display = 'block';
                    bloqueActual.style.display = 'none';
                } else {
                    // Ya no hay más bloques, mostrar siguiente pregunta
                    const siguientePreguntaDiv = document.getElementById(`pregunta-${parseInt(preguntaId) + 1}`);
                    if (siguientePreguntaDiv) {
                        siguientePreguntaDiv.style.display = "block";
                        bloqueActual.style.display = 'none';
                    } else {
                        const botonEnviar = document.getElementById("enviar");
                        if (botonEnviar) {
                            botonEnviar.style.display = "block";
                            bloqueActual.style.display = 'none';
                        }
                    }
                }
            }
        } else if (event.target.type === "text") {
            const preguntaId = event.target.dataset.preguntaId;
            const inputs = document.querySelectorAll(`input[data-pregunta-id="${preguntaId}"].respuesta`);
            const container = document.getElementById('respuestas-hidden-container');
            let todosLlenos = true;

            inputs.forEach(input => {
                if (input.value.trim() === "") {
                    todosLlenos = false;
                }
            });

            if (!todosLlenos) return;

            container.querySelectorAll(`input[name^="respuestas[${preguntaId}]"]`).forEach(el => el.remove());

            //formato: respuestas[preguntaId][respuestaId] = valor
            inputs.forEach(input => {
                const respuestaId = input.dataset.respuestaId;
                const valor = input.value.trim();

                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = `respuestas[${preguntaId}][patronNum][${respuestaId}]`;
                hiddenInput.value = valor;
                container.appendChild(hiddenInput);
            });

            avanzar = true;
        } else if (event.target.tagName === "TEXTAREA") { //pregunta abierta
            const preguntaId = event.target.dataset.preguntaId;
            const texto = event.target.value;
            
            const respuestaIdInput = document.querySelector(`input[name="respuestas[${preguntaId}][respuesta_id]"]`);
            const respuestaId = respuestaIdInput?.value || null;

            const payload = {
                [`respuestas[${preguntaId}][respuesta_id]`]: respuestaId,
                [`respuestas[${preguntaId}][texto]`]: texto
            };

            const preguntaActual = parseInt(event.target.dataset.pregunta);
            const siguientePreguntaDiv = document.getElementById(`pregunta-${preguntaActual + 1}`);
            if (siguientePreguntaDiv) {
                siguientePreguntaDiv.style.display = "block";
            }

            respuestasEnGrupo++;
            if (respuestasEnGrupo === LIMITE_PREGUNTAS_POR_BLOQUE) {
                const inicio = preguntaActual - (LIMITE_PREGUNTAS_POR_BLOQUE - 1);
                for (let i = inicio; i <= preguntaActual; i++) {
                    const preguntaDiv = document.getElementById(`pregunta-${i}`);
                    if (preguntaDiv) preguntaDiv.style.display = "none";
                }
                respuestasEnGrupo = 0;
            }

            $.ajax({
                url: RUTA_GUARDAR_RESPUESTAS,
                method: 'POST',
                data: payload,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    //console.log("Pregunta abierta enviada:", response);
                },
                error: function (xhr, status, error) {
                    //console.error("Error al enviar respuesta abierta:", error);
                }
            });

            return;
        } else {
            // Pregunta normal
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
            avanzar = true;
        }

        guardarRespuestasDesdeHiddenInputs();

        //Avanzar si corresponde
        if (avanzar) {
           const preguntaActual = parseInt(event.target.dataset.pregunta);
    
            if (tipo === 'likertBFQ') {
                setTimeout(() => {
                    avanzarAPreguntaSiguiente(preguntaActual);
                }, 1500); // Esperar 1.5 segundo
            } else {
                avanzarAPreguntaSiguiente(preguntaActual);
            }
        }
    }
}

function avanzarAPreguntaSiguiente(preguntaActual) {
    const siguientePreguntaDiv = document.getElementById(`pregunta-${preguntaActual + 1}`);

    if (siguientePreguntaDiv) {
        siguientePreguntaDiv.style.display = "block";
    } else {
        const botonEnviar = document.getElementById("enviar");
        if (botonEnviar) {
            botonEnviar.style.display = "block";
        }
    }

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

function iniciarTemporizador() {
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

            alert("tiempo agotado, enviando tus respuestas.")
            
            document.querySelector("form").submit();
        }
    }, 1000);
}

document.querySelectorAll('.cleaver-bloque').forEach((bloque, index) => {
    if (index > 1) {
        bloque.style.display = 'none';
    }
});


let formSubmitting = false;
document.querySelector("form").addEventListener("submit", function (e) {
    if (formSubmitting) return;

    e.preventDefault();

    formSubmitting = true;
    this.submit(); // Envío real
});


document.addEventListener("click", function (e) {
    //pdq
    if (e.target.classList.contains("btn-listo")) {
        listo = true;
        console.log("clic a listo");
        const respuestaElement = document.querySelector(".respuesta");
        if (respuestaElement) {
            manejarCambioRespuesta({ target: respuestaElement });
        }
    }

    //zavik o lifo
    if (e.target.classList.contains("btn-listo-ordenamiento")) {
        const preguntaId = e.target.dataset.preguntaId;
        const numPregunta = parseInt(e.target.dataset.pregunta);

        const lista = document.getElementById(`clone-source-${preguntaId}`);
        if (!lista) return;

        const inputs = lista.querySelectorAll("input.puntuacion-input");
        const container = document.getElementById("respuestas-hidden-container");

        container.querySelectorAll(`input[name^="respuestas[${preguntaId}][zavik]"]`).forEach(el => el.remove());

        inputs.forEach(input => {
            const respuestaId = input.closest("[data-respuesta-id]").dataset.respuestaId;
            const puntaje = input.value.trim();

            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = `respuestas[${preguntaId}][zavik][${respuestaId}]`;
            hiddenInput.value = puntaje;
            container.appendChild(hiddenInput);
        });

        guardarRespuestasDesdeHiddenInputs();
        avanzarAPreguntaSiguiente(numPregunta);
    }

});


function guardarRespuestasDesdeHiddenInputs() {
    const container = document.getElementById("respuestas-hidden-container");
    const todasLasRespuestas = {};

    container.querySelectorAll('input[type="hidden"]').forEach(input => {
        const name = input.name;

        if (name.endsWith('[]')) {
            const key = name.slice(0, -2);
            if (!todasLasRespuestas[key]) {
                todasLasRespuestas[key] = [];
            }
            todasLasRespuestas[key].push(input.value);
        } else {
            todasLasRespuestas[name] = input.value;
        }
    });

    console.log("Respuestas guardadas:", todasLasRespuestas);

    $.ajax({
        url: RUTA_GUARDAR_RESPUESTAS,
        method: "POST",
        data: todasLasRespuestas,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        success: function (response) {
            console.log("Respuestas enviadas correctamente");
        },
        error: function (xhr) {
            console.error("Error al enviar respuestas", xhr);
        }
    });
}

//instrucciones
function mostrarFormulario() {
    document.getElementById('contenedor-instrucciones').classList.add('d-none');
    document.getElementById('formulario-preguntas').classList.remove('d-none');
}

document.addEventListener('respuestaReordenada', function (e) {
    console.log('Se reordenó la lista de la pregunta ID:', e.detail.preguntaId);
    console.log('Nuevo orden:', e.detail.ordenActual);
});