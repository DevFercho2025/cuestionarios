<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <style>
    /*Estructura de Domino*/
    .contenedor {
      width: 67px;
      height: 110px;
      border: 2px solid black;
      box-sizing: border-box;
      display: flex;
      flex-direction: column;
      background: white;
    }

    .fila {
      flex: 1;
      border-top: 2px solid black;
      box-sizing: border-box;
    }

    .fila:first-child {
      border-top: none;
    }

    .contenedor-circulos {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .circulo {
      width: 9px;
      height: 9px;
      background-color: rgb(0, 0, 0);
      border-radius: 50%;
      position: absolute;
      transition: opacity 0.2s;
    }

    .circulo-input {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 100%;
        height: 100%;
        font-size: 20px;
        font-weight: bold;
        color: black;

        /*visualmente invisible*/
        background: transparent;
        border: none;
        outline: none;
        padding: 0;
        margin: 0;
        text-align: center;
        z-index: 2;

        caret-color: black;
    }
  </style>
</head>

<body>
    <div class="contenedor">
        <div class="fila" data-fila="1">
            <div class="contenedor-circulos" id="circulos-1">
                 <input class="circulo-input" type="number" id="input-f1" min="0" max="6">
            </div>
        </div>
        <div class="fila" data-fila="2">
            <div class="contenedor-circulos" id="circulos-2">
                 <input class="circulo-input" type="number" id="input-f2" min="0" max="6">
            </div>
        </div>
    </div>
</body>

<script>

    function generarCirculos(num, contenedorId) {
        const contenedor = document.getElementById(contenedorId);
        const input = contenedor.querySelector('input');
        contenedor.innerHTML = '';
        contenedor.appendChild(input); 

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


    document.querySelectorAll('.fila').forEach(fila => {
        const input = fila.querySelector('input');
        const filaId = fila.dataset.fila;
        const contenedorId = `circulos-${filaId}`;
        const contenedor = document.getElementById(contenedorId);

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
            generarCirculos(numCirculos, contenedorId);
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
</script>

</html>