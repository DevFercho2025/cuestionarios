@extends('layout.admin')
@section('title', 'Gestión de Respuestas')
@section('content')
    <head>
        <style>
            .btn-azul {
                background-color: #3d4e81;
                color: white;
            }

            .btn-editar {
                background-color: #05638d;
                color: white;
            }

            .btn-azul:hover {
                color: white;
                background-color: #055d82;
            }

            .btn-naranja {
                background-color: #d1850d;
                color: white;
            }

            .btn-naranja:hover {
                color: white;
                background-color: #b47b1f;
            }

            .btn-rojo {
                background-color: #a12e2e;
                color: white;
            }

            .btn-rojo:hover {
                color: white;
                background-color: #8b1a1a;
            }

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                display: inline-block;
                vertical-align: middle;
                margin-right: 20px; /* espacio entre elementos */
            }

            .dataTables_wrapper .dataTables_filter {
                float: right;
            }

            #myCustomFilter {
                margin-left: 10px;
                vertical-align: middle;
            }

            #filtroPrueba {
                background-color: transparent;
                border: 1px solid rgb(89, 91, 117);
                border-radius: 4px;
                color: #B2B3CA;
                padding: 9px 8px;
                font-size: 14px;
                outline: none;
                transition: border-color 0.3s ease;
                margin-top: 2px;
            }

            #filtroPrueba:focus {
                border-color: #3d4e81;
                box-shadow: 0 0 5px rgba(61, 78, 129, 0.5);
            }

            #filtroPrueba option {
                background-color: #262b3c;
                color: white;
            }

            #respuestasTable td[rowspan] {
                vertical-align: top;
            }
        </style>
    </head>

    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Gestión de Respuestas</h4>
                        </div>
                        <div class="col s4 right-align">
                        <div style="text-align: right;">
                            <a id="createRespuestaBtn" class="btn btn-large gradient-btn pulse" style="color: white; display: inline-block; background-color:#4f52b5">
                            Crear nueva respuesta
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Respuestas -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="respuestasTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Test_id</th>
                                <th>Pregunta</th>
                                <th>ID de respuesta</th>
                                <th>Respuesta</th>
                                <th>Opción</th>
                                <th>Respuesta correcta</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- jQuery y Scripts adicionales -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        
        const pruebas = @json($pruebas);
            
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
        }

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof jQuery !== 'undefined') {
                initializeApp();
            } else {
                console.error('jQuery no está disponible. Intenta incluirlo manualmente en tu plantilla.');
                alert('Error: jQuery no está cargado correctamente. Por favor, contacta al administrador.');
            }
        });

        function initializeApp() {
            // Configuración global de AJAX: token CSRF
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            // Inicializar componentes del template
            if (typeof M !== 'undefined') {
                M.Modal.init(document.querySelectorAll('.modal'));
                M.Tooltip.init(document.querySelectorAll('.tooltipped'));
            }

            // Inicialización de DataTable
            if (typeof jQuery.fn.DataTable === 'undefined') {
                console.error('DataTables no está disponible.');
                var dtCss = document.createElement('link');
                dtCss.rel = 'stylesheet';
                dtCss.href = 'https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css';
                document.head.appendChild(dtCss);

                var dtScript = document.createElement('script');
                dtScript.src = 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js';
                dtScript.onload = function () {
                    initializeDataTable();
                };
                document.body.appendChild(dtScript);
            } else {
                initializeDataTable();
            }
        }

        function initializeDataTable() {
            try {
                var table = jQuery('#respuestasTable').DataTable({
                    ajax: {
                        url: "{{ route('respuestas.datatable') }}",
                        dataSrc: '',
                        error: function (xhr, error, thrown) {
                            console.error('Error en la carga de datos:', error, thrown);
                            if (typeof M !== 'undefined') {
                                M.toast({
                                    html: '<i class="material-icons left">error</i> Error al cargar los datos',
                                    classes: 'rounded red'
                                });
                            } else {
                                alert('Error al cargar los datos de la tabla');
                            }
                        }
                    },
                    columns: [
                        {
                            data: 'pregunta.test_id', //columna oculta para filtrar por test
                            visible: false,
                            searchable: true
                        },
                        {
                            data: 'pregunta.question',
                            defaultContent: '<span class="grey-text">Sin Pregunta</span>',
                            render: function (data, type, row) {
                                return `<span data-id="${row.id}" data-field="question">${data ?? '-'}</span>`;
                            }
                        },
                        { data: 'id' },
                        {
                            data: 'answer',
                            render: function (data, type, row) {
                                return `<span class="editable" data-id="${row.id}" data-field="answer">${data ?? '-'}</span>`;
                            }
                        },
                        {
                            data: 'option',
                            render: function (data, type, row) {
                                return `<span class="editable" data-id="${row.id}" data-field="option">${data ?? '-'}</span>`;
                            }
                        },
                        
                        {
                            data: 'is_correct',
                            render: function(data, type, row) {
                                const icon = data ? '<i class="ri-check-line"></i>' : '<i class="ri-close-large-line"></i>';
                                return `<span class="editable" data-id="${row.id}" data-field="is_correct" data-value="${data}">${icon}</span>`;
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function (data, type, row) {
                                return `
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-azul waves-effect waves-light edit-btn tooltipped"
                                                style="margin: 8px; margin-left:0px" data-position="top" data-tooltip="Editar" data-id="${row.id}">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-rojo waves-effect waves-light delete-btn tooltipped"
                                                style="margin: 8px; margin-left:0px" data-position="top" data-tooltip="Eliminar" data-id="${row.id}">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ],
                    
                    responsive: true,
                    drawCallback: function () {
                        if (typeof M !== 'undefined') {
                            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                        }
                        var api = this.api();
                        var rows = api.rows({ page: 'current' }).nodes();
                        var preguntasProcesadas = {};

                        api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
                            var pregunta = api.cell(cell).data();

                            if (pregunta && preguntasProcesadas[pregunta]) {
                                cell.style.display = 'none'; // Oculta las preguntas repetidas
                            } else {
                                var count = api.column(0, { page: 'current' }).data().filter((data) => data === pregunta).length;
                                
                                if (pregunta) {
                                    cell.rowSpan = count;
                                    preguntasProcesadas[pregunta] = true;//Marca la pregunta como procesada
                                }
                            }
                        });
                    },
                    initComplete: function () {
                        
                        $('#filtroPruebaContainer').remove();

                       const pruebas = @json($pruebas);

                        let options = '<option value="">Todos</option>';
                        pruebas.forEach(p => {
                            options += `<option value="${p.id}">${p.test_title}</option>`;
                        });

                        let filtroSelectHtml = `
                            <div id="filtroPruebaContainer" style="display: inline-block; margin-left: 10px;">
                                <div class="input-field" style="margin:0;">
                                    <select id="filtroPrueba" class="browser-default">
                                        ${options}
                                    </select>
                                </div>
                            </div>
                        `;

                        let filtroCorrectasHtml = `
                            <div style="display:inline-block; margin-left:10px;">
                                <label>
                                    <input type="checkbox" id="filtrarCorrectas" />
                                    <span>Solo respuestas correctas</span>
                                </label>
                            </div>
                        `;

                        $('#respuestasTable_filter').append(filtroCorrectasHtml);
                        $('#respuestasTable_filter').append(filtroSelectHtml);

                        setTimeout(() => {
                            const select = document.getElementById('filtroPrueba');
                            const instance = M.FormSelect.getInstance(select);
                            if (instance) instance.destroy(); // destruir si ya existe
                            M.FormSelect.init(select);
                            $('#respuestasTable_filter').append($('#myCustomFilter'));
                            table.order([1, 'asc']).draw();
                        }, 100);

                        // Filtro por columna oculta (test_id)
                        $('#filtroPrueba').on('change', function () {
                            const val = $(this).val();
                            if (val) {
                                table.column(0).search('^' + val + '$', true, false).draw();
                            } else {
                                table.column(0).search('').draw();
                            }
                        });

                        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                            const rowNode = table.row(dataIndex).node(); // Obtiene el nodo de la fila
                            const isCorrect = $(rowNode).find('td span[data-field="is_correct"]').attr('data-value'); // Obtiene el valor oculto
                            
                            return $('#filtrarCorrectas').is(':checked') ? isCorrect === '1' : true;
                        });

                        // Evento para activar/desactivar el filtro
                        $('#filtrarCorrectas').on('change', function () {
                            
                            table.draw();
                        });
                    },
                    dom: '<"top"lf>rt<"bottom"ip><"clear">'
                });

                // Función para recargar la tabla
                function reloadTable() {
                    table.ajax.reload(function () {
                        if (typeof M !== 'undefined') {
                            M.toast({
                                html: '<i class="material-icons left">refresh</i> Tabla actualizada',
                                classes: 'rounded'
                            });
                        }
                    }, false);
                }

                //Editar datos de una respuesta con doble click
                $(document).on('dblclick', '.editable', function () {
                    const span = $(this);
                    const originalHTML = span.html().trim(); // Guarda el contenido con ícono
                    const field = span.data('field');
                    const id = span.data('id');
                    let editor;

                    if (field === 'is_correct') {
                        editor = $(`
                            <select class="inline-select">
                                <option value="1">✔️ Correcto</option>
                                <option value="0">❌ Incorrecto</option>
                            </select>
                        `);
                        
                        // Ajustar valor inicial detectando el ícono existente
                        const isChecked = originalHTML.includes('ri-check-line'); 
                        editor.val(isChecked ? '1' : '0');
                    } else {
                        editor = $('<input type="text" class="inline-input"/>')
                            .val(span.text().trim())
                            .css('width', '100%');
                    }

                    span.empty().append(editor);
                    editor.focus();

                    editor.on('blur change keydown', function (e) {
                        if ((e.type === 'keydown' && e.key !== 'Enter') ||
                            (field === 'is_correct' && e.type !== 'change' && e.type !== 'blur')) {
                            return;
                        }

                        let newValue;
                        if (field === 'is_correct') {
                            newValue = editor.val();
                        } else {
                            newValue = editor.val().trim();
                        }

                        // Si no hay cambios, restaurar contenido original con íconos
                        if ((field === 'is_correct' && ((originalHTML.includes('ri-check-line') ? '1' : '0') === newValue)) ||
                            (field !== 'is_correct' && newValue === span.text().trim())) {
                            
                            const restored = $('<span>')
                                .addClass('editable')
                                .attr('data-id', id)
                                .attr('data-field', field)
                                .html(originalHTML); //`.html()` para restaurar íconos en `is_correct`

                            editor.replaceWith(restored);
                            return;
                        }

                        // Si hay cambios, actualizar con el ícono correcto
                        const updatedHTML = field === 'is_correct'
                            ? (newValue === '1' ? '<i class="ri-check-line"></i>' : '<i class="ri-close-large-line"></i>')
                            : newValue;

                        const restored = $('<span>')
                            .addClass('editable')
                            .attr('data-id', id)
                            .attr('data-field', field)
                            .html(updatedHTML);

                        editor.replaceWith(restored);
                    

                        // Enviar AJAX
                        $.ajax({
                            url: `/psicometricas/admin/respuestas/${id}`,
                            method: 'PUT',
                            data: {
                                _token: "{{ csrf_token() }}",
                                [field]: newValue
                            },
                            success: function (response) {
                                // Texto a mostrar
                                const displayText = field === 'is_correct'
                                    ? (newValue === '1' ? 'Sí' : 'No')
                                    : newValue;

                                const nuevoSpan = $('<span>')
                                    .addClass('editable')
                                    .attr('data-id', id)
                                    .attr('data-field', field)
                                    .text(displayText);

                                editor.replaceWith(nuevoSpan);

                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Actualizado!',
                                    text: response.message || 'Campo actualizado correctamente',
                                    timer: 1500,
                                    showConfirmButton: false,
                                    background: '#262b3c',
                                });
                            },
                            error: function () {
                                // Restaura original en caso de error
                                const errorSpan = $('<span>')
                                    .addClass('editable')
                                    .attr('data-id', id)
                                    .attr('data-field', field)
                                    .text(originalText);
                                editor.replaceWith(errorSpan);

                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo actualizar.',
                                    background: '#262b3c',
                                });
                            }
                        });
                    });
                });

                // Comprobar disponibilidad de SweetAlert2
                if (typeof Swal === 'undefined') {
                    console.error('SweetAlert2 no está disponible.');
                    var swalScript = document.createElement('script');
                    swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    document.body.appendChild(swalScript);
                }


                //crear una respuesta
                $("#createRespuestaBtn").click(function() {
                    if (typeof Swal === 'undefined') {
                        alert('Falta SweetAlert2');
                        return;
                    }

                    $.ajax({
                        url: "{{ route('tests.withAll') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(tests) {
                            if (!Array.isArray(tests) || tests.length === 0) {
                                Swal.fire('Error', 'No hay tests disponibles para seleccionar.', 'error');
                                return;
                            }

                            // Función para crear opciones <option> de tests
                            function makeTestOptions() {
                                return tests.map(t => `<option value="${t.id}">${t.test_title}</option>`).join('');
                            }

                            // Función para crear opciones de secciones dado testId
                            function makeSectionOptions(testId) {
                                let test = tests.find(t => t.id == testId);
                                if (!test || !test.sections.length) {
                                    return '<option value="" disabled selected>No hay secciones</option>';
                                }
                                return test.sections.map(s => `<option value="${s.id}">${s.title}</option>`).join('');
                            }

                            // Función para crear opciones de preguntas con sectionId y testId
                            function makeQuestionOptions(testId, sectionId) {
                                let test = tests.find(t => t.id == testId);
                                if (!test) return '<option value="" disabled selected>No hay preguntas</option>';

                                let section = test.sections.find(s => s.id == sectionId);
                                if (!section || !section.questions.length) {
                                    return '<option value="" disabled selected>No hay preguntas</option>';
                                }

                                return section.questions.map(q =>
                                    `<option value="${q.id}" data-question-type="${q.question_type_id}">${q.question}</option>`
                                ).join('');
                            }

                            // Selección inicial
                            let selectedTestId = tests[0].id;
                            let selectedSectionId = tests[0].sections.length > 0 ? tests[0].sections[0].id : null;

                            // Opciones iniciales
                            let testOptions = makeTestOptions();
                            let sectionOptions = makeSectionOptions(selectedTestId);
                            let questionOptions = selectedSectionId ? makeQuestionOptions(selectedTestId, selectedSectionId) : '<option value="" disabled selected>No hay preguntas</option>';

                            let firstQuestionId = tests[0]?.sections[0]?.questions[0]?.id;
                            let firstQuestionType = getQuestionType(firstQuestionId, tests);
                            
                            Swal.fire({
                                html: `
                                    <div class="col-md mb-6 mb-md-0">
                                        <div class="card">
                                            <h2 class="card-header">Crear Respuesta</h2>
                                            <div class="card-body">
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <select id="swal-test_id" class="form-select" required>
                                                        ${testOptions}
                                                    </select>
                                                    <label for="swal-test_id">Test (Cuestionario)</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <select id="swal-section_id" class="form-select" required>
                                                        ${sectionOptions}
                                                    </select>
                                                    <label for="swal-section_id">Sección</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <select id="swal-question_id" class="form-select" required>
                                                        ${questionOptions}
                                                    </select>
                                                    <label for="swal-question_id">Pregunta</label>
                                                </div>

                                                <div id="respuestas-container">
                                                    <label>Respuestas</label>
                                                     ${generateRespuestaHTML(firstQuestionType)}
                                                </div>
                                                ${firstQuestionType === "10" ? '' : `
                                                    <button type="button" id="add-respuesta-btn" class="btn btn-azul mt-2" style="width:100%;">
                                                        + Añadir respuesta
                                                    </button>
                                                `}
                                            </div>
                                        </div>
                                    </div>
                                `,
                                showClass: { popup: 'animate__animated animate__fadeInDown' },
                                hideClass: { popup: 'animate__animated animate__fadeOutUp' },
                                focusConfirm: false,
                                confirmButtonText: 'Crear',
                                confirmButtonColor: '#3d4e81',
                                cancelButtonText: 'Cancelar',
                                cancelButtonColor: '#d32f2f',
                                showCancelButton: true,
                                buttonsStyling: true,
                                background: '#262b3c',
                                preConfirm: () => {
                                    const test_id = document.getElementById('swal-test_id').value;
                                    const section_id = document.getElementById('swal-section_id').value;
                                    const question_id = document.getElementById('swal-question_id').value;
                                    
                                    const questionType = parseInt(document.getElementById('add-respuesta-btn').dataset.questionType || '1');
                                    const respuestas = [];

                                    document.querySelectorAll('.respuesta-input').forEach(input => {
                                        const answer = input.querySelector('.answer-text').value.trim();
                                        const option = input.querySelector('.option-text').value.trim();
                                        const is_correct = input.querySelector('.is-correct').checked ? 1 : 0;

                                        if (questionType === 10) {
                                            if (answer) respuestas.push({ answer });
                                        } else if (questionType === 3) {
                                            if (answer && option) respuestas.push({ answer, option });
                                        } else {
                                            if (answer && option) respuestas.push({ answer, option, is_correct });
                                        }
                                    });


                                    if (!test_id || !section_id || !question_id || !answer || !option) {
                                        Swal.showValidationMessage('Por favor, complete todos los campos obligatorios.');
                                        return false;
                                    }

                                    return {
                                        test_id,
                                        section_id,
                                        question_id,
                                        respuestas,
                                        _token: '{{ csrf_token() }}'
                                    };
                                },
                                didOpen: () => {
                                    const container = document.getElementById('respuestas-container');
                                    const addBtn = document.getElementById('add-respuesta-btn');
                                    
                                    // Obtener tipo de la pregunta actual
                                    const questionSelect = document.getElementById('swal-question_id');
                                    const selectedQuestionId = parseInt(questionSelect.value);
                                    let questionType = getQuestionType(selectedQuestionId, tests);

                                    addBtn.style.display = (questionType === 10) ? 'none' : 'block';
                                    addBtn.dataset.questionType = questionType;

                                    //ajustar forma de agregar respuesta según tipo
                                    container.innerHTML = generateRespuestaHTML(questionType);
                                    updateRemoveButtons();
                                    

                                    addBtn.onclick = () => {
                                        const tipo = parseInt(addBtn.dataset.questionType);
                                        console.log(tipo)
                                        container.insertAdjacentHTML('beforeend', generateRespuestaHTML(tipo));
                                        updateRemoveButtons();
                                    };

                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "{{ route('respuestas.store') }}",
                                        type: "POST",
                                        data: result.value,
                                        dataType: "json",
                                        success: function(response) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: '¡Éxito!',
                                                text: response.message || 'Respuesta creada correctamente.',
                                                confirmButtonColor: '#26a69a',
                                                timer: 2000,
                                                timerProgressBar: true,
                                                background: '#262b3c',
                                            });
                                            reloadTable();
                                        },
                                        error: function(xhr) {
                                            let errorMsg = 'No se pudo crear la respuesta.';
                                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                                errorMsg = xhr.responseJSON.message;
                                            }
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: errorMsg,
                                                confirmButtonColor: '#ef5350',
                                                background: '#262b3c',
                                            });
                                        }
                                    });
                                }
                            });

                            function getQuestionType(questionId, tests) {
                                        for (const test of tests) {
                                            for (const section of test.sections) {
                                                const question = section.questions.find(q => q.id === questionId);
                                                if (question) return parseInt(question.question_type_id);
                                            }
                                        }
                                        return 1; // Default
                            }

                            function generateRespuestaHTML(questionType) {
                                        if (questionType === 3) {
                                            return `
                                                <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                                    <input type="text" class="form-control answer-text" placeholder="Elemento A" required style="flex:2;">
                                                    <input type="text" class="form-control option-text" placeholder="Elemento B" required style="flex:2;">
                                                    <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar par">×</button>
                                                </div>
                                            `;
                                        } else if (questionType === 10) {
                                            return  `
                                                <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                                    <input type="text" class="form-control answer-text" value="Respuesta abierta" disabled style="flex:4;">
                                                </div>
                                            `;
                                        } else {
                                            return `
                                                <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                                    <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                                    <input type="text" class="form-control option-text" placeholder="Opción" required style="flex:2;">
                                                    <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                                                    <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                                                </div>
                                            `;
                                        }
                            }

                            function updateRemoveButtons() {
                                const container = document.getElementById('respuestas-container');
                                const removeBtns = container.querySelectorAll('.remove-respuesta');
                                    removeBtns.forEach(btn => {
                                    btn.onclick = function () {
                                        if (container.querySelectorAll('.respuesta-input').length > 1) {
                                            btn.parentElement.remove();
                                        }
                                    };
                                });
                            }

                            // Cambiar secciones y preguntas al cambiar test
                            $(document).off('change', '#swal-test_id').on('change', '#swal-test_id', function() {
                                let testId = $(this).val();
                                let newSectionOptions = makeSectionOptions(testId);
                                $('#swal-section_id').html(newSectionOptions);

                                // Actualizar preguntas para la primera sección
                                let firstSectionId = $('#swal-section_id option:not([disabled])').first().val() || '';
                                let newQuestionOptions = makeQuestionOptions(testId, firstSectionId);
                                $('#swal-question_id').html(newQuestionOptions);
                            });

                            // Cambiar preguntas al cambiar sección
                            $(document).off('change', '#swal-section_id').on('change', '#swal-section_id', function() {
                                let sectionId = $(this).val();
                                let testId = $('#swal-test_id').val();
                                let newQuestionOptions = makeQuestionOptions(testId, sectionId);
                                $('#swal-question_id').html(newQuestionOptions);
                            });

                            // cambiar respuestas al cambiar pregunta
                            $(document).off('change', '#swal-question_id').on('change', '#swal-question_id', function() {
                                const selectedQuestionId = parseInt($(this).val());
                                const questionType = getQuestionType(selectedQuestionId, tests);

                                const addBtn = document.getElementById('add-respuesta-btn');
                                addBtn.dataset.questionType = questionType;
                                addBtn.style.display = (questionType === 10) ? 'none' : 'block';
                                
                                const container = document.getElementById('respuestas-container');
                                container.innerHTML = generateRespuestaHTML(questionType);
                                updateRemoveButtons();
                            });
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudieron cargar los tests.',
                                confirmButtonColor: '#d32f2f',
                            });
                        }
                    });
                });

                //editar a qué pregunta, sección y test pertenece la respuesta
                $('#respuestasTable').on('click', '.edit-btn', function () {
                    const id = $(this).data('id');

                    // Obtener la respuesta actual
                    $.ajax({
                        url: `/psicometricas/admin/respuestas/${id}`,
                        type: "GET",
                        dataType: "json",
                        success: function (respuesta) {
                            $.ajax({
                                url: "{{ route('tests.withAll') }}",
                                type: "GET",
                                dataType: "json",
                                success: function (tests) {
                                    // Construir options para tests
                                    let testOptions = tests.map(t => {
                                        const selected = t.id == respuesta.pregunta.test_id ? 'selected' : '';
                                        return `<option value="${t.id}" ${selected}>${t.test_title || t.title || t.name}</option>`;
                                    }).join('');

                                    // Obtener secciones del test seleccionado
                                    let selectedTest = tests.find(t => t.id == respuesta.pregunta.test_id);
                                    let sections = selectedTest ? selectedTest.sections : [];

                                    let sectionOptions = sections.map(s => {
                                        const selected = s.id == respuesta.pregunta.section_id ? 'selected' : '';
                                        return `<option value="${s.id}" ${selected}>${s.title}</option>`;
                                    }).join('');

                                    // Obtener preguntas de la sección seleccionada
                                    let selectedSection = sections.find(s => s.id == respuesta.pregunta.section_id);
                                    let questions = selectedSection ? selectedSection.questions : [];

                                    let questionOptions = questions.map(q => {
                                        const selected = q.id == respuesta.question_id ? 'selected' : '';
                                        return `<option value="${q.id}" ${selected}>${q.question}</option>`;
                                    }).join('');

                                    Swal.fire({
                                        html: `
                                            <div class="col-md mb-6 mb-md-0">
                                                <div class="card">
                                                    <h2 class="card-header">Editar a qué prueba pertenece esta respuesta/h2>
                                                    <div class="card-body">
                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <select id="swal-test_id" class="form-select" required>
                                                                ${testOptions}
                                                            </select>
                                                            <label for="swal-test_id">Test (Cuestionario)</label>
                                                        </div>
                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <select id="swal-section_id" class="form-select" required>
                                                                ${sectionOptions}
                                                            </select>
                                                            <label for="swal-section_id">Sección</label>
                                                        </div>
                                                        <div class="form-floating form-floating-outline mb-6">
                                                            <select id="swal-question_id" class="form-select" required>
                                                                ${questionOptions}
                                                            </select>
                                                            <label for="swal-question_id">Pregunta</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        `,
                                        showClass: { popup: 'animate__animated animate__fadeInDown' },
                                        hideClass: { popup: 'animate__animated animate__fadeOutUp' },
                                        focusConfirm: false,
                                        confirmButtonText: 'Actualizar',
                                        confirmButtonColor: '#3d4e81',
                                        cancelButtonText: 'Cancelar',
                                        cancelButtonColor: '#d32f2f',
                                        showCancelButton: true,
                                        buttonsStyling: true,
                                        background: '#262b3c',
                                        preConfirm: () => {
                                            return {
                                                question_id: $('#swal-question_id').val(),
                                                _token: '{{ csrf_token() }}'
                                            };
                                        }
                                    }).then(result => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: `/psicometricas/admin/respuestas/${id}`,
                                                type: "PUT",
                                                data: result.value,
                                                dataType: "json",
                                                success: function (response) {
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: '¡Actualizado!',
                                                        text: response.message,
                                                        timer: 2000,
                                                        timerProgressBar: true,
                                                        background: '#262b3c',
                                                        confirmButtonColor: '#26a69a'
                                                    });
                                                    reloadTable();
                                                },
                                                error: function (xhr) {
                                                    let errorMsg = 'No se pudo actualizar.';
                                                    if (xhr.responseJSON?.message) {
                                                        errorMsg = xhr.responseJSON.message;
                                                    }
                                                    Swal.fire({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: errorMsg,
                                                        confirmButtonColor: '#ef5350',
                                                        background: '#262b3c'
                                                    });
                                                }
                                            });
                                        }
                                    });

                                    // Actualizar secciones y preguntas cuando cambia el test
                                    $(document).off('change', '#swal-test_id').on('change', '#swal-test_id', function () {
                                        let testId = $(this).val();
                                        let test = tests.find(t => t.id == testId);
                                        let newSections = test ? test.sections : [];

                                        let newSectionOptions = newSections.map(s => `<option value="${s.id}">${s.title}</option>`).join('');
                                        $('#swal-section_id').html(newSectionOptions);

                                        // Actualizar preguntas para la primera sección
                                        let firstSectionId = newSections.length ? newSections[0].id : null;
                                        let newQuestions = firstSectionId ? (test.sections.find(s => s.id == firstSectionId)?.questions || []) : [];
                                        let newQuestionOptions = newQuestions.map(q => `<option value="${q.id}">${q.question}</option>`).join('');
                                        $('#swal-question_id').html(newQuestionOptions);
                                    });

                                    // Actualizar preguntas cuando cambia la sección
                                    $(document).off('change', '#swal-section_id').on('change', '#swal-section_id', function () {
                                        let sectionId = $(this).val();
                                        // Buscar la sección dentro del test actual seleccionado
                                        let currentTestId = $('#swal-test_id').val();
                                        let test = tests.find(t => t.id == currentTestId);
                                        let section = test ? test.sections.find(s => s.id == sectionId) : null;
                                        let questions = section ? section.questions : [];
                                        let questionOptions = questions.map(q => `<option value="${q.id}">${q.question}</option>`).join('');
                                        $('#swal-question_id').html(questionOptions);
                                    });

                                    // Actualizar respuestas al cambiar pregunta
                                    $(document).off('change', '#swal-question_id').on('change', '#swal-question_id', function () {
                                        let selectedQuestionId = $(this).val();
                                        
                                        let currentQuestionId = $('#swal-question_id').val();
                                        let question = questions.find(q => q.id == currentQuestionId);

                                        let questionType = parseInt(question.question_type_id);
                                        $('#add-respuesta-btn').data('questionType', questionType);

                                        const container = document.getElementById('respuestas-container');
                                        container.innerHTML = '';

                                        const div = document.createElement('div');
                                        div.className = 'respuesta-input';
                                        div.style.cssText = 'display:flex; gap:10px; margin-bottom:10px; align-items:center;';

                                        if (questionType === 3) {
                                            return `
                                                <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                                    <input type="text" class="form-control answer-text" placeholder="Elemento A" required style="flex:2;">
                                                    <input type="text" class="form-control option-text" placeholder="Elemento B" required style="flex:2;">
                                                    <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar par">×</button>
                                                </div>
                                            `;
                                        } else if (questionType === 10) {
                                            return `
                                                <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                                    <input type="text" class="form-control answer-text" placeholder="Respuesta abierta" required style="flex:4;">
                                                    <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                                                </div>
                                            `;
                                        } else {
                                            return `
                                                <div class="respuesta-input" style="display:flex; gap:10px; margin-bottom:10px; align-items:center;">
                                                    <input type="text" class="form-control answer-text" placeholder="Respuesta" required style="flex:2;">
                                                    <input type="text" class="form-control option-text" placeholder="Opción" required style="flex:2;">
                                                    <input type="checkbox" class="form-check-input is-correct" title="¿Es correcta?">
                                                    <button type="button" class="remove-respuesta btn btn-rojo btn-sm" title="Eliminar respuesta">×</button>
                                                </div>
                                            `;
                                        }
                                        container.appendChild(div);
                                    });
                                },
                                error: function () {
                                    Swal.fire('Error', 'No se pudieron cargar los tests.', 'error');
                                }
                            });
                        },
                        error: function () {
                            Swal.fire('Error', 'No se pudo obtener la respuesta.', 'error');
                        }
                    });
                });

                // Eliminar Respuesta
                $('#respuestasTable').on('click', '.delete-btn', function() {
                    const id = $(this).data('id');

                    Swal.fire({
                        title: '¿Eliminar Respuesta?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f44336', // rojo
                        cancelButtonColor: '#9e9e9e',  // gris
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        background: '#262b3c',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/psicometricas/admin/respuestas/${id}`,
                                type: "DELETE",
                                data: { _token: '{{ csrf_token() }}' },
                                dataType: "json",
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Respuesta eliminada!',
                                        text: response.message,
                                        confirmButtonColor: '#26a69a', // verde
                                        timer: 2000,
                                        timerProgressBar: true
                                    });
                                    reloadTable();
                                },
                                error: function(xhr) {
                                    let errorMsg = 'No se pudo eliminar la respuesta.';
                                    if (xhr.responseJSON && xhr.responseJSON.message) {
                                        errorMsg = xhr.responseJSON.message;
                                    }
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: errorMsg,
                                        confirmButtonColor: '#ef5350'
                                    });
                                }
                            });
                        }
                    });
                });

                // Reinicializar tooltips
                if (typeof M !== 'undefined') {
                        M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                    }
            } catch (error) {
                console.error('Error al inicializar la tabla:', error);
                alert('Ocurrió un error al inicializar la aplicación: ' + error.message);
            }
        }
    </script>
@endsection
