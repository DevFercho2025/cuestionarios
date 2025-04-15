@extends('layout.admin')
@section('title', 'Gestión de Secciones')
@section('content')
    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Gestión de Secciones</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createSeccionBtn" class="btn btn-large gradient-btn pulse">
                               Nueva Sección
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Secciones -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-content">
                        <table id="seccionesTable" class="responsive-table centered">
                            <thead class="dark-thead">
                            <tr>
                                <th>Título</th>
                                <th>Bloque</th>
                                <th>Cuestionario</th>
                                <th>Tiempo</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
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
            var table = jQuery('#seccionesTable').DataTable({
                ajax: {
                    url: "{{ route('secciones.datatable') }}",
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
                    {data: 'titulo'},
                    {data: 'bloque'},
                    {data: 'cuestionario'},
                    {data: 'time_at'},
                    {
                        data: null,
                        render: function (data, type, row) {
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

            // Crear Sección
            jQuery("#createSeccionBtn").click(function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }
                Swal.fire({
                    title: 'Crear Sección',
                    html: `
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">title</i>
                        <input id="swal-titulo" type="text" class="validate">
                        <label for="swal-titulo">Título</label>
                    </div>
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">view_module</i>
                        <input id="swal-bloque" type="text" class="validate">
                        <label for="swal-bloque">Bloque</label>
                    </div>
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">assignment</i>
                        <input id="swal-cuestionario" type="text" class="validate">
                        <label for="swal-cuestionario">Cuestionario</label>
                    </div>
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">access_time</i>
                        <input id="swal-time_at" type="text" class="validate" placeholder="HH:MM:SS">
                        <label for="swal-time_at">Tiempo</label>
                    </div>
                `,
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' },
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
                            success: function (response) {
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
                            error: function (xhr) {
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

                // Inicializar componentes Materialize dentro de SweetAlert
                setTimeout(function () {
                    if (jQuery('input.validate').length && typeof M !== 'undefined') {
                        M.CharacterCounter.init(document.querySelectorAll('input.validate'));
                        document.querySelectorAll('label').forEach(function (label) {
                            label.classList.add('active');
                        });
                    }
                }, 100);
            });

            // Editar Sección
            jQuery('#seccionesTable').on('click', '.edit-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }
                var id = jQuery(this).data('id');
                let row = table.row(jQuery(this).parents('tr')).data();

                Swal.fire({
                    title: '<i class="material-icons" style="vertical-align: middle; margin-right: 10px; color: #5e6fa1;">edit</i> Editar Sección',
                    html: `
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">title</i>
                        <input id="swal-titulo" type="text" class="validate" value="${row.titulo}">
                        <label for="swal-titulo" class="active">Título</label>
                    </div>
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">view_module</i>
                        <input id="swal-bloque" type="text" class="validate" value="${row.bloque}">
                        <label for="swal-bloque" class="active">Bloque</label>
                    </div>
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">assignment</i>
                        <input id="swal-cuestionario" type="text" class="validate" value="${row.cuestionario}">
                        <label for="swal-cuestionario" class="active">Cuestionario</label>
                    </div>
                    <div class="input-field mb-3">
                        <i class="material-icons prefix">access_time</i>
                        <input id="swal-time_at" type="text" class="validate" value="${row.time_at}">
                        <label for="swal-time_at" class="active">Tiempo</label>
                    </div>
                `,
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' },
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
                            success: function (response) {
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
                            error: function (xhr) {
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

                setTimeout(function () {
                    if (jQuery('input.validate').length && typeof M !== 'undefined') {
                        M.CharacterCounter.init(document.querySelectorAll('input.validate'));
                    }
                }, 100);
            });

            // Eliminar Sección
            jQuery('#seccionesTable').on('click', '.delete-btn', function () {
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
                    showClass: { popup: 'animate__animated animate__fadeIn' },
                    hideClass: { popup: 'animate__animated animate__fadeOut' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: "/admin/secciones/" + id,
                            type: "DELETE",
                            data: {_token: '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function (response) {
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
                            error: function (xhr) {
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
