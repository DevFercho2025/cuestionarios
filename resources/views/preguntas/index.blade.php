@extends('layout.admin')
@section('title', 'Gestión de Preguntas')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel gradient-card">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text"><i class="material-icons left">question_answer</i>Gestión de Preguntas</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createPreguntaBtn" class="waves-effect waves-light btn-large pulse">
                                <i class="material-icons left">add_circle</i>Nueva Pregunta
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
                        <table id="preguntasTable" class="highlight responsive-table centered striped">
                            <thead>
                            <tr>
                                <th><i class="material-icons left tiny">fingerprint</i>ID</th>
                                <th><i class="material-icons left tiny">help</i>Pregunta</th>
                                <th><i class="material-icons left tiny">assignment</i>Cuestionario</th>
                                <th><i class="material-icons left tiny">category</i>Sección</th>
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

            var table = $('#preguntasTable').DataTable({
                ajax: {
                    url: "{{ route('preguntas.datatable') }}",
                    dataSrc: '',
                    beforeSend: function() {
                        showLoader();
                    },
                    complete: function() {
                        hideLoader();
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
                                    <a class="btn-floating btn-small waves-effect waves-light blue edit-btn btn-action tooltipped" data-position="top" data-tooltip="Editar" data-id="${row.pregunta_id}">
                                        <i class="material-icons">edit</i>
                                    </a>
                                    <a class="btn-floating btn-small waves-effect waves-light red delete-btn btn-action tooltipped" data-position="top" data-tooltip="Eliminar" data-id="${row.pregunta_id}">
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
                showLoader();
                table.ajax.reload(function() {
                    hideLoader();
                    M.toast({html: '<i class="material-icons left">refresh</i> Tabla actualizada', classes: 'rounded'});
                }, false);
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

            // Editar Pregunta
            $('#preguntasTable').on('click', '.edit-btn', function(){
                var id = $(this).data('id');
                showLoader();
                // Obtener datos de la pregunta
                $.ajax({
                    url: "/admin/preguntas/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(pregunta){
                        // Cargar secciones
                        $.ajax({
                            url: "{{ route('secciones.all') }}",
                            type: "GET",
                            dataType: "json",
                            success: function(secciones){
                                hideLoader();
                                let options = '';
                                $.each(secciones, function(i, sec){
                                    options += `<option value="${sec.id}" ${sec.id == pregunta.seccion_id ? 'selected' : ''}>${sec.titulo}</option>`;
                                });

                                Swal.fire({
                                    title: '<i class="material-icons">edit</i> Editar Pregunta',
                                    html: `
                                        <div class="input-field">
                                            <i class="material-icons prefix">help</i>
                                            <input id="swal-pregunta" type="text" class="validate" value="${pregunta.pregunta}">
                                            <label for="swal-pregunta" class="active">Pregunta</label>
                                        </div>
                                        <div class="input-field">
                                            <i class="material-icons prefix">assignment</i>
                                            <input id="swal-cuestionario" type="text" class="validate" value="${pregunta.cuestionario}">
                                            <label for="swal-cuestionario" class="active">Cuestionario</label>
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
                                    confirmButtonText: '<i class="material-icons left">save</i> Actualizar',
                                    confirmButtonColor: '#26a69a',
                                    cancelButtonText: '<i class="material-icons left">close</i> Cancelar',
                                    cancelButtonColor: '#ef5350',
                                    showCancelButton: true,
                                    preConfirm: () => {
                                        return {
                                            pregunta: document.getElementById('swal-pregunta').value,
                                            cuestionario: document.getElementById('swal-cuestionario').value,
                                            seccion_id: document.getElementById('swal-seccion').value,
                                        }
                                    },
                                }).then((result) => {
                                    if(result.isConfirmed){
                                        showLoader();
                                        $.ajax({
                                            url: "/preguntas/" + id,
                                            type: "PUT",
                                            data: result.value,
                                            dataType: "json",
                                            success: function(response){
                                                hideLoader();
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
                                                hideLoader();
                                                let errorMsg = 'No se pudo actualizar la pregunta.';
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
                                hideLoader();
                                M.toast({html: '<i class="material-icons left">error</i> No se pudieron cargar las secciones', classes: 'red rounded'});
                            }
                        });
                    },
                    error: function(){
                        hideLoader();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo obtener los datos de la pregunta.',
                            confirmButtonColor: '#ef5350'
                        });
                    }
                });
            });

            // Eliminar Pregunta
            $('#preguntasTable').on('click', '.delete-btn', function(){
                var id = $(this).data('id');

                Swal.fire({
                    title: '¿Eliminar Pregunta?',
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
                        showLoader();
                        $.ajax({
                            url: "/preguntas/" + id,
                            type: "DELETE",
                            data: { _token: '{{ csrf_token() }}' },
                            dataType: "json",
                            success: function(response){
                                hideLoader();
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
                                hideLoader();
                                let errorMsg = 'No se pudo eliminar la pregunta.';
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
