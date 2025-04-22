
        // Este script debe ir al final de tu archivo o en @section('scripts')
        document.addEventListener('DOMContentLoaded', function() {

            M.AutoInit();
            // 1. Variables iniciales
            const preguntas = document.querySelectorAll('.pregunta');
            const totalPreguntas = preguntas.length;
            let preguntasRespondidas = 0;
            let preguntaActual = 0;

            // 2. Referencias a elementos DOM
            const circuloProgreso = document.querySelector('.circulo-Progreso');
            const valorProgreso = document.querySelector('.valor-Progreso');
            const textoSeccion = document.querySelector('.texto-Progreso');
            const temporizadores = document.querySelectorAll('.temporizador');
            const btnEnviar = document.getElementById('enviar');

            // 3. Función para actualizar el círculo de progreso
            function actualizarProgreso() {
                // Calcular porcentaje basado en respuestas dadas
                const porcentaje = Math.round((preguntasRespondidas / totalPreguntas) * 100);

                // Actualizar el texto del porcentaje
                valorProgreso.textContent = `${porcentaje}%`;

                // Actualizar el gradiente cónico (convertir porcentaje a grados: 0% = 0deg, 100% = 360deg)
                const grados = (porcentaje / 100) * 360;
                circuloProgreso.style.backgroundImage = `conic-gradient(blue ${grados}deg, #ededed 0deg)`;
            }

            // 4. Función para mostrar la pregunta actual
            function mostrarPregunta(index) {
                // Ocultar todas las preguntas y mostrar solo la actual
                preguntas.forEach((pregunta, i) => {
                    pregunta.style.display = (i === index) ? 'block' : 'none';
                });

                // Actualizar el índice de la pregunta actual
                preguntaActual = index;

                // Determinar a qué sección pertenece esta pregunta
                const preguntaElement = preguntas[index];

                // Obtener la sección actual desde los datos disponibles
                const seccionActual = obtenerSeccionDePregunta(preguntaElement);

                // Actualizar la visualización del temporizador
                actualizarTemporizador(seccionActual);
            }

            // 5. Función para obtener la sección de una pregunta
            function obtenerSeccionDePregunta(preguntaElement) {
                // Intentar obtener el ID de sección de diferentes maneras
                // 1. Directamente del atributo data-seccion-id de la pregunta
                let seccionId = preguntaElement.getAttribute('data-seccion-id');

                // 2. Si no existe, intentar encontrarlo en algún elemento hijo
                if (!seccionId) {
                    // Buscar en los inputs para ver si tienen un atributo relacionado con la sección
                    const inputs = preguntaElement.querySelectorAll('input');
                    for (const input of inputs) {
                        const seccionTemp = input.getAttribute('data-seccion-id');
                        if (seccionTemp) {
                            seccionId = seccionTemp;
                            break;
                        }
                    }
                }

                // 3. Como último recurso, extraer del ID de la pregunta si sigue un patrón
                if (!seccionId && preguntaElement.id) {
                    // Esto depende de tu estructura de IDs
                    const idMatch = preguntaElement.id.match(/pregunta-(\d+)-seccion-(\d+)/);
                    if (idMatch && idMatch[2]) {
                        seccionId = idMatch[2];
                    }
                }

                return seccionId;
            }

            // 6. Función para actualizar el temporizador visible
            function actualizarTemporizador(seccionId) {
                // Ocultar todos los temporizadores
                temporizadores.forEach(temp => {
                    temp.style.display = 'none';
                });

                // Mostrar solo el temporizador de la sección actual
                if (seccionId) {
                    const temporizador = document.getElementById(`temporizador-${seccionId}`);
                    if (temporizador) {
                        temporizador.style.display = 'block';
                    }
                }
            }

            // 7. Función para determinar si todas las preguntas requeridas están respondidas
            function todasPreguntasRequeridasRespondidas() {
                const preguntasRequeridas = document.querySelectorAll('input[required]');
                const grupos = {};

                // Agrupar por nombre (pregunta)
                preguntasRequeridas.forEach(input => {
                    const nombre = input.getAttribute('name');
                    if (!grupos[nombre]) {
                        grupos[nombre] = {
                            inputs: [],
                            respondida: false
                        };
                    }
                    grupos[nombre].inputs.push(input);
                });

                // Verificar si algún input de cada grupo está seleccionado
                for (const grupo in grupos) {
                    grupos[grupo].respondida = grupos[grupo].inputs.some(input => input.checked);
                    if (!grupos[grupo].respondida) {
                        return false;
                    }
                }

                return true;
            }

            // 8. Manejar eventos de selección de respuestas
            document.querySelectorAll('.respuesta').forEach(radio => {
                radio.addEventListener('change', function() {
                    // Obtener el índice de la pregunta actual desde el atributo data-pregunta
                    const preguntaIndex = parseInt(this.getAttribute('data-pregunta'));

                    // Verificar si esta pregunta ya estaba respondida (cambio de respuesta)
                    const preguntaName = this.getAttribute('name');
                    const preguntaRespondidaPreviamente = document.querySelector(`input[name="${preguntaName}"]:checked`) !== null;

                    // Solo incrementar el contador si es una nueva respuesta
                    if (!preguntaRespondidaPreviamente) {
                        preguntasRespondidas++;
                        actualizarProgreso();
                    }

                    // Avanzar a la siguiente pregunta después de un breve retraso
                    setTimeout(() => {
                        if (preguntaIndex < totalPreguntas - 1) {
                            // Si no es la última pregunta, mostrar la siguiente
                            mostrarPregunta(preguntaIndex + 1);
                        } else {
                            // Si es la última pregunta y todas las requeridas están respondidas
                            if (todasPreguntasRequeridasRespondidas()) {
                                // Enviar automáticamente el formulario después de un breve retraso
                                setTimeout(() => {
                                    btnEnviar.click();
                                }, 1000);
                            }
                        }
                    }, 300); // Retraso de 300ms para que el usuario vea su selección
                });
            });

            // 9. Configurar temporizadores
            temporizadores.forEach(temporizador => {
                // Obtener tiempo inicial del atributo data-tiempo
                const tiempoInicial = temporizador.getAttribute('data-tiempo');
                if (!tiempoInicial) return;

                // Convertir el formato "mm:ss" a segundos
                const [minutos, segundos] = tiempoInicial.split(':').map(Number);
                let tiempoRestante = minutos * 60 + segundos;

                // Iniciar el temporizador
                const intervalo = setInterval(() => {
                    tiempoRestante--;

                    // Si se agotó el tiempo
                    if (tiempoRestante <= 0) {
                        clearInterval(intervalo);
                        document.getElementById('tiempo_agotado').value = '1';
                        btnEnviar.click();
                        return;
                    }

                    // Actualizar el texto del temporizador
                    const minutosRestantes = Math.floor(tiempoRestante / 60);
                    const segundosRestantes = tiempoRestante % 60;
                    temporizador.innerHTML = `Tiempo restante: ${minutosRestantes.toString().padStart(2, '0')}:${segundosRestantes.toString().padStart(2, '0')}`;

                    // Cambiar a rojo cuando quede poco tiempo (menos de 30 segundos)
                    if (tiempoRestante < 30) {
                        temporizador.style.color = 'red';
                    }
                }, 1000);
            });

            // 10. Verificar respuestas ya seleccionadas al cargar
            function contarRespuestasIniciales() {
                preguntasRespondidas = document.querySelectorAll('input[type="radio"]:checked').length;
                actualizarProgreso();
            }

            // 11. Asegurarse de que se muestre el temporizador correcto al inicio
            function inicializarTemporizador() {
                const primeraPregunta = preguntas[0];
                if (primeraPregunta) {
                    const seccionInicial = primeraPregunta.querySelector('.texto-Progreso')?.getAttribute('data-id-seccion');
                    if (seccionInicial) {
                        const temporizador = document.getElementById(`temporizador-${seccionInicial}`);
                        if (temporizador) {
                            temporizador.style.display = 'block';
                        }
                    }
                }
            }

            // 12. Inicialización
            mostrarPregunta(0);
            contarRespuestasIniciales();
            inicializarTemporizador();

            // 13. Exponer funciones útiles al ámbito global (para depuración)
            window.avanzarPregunta = function() {
                if (preguntaActual < totalPreguntas - 1) {
                    mostrarPregunta(preguntaActual + 1);
                }
            };

            window.retrocederPregunta = function() {
                if (preguntaActual > 0) {
                    mostrarPregunta(preguntaActual - 1);
                }
            };
        });
