    const listas = document.querySelectorAll('ul[id^="clone-source-"]');

    listas.forEach(lista => {
        Sortable.create(lista, {
            animation: 150,
            onSort: function () {
                actualizarPuntajes(lista);

                const evento = new CustomEvent('respuestaReordenada', {
                    detail: {
                        lista: lista,
                        preguntaId: lista.id.replace('clone-source-', ''),
                        ordenActual: [...lista.querySelectorAll('.drag-item')].map(el => el.dataset.respuestaId)
                    }
                });

                document.dispatchEvent(evento);
            }
        });

        actualizarPuntajes(lista);
    });

function actualizarPuntajes(lista) {
    const items = lista.querySelectorAll('.drag-item');
    let puntaje = 4;
    items.forEach(item => {
        const input = item.querySelector('.puntuacion-input');
        if (input) input.value = puntaje;
        puntaje--;
    });
}
