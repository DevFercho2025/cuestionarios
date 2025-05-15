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

                jQuery("#crearPreguntaBtn").click(function () {
                    if (typeof Swal === 'undefined') {
                        alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                        return;
                    }

                    // Primero cargamos las secciones antes de mostrar el formulario
                    $.ajax({
                        url: "{{ route('secciones.all') }}",
                        type: "GET",
                        dataType: "json",
                        success: function (secciones) {
                            let options = '<option value="" disabled selected>Seleccione una sección</option>';
                            $.each(secciones, function (i, sec) {
                                options += `<option value="${sec.id}">${sec.titulo}</option>`;
                            });

                            Swal.fire({
                                html: `
                                <div class="col-md mb-6 mb-md-0">
                                <div class="card">
                                    <h2 class="card-header">Crear Pregunta</h2>
                                    <div class="card-body">
                                        <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-pregunta" type="text" class="form-control" placeholder="Pregunta" required="">
                                        <label for="swal-pregunta">Pregunta</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-6">
                                        <input type="text" id="swal-cuestionario" class="form-control" placeholder="Cuestionario" required="">
                                        <label for="swal-cuestionario">Cuestionario</label>
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
                                    return {
                                        pregunta: document.getElementById('swal-pregunta').value,
                                        cuestionario: document.getElementById('swal-cuestionario').value,
                                        seccion_id: document.getElementById('swal-seccion').value,
                                        _token: '{{ csrf_token() }}'
                                    };
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    jQuery.ajax({
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

                                            // Recargar tabla
                                            jQuery('#preguntasTable').DataTable().ajax.reload(null, false);
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
                        },
                        error: function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudieron cargar las secciones.',
                                confirmButtonColor: '#d32f2f',
                            });
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
