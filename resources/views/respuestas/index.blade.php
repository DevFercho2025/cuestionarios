@extends('layout.app')
@section('title', 'Gestión de Respuestas')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel gradient-card">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text"><i class="material-icons left">question_answer</i>Gestión de Respuestas</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createRespuestaBtn" class="waves-effect waves-light btn-large pulse">
                                <i class="material-icons left">add_circle</i>Nueva Respuesta
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div class="card z-depth-3">
                    <div class="card-content">
                        <table id="respuestasTable" class="highlight responsive-table centered striped">
                            <thead>
                            <tr>
                                <th><i class="material-icons left tiny">fingerprint</i>ID</th>
                                <th><i class="material-icons left tiny">comment</i>Respuesta</th>
                                <th><i class="material-icons left tiny">label</i>Opción</th>
                                <th><i class="material-icons left tiny">help</i>Pregunta</th>
                                <th><i class="material-icons left tiny">settings</i>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            <!-- Se llenará vía AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .gradient-card {
            background: linear-gradient(to right, #1976d2, #64b5f6);
            border-radius: 8px;
            margin-top: 20px;
        }

        .btn-floating {
            margin: 0 5px;
        }

        .card {
            border-radius: 8px;
            margin-top: 10px;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ccc !important;
            border-radius: 4px !important;
            padding: 0 10px !important;
            margin-bottom: 10px !important;
        }

        .swal2-popup {
            border-radius: 10px !important;
        }

        .swal2-input, .swal2-select {
            border-radius: 4px !important;
            border: 1px solid #ccc !important;
            margin: 10px 0 !important;
            width: 100% !important;
        }

        .btn-action {
            transition: all 0.3s ease;
        }

        .btn-action:hover {
            transform: scale(1.1);
        }
    </style>

    <script>
        $(document).ready(function(){
            // Configuración global de AJAX para enviar el token CSRF en todas las solicitudes
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Inicializar componentes de Materialize
            $('.modal').modal();
            $('select').formSelect();

            // Funciones de loader eliminadas
            function showLoader() {
                // Función vacía para mantener compatibilidad
            }

            function hideLoader() {
                // Función vacía para mantener compatibilidad
            }

            var table = $('#respuestasTable').DataTable({
                ajax: {
                    url: "{{ route('respuestas.datatable') }}",
                    dataSrc: ''
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
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <a class="btn-floating btn-small waves-effect waves-light blue edit-btn btn-action tooltipped" data-position="top" data-tooltip="Editar" data-id="${row.respuesta_id}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <a class="btn-floating btn-small waves-effect waves-light red delete-btn btn-action tooltipped" data-position="top" data-tooltip="Eliminar" data-id="${row.respuesta_id}">
                                        <i class="material-icons">delete</i>
                                    </a>
                                </div>
                            `;
                        }
                    }
                ],
                responsive: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                drawCallback: function() {
                    // Reinicializar tooltips después de cada redibujado
                    $('.tooltipped').tooltip();
                }
            });

            function reloadTable() {
                table.ajax.reload(function() {
                    M.toast({html: '<i class="material-icons left">refresh</i> Tabla actualizada', classes: 'rounded'});
                }, false);
            }

            // Crear Respuesta
            $("#createRespuestaBtn").click(function(){
                // Para crear una respuesta, se requiere seleccionar la pregunta.
                $.ajax({
                    url: "{{ route('preguntas.datatable') }}",
                    type: "GET",
                    dataType: "json",
                    success: function(preguntas){
                        let options = '<option value="" disabled selected>Seleccione una pregunta</option>';
                        $.each(preguntas, function(i, pregunta){
                            options += `<option value="${pregunta.pregunta_id}">${pregunta.pregunta}</option>`;
                        });

                        Swal.fire({
                            title: '<i class="material-icons">add_circle_outline</i> Crear Respuesta',
                            html: `
                                <div class="input-field">
                                    <i class="material-icons prefix">comment</i>
                                    <input id="swal-respuesta" type="text" class="validate">
                                    <label for="swal-respuesta">Respuesta</label>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">label</i>
                                    <input id="swal-opcion" type="text" class="validate" placeholder="A, B, C...">
                                    <label for="swal-opcion">Opción</label>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">help</i>
                                    <select id="swal-pregunta" class="browser-default">${options}</select>
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
                                }
                            }
                        }).then((result) => {
                            if(result.isConfirmed){
                                $.ajax({
                                    url: "{{ route('respuestas.store') }}",
                                    type: "POST",
                                    data: result.value,
                                    dataType: "json",
                                    success: function(response){
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
                                        let errorMsg = 'No se pudo crear la respuesta.';
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
                        M.toast({html: '<i class="material-icons left">error</i> No se pudieron cargar las preguntas', classes: 'red rounded'});
                    }
                });
            });

            // Editar Respuesta
            $('#respuestasTable').on('click', '.edit-btn', function(){
                var id = $(this).data('id');
                $.ajax({
                    url: "/admin/respuestas/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(respuesta){
                        // Cargar las preguntas para el select
                        $.ajax({
                            url: "{{ route('preguntas.datatable') }}",
                            type: "GET",
                            dataType: "json",
                            success: function(preguntas){
                                let options = '';
                                $.each(preguntas, function(i, pregunta){
                                    let selected = pregunta.pregunta_id == respuesta.pregunta_id ? 'selected' : '';
                                    options += `<option value="${pregunta.pregunta_id}" ${selected}>${pregunta.pregunta}</option>`;
                                });

                                Swal.fire({
                                    title: '<i class="material-icons">edit</i> Editar Respuesta',
                                    html: `
                                        <div class="input-field">
                                            <i class="material-icons prefix">comment</i>
                                            <input id="swal-respuesta" type="text" class="validate" value="${respuesta.respuesta}">
                                            <label for="swal-respuesta" class="active">Respuesta</label>
                                        </div>
                                        <div class="input-field">
                                            <i class="material-icons prefix">label</i>
                                            <input id="swal-opcion" type="text" class="validate" value="${respuesta.opcion}">
                                            <label for="swal-opcion" class="active">Opción</label>
                                        </div>
                                        <div class="input-field">
                                            <i class="material-icons prefix">help</i>
                                            <select id="swal-pregunta" class="browser-default">${options}</select>
                                        </div>
                                    `,
                                    showClass: {
                                        popup: 'animate__animated animate__fadeInDown'
                                    },
                                    hideClass: {
                                        popup: 'animate__animated animate__fadeOutUp'
                                    },
                                    focusConfirm: false,
                                    confirmButtonText: '<i class="material-icons left">save</i> Actualizar',
                                    confirmButtonColor: '#26a69a',
                                    cancelButtonText: '<i class="material-icons left">close</i> Cancelar',
                                    cancelButtonColor: '#ef5350',
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
                                    $('input.validate').characterCounter();
                                    $('select.browser-default').formSelect();
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

            // Inicializar tooltips
            $('.tooltipped').tooltip();
        });
    </script>
@endsection
