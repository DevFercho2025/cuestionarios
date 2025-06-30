document.addEventListener('DOMContentLoaded', function () {
    const cardel = document.getElementById('sortable-cards');
    if (cardel) {
        Sortable.create(cardel, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.cursor-move',
            draggable: '.drag-item'
        });
    }
});