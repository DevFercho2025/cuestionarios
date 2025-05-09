@extends('layout.admin')
@section('title', 'Gestión de Compañías')
@section('content')
    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Gestión de Compañías</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createCompanyBtn" class="btn btn-large gradient-btn pulse">
                               Nueva Compañía
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla de Compañías -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="companiesTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>logo</th>
                                <th>Activo</th>
                                <th>Fecha de creación</th>
                                <th>Actualizado por última vez</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.8/inputmask.min.js"></script>

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
            var table = $('#companiesTable').DataTable({
            ajax: {
                url: "{{ route('companias.datatable') }}",
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
                {data: 'id'},
                {data: 'name'},
                {data: 'description'},
                {
                data: 'logo',
                title: 'Logo',
                render: function(data, type, row) {
                    return data ? `<img src="${data}" alt="Logo" style="max-height: 50px;">` : 'Sin logo';
                }
            },
                {data: 'active'},
                {data: 'created_at'},
                {data: 'updated_at'},
                {
                    data: null,
                    render: function (data, type, row) {
                        return `
                            <div class="action-buttons">
                                <button type="button" class="btn btn-info waves-effect waves-light edit-btn tooltipped"
                                        data-position="top" data-tooltip="Editar" data-id="${row.id}">
                                    <i class="ri-pencil-line"></i>
                                </button>
                                <button type="button" class="btn btn-danger waves-effect waves-light delete-btn tooltipped"
                                        data-position="top" data-tooltip="Eliminar" data-id="${row.id}">
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
            // Crear Compañía
            jQuery("#createCompanyBtn").click(function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }

                Swal.fire({
                    html: `
                        <div class="col-md mb-6 mb-md-0">
                            <div class="card">
                                <h2 class="card-header">Crear Compañía</h2>
                                <div class="card-body">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-name" type="text" class="form-control" placeholder="Nombre" required>
                                        <label for="swal-name">Nombre</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-description" type="text" class="form-control" placeholder="Descripción" required>
                                        <label for="swal-description">Descripción</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <div class="row">
                                            <div class="col s12">
                                                <label for="swal-active" class="mr-2 left-align">¿Compañía activa?</label>
                                                <label class="left-align">
                                                    <input type="radio" id="swal-active-yes" name="swal-active" value="1">
                                                    <span>Sí</span>
                                                </label>
                                                <label class="left-align">
                                                    <input type="radio" id="swal-active-no" name="swal-active" value="0">
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-logo" type="file" class="form-control" placeholder="Selecciona un logo">
                                        <label for="swal-logo">Logo</label>
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
                    background: '#262b3c',
                    preConfirm: () => {
                        const logoFile = document.getElementById('swal-logo').files[0];
                        const formData = new FormData();
                        formData.append('name', document.getElementById('swal-name').value);
                        formData.append('description', document.getElementById('swal-description').value);

                        // Agregar el valor del radio 'activo'
                        const isActive = document.querySelector('input[name="swal-active"]:checked') ? document.querySelector('input[name="swal-active"]:checked').value : '0';
                        formData.append('active', isActive);

                        if (logoFile) {
                            formData.append('logo', logoFile);
                        }

                        formData.append('_token', '{{ csrf_token() }}');

                        return formData;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: "{{ route('companias.store') }}", // Reemplaza con la ruta de tu controlador
                            type: "POST",
                            data: result.value,
                            processData: false,
                            contentType: false,
                            dataType: "json",
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Compañía creada!',
                                    text: response.message,
                                    confirmButtonColor: '#3d4e81',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    background: '#262b3c',
                                });
                                reloadTable(); // Función para recargar la tabla (seguramente la tienes definida)
                            },
                            error: function (xhr) {
                                let errorMsg = 'No se pudo crear la compañía.';
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


            // Editar Compañía
            jQuery('#companiesTable').on('click', '.edit-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }

                var id = jQuery(this).data('id');
                let row = jQuery('#companiesTable').DataTable().row(jQuery(this).parents('tr')).data();

                Swal.fire({
                    html: `
                        <div class="col-md mb-6 mb-md-0">
                            <div class="card">
                                <h2 class="card-header">Editar Datos de la Compañía</h2>
                                <div class="card-body">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-name" type="text" class="form-control" placeholder="Nombre" required value="${row.name}">
                                        <label for="swal-name">Nombre</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-description" type="text" class="form-control" placeholder="Descripción" required value="${row.description}">
                                        <label for="swal-description">Descripción</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <div class="row">
                                            <div class="col s12">
                                                <label for="swal-active" class="mr-2 left-align">¿Compañía activa?</label>
                                                <label class="left-align">
                                                    <input type="radio" id="swal-active-yes" name="swal-active" value="1" ${row.active === 'Sí' ? 'checked' : ''}>
                                                    <span>Sí</span>
                                                </label>
                                                <label class="left-align">
                                                    <input type="radio" id="swal-active-no" name="swal-active" value="0" ${row.active === 'No' ? 'checked' : ''}>
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-logo" type="file" class="form-control" placeholder="Selecciona un logo">
                                        <label for="swal-logo">Logo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `,
                    showClass: { popup: 'animate__animated animate__fadeInDown' },
                    hideClass: { popup: 'animate__animated animate__fadeOutUp' },
                    focusConfirm: false,
                    confirmButtonText: 'Actualizar',
                    confirmButtonColor: '#3d4e81',
                    cancelButtonText: 'Cancelar',
                    cancelButtonColor: '#d32f2f',
                    showCancelButton: true,
                    background: '#262b3c',
                    preConfirm: () => {
                        
                        var formData = new FormData();
                        formData.append('name', document.getElementById('swal-name').value);
                        formData.append('description', document.getElementById('swal-description').value);

                        var activeValue = document.querySelector('input[name="swal-active"]:checked').value;
                        formData.append('active', activeValue);  //Estado 1 o 0
                        formData.append('_method', 'PUT');
                        formData.append('_token', '{{ csrf_token() }}');
                        
                        var logoFile = document.getElementById('swal-logo').files[0];
                        if (logoFile) {
                            formData.append('logo', logoFile);
                        }
                        return formData;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: `/admin/companias/${id}`,
                            type: 'POST',
                            data: result.value,
                            processData: false,
                            contentType: false,
                            dataType: 'json',
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
                                let errorMsg = 'No se pudo actualizar la compañía.';
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



            // Eliminar Compañía
            jQuery('#companiesTable').on('click', '.delete-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }
                var id = jQuery(this).data('id');

                Swal.fire({
                    title: '¿Eliminar Compañía?',
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
                            url: "/admin/companias/" + id,
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
                                let errorMsg = 'No se pudo eliminar la compañía.';
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
