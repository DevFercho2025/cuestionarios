@extends('layout.admin')
@section('title', 'Gestión de Respuestas')
@section('content')
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
                            <a id="createRespuestaBtn" class="btn btn-large gradient-btn pulse">
                               Nueva Respuesta
                            </a>
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
                                <th>ID</th>
                                <th>Respuesta</th>
                                <th>Opción</th>
                                <th>Pregunta</th>
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
                        { data: 'respuesta_id' },
                        { data: 'respuesta' },
                        { data: 'opcion' },
                        {
                            data: 'pregunta.pregunta',
                            defaultContent: '<span class="grey-text">Sin Pregunta</span>'
                        },
                        {
                            data: null,
                            render: function (data, type, row) {
                                return `
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-info waves-effect waves-light edit-btn tooltipped"
                                                    data-position="top" data-tooltip="Editar" data-id="${row.respuesta_id}">
                                                <i class="ri-pencil-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger waves-effect waves-light delete-btn tooltipped"
                                                    data-position="top" data-tooltip="Eliminar" data-id="${row.respuesta_id}">
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

                $("#createRespuestaBtn").click(function() {
                    // Para crear una respuesta, se requiere seleccionar la pregunta.
                    $.ajax({
                        url: "{{ route('preguntas.datatable') }}",
                        type: "GET",
                        dataType: "json",
                        success: function(preguntas) {
                            let options = '<option value="" disabled selected>Seleccione una pregunta</option>';
                            $.each(preguntas, function(i, pregunta) {
                                options += `<option value="${pregunta.pregunta_id}">${pregunta.pregunta}</option>`;
                            });

                            Swal.fire({
                                html: `
                                    <div class="col-md mb-6 mb-md-0">
                                        <div class="card">
                                            <h2 class="card-header">Crear Respuesta</h2>
                                            <div class="card-body">
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input id="swal-respuesta" type="text" class="form-control" placeholder="Respuesta" required="">
                                                    <label for="swal-respuesta">Respuesta</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input type="text" id="swal-opcion" class="form-control" placeholder="Opción" required="">
                                                    <label for="swal-opcion">Opción</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <select id="swal-pregunta" class="form-select">
                                                        ${options}
                                                    </select>
                                                    <label for="swal-pregunta">Pregunta</label>
                                                </div>
                                            </div>
                                        </div>
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
                                        respuesta: document.getElementById('swal-respuesta').value,
                                        opcion: document.getElementById('swal-opcion').value,
                                        pregunta_id: document.getElementById('swal-pregunta').value,
                                        _token: '{{ csrf_token() }}'
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
                                                text: response.message,
                                                confirmButtonColor: '#26a69a',
                                                timer: 2000,
                                                timerProgressBar: true
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
                                                confirmButtonColor: '#ef5350'
                                            });
                                        }
                                    });
                                }
                            });

                            // Activar etiquetas de Materialize dentro de SweetAlert
                            setTimeout(function() {
                                $('input.validate').characterCounter();
                                $('select.browser-default').formSelect();
                                $('label').addClass('active');
                            }, 100);
                        },
                        error: function() {
                            M.toast({ html: '<i class="material-icons left">error</i> No se pudieron cargar las preguntas', classes: 'red rounded' });
                        }
                    });
                });


                //editar respuesta
                $('#respuestasTable').on('click', '.edit-btn', function(){
                    var id = $(this).data('id');
                    $.ajax({
                        url: `/admin/respuestas/${id}`,
                        type: "GET",
                        dataType: "json",
                        success: function(respuesta){
                            // Cargar las preguntas para el select
                            $.ajax({
                                url: "{{ route('preguntas.datatable') }}",
                                type: "GET",
                                dataType: "json",
                                success: function(preguntas){
                                    let options = '<option value="" disabled selected>Seleccione una pregunta</option>';
                                    $.each(preguntas, function(i, pregunta){
                                        let selected = pregunta.pregunta_id == respuesta.pregunta_id ? 'selected' : '';
                                        options += `<option value="${pregunta.pregunta_id}" ${selected}>${pregunta.pregunta}</option>`;
                                    });

                                    Swal.fire({
                                        title: 'Editar Respuesta',
                                        html: `
                                            <div class="col-md mb-6 mb-md-0">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="form-floating form-floating-outline mb-6">
                                                        <input id="swal-respuesta" type="text" class="form-control" placeholder="Respuesta" value="${respuesta.respuesta}" required="">
                                                        <label for="swal-respuesta">Respuesta</label>
                                                    </div>
                                                    <div class="form-floating form-floating-outline mb-6">
                                                        <input id="swal-opcion" type="text" class="form-control" placeholder="Opción" value="${respuesta.opcion}" required="">
                                                        <label for="swal-opcion">Opción</label>
                                                    </div>
                                                    <div class="form-floating form-floating-outline mb-6">
                                                        <select id="swal-pregunta" class="form-select">
                                                            ${options}
                                                        </select>
                                                        <label for="swal-pregunta">Pregunta</label>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        `,
                                        showClass: {
                                            popup: 'animate__animated animate__fadeInDown'
                                        },
                                        hideClass: {
                                            popup: 'animate__animated animate__fadeOutUp'
                                        },
                                        focusConfirm: false,
                                        confirmButtonText: 'Actualizar',
                                        confirmButtonColor: '#3d4e81',
                                        cancelButtonText: 'Cancelar',
                                        cancelButtonColor: '#d32f2f',
                                        showCancelButton: true,
                                        preConfirm: () => {
                                            return {
                                                respuesta: document.getElementById('swal-respuesta').value,
                                                opcion: document.getElementById('swal-opcion').value,
                                                pregunta_id: document.getElementById('swal-pregunta').value,
                                                _token: '{{ csrf_token() }}'
                                            }
                                        },
                                    }).then((result) => {
                                        if(result.isConfirmed){
                                            $.ajax({
                                                url: "/admin/respuestas/" + id,
                                                type: "PUT",
                                                data: result.value,
                                                dataType: "json",
                                                success: function(response){
                                                    Swal.fire({
                                                        icon: 'success',
                                                        title: '¡Actualizado!',
                                                        text: response.message,
                                                        confirmButtonColor: '#26a69a',
                                                        timer: 2000,
                                                        timerProgressBar: true
                                                    });
                                                    reloadTable();
                                                },
                                                error: function(xhr){
                                                    let errorMsg = 'No se pudo actualizar la respuesta.';
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
                                        $('input.form-control').characterCounter();
                                        $('select.form-select').formSelect();
                                    }, 100);
                                },
                                error: function(){
                                    M.toast({html: '<i class="material-icons left">error</i> No se pudieron cargar las preguntas', classes: 'red rounded'});
                                }
                            });
                        },
                        error: function(){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudieron obtener los datos de la respuesta.',
                                confirmButtonColor: '#ef5350'
                            });
                        }
                    });
                });


                // Eliminar Respuesta
                $('#respuestasTable').on('click', '.delete-btn', function(){
                    var id = $(this).data('id');

                    Swal.fire({
                        title: '¿Eliminar Respuesta?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f44336',
                        cancelButtonColor: '#9e9e9e',
                        confirmButtonText: '<i class="material-icons left">delete</i> Sí, eliminar',
                        cancelButtonText: '<i class="material-icons left">cancel</i> Cancelar',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut'
                        }
                    }).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url: "/admin/respuestas/" + id,
                                type: "DELETE",
                                data: { _token: '{{ csrf_token() }}' },
                                dataType: "json",
                                success: function(response){
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Eliminada!',
                                        text: response.message,
                                        confirmButtonColor: '#26a69a',
                                        timer: 2000,
                                        timerProgressBar: true
                                    });
                                    reloadTable();
                                },
                                error: function(xhr){
                                    let errorMsg = 'No se pudo eliminar la respuesta.';
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
                });

                // Eliminar Respuesta
                $('#respuestasTable').on('click', '.delete-btn', function(){
                    var id = $(this).data('id');

                    Swal.fire({
                        title: '¿Eliminar Respuesta?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#f44336',
                        cancelButtonColor: '#9e9e9e',
                        confirmButtonText: '<i class="material-icons left">delete</i> Sí, eliminar',
                        cancelButtonText: '<i class="material-icons left">cancel</i> Cancelar',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut'
                        }
                    }).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url: "/admin/respuestas/" + id,
                                type: "DELETE",
                                data: { _token: '{{ csrf_token() }}' },
                                dataType: "json",
                                success: function(response){
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Eliminada!',
                                        text: response.message,
                                        confirmButtonColor: '#26a69a',
                                        timer: 2000,
                                        timerProgressBar: true
                                    });
                                    reloadTable();
                                },
                                error: function(xhr){
                                    let errorMsg = 'No se pudo eliminar la respuesta.';
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
