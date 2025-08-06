function generarCirculosCandidato(num, contenedor) {
    if (!contenedor) return;

    // Eliminar todos los círculos existentes
    contenedor.querySelectorAll('.circulo').forEach(c => c.remove());

    // Crear los nuevos círculos
    for (let i = 0; i < num; i++) {
        const circulo = document.createElement('div');
        circulo.classList.add('circulo');
        if (contenedor.closest('.contenedor')?.getAttribute('data-fillable') === "1") {
            circulo.classList.add('editable');
        }

        contenedor.appendChild(circulo);
    }

    posicionarCirculos(contenedor, num);
}

function posicionarCirculos(contenedor, cantidad) {
    const posiciones = {
        1: [{ top: '50%', left: '50%', transform: 'translate(-50%, -50%)' }],
        2: [
            { top: '10%', right: '10%' },
            { bottom: '10%', left: '10%' }
        ],
        3: [
            { top: '10%', right: '10%' },
            { top: '50%', left: '50%', transform: 'translate(-50%, -50%)' },
            { bottom: '10%', left: '10%' }
        ],
        4: [
            { top: '10%', left: '10%' },
            { top: '10%', right: '10%' },
            { bottom: '10%', left: '10%' },
            { bottom: '10%', right: '10%' }
        ],
        5: [
            { top: '10%', left: '10%' },
            { top: '10%', right: '10%' },
            { bottom: '10%', left: '10%' },
            { bottom: '10%', right: '10%' },
            { top: '50%', left: '50%', transform: 'translate(-50%, -50%)' }
        ],
        6: [
            { top: '10%', left: '10%' },
            { top: '50%', left: '10%', transform: 'translateY(-50%)' },
            { bottom: '10%', left: '10%' },
            { top: '10%', right: '10%' },
            { top: '50%', right: '10%', transform: 'translateY(-50%)' },
            { bottom: '10%', right: '10%' }
        ]
    };

    const circulos = contenedor.querySelectorAll('.circulo');
    const pos = posiciones[cantidad] || [];

    circulos.forEach((circulo, i) => {
        const estilo = pos[i];
        if (!estilo) return;
        Object.assign(circulo.style, estilo);
    });
}

function inicializarDominosCandidato() {
    console.log("Inicializando dominos visibles (solo visualización)");

    const dominos = document.querySelectorAll('.contenedor-dinamico-domino .contenedor');

    dominos.forEach((contenedor, index) => {
        const fila1 = contenedor.querySelector('.fila[data-fila="1"]');
        const fila2 = contenedor.querySelector('.fila[data-fila="2"]');

        const input1 = fila1?.querySelector('input');
        const input2 = fila2?.querySelector('input');

        const contenedor1 = fila1?.querySelector('.contenedor-circulos');
        const contenedor2 = fila2?.querySelector('.contenedor-circulos');

        const fillable = contenedor.getAttribute('data-fillable');

        if (fillable === "1") {
            // Mostrar inputs y permitir interacción
            if (input1) input1.style.display = 'block';
            if (input2) input2.style.display = 'block';

            [input1, input2].forEach((input, fila) => {
                if (!input) return;
                const contenedorCirculos = fila === 0 ? contenedor1 : contenedor2;

                input.addEventListener('input', () => {
                    let valor = parseInt(input.value);
                    if (isNaN(valor) || valor < 0 || valor > 6) {
                        input.value = '';
                        return;
                    }

                    generarCirculosCandidato(valor, contenedorCirculos);
                    input.style.display = 'none';
                });

                contenedorCirculos.addEventListener('click', () => {
                    input.style.display = 'block';
                    input.value = ''; // limpiar valor
                    input.focus();

                    // Quitar círculos anteriores
                    contenedorCirculos.querySelectorAll('.circulo').forEach(c => c.remove());
                });
            });
        } else {
            // Ocultar inputs y renderizar círculos (modo solo lectura)
            if (input1) {
                input1.style.display = 'none';
                const num1 = parseInt(input1.value) || 0;
                generarCirculosCandidato(num1, contenedor1);
            }

            if (input2) {
                input2.style.display = 'none';
                const num2 = parseInt(input2.value) || 0;
                generarCirculosCandidato(num2, contenedor2);
            }
        }
    });
}

// Ejecutar cuando el DOM esté listo
if (document.readyState === "complete") {
    inicializarDominosCandidato();
} else {
    window.addEventListener("load", inicializarDominosCandidato);
}
