<head>
    <style>
        .modal-fullheight .modal-content {
            height: 80vh;
            overflow-y: auto;
        }
    </style>


</head>
<!-- Modal Bootstrap con contenido Materialize -->
<div class="modal fade" id="ventana-crear-prueba" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-fullheight">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crea una prueba</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4"> <!-- border-end-->
                        <div class="card">
                            <!--<h5 class="card-header">Crear Test</h5>-->
                            <div class="card-body">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input id="test-titulo" type="text" class="form-control" placeholder="Título" required>
                                    <label for="test-titulo">Título</label>
                                </div>

                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="test-categoria" class="form-select" required>
                                    </select>
                                    <label for="test-categoria">Categoría</label>
                                </div>

                                <div class="form-floating form-floating-outline mb-4">
                                    <select id="test-tipo" class="form-select" required>
                                    </select>
                                    <label for="test-tipo">Tipo</label>
                                </div>

                                <button id="btn-crear-test" class="btn btn-primary w-100 mt-2">Crear prueba</button>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <!--<h5 class="card-header">Crear Sección</h5>-->
                            <div class="card-body">
                                <div id="crear-seccion-form">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input id="seccion-titulo" type="text" class="form-control" placeholder="Título" required>
                                        <label for="seccion-titulo">Título</label>
                                    </div>

                                    <div class="form-floating form-floating-outline mb-4">
                                        <input id="seccion-bloque" type="text" class="form-control" placeholder="Bloque" required>
                                        <label for="seccion-bloque">Bloque</label>
                                    </div>

                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="seccion-test-id" class="form-select" required>
                                            <option disabled selected>Selecciona una prueba</option>
                                        </select>
                                        <label for="seccion-test-id">Prueba a la que pertenece</label>
                                    </div>

                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" id="seccion-tiempo" class="form-control" placeholder="Tiempo (hh:mm:ss)" value="00:00:00" required>
                                        <label for="seccion-tiempo">Tiempo (hh:mm:ss)</label>
                                    </div>

                                    <button id="btn-crear-seccion" class="btn btn-secondary w-100 mt-2">Crear sección</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-8">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" id="tabs-secciones" role="tablist">
                            <!--Aquí van pestañas de secciones creadas-->
                        </ul>

                        <!-- Tab content -->
                        <div class="tab-content mt-3" id="contenido-secciones">
                            <!--Contenido para crear preguntas y sus respuestas-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary" id="TestGuardarBtn">Guardar</a>
            </div>
        </div>
    </div>
</div>

