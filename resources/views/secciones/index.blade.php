@extends('layout.app')
@section('title', 'Gestión de Secciones')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <div class="card-panel gradient-card">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text"><i class="material-icons left">view_list</i>Gestión de Secciones</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createSeccionBtn" class="waves-effect waves-light btn-large pulse">
                                <i class="material-icons left">add_circle</i>Nueva Sección
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
                        <table id="seccionesTable" class="highlight responsive-table centered striped">
                            <thead>
                            <tr>
                                <th><i class="material-icons left tiny">fingerprint</i>ID</th>
                                <th><i class="material-icons left tiny">title</i>Título</th>
                                <th><i class="material-icons left tiny">view_module</i>Bloque</th>
                                <th><i class="material-icons left tiny">assignment</i>Cuestionario</th>
                                <th><i class="material-icons left tiny">access_time</i>Tiempo</th>
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

            var table = $('#seccionesTable').DataTable({
                ajax: {
                    url: "{{ route('secciones.datatable') }}",
                    dataSrc: ''
                },
                columns: [
                    { data: 'id' },
                    { data: 'titulo' },
                    { data: 'bloque' },
                    { data: 'cuestionario' },
                    { data: 'time_at' },
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

            // Crear Sección
            $("#createSeccionBtn").click(function(){
                // Usar SweetAlert2 con estilos de Materialize
                Swal.fire({
                    title: '<i class="material-icons">add_circle_outline</i> Crear Sección',
                    html: `
                        <div class="input-field">
                            <i class="material-icons prefix">title</i>
                            <input id="swal-titulo" type="text" class="validate">
                            <label for="swal-titulo">Título</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">view_module</i>
                            <input id="swal-bloque" type="text" class="validate">
                            <label for="swal-bloque">Bloque</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">assignment</i>
                            <input id="swal-cuestionario" type="text" class="validate">
                            <label for="swal-cuestionario">Cuestionario</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">access_time</i>
                            <input id="swal-time_at" type="text" class="validate" placeholder="HH:MM:SS">
                            <label for="swal-time_at">Tiempo</label>
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
                            titulo: document.getElementById('swal-titulo').value,
                            bloque: document.getElementById('swal-bloque').value,
                            cuestionario: document.getElementById('swal-cuestionario').value,
                            time_at: document.getElementById('swal-time_at').value,
                            _token: '{{ csrf_token() }}'
                        }
                    }
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            url: "{{ route('secciones.store') }}",
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
                                let errorMsg = 'No se pudo crear la sección.';
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
                    $('label').addClass('active');
                }, 100);
            });

            // Editar Sección
            $('#seccionesTable').on('click', '.edit-btn', function(){
                var id = $(this).data('id');
                let row = table.row($(this).parents('tr')).data();

                Swal.fire({
                    title: '<i class="material-icons">edit</i> Editar Sección',
                    html: `
                        <div class="input-field">
                            <i class="material-icons prefix">title</i>
                            <input id="swal-titulo" type="text" class="validate" value="${row.titulo}">
                            <label for="swal-titulo" class="active">Título</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">view_module</i>
                            <input id="swal-bloque" type="text" class="validate" value="${row.bloque}">
                            <label for="swal-bloque" class="active">Bloque</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">assignment</i>
                            <input id="swal-cuestionario" type="text" class="validate" value="${row.cuestionario}">
                            <label for="swal-cuestionario" class="active">Cuestionario</label>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">access_time</i>
                            <input id="swal-time_at" type="text" class="validate" value="${row.time_at}">
                            <label for="swal-time_at" class="active">Tiempo</label>
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
                            titulo: document.getElementById('swal-titulo').value,
                            bloque: document.getElementById('swal-bloque').value,
                            cuestionario: document.getElementById('swal-cuestionario').value,
                            time_at: document.getElementById('swal-time_at').value,
                            _token: '{{ csrf_token() }}'
                        }
                    },
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            url: "/admin/secciones/" + id,
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
                                let errorMsg = 'No se pudo actualizar la sección.';
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
                }, 100);
            });

            // Eliminar Sección
            $('#seccionesTable').on('click', '.delete-btn', function(){
                var id = $(this).data('id');

                Swal.fire({
                    title: '¿Eliminar Sección?',
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
                            url: "/admin/secciones/" + id,
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
                                let errorMsg = 'No se pudo eliminar la sección.';
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
