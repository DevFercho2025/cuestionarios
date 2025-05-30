@extends('layout.admin')
@section('title', 'Gestión de Preguntas')
@section('content')
    <div class="container">
       <!-- emcabezado-->
       <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Gestión de Preguntas</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="crearPreguntaBtn" class="btn btn-large gradient-btn pulse">
                                Nueva pregunta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Preguntas -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="preguntasTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pregunta</th>
                                <th>Cuestionario</th>
                                <th>Sección</th>
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
                M.FormSelect.init(document.querySelectorAll('select'));
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
                var table = jQuery('#preguntasTable').DataTable({
                    ajax: {
                        url: "{{ route('preguntas.datatable') }}",
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
                        { data: 'pregunta_id' },
                        { data: 'question' },
                        { data: 'test.titulo', defaultContent: '<span class="grey-text">Sin Test</span>' },
                        { data: 'seccion.title', defaultContent: '<span class="grey-text">Sin Sección</span>' },
                        {
                            data: null,
                            render: function(data, type, row) {
                                return `
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-info waves-effect waves-light edit-btn tooltipped"
                                                data-position="top" data-tooltip="Editar" data-id="${row.pregunta_id}">
                                            <i class="ri-pencil-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light eliminar-pregunta-btn tooltipped"
                                                data-position="top" data-tooltip="Eliminar" data-id="${row.pregunta_id}">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ],
                    responsive: true,
                    // Se elimina la opción de idioma para evitar textos extra de traducción
                    drawCallback: function () {
                        if (typeof M !== 'undefined') {
                            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                        }
                    },
                    initComplete: function () {
                        console.log('DataTable inicializada completamente');
                    }
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

                // Comprobar disponibilidad de SweetAlert2
                if (typeof Swal === 'undefined') {
                    console.error('SweetAlert2 no está disponible.');
                    var swalScript = document.createElement('script');
                    swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    document.body.appendChild(swalScript);
                }

                //crear pregunta sin formato
                /*jQuery("#crearPreguntaBtn").click(function () {
                    if (typeof Swal === 'undefined') {
                        alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                        return;
                    }

                    // 1. Cargar todos los tests
                    $.ajax({
                        url: "{{ route('tests.all') }}", // Define ruta para traer tests con su id y título
                        type: "GET",
                        dataType: "json",
                        success: function (tests) {
                            if (!Array.isArray(tests) || tests.length === 0) {
                                Swal.fire('Error', 'No hay tests disponibles para seleccionar.', 'error');
                                return;
                            }

                            // Opciones para select de tests
                            let testOptions = tests.map(t => `<option value="${t.id}">${t.test_title || t.titulo || t.title || t.name}</option>`).join('');

                            // Cargar secciones del primer test por defecto
                            let selectedTestId = tests[0].id;

                            // Función para cargar secciones según test_id
                            function loadSections(testId, callback) {
                                $.ajax({
                                    url: "{{ url('psicometricas/admin/secciones/by-test') }}/" + testId, // Ruta que devuelve secciones de un test dado
                                    type: "GET",
                                    dataType: "json",
                                    success: function (secciones) {
                                        if (!Array.isArray(secciones) || secciones.length === 0) {
                                            callback('<option value="" disabled selected>No hay secciones</option>');
                                        } else {
                                            let secOptions = secciones.map(s => `<option value="${s.id}">${s.title}</option>`).join('');
                                            callback(secOptions);
                                        }
                                    },
                                    error: function () {
                                        callback('<option value="" disabled selected>Error cargando secciones</option>');
                                    }
                                });
                            }

                            // Cargar secciones inicialmente para el primer test
                            loadSections(selectedTestId, function (sectionOptions) {
                                Swal.fire({
                                    html: `
                                        <div class="col-md mb-6 mb-md-0">
                                            <div class="card">
                                                <h2 class="card-header">Crear Pregunta</h2>
                                                <div class="card-body">
                                                    <div class="form-floating form-floating-outline mb-6">
                                                        <input id="swal-question" type="text" class="form-control" placeholder="Pregunta" required>
                                                        <label for="swal-question">Pregunta</label>
                                                    </div>
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
                                                    <div class="form-check mb-6">
                                                        <input class="form-check-input" type="checkbox" value="1" id="swal-required">
                                                        <label class="form-check-label" for="swal-required">Requerida</label>
                                                    </div>
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
                                        const question = document.getElementById('swal-question').value.trim();
                                        const test_id = document.getElementById('swal-test_id').value;
                                        const section_id = document.getElementById('swal-section_id').value;
                                        const required = document.getElementById('swal-required').checked ? 1 : 0;

                                        if (!question || !test_id || !section_id) {
                                            Swal.showValidationMessage('Por favor, complete todos los campos obligatorios.');
                                            return false;
                                        }

                                        return {
                                            question,
                                            test_id,
                                            section_id,
                                            required,
                                            _token: '{{ csrf_token() }}'
                                        };
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $.ajax({
                                            url: "{{ route('preguntas.store') }}",
                                            type: "POST",
                                            data: result.value,
                                            dataType: "json",
                                            success: function (response) {
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: '¡Éxito!',
                                                    text: response.message || 'Pregunta creada exitosamente.',
                                                    confirmButtonColor: '#3d4e81',
                                                    timer: 2000,
                                                    timerProgressBar: true,
                                                    background: '#262b3c',
                                                });
                                                $('#preguntasTable').DataTable().ajax.reload(null, false);
                                            },
                                            error: function (xhr) {
                                                let errorMsg = 'No se pudo crear la pregunta.';
                                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                                    errorMsg = xhr.responseJSON.message;
                                                }
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: errorMsg,
                                                    confirmButtonColor: '#d32f2f',
                                                    background: '#262b3c',
                                                });
                                            }
                                        });
                                    }
                                });

                                // Cuando cambie el test, actualizar secciones
                                $(document).off('change', '#swal-test_id');
                                $(document).on('change', '#swal-test_id', function () {
                                    let selectedTest = $(this).val();
                                    loadSections(selectedTest, function (secOptions) {
                                        $('#swal-section_id').html(secOptions);
                                    });
                                });
                            });
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudieron cargar los tests.',
                                confirmButtonColor: '#d32f2f',
                            });
                        }
                    });
                });*/

                //crear pregunta con formato
                jQuery("#crearPreguntaBtn").click(function () {
                    if (typeof Swal === 'undefined') {
                        alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                        return;
                    }

                    // 1. Cargar todos los tests y tipos de pregunta simultáneamente
                    $.when(
                        $.ajax({
                            url: "{{ route('tests.all') }}",
                            type: "GET",
                            dataType: "json"
                        }),
                        $.ajax({
                            url: "{{ route('question_types.all') }}", // Ruta para obtener tipos de pregunta
                            type: "GET",
                            dataType: "json"
                        })
                    ).done(function (tests, questionTypes) {
                        tests = tests[0];           // $.when devuelve arrays con [data, status, xhr]
                        questionTypes = questionTypes[0];

                        if (!Array.isArray(tests) || tests.length === 0) {
                            Swal.fire('Error', 'No hay tests disponibles para seleccionar.', 'error');
                            return;
                        }
                        if (!Array.isArray(questionTypes) || questionTypes.length === 0) {
                            Swal.fire('Error', 'No hay tipos de pregunta disponibles.', 'error');
                            return;
                        }

                        // Opciones para select tests
                        let testOptions = tests.map(t => `<option value="${t.id}">${t.test_title || t.titulo || t.title || t.name}</option>`).join('');

                        // Opciones para select tipos de pregunta
                        let typeOptions = questionTypes.map(qt => `<option value="${qt.id}">${qt.name}</option>`).join('');

                        let selectedTestId = tests[0].id;

                        function loadSections(testId, callback) {
                            $.ajax({
                                url: "{{ url('psicometricas/admin/secciones/by-test') }}/" + testId,
                                type: "GET",
                                dataType: "json",
                                success: function (secciones) {
                                    if (!Array.isArray(secciones) || secciones.length === 0) {
                                        callback('<option value="" disabled selected>No hay secciones</option>');
                                    } else {
                                        let secOptions = secciones.map(s => `<option value="${s.id}">${s.title}</option>`).join('');
                                        callback(secOptions);
                                    }
                                },
                                error: function () {
                                    callback('<option value="" disabled selected>Error cargando secciones</option>');
                                }
                            });
                        }

                        loadSections(selectedTestId, function (sectionOptions) {
                            Swal.fire({
                                html: `
                                    <div class="col-md mb-6 mb-md-0">
                                        <div class="card">
                                            <h2 class="card-header">Crear Pregunta</h2>
                                            <div class="card-body">
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input id="swal-question" type="text" class="form-control" placeholder="Pregunta" required>
                                                    <label for="swal-question">Pregunta</label>
                                                </div>
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
                                                    <select id="swal-question_type_id" class="form-select" required>
                                                        ${typeOptions}
                                                    </select>
                                                    <label for="swal-question_type_id">Tipo de pregunta</label>
                                                </div>
                                                <div class="form-check mb-6">
                                                    <input class="form-check-input" type="checkbox" value="1" id="swal-required">
                                                    <label class="form-check-label" for="swal-required">Requerida</label>
                                                </div>
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
                                    const question = document.getElementById('swal-question').value.trim();
                                    const test_id = document.getElementById('swal-test_id').value;
                                    const section_id = document.getElementById('swal-section_id').value;
                                    const question_type_id = document.getElementById('swal-question_type_id').value;
                                    const required = document.getElementById('swal-required').checked ? 1 : 0;

                                    if (!question || !test_id || !section_id || !question_type_id) {
                                        Swal.showValidationMessage('Por favor, complete todos los campos obligatorios.');
                                        return false;
                                    }

                                    return {
                                        question,
                                        test_id,
                                        section_id,
                                        question_type_id,
                                        required,
                                        _token: '{{ csrf_token() }}'
                                    };
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: "{{ route('preguntas.store') }}",
                                        type: "POST",
                                        data: result.value,
                                        dataType: "json",
                                        success: function (response) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: '¡Éxito!',
                                                text: response.message || 'Pregunta creada exitosamente.',
                                                confirmButtonColor: '#3d4e81',
                                                timer: 2000,
                                                timerProgressBar: true,
                                                background: '#262b3c',
                                            });
                                            $('#preguntasTable').DataTable().ajax.reload(null, false);
                                        },
                                        error: function (xhr) {
                                            let errorMsg = 'No se pudo crear la pregunta.';
                                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                                errorMsg = xhr.responseJSON.message;
                                            }
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Error',
                                                text: errorMsg,
                                                confirmButtonColor: '#d32f2f',
                                                background: '#262b3c',
                                            });
                                        }
                                    });
                                }
                            });

                            // Cuando cambie el test, actualizar secciones
                            $(document).off('change', '#swal-test_id');
                            $(document).on('change', '#swal-test_id', function () {
                                let selectedTest = $(this).val();
                                loadSections(selectedTest, function (secOptions) {
                                    $('#swal-section_id').html(secOptions);
                                });
                            });
                        });

                    }).fail(function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudieron cargar los tests o los tipos de pregunta.',
                            confirmButtonColor: '#d32f2f',
                        });
                    });
                });


                //editar pregunta
                /*$('#preguntasTable').on('click', '.edit-btn', function() {
                    const id = $(this).data('id');  //ID de la fila seleccionada
                    var rowData = table.row($(this).closest('tr')).data();
                    
                    $.ajax({
                        url: "{{ route('secciones.all') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(secciones) {
                            let options = '<option value="" disabled>Seleccione una sección</option>';
                            $.each(secciones, function(i, sec) {
                                const selected = rowData.seccion && sec.id === rowData.seccion.id ? 'selected' : '';
                                options += `<option value="${sec.id}" ${selected}>${sec.titulo}</option>`;
                            });

                            Swal.fire({
                                html: `
                                    <div class="col-md mb-6 mb-md-0">
                                    <div class="card">
                                        <h2 class="card-header">Editar Pregunta</h2>
                                        <div class="card-body">
                                            <div class="form-floating form-floating-outline mb-6">
                                                <input type="text" id="pregunta" class="form-control" placeholder="Pregunta" value="${rowData.pregunta}" required>
                                                <label for="pregunta">Pregunta</label>
                                            </div>
                                            <div class="form-floating form-floating-outline mb-6">
                                                <input type="text" id="cuestionario" class="form-control" placeholder="Cuestionario" value="${rowData.cuestionario}" required>
                                                <label for="cuestionario">Cuestionario</label>
                                            </div>
                                            <div class="form-floating form-floating-outline mb-6">
                                                <select id="swal-seccion" class="form-select">
                                                ${options}
                                                </select>
                                                <label for="swal-seccion">Sección</label>
                                            </div>
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
                                    var pregunta = $('#pregunta').val();
                                    var cuestionario = $('#cuestionario').val();
                                    var seccion_id = $('#swal-seccion').val();

                                    return $.ajax({
                                    url: `/admin/preguntas/${id}`,
                                    type: 'PUT',
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    data: {
                                        pregunta: pregunta,
                                        cuestionario: cuestionario,
                                        seccion_id: seccion_id
                                    }
                                    }).then(response => {
                                    Swal.fire('¡Actualizado!', 'Los datos se han actualizado correctamente.', 'success');
                                    table.ajax.reload();
                                    }).catch(() => {
                                    Swal.showValidationMessage('Hubo un problema al actualizar los datos.');
                                    });
                                }
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudieron cargar las secciones.',
                                confirmButtonColor: '#ef5350'
                            });
                        }
                    });
                });*/

                $('#preguntasTable').on('click', '.edit-btn', function() {
                    const preguntaId = $(this).data('id');
                    const table = $('#preguntasTable').DataTable();

                    // Obtener datos de la fila seleccionada (opcional, puede contener info básica)
                    var rowData = table.row($(this).closest('tr')).data();

                    // 1. Cargar la pregunta con sus datos completos
                    $.ajax({
                        url: "{{ url('psicometricas/admin/gpreguntas') }}/" + preguntaId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(pregunta) {
                            // 2. Cargar todos los tests
                            $.ajax({
                                url: "{{ route('tests.all') }}",
                                type: "GET",
                                dataType: "json",
                                success: function(tests) {
                                    if (!Array.isArray(tests) || tests.length === 0) {
                                        Swal.fire('Error', 'No hay tests disponibles para seleccionar.', 'error');
                                        return;
                                    }

                                    let testOptions = tests.map(t => 
                                        `<option value="${t.id}" ${t.id == pregunta.test_id ? 'selected' : ''}>${t.test_title || t.titulo || t.title || t.name}</option>`
                                    ).join('');

                                    // Función para cargar secciones de un test específico, con opción de seleccionar la sección actual
                                    function loadSections(testId, selectedSectionId, callback) {
                                        $.ajax({
                                            url: "{{ url('psicometricas/admin/secciones/by-test') }}/" + testId,
                                            type: "GET",
                                            dataType: "json",
                                            success: function (secciones) {
                                                if (!Array.isArray(secciones) || secciones.length === 0) {
                                                    callback('<option value="" disabled>No hay secciones</option>');
                                                } else {
                                                    let secOptions = secciones.map(s => 
                                                        `<option value="${s.id}" ${s.id == selectedSectionId ? 'selected' : ''}>${s.title}</option>`
                                                    ).join('');
                                                    callback(secOptions);
                                                }
                                            },
                                            error: function () {
                                                callback('<option value="" disabled>Error cargando secciones</option>');
                                            }
                                        });
                                    }

                                    // 3. Cargar tipos de pregunta
                                    $.ajax({
                                        url: "{{ route('question_types.all') }}",
                                        type: "GET",
                                        dataType: "json",
                                        success: function(questionTypes) {
                                            let typeOptions = questionTypes.map(qt => 
                                                `<option value="${qt.id}" ${qt.id == pregunta.question_type_id ? 'selected' : ''}>${qt.name}</option>`
                                            ).join('');

                                            // 4. Cargar las secciones del test seleccionado, para poner el select correcto
                                            loadSections(pregunta.test_id, pregunta.section_id, function(sectionOptions) {
                                                // 5. Mostrar SweetAlert con el formulario precargado
                                                Swal.fire({
                                                    html: `
                                                        <div class="col-md mb-6 mb-md-0">
                                                            <div class="card">
                                                                <h2 class="card-header">Editar Pregunta</h2>
                                                                <div class="card-body">
                                                                    <div class="form-floating form-floating-outline mb-6">
                                                                        <input id="swal-question" type="text" class="form-control" placeholder="Pregunta" value="${pregunta.question}" required>
                                                                        <label for="swal-question">Pregunta</label>
                                                                    </div>

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
                                                                        <select id="swal-question_type_id" class="form-select" required>
                                                                            ${typeOptions}
                                                                        </select>
                                                                        <label for="swal-question_type_id">Tipo de Pregunta</label>
                                                                    </div>

                                                                    <div class="form-check mb-6">
                                                                        <input class="form-check-input" type="checkbox" value="1" id="swal-required" ${pregunta.required ? 'checked' : ''}>
                                                                        <label class="form-check-label" for="swal-required">Requerida</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    `,
                                                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                                                    hideClass: { popup: 'animate__animated animate__fadeOutUp' },
                                                    focusConfirm: false,
                                                    confirmButtonText: 'Guardar',
                                                    confirmButtonColor: '#3d4e81',
                                                    cancelButtonText: 'Cancelar',
                                                    cancelButtonColor: '#d32f2f',
                                                    showCancelButton: true,
                                                    buttonsStyling: true,
                                                    background: '#262b3c',
                                                    preConfirm: () => {
                                                        const question = document.getElementById('swal-question').value.trim();
                                                        const test_id = document.getElementById('swal-test_id').value;
                                                        const section_id = document.getElementById('swal-section_id').value;
                                                        const question_type_id = document.getElementById('swal-question_type_id').value;
                                                        const required = document.getElementById('swal-required').checked ? 1 : 0;

                                                        if (!question || !test_id || !section_id || !question_type_id) {
                                                            Swal.showValidationMessage('Por favor, complete todos los campos obligatorios.');
                                                            return false;
                                                        }

                                                        return {
                                                            question,
                                                            test_id,
                                                            section_id,
                                                            question_type_id,
                                                            required,
                                                            _token: '{{ csrf_token() }}'
                                                        };
                                                    }
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        $.ajax({
                                                            url: `/preguntas/${preguntaId}`,
                                                            type: "PUT",
                                                            data: result.value,
                                                            dataType: "json",
                                                            success: function (response) {
                                                                Swal.fire({
                                                                    icon: 'success',
                                                                    title: '¡Éxito!',
                                                                    text: response.message || 'Pregunta actualizada exitosamente.',
                                                                    confirmButtonColor: '#3d4e81',
                                                                    timer: 2000,
                                                                    timerProgressBar: true,
                                                                    background: '#262b3c',
                                                                });
                                                                table.ajax.reload(null, false);
                                                            },
                                                            error: function (xhr) {
                                                                let errorMsg = 'No se pudo actualizar la pregunta.';
                                                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                                                    errorMsg = xhr.responseJSON.message;
                                                                }
                                                                Swal.fire({
                                                                    icon: 'error',
                                                                    title: 'Error',
                                                                    text: errorMsg,
                                                                    confirmButtonColor: '#d32f2f',
                                                                    background: '#262b3c',
                                                                });
                                                            }
                                                        });
                                                    }
                                                });

                                                // Cuando cambie el test, actualizar secciones
                                                $(document).off('change', '#swal-test_id');
                                                $(document).on('change', '#swal-test_id', function () {
                                                    let selectedTest = $(this).val();
                                                    loadSections(selectedTest, null, function(secOptions) {
                                                        $('#swal-section_id').html(secOptions);
                                                    });
                                                });
                                            });
                                        },
                                        error: function() {
                                            Swal.fire('Error', 'No se pudieron cargar los tipos de pregunta.', 'error');
                                        }
                                    });
                                },
                                error: function() {
                                    Swal.fire('Error', 'No se pudieron cargar los tests.', 'error');
                                }
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'No se pudo cargar la pregunta.', 'error');
                        }
                    });
                });



                // Eliminar Pregunta
                $('#preguntasTable').on('click', '.eliminar-pregunta-btn', function() {
                    const preguntaId = $(this).data('id');
                    Swal.fire({
                        title: '¿Eliminar Pregunta?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f44336',
                        cancelButtonColor: '#9e9e9e',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                        background: '#262b3c',
                    }).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url: `/psicometricas/admin/preguntas/${preguntaId}`,
                                type: "DELETE",
                                data: { _token: '{{ csrf_token() }}' },
                                success: function(response){
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Pregunta eliminada!',
                                        text: response.message,
                                        confirmButtonColor: '#26a69a',
                                        timer: 2000,
                                        timerProgressBar: true
                                    });
                                    reloadTable();
                                },
                                error: function(xhr){
                                    Swal.fire('Error', 'No se pudo eliminar la pregunta.', 'error');
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