<script>
    let bsModal;
    document.addEventListener('DOMContentLoaded', function () {

        //Abrir ventana
        document.getElementById('TestBtn').addEventListener('click', function () {
            Promise.all([
                cargarCategoriasYTipos(),
                cargarPruebas()
            ]).then(() => {
                bsModal = new bootstrap.Modal(document.getElementById('ventana-crear-prueba'));
                bsModal.show();
            });
        });

        //Cerrar ventana
        document.getElementById('TestGuardarBtn').addEventListener('click', function () {
            bsModal.hide();
        });

        //crear un test
        document.getElementById('btn-crear-test').addEventListener('click', function () {
            const titulo = document.getElementById('test-titulo').value.trim();
            if (titulo === '') {
                alert('El título es obligatorio');
                return;
            }

            const data = {
                titulo: titulo,
                categoria_id: document.getElementById('test-categoria').value,
                tipo_id: document.getElementById('test-tipo').value,
                _token: '{{ csrf_token() }}'
            };

            jQuery.ajax({
                url: `{{ url('psicometricas/admin/pruebas') }}`,
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    alert('¡Test creado exitosamente!');
                    let table = jQuery('#testsTable').DataTable();
                    table.ajax.reload(null, false);

                    const nuevoTestId = response.test.id;

                    //seleccionar test recién creado en el select de crear sección
                    cargarPruebas().then(() => {
                        jQuery('#seccion-test-id').val(nuevoTestId);
                    });
                },
                error: function (xhr) {
                    let errorMsg = 'No se pudo crear el nuevo test.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                }
            });
        });

        //crear una Sección
        document.getElementById('btn-crear-seccion').addEventListener('click', function () {
            const data = {
                title: document.getElementById('seccion-titulo').value,
                block: document.getElementById('seccion-bloque').value,
                test_id: document.getElementById('seccion-test-id').value,
                time_at: document.getElementById('seccion-tiempo').value,
                _token: '{{ csrf_token() }}'
            };

            jQuery.ajax({
                url: "{{ route('secciones.store') }}",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    alert('¡Sección creada exitosamente!');
                    agregarPestañaDeSeccion(response.seccion);
                },
                error: function (xhr) {
                    let errorMsg = 'No se pudo crear la sección.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                }
            });
        });
        document.getElementById('seccion-tiempo').addEventListener('input', function () {
            const input = $(this);
            let value = input.val();
            let cursorPosition = input.prop("selectionStart"); //Posición actual del cursor

            //Filtra caracteres no válidos y mantiene sólo números y dos puntos
            value = value.replace(/[^0-9:]/g, "");

            //Divide el valor en partes (horas, minutos, segundos)
            const partes = value.split(":");
            const horas = partes[0]?.slice(0, 2) || "00";
            const minutos = partes[1]?.slice(0, 2) || "00";
            const segundos = partes[2]?.slice(0, 2) || "00";

            //Reconstruye el valor con el formato correcto
            const nuevoValor = `${horas}:${minutos}:${segundos}`;
            input.val(nuevoValor);

            //Ajuste de la posición del cursor según la cantidad de dígitos ingresados
            if (cursorPosition <= 2) {
                if (horas.length === 2 && cursorPosition === 2) {
                    cursorPosition = 3; // Mueve el cursor después del primer ":"
                }
            } else if (cursorPosition <= 5) {
                if (minutos.length === 2 && cursorPosition === 5) {
                    cursorPosition = 6; // Mueve el cursor después del segundo ":"
                }
            } else if (cursorPosition <= 8) {
                cursorPosition = Math.min(cursorPosition, 8);
            }

            // Ajusta el cursor para que se posicione correctamente
            input.prop("selectionStart", cursorPosition);
            input.prop("selectionEnd", cursorPosition);
        });

        //crear una pregunta
        document.body.addEventListener('click', function (event) {
            //guardar pregunta
            if (event.target && event.target.id.startsWith('btn-crear-pregunta-')) {
                const button = event.target;
                const seccionId = button.id.replace('btn-crear-pregunta-', '');

                const texto = document.querySelector(`#pregunta-texto-${seccionId}`).value;
                const tipo = document.querySelector(`#pregunta-tipo-id-${seccionId}`).value;
                const requerida = document.querySelector(`#pregunta-requerida-${seccionId}`).checked;

                const contenedor = document.querySelector(`#seccion-${seccionId}`);
                const testId = contenedor.getAttribute('data-test-id');
                const sectionId = contenedor.getAttribute('data-section-id');

                const data = {
                    question: texto,
                    test_id: testId,
                    section_id: sectionId,
                    question_type_id: tipo,
                    required: requerida ? 1 : 0,
                    _token: '{{ csrf_token() }}'
                };

                jQuery.ajax({
                    url: "{{ route('preguntas.store') }}",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        alert('¡Pregunta creada exitosamente!');
                        const contenedorPreguntas = document.querySelector(`#preguntas-creadas-${seccionId}`);
                        contenedorPreguntas.insertAdjacentHTML('beforeend', renderizarPregunta(response.pregunta));

                        document.querySelector(`#pregunta-texto-${seccionId}`).value = '';
                        document.querySelector(`#pregunta-tipo-id-${seccionId}`).selectedIndex = 0;
                        document.querySelector(`#pregunta-requerida-${seccionId}`).checked = false;
                        document.querySelector(`#contenedor-respuestas-previo-${seccionId}`).innerHTML = '<div class="text-muted small">Elige un tipo de pregunta</div>';

                        guardarRespuestasAutomaticas({testId: testId, sectionId: sectionId, questionId: response.pregunta.id});
                    },
                    error: function (xhr) {
                        let errorMsg = 'No se pudo crear la pregunta.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        alert(errorMsg);
                    }
                });

            }

            //ver cómo es la escala likert 4 o 5
            if (event.target && event.target.classList.contains('ver-likert')) {
                const btn = event.target;
                const wrapper = btn.closest('.likert-wrapper');
                const select = wrapper.querySelector('select[id^="likert-scale-size"]');
                const container = wrapper.querySelector('div[id^="likert-options-container"]');

                if (!select || !container) return;

                const value = parseInt(select.value);
                container.innerHTML = '';

                if (![4, 5].includes(value)) {
                    container.innerHTML = '<p style="color: red;">Seleccione una escala válida.</p>';
                    return;
                }

                const labels = {
                    4: ['Totalmente en desacuerdo', 'En desacuerdo', 'De acuerdo', 'Totalmente de acuerdo'],
                    5: ['Totalmente en desacuerdo', 'En desacuerdo', 'Neutral', 'De acuerdo', 'Totalmente de acuerdo']
                };

                labels[value].forEach(label => {
                    container.insertAdjacentHTML('beforeend', `
                        <div class="respuesta-input d-flex gap-2 align-items-center mb-2">
                            <input type="text" class="form-control answer-text" value="${label}" readonly style="flex:4;">
                        </div>`);
                });
            }

            //añadir respuesta en múltiple, reacción forzada o pares
            if (event.target && event.target.id.startsWith('add-respuesta-btn-')) {
                const questionId = event.target.id.replace('add-respuesta-btn-', '');
                const container = document.getElementById(`respuestas-dinamicas-${questionId}`);

                if (!container) return;

                // Detectar tipo de pregunta:
                const tipo = parseInt(container.dataset.questionType || 1);

                let newRespuestaHTML = '';

                switch (tipo) {
                    case 3: // Pareamiento forzado
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control answer-text-a" placeholder="Elemento A" required style="flex:2;">
                                <input type="text" class="form-control answer-text-b" placeholder="Elemento B" required style="flex:2;">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar par">×</button>
                            </div>
                        `;
                        break;

                    default: // Selección múltiple, reacción forzada, otro tipo aún no definido.
                        newRespuestaHTML = `
                            <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                <input type="text" class="form-control option-text" placeholder="Opción" required style="flex:2;">
                                <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                                <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                            </div>
                        `;
                        break;
                }

                container.insertAdjacentHTML('beforeend', newRespuestaHTML);
                updateRemoveButtons(container);
            }

        });

        //mostrar tipo de respuesta al cambiar tipo de pregunta
        document.body.addEventListener('change', function (event) {
            if (event.target && event.target.id.startsWith('pregunta-tipo-id-')) {
                const select = event.target;
                const seccionId = select.id.replace('pregunta-tipo-id-', '');
                const tipo = parseInt(select.value);
                const contenedorPrevio = document.querySelector(`#contenedor-respuestas-previo-${seccionId}`);

                if (!isNaN(tipo) && contenedorPrevio) {
                    contenedorPrevio.innerHTML = generateRespuestaHTML(tipo);
                    updateRemoveButtons(contenedorPrevio);
                }
            }
        });
    });

    //cargar contenido para crear test
    function cargarCategoriasYTipos() {
        return jQuery.ajax({
                url: "{{ route('pruebas.categorias.tipos') }}",
                type: "GET",
                dataType: "json",
                success: function (categories) {
                    const $categoria = jQuery('#test-categoria');
                    const $tipo = jQuery('#test-tipo');

                    // Limpia las opciones actuales
                    $categoria.empty();
                    $tipo.empty();

                    //Agrega opción por defecto
                    $categoria.append('<option value="" disabled selected>Selecciona una categoría</option>');

                    categories.forEach(cat => {
                        $categoria.append(`<option value="${cat.id}">${cat.category_name}</option>`);
                    });

                    //primera categoría para llenar tipos
                    const firstCategory = categories[0];
                    const tipos = firstCategory ? firstCategory.test_types : [];

                    if (tipos.length > 0) {
                        tipos.forEach((type, index) => {
                            const selected = index === 0 ? 'selected' : '';
                            $tipo.append(`<option value="${type.id}" ${selected}>${type.type_name}</option>`);
                        });
                    } else {
                        $tipo.append('<option value="" disabled selected>No hay tipos</option>');
                    }

                    // Al cambiar la categoría, actualiza tipos
                    $categoria.off('change').on('change', function () {
                        const catId = jQuery(this).val();
                        const categoriaSeleccionada = categories.find(cat => cat.id == catId);
                        const tiposNuevaCategoria = categoriaSeleccionada ? categoriaSeleccionada.test_types : [];

                        $tipo.empty();

                        if (tiposNuevaCategoria.length > 0) {
                            tiposNuevaCategoria.forEach((type, index) => {
                                const selected = index === 0 ? 'selected' : '';
                                $tipo.append(`<option value="${type.id}" ${selected}>${type.type_name}</option>`);
                            });
                        } else {
                            $tipo.append('<option value="" disabled selected>No hay tipos</option>');
                        }
                    });
                },
                error: function () {
                    alert('Error al cargar categorías');
                }
        });
    }

    //Cargar contenido para crear sección
    function cargarPruebas() {
        return jQuery.ajax({
            url: "{{ route('tests.all') }}",
            type: "GET",
            dataType: "json",
            success: function (tests) {
                const $select = jQuery('#seccion-test-id');
                $select.empty().append('<option disabled selected>Selecciona una prueba</option>');
                tests.forEach(test => {
                    $select.append(`<option value="${test.id}">${test.test_title}</option>`);
                });
            },
            error: function () {
                alert('Error al cargar pruebas');
            }
        });
    }

    //agregar pestañas en el modal por cada sección creada
    function agregarPestañaDeSeccion(seccion) {
        const seccionId = 'seccion-' + seccion.id;
        const titulo = seccion.title;

        if (!document.getElementById('tabs-secciones') || !document.getElementById('contenido-secciones')) {
            console.warn('Contenedor de pestañas no encontrado');
            return;
        }

        const tab = `
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="${seccionId}-tab" data-bs-toggle="tab" data-bs-target="#${seccionId}" type="button" role="tab" aria-controls="${seccionId}" aria-selected="false">
                    ${titulo}
                </button>
            </li>`;

        const contenido = `
            <div class="tab-pane fade" id="${seccionId}" role="tabpanel" aria-labelledby="${seccionId}-tab"
                data-test-id="${seccion.test_id}" data-section-id="${seccion.id}">
                ${generarFormPreguntaHTML(seccion)}
            </div>`;

        jQuery('#tabs-secciones').append(tab);
        jQuery('#contenido-secciones').append(contenido);

        const tabTriggerEl = document.querySelector(`#${seccionId}-tab`);
        const tabTrigger = new bootstrap.Tab(tabTriggerEl);
        tabTrigger.show();

         cargarTiposDePregunta(`#pregunta-tipo-id-${seccion.id}`);
    }

    //cargar contenido para crear una pregunta
    function generarFormPreguntaHTML(seccion){
        return `
        <div class="card mt-3">
            <div class="card-body">
                <!--h6 class="mb-3">Crear pregunta</h6>-->
                <div class="form-floating form-floating-outline mb-4">
                    <input type="text" class="form-control" id="pregunta-texto-${seccion.id}" placeholder="Pregunta" required>
                    <label for="pregunta-texto-${seccion.id}">Pregunta</label>
                </div>

                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="form-floating form-floating-outline">
                            <select class="form-select" id="pregunta-tipo-id-${seccion.id}" required>
                                <!-- Opciones se cargan dinámicamente -->
                            </select>
                            <label for="pregunta-tipo-id-${seccion.id}">Tipo de pregunta</label>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-center">
                        <div class="form-check ms-2">
                            <input class="form-check-input" type="checkbox" value="1" id="pregunta-requerida-${seccion.id}">
                            <label class="form-check-label" for="pregunta-requerida-${seccion.id}">¿Requerida?</label>
                        </div>
                    </div>
                </div>

                <!-- Contenedor para crear respuestas -->
                <div id="contenedor-respuestas-previo-${seccion.id}" class="mb-3">
                    <div class="text-muted small mb-2">Elige un tipo de pregunta para modificar las respuestas posibles...</div>
                </div>

                <button class="btn btn-success w-100" id="btn-crear-pregunta-${seccion.id}">Crear pregunta</button>

                <!-- Contenedor para mostrar preguntas creadas -->
                <div id="preguntas-creadas-${seccion.id}" class="mt-4"></div>
            </div>
        </div>`;
    }

    function cargarTiposDePregunta(selectSelector) {
        $.ajax({
            url: "{{ route('question_types.all') }}",
            type: "GET",
            dataType: "json",
            success: function (tipos) {
                const $select = $(selectSelector);
                $select.empty().append('<option disabled selected>Selecciona tipo</option>');
                tipos.forEach(tipo => {
                    $select.append(`<option value="${tipo.id}">${tipo.name}</option>`);
                });
            },
            error: function () {
                alert("Error al cargar los tipos de pregunta.");
            }
        });
    }

    //Mostrar preguntas ya creadas
    function renderizarPregunta(pregunta) {
        const tipo = parseInt(pregunta.question_type_id || pregunta.question_type?.id || 1);
        const contenedorRespuestasID = `respuestas-container-${pregunta.id}`;
        let html = `
            <div class="card mb-3 border-start border-success border-3">
                <div class="card-body">
                    <p class="fw-bold mb-1">${pregunta.question}</p>
                    <small class="text-muted d-block mb-3">
                        Tipo: ${pregunta.question_type?.name || 'N/A'} |
                        ${pregunta.required ? 'Requerida' : 'Opcional'}
                    </small>

                    <!-- Formulario para respuestas -->
                    <div id="${contenedorRespuestasID}" data-question-id="${pregunta.id}" data-question-type="${tipo}">
                        ${generateRespuestaHTML(tipo, pregunta.id)}
                    </div>
                </div>
            </div>
        `;

        return html;
    }

    //Mostrar form para crear respuesta según el tipo de la pregunta ya creada
    function generateRespuestaHTML(questionType, questionId) {
        const alreadyHasAddButton = !!document.getElementById('add-respuesta-btn');
        let html = '';


        switch (questionType) {
            case 2:
            // Escala tipo Likert (1 a 5)
                return `
                    <div class="likert-wrapper">
                        <div class="respuesta-input" id="likert-config" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <label style="font-weight: bold;">Tamaño de la escala:</label>
                            <select id="likert-scale-size" class="form-control" style="width: 200px;">
                                <option value="">Seleccione</option>
                                <option value="4">Escala de 4 puntos</option>
                                <option value="5">Escala de 5 puntos</option>
                            </select>
                            <button type="button" class="ver-likert btn btn-azul btn-sm" title="Ver las opciones de esta escala"> ? </button>
                        </div>
                        <div id="likert-options-container" style="margin-top: 10px;"></div>
                    </div>
                    `;
                break;
            case 3:
                //Pareamiento forzado
                    html += `<div id="respuestas-dinamicas-${questionId}" data-question-type="3"></div>`;

                    if (!alreadyHasAddButton) {
                        html += `
                            <button type="button" id="add-respuesta-btn-${questionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px">
                                + Añadir respuesta
                            </button>
                        `;
                    }

                    return html;
                break;
            case 4:
                //doble opción
                    return `
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                            <input type="text" class="form-control option-text" placeholder="Opción" value="a" required style="flex:2;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                            <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                        </div>
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                            <input type="text" class="form-control option-text" placeholder="Opción" value="b" required style="flex:2;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                            <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                        </div>
                    `;
                break;
            case 5:
                //Verdadero o Falso
                    return `
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control answer-text" value="Verdadero" disabled required style="flex:2;">
                            <input type="text" class="form-control option-text" value="a" readonly style="width: 60px;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                        </div>
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control answer-text" value="Falso" disabled required style="flex:2;">
                            <input type="text" class="form-control option-text" value="b" readonly style="width: 60px;">
                            <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                        </div>
                    `;
                break;
            case 10:
                //Pregunta Abierta
                    return `
                        <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                            <input type="text" class="form-control answer-text" value="Respuesta abierta" readonly style="flex:4;">
                        </div>
                    `;
                break;
            default:
                //Selección múltiple(1), reacción forzada(8)
                    html += `<div id="respuestas-dinamicas-${questionId}" data-question-type="${questionType}"></div>`;

                    // Botón para añadir nuevas respuestas
                    html += `
                        <button type="button" id="add-respuesta-btn-${questionId}" class="btn btn-azul mt-1" style="width:100%; margin-bottom:10px;">
                            + Añadir respuesta
                        </button>
                    `;


                    return html;
                break;
            }

        return html;
    }

    //quitar una respuesta añadida
    function updateRemoveButtons(containerSelector) {
        const container = typeof containerSelector === 'string' ? document.querySelector(containerSelector) : containerSelector;
        if (!container) return;

        container.querySelectorAll('.remove-respuesta').forEach(btn => {
            btn.onclick = () => {
                if (container.querySelectorAll('.respuesta-input').length > 1) {
                    btn.parentElement.remove();
                }
            };
        });
    }

    function guardarRespuestasAutomaticas({testId, sectionId, questionId}) {
        const test_id = testId;
        const section_id = sectionId;
        const question_id = questionId;

        const container = document.getElementById(`respuestas-container-${question_id}`);
        if (!container) {
            console.warn(`Contenedor de respuestas no encontrado para pregunta ${question_id}`);
            return;
        }
        const questionType = parseInt(container.dataset.questionType || '1');

            const respuestas = [];
            let valid = true;

            switch (questionType) {
                case 2:
                    // Likert
                    const scaleSize = parseInt(document.getElementById('likert-scale-size').value);
                    if (!scaleSize || ![4, 5].includes(scaleSize)) {
                        valid = false;
                        break;
                    }

                    const labels = {
                        4: ['Totalmente en desacuerdo', 'En desacuerdo', 'De acuerdo', 'Totalmente de acuerdo'],
                        5: ['Totalmente en desacuerdo', 'En desacuerdo', 'Neutral', 'De acuerdo', 'Totalmente de acuerdo']
                    };

                    labels[scaleSize].forEach((label, index) => {
                        respuestas.push({
                            answer: label,
                            option: String.fromCharCode(97 + index),
                            is_correct: null,
                            extra_data: {
                                scale_type: scaleSize,
                                label_index: index + 1
                            }
                        });
                    });
                    break;

                case 3:
                    // Pareamiento forzado
                    document.querySelectorAll('.respuesta-input').forEach(input => {
                        const answerA = input.querySelector('.answer-text-a')?.value.trim();
                        const answerB = input.querySelector('.answer-text-b')?.value.trim();

                        if (answerA && answerB) {
                            const pairId = 'pair_' + Math.random().toString(36).substr(2, 9);
                            respuestas.push(
                                { answer: answerA, extra_data: { pair_id: pairId } },
                                { answer: answerB, extra_data: { pair_id: pairId } }
                            );
                        } else {
                             valid = false;
                        }
                    });
                    break;

                default:
                    // Otros tipos que usan una sola respuesta por input
                    document.querySelectorAll('.respuesta-input').forEach(input => {
                        const answerEl = input.querySelector('.answer-text');
                        const optionEl = input.querySelector('.option-text');
                        const isCorrectEl = input.querySelector('.is-correct');

                        const answer = answerEl ? answerEl.value.trim() : '';
                        const option = optionEl ? optionEl.value.trim() : '';
                        let is_correct = null;

                        if (questionType !== 8 && isCorrectEl) {
                            is_correct = isCorrectEl.checked ? 1 : 0;
                        }

                        switch (questionType) {
                            case 5: // Verdadero/Falso
                                if (answer && option) {
                                    respuestas.push({ answer, option, is_correct });
                                } else {
                                    valid = false;
                                }
                                break;
                            case 10: // Abierta
                                if (answer) respuestas.push({ answer });
                                else valid = false;
                                 break;
                            default:
                                if (answer && option) {
                                    respuestas.push({ answer, option, is_correct });
                                } else {
                                     valid = false;
                                }
                                break;
                        }
                    });
                break;
            }


            if (!test_id || !section_id || !question_id || !valid || respuestas.length === 0) {
                Swal.showValidationMessage('Por favor, complete todos los campos requeridos.');
                return false;
            }

            const data = {
                test_id,
                section_id,
                question_id,
                respuestas,
                _token: '{{ csrf_token() }}'
            };

            jQuery.ajax({
                url: "{{ route('respuestas.store') }}",
                type: "POST",
                data: data,
                dataType: "json",
                success: function (response) {
                    alert('¡Respuestas creadas exitosamente!');
                    agregarPestañaDeSeccion(response.seccion);
                },
                error: function (xhr) {
                    let errorMsg = 'No se pudo crear la respuesta.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                }
            });
    }
</script>




