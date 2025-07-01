document.addEventListener('DOMContentLoaded', function () {
        const glosario = document.getElementById('glosario-original');
        const destino = document.getElementById('contenedor-glosario');

        if (glosario && destino) {
            destino.innerHTML = glosario.innerHTML;
            glosario.remove();
        }

        const btnToggle = document.getElementById('toggle-glosario');
        const body = document.getElementById('glosario-body');

        if (btnToggle && body) {
            btnToggle.addEventListener('click', () => {
                body.style.display = body.style.display === 'none' ? 'block' : 'none';
            });
        }
    });