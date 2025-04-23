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
                            <a id="registrarCandidatoBtn" class="btn btn-large gradient-btn pulse">
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
                        { data: 'pregunta' },
                        { data: 'cuestionario' },
                        { data: 'seccion.titulo', defaultContent: '<span class="grey-text">Sin Sección</span>' },
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

                // Crear Pregunta
                $("#createPreguntaBtn").click(function(){
                    showLoader();
                    // Cargar secciones para el dropdown
                    $.ajax({
                        url: "{{ route('secciones.all') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(secciones){
                            hideLoader();
                            let options = '<option value="" disabled selected>Seleccione una sección</option>';
                            $.each(secciones, function(i, sec){
                                options += `<option value="${sec.id}">${sec.titulo}</option>`;
                            });

                            // Usar SweetAlert2 con estilos de Materialize
                            Swal.fire({
                                title: '<i class="material-icons">add_circle_outline</i> Crear Pregunta',
                                html: `
                                    <div class="input-field">
                                        <i class="material-icons prefix">help</i>
                                        <input id="swal-pregunta" type="text" class="validate">
                                        <label for="swal-pregunta">Pregunta</label>
                                    </div>
                                    <div class="input-field">
                                        <i class="material-icons prefix">assignment</i>
                                        <input id="swal-cuestionario" type="text" class="validate">
                                        <label for="swal-cuestionario">Cuestionario</label>
                                    </div>
                                    <div class="input-field">
                                        <i class="material-icons prefix">category</i>
                                        <select id="swal-seccion" class="browser-default">${options}</select>
                                    </div>
                                `,
                                showClass: {
                                    popup: 'animate__animated animate__fadeInDown'
                                },
                                hideClass: {
                                    popup: 'animate__animated animate__fadeOutUp'
                                },
                                focusConfirm: false,
                                confirmButtonText: '<i class="material-icons left">check</i> Crear',
                                confirmButtonColor: '#26a69a',
                                cancelButtonText: '<i class="material-icons left">close</i> Cancelar',
                                cancelButtonColor: '#ef5350',
                                showCancelButton: true,
                                buttonsStyling: true,
                                preConfirm: () => {
                                    return {
                                        pregunta: document.getElementById('swal-pregunta').value,
                                        cuestionario: document.getElementById('swal-cuestionario').value,
                                        seccion_id: document.getElementById('swal-seccion').value,
                                    }
                                }
                            }).then((result) => {
                                if(result.isConfirmed){
                                    showLoader();
                                    $.ajax({
                                        url: "{{ route('preguntas.store') }}",
                                        type: "POST",
                                        data: result.value,
                                        dataType: "json",
                                        success: function(response){
                                            hideLoader();
                                            Swal.fire({
                                                icon: 'success',
                                                title: '¡Éxito!',
                                                text: response.message,
                                                confirmButtonColor: '#26a69a',
                                                timer: 2000,
                                                timerProgressBar: true
                                            });
                                            reloadTable();
                                        },
                                        error: function(xhr){
                                            hideLoader();
                                            let errorMsg = 'No se pudo crear la pregunta.';
                                            if(xhr.responseJSON && xhr.responseJSON.message) {
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

                            // Activar etiquetas de Materialize dentro de SweetAlert
                            setTimeout(function(){
                                $('input.validate').characterCounter();
                                $('select.browser-default').formSelect();
                                $('label').addClass('active');
                            }, 100);
                        },
                        error: function(){
                            hideLoader();
                            M.toast({html: '<i class="material-icons left">error</i> No se pudieron cargar las secciones', classes: 'red rounded'});
                        }
                    });
                });
                
                //editar pregunta
                $('#preguntasTable').on('click', '.edit-btn', function() {
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
                                title: 'Editar Pregunta',
                                html: `
                                    <style>
                                        .custom-input {
                                            width: 100%;
                                            padding: 0.625em 1em;
                                            font-size: 1rem;
                                            border: 1px solid #d9d9d9;
                                            border-radius: 0.25em;
                                            box-sizing: border-box;
                                            margin-top: 0.25em;
                                            margin-bottom: 1em;
                                        }
                                    </style>
                                    <form id="editForm">
                                        <div class="form-group">
                                            <label for="pregunta">Pregunta:</label>
                                            <input type="text" id="pregunta" class="custom-input" value="${rowData.pregunta}">
                                        </div>
                                        <div class="form-group">
                                            <label for="cuestionario">Cuestionario:</label>
                                            <input type="text" id="cuestionario" class="custom-input" value="${rowData.cuestionario}">
                                        </div>
                                        <div class="form-group">
                                            <label for="swal-seccion">Sección:</label>
                                            <select id="swal-seccion" class="custom-input">
                                                ${options}
                                            </select>
                                        </div>
                                    </form>
                                `,
                                focusConfirm: false,
                                preConfirm: () => {
                                    var pregunta = $('#pregunta').val();
                                    var cuestionario = $('#cuestionario').val();
                                    var seccion_id = $('#swal-seccion').val(); //ID de la sección seleccionada

                                    $.ajax({
                                        url: `/admin/preguntas/${id}`,
                                        type: 'PUT',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: {
                                            pregunta: pregunta,
                                            cuestionario: cuestionario,
                                            seccion_id: seccion_id
                                        },
                                        success: function(response) {
                                            Swal.fire('¡Actualizado!', 'Los datos se han actualizado correctamente.', 'success');
                                            table.ajax.reload();
                                        },
                                        error: function(xhr) {
                                            Swal.fire('Error', 'Hubo un problema al actualizar los datos.', 'error');
                                        }
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
                });



                /*
                $('#preguntasTable').on('click', '.edit-btn', function() {
                    const id = $(this).data('id');  // Obtener el ID de la fila
                    var rowData = table.row($(this).closest('tr')).data();

                    $.ajax({
                        url: "{{ route('secciones.all') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(secciones){

                            let options = '<option value="" disabled>Seleccione una sección</option>';
                            $.each(secciones, function(i, sec){
                                const selected = rowData.seccion && sec.id === rowData.seccion.id ? 'selected' : '';
                                options += `<option value="${sec.id}" ${selected}>${sec.titulo}</option>`;
                            });

                            Swal.fire({
                                title: 'Editar Pregunta',
                                html: `
                                    <style>
                                        .custom-input {
                                            width: 100%;
                                            padding: 0.625em 1em;
                                            font-size: 1rem;
                                            border: 1px solid #d9d9d9;
                                            border-radius: 0.25em;
                                            box-sizing: border-box;
                                            margin-top: 0.25em;
                                            margin-bottom: 1em;
                                        }
                                    </style>
                                    <form id="editForm">
                                        <div class="form-group">
                                            <label for="pregunta">Pregunta:</label>
                                            <input type="text" id="pregunta" class="custom-input" value="${rowData.pregunta}">
                                        </div>
                                        <div class="form-group">
                                            <label for="cuestionario">Cuestionario:</label>
                                            <input type="text" id="cuestionario" class="custom-input" value="${rowData.cuestionario}">
                                        </div>
                                        <div class="form-group">
                                            <label for="swal-seccion">Sección:</label>
                                            <select id="swal-seccion" class="custom-input">
                                                ${options}
                                            </select>
                                        </div>
                                    </form>
                                `,
                                focusConfirm: false,
                                preConfirm: () => {
                                    const pregunta = $('#pregunta').val();
                                    const cuestionario = $('#cuestionario').val();
                                    const seccion_id = $('#swal-seccion').val();

                                    // Enviar la solicitud AJAX para actualizar la pregunta
                                    $.ajax({
                                        url: `/admin/preguntas/${id}`,
                                        type: 'PUT',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        },
                                        data: {
                                            pregunta: pregunta,
                                            cuestionario: cuestionario,
                                            seccion_id: rowData.seccion_id
                                        },
                                        success: function(response) {
                                            Swal.fire('¡Actualizado!', 'Los datos se han actualizado correctamente.', 'success');
                                            table.ajax.reload();
                                        },
                                        error: function(xhr) {
                                            Swal.fire('Error', 'Hubo un problema al actualizar los datos.', 'error');
                                        }
                                    });
                                }
                            });
                        },
                        error: function(xhr){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudieron cargar las secciones.',
                                confirmButtonColor: '#ef5350'
                            });
                        }
                    });
                });*/


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
                    }).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url: `/admin/preguntas/${preguntaId}`,
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
