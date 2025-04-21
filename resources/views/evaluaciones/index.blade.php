@extends('layout.admin')
@section('title', 'Gestión de Evaluaciones')

@section('content')
    <div class="container">
        <!-- emcabezado-->
            <div class="row">
                <div class="col s12">
                    <div class="card-panel dark-gradient">
                        <div class="row valign-wrapper mb-0">
                            <div class="col s8">
                                <h4 class="white-text">Gestión de Códigos y evaluaciones</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Tabla de aplicaciones -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="aplicacionesTable" class="dt-responsive table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID de la Aplicación</th>
                                    <th>ID de Usuario</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Vacante</th>
                                    <th>Código</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--Volver a dashboard-->
        <div class="row">
            <div class="col s12">
                <a href="{{ route('admin.index') }}" class="waves-effect waves-light btn-large blue">
                    Regresar a Admin
                </a>
            </div>
        </div>
    </div>


    @push('scripts')
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Inicializar componentes del template
            if (typeof M !== 'undefined' && M.Modal) {
                M.Modal.init(document.querySelectorAll('.modal'));
                M.FormSelect.init(document.querySelectorAll('select'));
                M.Tooltip.init(document.querySelectorAll('.tooltipped'));
            } else {
                console.error('Materialize no está cargado correctamente o M.Modal es undefined');
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

        function initializeDataTable(){
            try {
                var table = jQuery('#aplicacionesTable').DataTable({
                    ajax: {
                        url: "{{ route('admin.aplicaciones.datatable')}}",
                        dataSrc: 'data',
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
                        { data: 'id' },
                        { data: 'user_id'},
                        { data: 'nombre' },
                        { data: 'email' },
                        { data: 'vacante' },
                        { data: 'codigo' },
                        {
                            data: null,
                            render: function(data, type, row){
                                return botones = `
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-success waves-effect waves-light asignar-evaluacion-btn tooltipped"
                                            data-position="top" data-tooltip="Añadir Evaluación" data-id="${row.user_id}">
                                            <i class="ri-add-line"></i>
                                        </button>
                                        <button type="button" class="btn btn-secondary waves-effect waves-light ver-evaluaciones-btn tooltipped"
                                            data-position="top" data-tooltip="Ver evaluaciones" data-id="${row.user_id}">
                                            <i class="ri-eye-fill"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light eliminar-aplicacion-btn tooltipped"
                                            data-position="top" data-tooltip="Eliminar aplicación" data-id="${row.id}">
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

                //ver las evalauciones ya asignadas a un usuario
                $(document).on('click', '.ver-evaluaciones-btn', function () {
                    const userId = $(this).data('id');

                    $.get(`/admin/evaluaciones/usuario/${userId}`, function (categorias) {
                        if (!categorias || categorias.length === 0) {
                            Swal.fire('Evaluaciones', 'Este usuario no tiene evaluaciones asignadas.', 'info');
                            return;
                        }

                        const checkboxes = categorias.map(cat => `
                            <div style="text-align:left;">
                                <label>
                                    <input type="checkbox" class="filled-in eval-checkbox" value="${cat.id}" />
                                    <span>${cat.titulo_cuestionario}</span>
                                </label>
                            </div>
                        `).join('');

                        Swal.fire({
                            title: 'Evaluaciones asignadas',
                            html: `
                                <p>Selecciona las evaluaciones que deseas eliminar:</p>
                                ${checkboxes}
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Eliminar seleccionadas',
                            cancelButtonText: 'Cerrar',
                            preConfirm: () => {
                                const seleccionadas = $('.eval-checkbox:checked').map(function () {
                                    return $(this).val();
                                }).get();

                                if (seleccionadas.length === 0) {
                                    Swal.showValidationMessage('Debes seleccionar al menos una evaluación para eliminar.');
                                    return false;
                                }

                                Swal.showLoading();
                                return $.ajax({
                                    url: "{{ route('admin.evaluaciones.eliminar') }}",
                                    method: 'POST',
                                    data: {
                                        user_id: userId,
                                        categorias: seleccionadas,
                                        _token: "{{ csrf_token() }}"
                                    }
                                }).then(response => {
                                    Swal.hideLoading();

                                    // Quitar checkboxes eliminados del DOM
                                    seleccionadas.forEach(id => {
                                        $(`.eval-checkbox[value="${id}"]`).closest('div').remove();
                                    });

                                    return false; // No cerrar el modal
                                }).catch(() => {
                                    Swal.hideLoading();
                                    Swal.showValidationMessage('Error al eliminar evaluaciones.');
                                    return false;
                                });
                            }
                        });
                    }).fail(function () {
                        Swal.fire('Error', 'No se pudo obtener la lista de evaluaciones.', 'error');
                    });
                });

                //asignar una evaluación a una aplicacion
                $(document).on('click', '.asignar-evaluacion-btn', function () {
                    const userId = $(this).data('id');

                    $.get("{{ route('admin.categorias.listar') }}", function (categorias) {
                        let opciones = categorias.map(cat => `<option value="${cat.id}">${cat.titulo_cuestionario}</option>`).join('');

                        Swal.fire({
                            title: 'Asignar Evaluaciones',
                            html: `
                                <p>Selecciona una o varias categorías:</p>
                                <select id="categoriasSelect" class="browser-default" multiple style="width:100%;height:150px;">
                                    ${opciones}
                                </select>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Asignar',
                            cancelButtonText: 'Cancelar',
                            preConfirm: () => {
                                const seleccionadas = $('#categoriasSelect').val();

                                if (!seleccionadas || seleccionadas.length === 0) {
                                    Swal.showValidationMessage('Debes seleccionar al menos una categoría');
                                    return false;
                                }

                                console.log({
                                    user_id: userId,
                                    categorias: seleccionadas
                                });

                                // Asegurarnos de que estamos manejando la respuesta como JSON
                                return $.ajax({
                                    url: "{{ route('admin.evaluaciones.asignar') }}",
                                    type: 'POST',
                                    data: {
                                        user_id: userId,
                                        categorias: seleccionadas,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    dataType: 'json', // Asegurarnos de que la respuesta sea JSON
                                    success: function (response) {
                                        console.log(response);  // Para ver la respuesta en consola
                                        if (response.success) {
                                            Swal.fire('¡Éxito!', response.message, 'success');
                                        } else {
                                            Swal.fire('Error', 'No se pudieron asignar las evaluaciones.', 'error');
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        // Mostramos el error para depuración
                                        console.error('Error al asignar evaluaciones:', error);
                                        Swal.fire('Error', 'Hubo un problema al asignar las evaluaciones.', 'error');
                                    }
                                });
                            }
                        });
                    });
                });


                //eliminar un registro con código/aplicación.
                $(document).on('click', '.eliminar-aplicacion-btn', function () {
                    const aplicacionId = $(this).data('id');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará la aplicación del candidato.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/admin/aplicaciones/${aplicacionId}`,
                                type: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function (response) {
                                    Swal.fire('Eliminado', 'La aplicación ha sido eliminada.', 'success');
                                    $('#aplicacionesTable').DataTable().ajax.reload();
                                    },
                                error: function () {
                                    Swal.fire('Error', 'No se pudo eliminar la aplicación.', 'error');
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
    @endpush
@endsection