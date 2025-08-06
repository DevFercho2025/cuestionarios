    function generarCirculos(num, contenedor) {
        if (!contenedor) return;
        
        const input = contenedor.querySelector('input');
        contenedor.innerHTML = '';
        if (input) contenedor.appendChild(input);

        for (let i = 0; i < num; i++) {
            const circulo = document.createElement('div');
            circulo.classList.add('circulo');
            contenedor.appendChild(circulo);
        }

        posicionarCirculos(contenedor, num);
    }

    function posicionarCirculos(contenedor, cantidad) {
        const posiciones = {
            1: [
                { top: '50%', left: '50%', transform: 'translate(-50%, -50%)' }
            ],
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

    function inicializarDomino(contenedorDomino) {
        const filas = contenedorDomino.querySelectorAll('.fila');

        filas.forEach(fila => {
            const input = fila.querySelector('input');
            const contenedor = fila.querySelector('.contenedor-circulos');

            fila.addEventListener('click', (e) => {
                contenedor.querySelectorAll('.circulo').forEach(c => {
                    c.style.display = 'none';
                });

                input.style.display = 'block';
                input.focus();
                e.stopPropagation();
            });

            //Al salir del input o presionar Enter
            input.addEventListener('blur', () => {
                const numCirculos = parseInt(input.value) || 0;
                generarCirculos(numCirculos, contenedor);
                input.style.display = 'none';
                input.value = '';
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                input.blur();
                }
            });

            input.addEventListener('input', () => {
                const valor = parseInt(input.value);
                if (valor > 6) input.value = 6;
                if (valor < 0) input.value = 0;
            });
        });
    }


    if (document.readyState === "complete") {
        inicializarTodosLosDominos();
    } else {
        window.addEventListener("load", inicializarTodosLosDominos);
    }

    function inicializarTodosLosDominos() {
        console.log("Inicializando dominos visibles (candidato)");

        const dominos = document.querySelectorAll('.contenedor-dinamico-domino .contenedor');

        dominos.forEach(contenedor => {
            const fila1 = contenedor.querySelector('.fila[data-fila="1"]');
            const fila2 = contenedor.querySelector('.fila[data-fila="2"]');

            const input1 = fila1?.querySelector('input');
            const input2 = fila2?.querySelector('input');

            const contenedor1 = fila1?.querySelector('.contenedor-circulos');
            const contenedor2 = fila2?.querySelector('.contenedor-circulos');

            const fillable = contenedor.dataset.fillable === '1';

            if (fillable) {
                inicializarDomino(contenedor);
            } else {
                // 1. Ocultar inputs completamente
                if (input1) input1.classList.add('invisible-input');
                if (input2) input2.classList.add('invisible-input');

                // 2. Generar los círculos
                generarCirculos(parseInt(input1?.value || 0), contenedor1);
                generarCirculos(parseInt(input2?.value || 0), contenedor2);
            }
        });
    }