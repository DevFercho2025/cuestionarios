@extends('layout.app')
@section('title', 'Gestión de Respuestas Correctas')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel gradient-card">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text"><i class="material-icons left">check_circle</i>Gestión de Respuestas Correctas</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createRCBtn" class="waves-effect waves-light btn-large pulse">
                                <i class="material-icons left">add_circle</i>Nueva Relación
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
                        <table id="rcTable" class="highlight responsive-table centered striped">
                            <thead>
                            <tr>
                                <th><i class="material-icons left tiny">fingerprint</i>ID</th>
                                <th><i class="material-icons left tiny">help</i>Pregunta</th>
                                <th><i class="material-icons left tiny">verified</i>Respuesta Correcta</th>
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

            var table = $('#rcTable').DataTable({
                ajax: {
                    url: "{{ route('respuestas_correctas.datatable') }}",
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    {
                        data: 'pregunta.pregunta',
                        defaultContent: '<span class="grey-text">Sin Pregunta</span>'
                    },
                    {
                        data: 'respuesta.respuesta',
                        defaultContent: '<span class="grey-text">Sin Respuesta</span>'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <a class="btn-floating btn-small waves-effect waves-light blue edit-btn btn-action tooltipped" data-position="top" data-tooltip="Editar" data-id="${row.id}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <a class="btn-floating btn-small waves-effect waves-light red delete-btn btn-action tooltipped" data-position="top" data-tooltip="Eliminar" data-id="${row.id}">
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

            // Crear Relación Respuesta Correcta
            $("#createRCBtn").click(function(){
                // Añadir meta CSRF para todas las solicitudes AJAX
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Se requiere cargar preguntas y respuestas para crear la relación
                $.when(
                    $.ajax({ url: "{{ route('preguntas.datatable') }}", type: "GET", dataType: "json" }),
                    $.ajax({ url: "{{ route('respuestas.datatable') }}", type: "GET", dataType: "json" })
                ).done(function(preguntasData, respuestasData) {
                    let preguntas = preguntasData[0];
                    let respuestas = respuestasData[0];
                    let opcionesPreguntas = '<option value="" disabled selected>Seleccione una pregunta</option>';
                    let opcionesRespuestas = '<option value="" disabled selected>Seleccione la respuesta correcta</option>';

                    $.each(preguntas, function(i, p){
                        opcionesPreguntas += `<option value="${p.pregunta_id}">${p.pregunta}</option>`;
                    });
                    $.each(respuestas, function(i, r){
                        opcionesRespuestas += `<option value="${r.respuesta_id}">${r.respuesta} (Opción: ${r.opcion})</option>`;
                    });

                    Swal.fire({
                        title: '<i class="material-icons">add_circle_outline</i> Crear Relación',
                        html: `
                            <div class="input-field">
                                <i class="material-icons prefix">help</i>
                                <select id="swal-pregunta" class="browser-default">${opcionesPreguntas}</select>
                            </div>
                            <div class="input-field" style="margin-top: 20px;">
                                <i class="material-icons prefix">verified</i>
                                <select id="swal-respuesta" class="browser-default">${opcionesRespuestas}</select>
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
                                pregunta_id: document.getElementById('swal-pregunta').value,
                                respuestas_id: document.getElementById('swal-respuesta').value,
                            }
                        }
                    }).then((result) => {
                        if(result.isConfirmed){
                            $.ajax({
                                url: "{{ route('respuestas_correctas.store') }}",
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
                                    let errorMsg = 'No se pudo crear la relación.';
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

                    // Activar componentes de Materialize dentro de SweetAlert
                    setTimeout(function(){
                        $('select.browser-default').formSelect();
                    }, 100);
                });
            });

            // Editar Relación Respuesta Correcta
            $('#rcTable').on('click', '.edit-btn', function(){
                var id = $(this).data('id');
                $.ajax({
                    url: "/admin/respuestas_correctas/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(relacion){
                        // Cargar preguntas y respuestas
                        $.when(
                            $.ajax({ url: "{{ route('preguntas.datatable') }}", type: "GET", dataType: "json" }),
                            $.ajax({ url: "{{ route('respuestas.datatable') }}", type: "GET", dataType: "json" })
                        ).done(function(preguntasData, respuestasData){
                            let preguntas = preguntasData[0];
                            let respuestas = respuestasData[0];
                            let opcionesPreguntas = '';
                            let opcionesRespuestas = '';

                            $.each(preguntas, function(i, p){
                                let selected = p.pregunta_id == relacion.pregunta_id ? 'selected' : '';
                                opcionesPreguntas += `<option value="${p.pregunta_id}" ${selected}>${p.pregunta}</option>`;
                            });
                            $.each(respuestas, function(i, r){
                                let selected = r.respuesta_id == relacion.respuestas_id ? 'selected' : '';
                                opcionesRespuestas += `<option value="${r.respuesta_id}" ${selected}>${r.respuesta} (Opción: ${r.opcion})</option>`;
                            });

                            Swal.fire({
                                title: '<i class="material-icons">edit</i> Editar Relación',
                                html: `
                                    <div class="input-field">
                                        <i class="material-icons prefix">help</i>
                                        <select id="swal-pregunta" class="browser-default">${opcionesPreguntas}</select>
                                    </div>
                                    <div class="input-field" style="margin-top: 20px;">
                                        <i class="material-icons prefix">verified</i>
                                        <select id="swal-respuesta" class="browser-default">${opcionesRespuestas}</select>
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
                                        pregunta_id: document.getElementById('swal-pregunta').value,
                                        respuestas_id: document.getElementById('swal-respuesta').value,
                                    }
                                },
                            }).then((result) => {
                                if(result.isConfirmed){
                                    $.ajax({
                                        url: "/admin/respuestas_correctas/" + id,
                                        type: "PUT",
                                        data: {
                                            ...result.value,
                                            _token: '{{ csrf_token() }}'
                                        },
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
                                            let errorMsg = 'No se pudo actualizar la relación.';
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

                            // Activar componentes de Materialize dentro de SweetAlert
                            setTimeout(function(){
                                $('select.browser-default').formSelect();
                            }, 100);
                        });
                    },
                    error: function(){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo obtener los datos de la relación.',
                            confirmButtonColor: '#ef5350'
                        });
                    }
                });
            });

            // Eliminar Relación Respuesta Correcta
            $('#rcTable').on('click', '.delete-btn', function(){
                var id = $(this).data('id');

                Swal.fire({
                    title: '¿Eliminar Relación?',
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
                            url: "/admin/respuestas_correctas/" + id,
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
                                let errorMsg = 'No se pudo eliminar la relación.';
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
