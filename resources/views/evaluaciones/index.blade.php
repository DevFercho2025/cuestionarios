@extends('layout.admin')
@section('title', 'Gestión de Evaluaciones')

@section('content')
<head>
    <style>
        .col-id, .col-user-id {
            width: 11%;
            text-align: center;
        }

        .btn-azul {
            background-color: #05638d;
            color: white;
        }

        .btn-azul:hover {
            color: white;
            background-color: #055d82;
        }

        .btn-naranja {
            background-color: #d1850d;
            color: white;
        }

        .btn-naranja:hover {
            color: white;
            background-color: #b47b1f;
        }

        .btn-rojo {
            background-color: #a12e2e;
            color: white;
        }

        .btn-rojo:hover {
            color: white;
            background-color: #8b1a1a;
        }

        /*select para elegir pruebas*/
        .custom-option {
            display: block;
            margin-bottom: 8px;
            padding: 6px 12px;
            border-radius: 4px;
            background-color: #394263;
            cursor: pointer;
            user-select: none;
            color: #fff;
            text-align: left;
        }

        .custom-option:hover {
            background-color: #55618c; /* más claro al pasar el mouse */
        }

        .custom-option input[type="checkbox"] {
            margin-right: 8px;
        }
    </style>
</head>
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
                                    <th>ID de código</th>
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="{{ asset('js/tables-datatables-advanced.js') }}"></script>

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
                        { data: 'id', className: 'col-id' },
                        { data: 'user_id', className: 'col-user-id'},
                        { data: 'nombre' },
                        { data: 'email' },
                        { data: 'vacante' },
                        { data: 'codigo' },
                        {
                            data: null,
                            render: function(data, type, row){
                                return botones = `
                                    <div class="action-buttons" style="gap: 10px;">
                                        <button type="button" class="btn btn-azul waves-effect waves-light asignar-evaluacion-btn tooltipped"
                                            style="min-width: 50%; margin: 5px; margin-left:0px"
                                            data-position="top" title="Asignar Evaluaciones" data-id="${row.user_id}">
                                            <i class="ri-add-line"></i>
                                        </button>

                                        <button type="button" class="btn btn-secondary waves-effect waves-light ver-evaluaciones-btn tooltipped"
                                            style="min-width: 30%; margin: 5px; margin-left:0px"
                                            data-position="top" title="Ver evaluaciones asignadas para este código" data-id="${row.user_id}">
                                            <i class="ri-eye-fill"></i>
                                        </button>

                                        <button type="button" class="btn btn-naranja waves-effect waves-light configurar-btn tooltipped"
                                            style="min-width: 50%; margin: 5px; margin-left:0px"
                                            data-position="top" title="Configurar permisos" data-id="${row.id}">
                                            <i class="ri-settings-3-line"></i>
                                        </button>

                                        <button type="button" class="btn btn-rojo waves-effect waves-light eliminar-codigo-btn tooltipped"
                                            style="min-width: 30%; margin: 5px; margin-left:0px"
                                            data-position="top" title="Eliminar código" data-id="${row.id}">
                                            <i class="ri-delete-bin-6-line"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        }
                    ],
                    responsive: true,
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
                    setTimeout(() => {
                        $('.waves-ripple').remove();
                    }, 300);

                    $.get(`/psicometricas/admin/evaluaciones/usuario/${userId}`, function (pruebas) {
                        if (!pruebas || pruebas.length === 0) {
                            Swal.fire({
                                title: 'Evaluaciones',
                                text: 'Este usuario no tiene evaluaciones asignadas.',
                                icon: 'info',
                                background: '#262b3c',
                                color: '#fff',
                                confirmButtonColor: '#3d4e81'
                            });
                            return;
                        }

                        const checkboxes = pruebas.map(p => `
                            <div style="text-align:left;">
                                <label>
                                    <input type="checkbox" class="filled-in eval-checkbox" value="${p.id}" />
                                    <span>${p.test_title}</span>
                                </label>
                            </div>
                        `).join('');

                        Swal.fire({
                            title: 'Ver evaluaciones asignadas',
                            background: '#262b3c',
                            color: '#fff',
                            html: `
                                <p>Selecciona las evaluaciones que deseas eliminar:</p>
                                ${checkboxes}
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Eliminar seleccionadas',
                            cancelButtonText: 'Cerrar',
                            confirmButtonColor: '#d32f2f',
                            cancelButtonColor: '#3d4e81',
                            preConfirm: () => {
                                const seleccionadas = Array.from(
                                    Swal.getPopup().querySelectorAll('.eval-checkbox:checked')
                                ).map(checkbox => checkbox.value);

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
                                        tests: seleccionadas,
                                        _token: "{{ csrf_token() }}"
                                    }
                                }).then(response => {
                                    Swal.hideLoading();

                                    // Elimina los checkboxes del popup
                                    seleccionadas.forEach(id => {
                                        const checkbox = Swal.getPopup().querySelector(`.eval-checkbox[value="${id}"]`);
                                        if (checkbox) {
                                            checkbox.closest('div').remove();
                                        }
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

                //asignar una evaluación a un código
                $(document).on('click', '.asignar-evaluacion-btn', function () {
                    const userId = $(this).data('id');
                    setTimeout(() => {
                        $('.waves-ripple').remove();
                    }, 300);

                    $.get("{{ route('admin.categorias.listar') }}", { user_id: userId }, function (pruebas) {
                        let opciones = pruebas.map(p => `
                        <label class="custom-option">
                            <input type="checkbox" value="${p.id}" name="pruebas[]" />
                            ${p.test_title}
                        </label>
                        `).join('');

                        Swal.fire({
                            title: 'Asignar Evaluaciones',
                            background: '#262b3c',
                            color: '#fff',
                            html: `
                                <p>Selecciona una o varias pruebas:</p>
                                <div id="pruebasSelect" style="max-height: 150px; overflow-y: auto;">
                                    ${opciones}
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Asignar',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3d4e81',
                            cancelButtonColor: '#d32f2f',
                            preConfirm: () => {
                                const seleccionadas = $('#pruebasSelect input[type="checkbox"]:checked').map(function () {
                                        return $(this).val();
                                    }).get();

                                if (!seleccionadas || seleccionadas.length === 0) {
                                    Swal.showValidationMessage('Debes seleccionar al menos una prueba para asignar');
                                    return false;
                                }

                                return $.ajax({
                                    url: "{{ route('admin.evaluaciones.asignar') }}",
                                    type: 'POST',
                                    data: {
                                        user_id: userId,
                                        pruebas: seleccionadas,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    dataType: 'json', 
                                    success: function (response) {
                                        if (response.success) {
                                            Swal.fire({
                                                title: '¡Éxito!',
                                                text: response.message,
                                                icon: 'success',
                                                background: '#262b3c',
                                                color: '#fff',
                                                confirmButtonColor: '#3d4e81'
                                            });
                                        } else {
                                            Swal.fire({
                                                title: 'Error',
                                                text: response.message || 'No se pudieron asignar las evaluaciones.',
                                                icon: 'error',
                                                background: '#262b3c',
                                                color: '#fff',
                                                confirmButtonColor: '#d32f2f'
                                            });
                                        }
                                    },
                                    error: function (xhr, status, error) {
                                        let msg = 'Hubo un problema al asignar las evaluaciones.';

                                        if (xhr.responseJSON && xhr.responseJSON.message) {
                                            msg = xhr.responseJSON.message;
                                        }

                                        Swal.fire('Error', msg, 'error');
                                    }
                                });
                            }
                        });
                    });
                });

                //configurar un código (permisos de evaluación)
                $(document).on('click', '.configurar-btn', function () {
                    const aplicacionId = $(this).data('id');
                    setTimeout(() => {
                        $('.waves-ripple').remove();
                    }, 300);

                    // Obtener configuración actual antes de mostrar el modal
                    $.get(`{{ url('psicometricas/admin/aplicaciones') }}/${aplicacionId}/configuracion`, function(config) {
                        Swal.fire({
                            title: 'Configurar Aplicación',
                            background: '#262b3c',
                            color: '#fff',
                            html: `
                                <div style="text-align:left">
                                    <label><strong>Cámara prendida:</strong></label>
                                    <select id="camara" class="browser-default">
                                        <option value="1" ${config.camera == 1 ? 'selected' : ''}>Sí</option>
                                        <option value="0" ${config.camera == 0 ? 'selected' : ''}>No</option>
                                    </select>
                                    <br><br>
                                    <label><strong>Ubicación prendida:</strong></label>
                                    <select id="ubicacion" class="browser-default">
                                        <option value="1" ${config.location == 1 ? 'selected' : ''}>Sí</option>
                                        <option value="0" ${config.location == 0 ? 'selected' : ''}>No</option>
                                    </select>
                                    <!--<br><br>
                                    <label><strong>Secciones y tiempos:</strong></label>
                                    <div id="contenedorSecciones" style="border: 1px solid #ccc; padding: 10px; border-radius: 5px; max-height:200px; overflow-y:auto;">
                                         Aquí llenar con las secciones
                                    </div> -->
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Guardar configuración',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#3d4e81',
                            cancelButtonColor: '#d32f2f',
                            preConfirm: () => {
                                const camara = $('#camara').val();
                                const ubicacion = $('#ubicacion').val();

                                return $.ajax({
                                    url: "{{ route('admin.aplicaciones.configurar') }}",
                                    type: 'POST',
                                    data: {
                                        aplicacion_id: aplicacionId,
                                        camera: camara,
                                        location: ubicacion,
                                        _token: "{{ csrf_token() }}"
                                    },
                                    dataType: 'json'
                                }).then(response => {
                                    if (!response.success) {
                                        throw new Error(response.message || 'No se pudo guardar la configuración');
                                    }
                                    return response;
                                }).catch(error => {
                                    Swal.showValidationMessage(error.message);
                                    return false;
                                });
                            }
                        }).then(result => {
                            if (result.isConfirmed) {
                                Swal.fire({
                                    title: '¡Configurado!',
                                    text: 'La configuración fue guardada correctamente.',
                                    icon: 'success',
                                    background: '#262b3c',
                                    color: '#fff',
                                    confirmButtonColor: '#3d4e81'
                                });
                            }
                        });
                    });
                });

                //eliminar un código de evaluación
                $(document).on('click', '.eliminar-codigo-btn', function () {
                    const codigoId = $(this).data('id');
                    setTimeout(() => {
                        $('.waves-ripple').remove();
                    }, 300);

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "Esta acción eliminará el acceso al candidato a la plataforma de evaluación. Si tiene evaluaciones incompletas, no podrá realizarlas.",
                        icon: 'warning',
                        background: '#262b3c',
                        color: '#fff',
                        showCancelButton: true,
                        confirmButtonColor: '#d32f2f',
                        cancelButtonColor: '#373b95',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/psicometricas/admin/aplicaciones/${codigoId}`,
                                type: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: function (response) {
                                    Swal.fire({
                                        title: '¡Eliminado!',
                                        text: 'Código de acceso eliminado',
                                        icon: 'success',
                                        background: '#262b3c',
                                        color: '#fff',
                                        confirmButtonColor: '#3d4e81'
                                    });
                                    $('#aplicacionesTable').DataTable().ajax.reload();
                                    },
                                error: function () {
                                    Swal.fire('Error', 'No se pudo eliminar el código de acceso.', 'error');
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