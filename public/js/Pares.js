function getRandomColor() {
    const hue = Math.floor(Math.random() * 360); //Toda la paleta
    return `hsl(${hue}, 70%, 60%)`;
}
    
    document.querySelectorAll('[data-role="pregunta"]').forEach(contenedor => {
        const preguntaId = contenedor.dataset.preguntaId;
        const Answersinput = document.getElementById('answers-' + preguntaId);

        let selectedA = null;
        let connections = [];

        //Seleccionar ítems dentro de cada columna
        const itemsA = contenedor.querySelectorAll('[data-column="a"] .list-group-item');
        const itemsB = contenedor.querySelectorAll('[data-column="b"] .list-group-item');

        function clearSelection() {
            itemsA.forEach(item => item.classList.remove('selected'));
            itemsB.forEach(item => item.classList.remove('selected'));
        }

        itemsA.forEach(item => {
            item.addEventListener("click", () => {
                clearSelection();
                selectedA = item;
                item.classList.add("selected");
            });
        });

        itemsB.forEach(item => {
            item.addEventListener("click", () => {
                if (selectedA) {
                    item.classList.add("selected");

                    const color = getRandomColor();

                    const line = new LeaderLine(
                        selectedA,
                        item,
                        {
                            color: color,
                            size: 4,
                            path: 'straight',
                            endPlug: 'behind'
                        }
                    );

                    connections.push({
                        idA: selectedA.dataset.id,
                        idB: item.dataset.id,
                        line: line
                    });

                    selectedA.classList.add("disabled");
                    item.classList.add("disabled");

                    selectedA = null;
                    clearSelection();

                    //actualiza guardado de respuestas
                    const data = connections.map(c => ({
                        left_id: c.idA,
                        right_id: c.idB
                    }));
                    Answersinput.value = JSON.stringify(data);
                }
            });
        });
    });
