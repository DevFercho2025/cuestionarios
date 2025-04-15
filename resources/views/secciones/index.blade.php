@extends('layout.admin')
@section('title', 'Gestión de Secciones')
@section('content')
    <div class="container">
        <!-- Header con estilo oscuro -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text"><i class="material-icons left">view_list</i>Gestión de Secciones</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createSeccionBtn" class="btn btn-large gradient-btn pulse">
                                <i class="material-icons left">add</i> Nueva Sección
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla con estilo oscuro -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-content">
                        <table id="seccionesTable" class="highlight responsive-table centered striped dark-table">
                            <thead class="dark-thead">
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

    <!-- Estilos para tema oscuro -->
    <style>
        .dark-thead th {
            color: #ffffff;
            font-weight: 500;
            padding: 15px 10px;
            border-bottom: 1px solid #3d4e81;
        }

        .dark-table tbody tr:nth-child(odd) {
            background-color: #303548 !important;
        }

        .dark-table tbody tr:nth-child(even) {
            background-color: #262b3c !important;
        }

        .dark-table tbody tr:hover {
            background-color: #3d4e81 !important;
        }

        .btn-floating {
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .btn-floating.blue {
            background-color: #3d4e81 !important;
        }

        .btn-floating.blue:hover {
            background-color: #5e6fa1 !important;
        }

        .btn-floating.red {
            background-color: #d32f2f !important;
        }

        .btn-floating.red:hover {
            background-color: #e53935 !important;
        }

        .btn-floating:hover {
            transform: scale(1.15);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: #2e3446 !important;
            color: #ffffff !important;
            border: 1px solid #3d4e81 !important;
            border-radius: 30px !important;
            padding: 0 15px !important;
            margin-bottom: 15px !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #5e6fa1 !important;
            box-shadow: 0 0 8px rgba(94,111,161,0.4);
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #f5f5f5 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #f5f5f5 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #3d4e81 !important;
            color: #ffffff !important;
            border: none !important;
        }

        /* SweetAlert2 estilos para tema oscuro */
        .swal2-popup {
            background-color: #262b3c !important;
            color: #f5f5f5 !important;
            border-radius: 10px !important;
        }

        .swal2-title, .swal2-content {
            color: #f5f5f5 !important;
        }

        .swal2-input, .swal2-select {
            background-color: #2e3446 !important;
            color: #ffffff !important;
            border: 1px solid #3d4e81 !important;
            border-radius: 8px !important;
        }

        .swal2-input:focus, .swal2-select:focus {
            border-color: #5e6fa1 !important;
            box-shadow: 0 0 8px rgba(94,111,161,0.4) !important;
        }

        .input-field input, .input-field textarea {
            color: #ffffff !important;
        }

        .input-field label, .input-field i {
            color: #cfd8dc !important;
        }

        .swal2-loader {
            border-color: #3d4e81 transparent #3d4e81 transparent !important;
        }

        /* Toast mejorados */
        #toast-container {
            top: 20px !important;
            right: 20px !important;
        }

        .toast {
            background-color: #3d4e81 !important;
            border-radius: 8px !important;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2) !important;
        }
    </style>

    <!-- Asegurarnos de cargar jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Verificar si jQuery está cargado, si no, cargar desde CDN
        if (typeof jQuery === 'undefined') {
            document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
        }

        // Asegurarse de que el código se ejecute después de cargar jQuery
        document.addEventListener('DOMContentLoaded', function() {
            // Verificar si jQuery está disponible
            if (typeof jQuery !== 'undefined') {
                initializeApp();
            } else {
                console.error('jQuery no está disponible. Intenta incluirlo manualmente en tu plantilla.');
                alert('Error: jQuery no está cargado correctamente. Por favor, contacta al administrador.');
            }
        });

        function initializeApp() {
            // Configuración global de AJAX para enviar el token CSRF en todas las solicitudes
            jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            // Inicializar componentes de Materialize
            if (typeof M !== 'undefined') {
                M.Modal.init(document.querySelectorAll('.modal'));
                M.FormSelect.init(document.querySelectorAll('select'));
                M.Tooltip.init(document.querySelectorAll('.tooltipped'));
            }

            // Verificar si DataTable está disponible
            if (typeof jQuery.fn.DataTable === 'undefined') {
                console.error('DataTables no está disponible. Asegúrate de que esté cargado correctamente.');

                // Intentar cargar DataTables dinámicamente
                var dtCss = document.createElement('link');
                dtCss.rel = 'stylesheet';
                dtCss.href = 'https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css';
                document.head.appendChild(dtCss);

                var dtScript = document.createElement('script');
                dtScript.src = 'https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js';
                dtScript.onload = function() {
                    initializeDataTable();
                };
                document.body.appendChild(dtScript);
            } else {
                initializeDataTable();
            }
        }

        function initializeDataTable() {
            try {
                var table = jQuery('#seccionesTable').DataTable({
                    ajax: {
                        url: "{{ route('secciones.datatable') }}",
                        dataSrc: '',
                        error: function(xhr, error, thrown) {
                            console.error('Error en la carga de datos:', error, thrown);
                            if (typeof M !== 'undefined') {
                                M.toast({html: '<i class="material-icons left">error</i> Error al cargar los datos', classes: 'rounded red'});
                            } else {
                                alert('Error al cargar los datos de la tabla');
                            }
                        }
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
        <a class="btn-floating btn-small gradient-btn edit-btn tooltipped pulse" data-position="top" data-tooltip="Editar" data-id="${row.id}">
            <i class="material-icons">edit</i>
        </a>
        <a class="btn-floating btn-small red darken-2 delete-btn tooltipped pulse" data-position="top" data-tooltip="Eliminar" data-id="${row.id}">
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
                        if (typeof M !== 'undefined') {
                            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
                        }
                    },
                    initComplete: function() {
                        console.log('DataTable inicializada completamente');
                    }
                });

                // Función para recargar la tabla
                function reloadTable() {
                    table.ajax.reload(function() {
                        if (typeof M !== 'undefined') {
                            M.toast({html: '<i class="material-icons left">refresh</i> Tabla actualizada', classes: 'rounded'});
                        }
                    }, false);
                }

                // Verificar si SweetAlert2 está disponible
                if (typeof Swal === 'undefined') {
                    console.error('SweetAlert2 no está disponible. Asegúrate de que esté cargado correctamente.');

                    // Intentar cargar SweetAlert2 dinámicamente
                    var swalScript = document.createElement('script');
                    swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    document.body.appendChild(swalScript);
                }

                // Crear Sección
                jQuery("#createSeccionBtn").click(function() {
                    if (typeof Swal === 'undefined') {
                        alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                        return;
                    }

                    Swal.fire({
                        title: 'Crear Sección',
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
                        confirmButtonColor: '#3d4e81',
                        cancelButtonText: '<i class="material-icons left">close</i> Cancelar',
                        cancelButtonColor: '#d32f2f',
                        showCancelButton: true,
                        buttonsStyling: true,
                        background: '#262b3c',
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
                        if (result.isConfirmed) {
                            jQuery.ajax({
                                url: "{{ route('secciones.store') }}",
                                type: "POST",
                                data: result.value,
                                dataType: "json",
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Éxito!',
                                        text: response.message,
                                        confirmButtonColor: '#3d4e81',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        background: '#262b3c',
                                    });
                                    reloadTable();
                                },
                                error: function(xhr) {
                                    let errorMsg = 'No se pudo crear la sección.';
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

                    // Activar etiquetas de Materialize dentro de SweetAlert
                    setTimeout(function() {
                        if (jQuery('input.validate').length && typeof M !== 'undefined') {
                            M.CharacterCounter.init(document.querySelectorAll('input.validate'));
                            document.querySelectorAll('label').forEach(function(label) {
                                label.classList.add('active');
                            });
                        }
                    }, 100);
                });

                // Editar Sección
                jQuery('#seccionesTable').on('click', '.edit-btn', function() {
                    if (typeof Swal === 'undefined') {
                        alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                        return;
                    }

                    var id = jQuery(this).data('id');
                    let row = table.row(jQuery(this).parents('tr')).data();

                    Swal.fire({
                        title: '<i class="material-icons" style="vertical-align: middle; margin-right: 10px; color: #5e6fa1;">edit</i> Editar Sección',
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
                        confirmButtonColor: '#3d4e81',
                        cancelButtonText: '<i class="material-icons left">close</i> Cancelar',
                        cancelButtonColor: '#d32f2f',
                        showCancelButton: true,
                        background: '#262b3c',
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
                        if (result.isConfirmed) {
                            jQuery.ajax({
                                url: "/admin/secciones/" + id,
                                type: "PUT",
                                data: result.value,
                                dataType: "json",
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Actualizado!',
                                        text: response.message,
                                        confirmButtonColor: '#3d4e81',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        background: '#262b3c',
                                    });
                                    reloadTable();
                                },
                                error: function(xhr) {
                                    let errorMsg = 'No se pudo actualizar la sección.';
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

                    // Activar etiquetas de Materialize dentro de SweetAlert
                    setTimeout(function() {
                        if (jQuery('input.validate').length && typeof M !== 'undefined') {
                            M.CharacterCounter.init(document.querySelectorAll('input.validate'));
                        }
                    }, 100);
                });

                // Eliminar Sección
                jQuery('#seccionesTable').on('click', '.delete-btn', function() {
                    if (typeof Swal === 'undefined') {
                        alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                        return;
                    }

                    var id = jQuery(this).data('id');

                    Swal.fire({
                        title: '¿Eliminar Sección?',
                        text: "Esta acción no se puede deshacer",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d32f2f',
                        cancelButtonColor: '#4b5563',
                        confirmButtonText: '<i class="material-icons left">delete</i> Sí, eliminar',
                        cancelButtonText: '<i class="material-icons left">cancel</i> Cancelar',
                        background: '#262b3c',
                        showClass: {
                            popup: 'animate__animated animate__fadeIn'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            jQuery.ajax({
                                url: "/admin/secciones/" + id,
                                type: "DELETE",
                                data: { _token: '{{ csrf_token() }}' },
                                dataType: "json",
                                success: function(response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Eliminada!',
                                        text: response.message,
                                        confirmButtonColor: '#3d4e81',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        background: '#262b3c',
                                    });
                                    reloadTable();
                                },
                                error: function(xhr) {
                                    let errorMsg = 'No se pudo eliminar la sección.';
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
                });

                // Inicializar tooltips
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
