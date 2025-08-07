
document.querySelectorAll('[id^="sortable-cards-"]').forEach(lista => {
    Sortable.create(lista, {
        animation: 150,
        ghostClass: 'sortable-ghost',
        onSort: function () {
            const preguntaId = lista.id.replace('sortable-cards-', '');
            const evento = new CustomEvent('palabrasReordenadas', {
                detail: {
                    lista: lista,
                    preguntaId: preguntaId,
                    ordenActual: [...lista.querySelectorAll('.drag-item')].map(el => el.dataset.palabraIndex)
                }
            });

            document.dispatchEvent(evento);
        }
    });
});