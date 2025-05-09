@extends('layout.admin')
@section('title', 'Gestión de Usuarios')
@section('content')
    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Gestión de Usuarios</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="crearUsuarioBtn" class="btn btn-large gradient-btn pulse">
                               Nuevo usuario
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
                    <div class="card-datatable table-responsive">
                        <table id="usuariosTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Compañía</th>
                                <th>Creado el:</th>
                                <th>Actualizado el:</th>
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

            function initializeDataTable(){
                try {
                    var table = jQuery('#usuariosTable').DataTable({
                        ajax: {
                            url: "{{ route('usuarios.datatable')}}",
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
                            {data: 'id'},
                            {
                                data: 'name',
                                render: function (data, type, row) {
                                    return `<span class="editable" data-id="${row.id}" data-field="name">${data}</span>`;
                                }
                            },
                            {
                                data: 'email',
                                render: function (data, type, row) {
                                    return `<span class="editable" data-id="${row.id}" data-field="email">${data}</span>`;
                                }
                            },
                            {
                                data: 'rol',
                                render: function (data) {
                                    return data;
                                }
                            },
                            {
                                data: 'company_name',
                                render: function (data) {
                                    return data;
                                }
                            },
                            {
                                data: 'created_at',
                                render: function (data) {
                                    return new Date(data).toLocaleString();
                                }
                            },
                            {
                                data: 'updated_at',
                                render: function (data) {
                                    return new Date(data).toLocaleString();
                                }
                            },
                            {
                                data: null,
                                render: function(data, type, row){
                                    let botones = `
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-danger waves-effect waves-light delete-btn tooltipped"
                                                    data-position="top" data-tooltip="Eliminar" data-id="${row.id}">
                                                <i class="ri-delete-bin-6-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-info waves-effect waves-light ver-perfil-btn tooltipped"
                                                    data-position="top" data-tooltip="Ver perfil" data-id="${row.id}">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                    `;

                                    // Cerrar el div 'action-buttons'
                                    botones += '</div>';
                                    return botones;
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

                    // Crear Usuario
                    jQuery("#crearUsuarioBtn").click(function () {
                        if (typeof Swal === 'undefined') {
                            alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                            return;
                        }

                        $.when(
                            $.ajax({ url: "{{ route('companias.all') }}", type: "GET", dataType: "json" }),
                            $.ajax({ url: "{{ route('roles.all') }}", type: "GET", dataType: "json" }),
                        ).done(function (companiasData, rolesData) {
                            let companias = companiasData[0];
                            let roles = rolesData[0];
                            let opcionesCompanias = '<option value="" disabled selected>Seleccione una compañía</option>';
                            let opcionesRoles = '<option value="" disabled selected>Seleccione un rol</option>';

                            $.each(companias, function (i, comp) {
                                opcionesCompanias += `<option value="${comp.id}">${comp.name}</option>`;
                            });

                            $.each(roles, function (i, rol) {
                                opcionesRoles += `<option value="${rol.id}">${rol.name}</option>`;
                            });

                            Swal.fire({
                                html: `
                                    <div class="col-md mb-6 mb-md-0">
                                        <div class="card">
                                            <h2 class="card-header">Crear Usuario</h2>
                                            <div class="card-body">
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input id="swal-name" type="text" class="form-control" placeholder="Nombre" required>
                                                    <label for="swal-name">Nombre</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input id="swal-lastN" type="text" class="form-control" placeholder="Apellidos" required>
                                                    <label for="swal-lastN">Apellidos</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input id="swal-email" type="email" class="form-control" placeholder="Correo" required>
                                                    <label for="swal-email">Correo</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <input id="swal-pass" type="password" class="form-control" placeholder="Contraseña provisional" required>
                                                    <label for="swal-pass">Contraseña provisional</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <select id="swal-compania" class="form-select">
                                                        ${opcionesCompanias}
                                                    </select>
                                                    <label for="swal-compania">Compañía</label>
                                                </div>
                                                <div class="form-floating form-floating-outline mb-6">
                                                    <select id="swal-rol" class="form-select">
                                                        ${opcionesRoles}
                                                    </select>
                                                    <label for="swal-rol">Rol</label>
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
                                preConfirm: () => {
                                    const companiaId = document.getElementById('swal-compania').value;
                                    const rolId = document.getElementById('swal-rol').value;
                                    const nombre = document.getElementById('swal-name').value;
                                    const apellido = document.getElementById('swal-lastN').value;
                                    const name = nombre + " " + apellido;
                                    const email = document.getElementById('swal-email').value;
                                    const pass = document.getElementById('swal-pass').value;

                                    return {
                                        name: name,
                                        email: email,
                                        password: pass,
                                        compania_id: companiaId,
                                        rol_id: rolId,
                                        
                                        _token: '{{ csrf_token() }}'
                                    };
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    jQuery.ajax({
                                        url: "{{ route('usuarios.store') }}",
                                        type: "POST",
                                        data: result.value,
                                        dataType: "json",
                                        success: function (response) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: '¡Éxito!',
                                                text: response.message || 'Usuario creado exitosamente.',
                                                confirmButtonColor: '#3d4e81',
                                                timer: 2000,
                                                timerProgressBar: true,
                                                background: '#262b3c',
                                            });
                                            reloadTable();
                                        },
                                        error: function (xhr) {
                                            let errorMsg = 'No se pudo crear el usuario.';
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
                        }).fail(function () {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudieron cargar los roles o compañías.',
                                confirmButtonColor: '#d32f2f',
                            });
                        });
                    });

                    //hacer editable con doble clic
                    $(document).on('dblclick', '.editable', function () {
                        const span = $(this);
                        const original = span.text();
                        const field = span.data('field');
                        const id = span.data('id');

                        const input = $('<input type="text" class="inline-input"/>')
                            .val(original)
                            .css('width', '100%');

                        span.replaceWith(input);
                        input.focus();

                        input.on('blur keydown', function (e) {
                            if (e.type === 'blur' || e.key === 'Enter') {
                                const newValue = input.val();

                                if (newValue !== original) {
                                    $.ajax({
                                        url: `/usuarios/${id}`,
                                        method: 'PUT',
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            [field]: newValue
                                        },
                                        success: function () {
                                            // Crear un nuevo span con el nuevo valor
                                            const nuevoSpan = $(`<span class="editable" data-id="${id}" data-field="${field}">${newValue}</span>`);
                                            input.replaceWith(nuevoSpan);
                                            M.toast({ html: 'Actualizado correctamente', classes: 'green' });
                                        },
                                        error: function () {
                                            // Reemplazar el input por el span original si hay error
                                            const nuevoSpan = $(`<span class="editable" data-id="${id}" data-field="${field}">${original}</span>`);
                                            input.replaceWith(nuevoSpan);
                                            M.toast({ html: 'Error al actualizar', classes: 'red' });
                                        }
                                    });
                                } else {
                                    // Si no se ha cambiado el valor, restauramos el span original
                                    const nuevoSpan = $(`<span class="editable" data-id="${id}" data-field="${field}">${original}</span>`);
                                    input.replaceWith(nuevoSpan);
                                }
                            }
                        });
                    });

                    // Eliminar Candidato
                    jQuery('#usuariosTable').on('click', '.delete-btn', function () {
                        if (typeof Swal === 'undefined') {
                            alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                            return;
                        }
                        var id = jQuery(this).data('id');

                        Swal.fire({
                            title: '¿Eliminar usuario?',
                            text: "Este usuario dejará de existir y no podrá usar los servicios de Alobri.",
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
                                    url: `/admin/usuarios/${id}`,
                                    method: "DELETE",
                                    data: {_token: '{{ csrf_token() }}'},
                                    dataType: "json",
                                    success: function (response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Eliminado!',
                                            text: response.message,
                                            confirmButtonColor: '#3d4e81',
                                            timer: 2000,
                                            timerProgressBar: true,
                                            background: '#262b3c',
                                        });
                                        reloadTable();
                                    },
                                    error: function (xhr) {
                                        let errorMsg = 'No se pudo eliminar al usuario.';
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
    @endpush
@endsection