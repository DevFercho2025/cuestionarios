@extends('layout.admin')
@section('title', 'API Consumers')
@section('content')
    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">API Consumers</h4>
                            <p class="white-text" style="margin:0; opacity:0.7;">Plataformas autorizadas para consumir la API</p>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createConsumerBtn" class="btn btn-large gradient-btn pulse">
                               Nuevo Consumer
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla de Consumers -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="consumersTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Slug</th>
                                <th>Dominio</th>
                                <th>Activo</th>
                                <th>Ultimo uso</th>
                                <th>Creado</th>
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

<script>
    if (typeof jQuery === 'undefined') {
        document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
    }

    document.addEventListener('DOMContentLoaded', function () {
        if (typeof jQuery !== 'undefined') {
            initializeApp();
        } else {
            console.error('jQuery no esta disponible.');
            alert('Error: jQuery no esta cargado correctamente.');
        }
    });

    function initializeApp() {
        jQuery.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        if (typeof M !== 'undefined') {
            M.Modal.init(document.querySelectorAll('.modal'));
            M.FormSelect.init(document.querySelectorAll('select'));
            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
        }

        if (typeof jQuery.fn.DataTable === 'undefined') {
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
            var table = $('#consumersTable').DataTable({
                ajax: {
                    url: "{{ route('consumers.datatable') }}",
                    dataSrc: '',
                    error: function (xhr, error, thrown) {
                        console.error('Error en la carga de datos:', error, thrown);
                        if (typeof M !== 'undefined') {
                            M.toast({
                                html: '<i class="material-icons left">error</i> Error al cargar los datos',
                                classes: 'rounded red'
                            });
                        }
                    }
                },
                columns: [
                    {data: 'id'},
                    {data: 'name'},
                    {data: 'slug'},
                    {data: 'domain'},
                    {
                        data: 'is_active',
                        render: function(data) {
                            var color = data === 'Si' ? 'green' : 'red';
                            return `<span class="badge ${color} white-text" style="border-radius:4px; padding:2px 8px;">${data}</span>`;
                        }
                    },
                    {data: 'last_used_at'},
                    {data: 'created_at'},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-info waves-effect waves-light edit-btn tooltipped"
                                            data-position="top" data-tooltip="Editar" data-id="${row.id}">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning waves-effect waves-light regen-btn tooltipped"
                                            data-position="top" data-tooltip="Regenerar Secret" data-id="${row.id}" data-name="${row.name}">
                                        <i class="ri-key-2-line"></i>
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
                }
            });

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

            if (typeof Swal === 'undefined') {
                var swalScript = document.createElement('script');
                swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                document.body.appendChild(swalScript);
            }

            // Crear Consumer
            jQuery("#createConsumerBtn").click(function () {
                Swal.fire({
                    html: `
                        <div class="col-md mb-6 mb-md-0">
                            <div class="card">
                                <h2 class="card-header">Nuevo API Consumer</h2>
                                <div class="card-body">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-name" type="text" class="form-control" placeholder="Nombre de la plataforma" required>
                                        <label for="swal-name">Nombre</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-domain" type="text" class="form-control" placeholder="ej. app.ejemplo.com">
                                        <label for="swal-domain">Dominio (opcional)</label>
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
                    background: '#262b3c',
                    preConfirm: () => {
                        const name = document.getElementById('swal-name').value.trim();
                        if (!name) {
                            Swal.showValidationMessage('El nombre es obligatorio');
                            return false;
                        }
                        return {
                            name: name,
                            domain: document.getElementById('swal-domain').value.trim() || null
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: "{{ route('consumers.store') }}",
                            type: "POST",
                            data: JSON.stringify(result.value),
                            contentType: 'application/json',
                            dataType: "json",
                            success: function (response) {
                                // Mostrar el secret generado
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Consumer creado',
                                    html: `
                                        <p>Guarda este secret, <strong>no se mostrara de nuevo</strong>:</p>
                                        <div style="background:#1a1e2e; padding:12px; border-radius:6px; margin-top:10px; word-break:break-all; font-family:monospace; font-size:13px; color:#4fc3f7;">
                                            ${response.data.secret}
                                        </div>
                                        <button onclick="navigator.clipboard.writeText('${response.data.secret}'); this.textContent='Copiado!'"
                                                class="btn btn-sm" style="margin-top:10px; background:#3d4e81;">
                                            Copiar Secret
                                        </button>
                                    `,
                                    confirmButtonColor: '#3d4e81',
                                    background: '#262b3c',
                                });
                                reloadTable();
                            },
                            error: function (xhr) {
                                let errorMsg = 'No se pudo crear el consumer.';
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

            // Editar Consumer
            jQuery('#consumersTable').on('click', '.edit-btn', function () {
                var id = jQuery(this).data('id');
                let row = jQuery('#consumersTable').DataTable().row(jQuery(this).parents('tr')).data();

                Swal.fire({
                    html: `
                        <div class="col-md mb-6 mb-md-0">
                            <div class="card">
                                <h2 class="card-header">Editar API Consumer</h2>
                                <div class="card-body">
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-name" type="text" class="form-control" placeholder="Nombre" required value="${row.name}">
                                        <label for="swal-name">Nombre</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <input id="swal-domain" type="text" class="form-control" placeholder="Dominio" value="${row.domain === '—' ? '' : row.domain}">
                                        <label for="swal-domain">Dominio (opcional)</label>
                                    </div>
                                    <div class="form-floating form-floating-outline mb-6">
                                        <div class="row">
                                            <div class="col s12">
                                                <label class="mr-2 left-align">Activo?</label>
                                                <label class="left-align">
                                                    <input type="radio" id="swal-active-yes" name="swal-active" value="1" ${row.is_active === 'Si' ? 'checked' : ''}>
                                                    <span>Si</span>
                                                </label>
                                                <label class="left-align">
                                                    <input type="radio" id="swal-active-no" name="swal-active" value="0" ${row.is_active === 'No' ? 'checked' : ''}>
                                                    <span>No</span>
                                                </label>
                                            </div>
                                        </div>
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
                        const name = document.getElementById('swal-name').value.trim();
                        if (!name) {
                            Swal.showValidationMessage('El nombre es obligatorio');
                            return false;
                        }
                        const activeRadio = document.querySelector('input[name="swal-active"]:checked');
                        return {
                            name: name,
                            domain: document.getElementById('swal-domain').value.trim() || null,
                            is_active: activeRadio ? parseInt(activeRadio.value) : 1
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: "{{ url('psicometricas/admin/consumers') }}/" + id,
                            type: 'PUT',
                            data: JSON.stringify(result.value),
                            contentType: 'application/json',
                            dataType: 'json',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Actualizado',
                                    text: response.message,
                                    confirmButtonColor: '#3d4e81',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    background: '#262b3c',
                                });
                                reloadTable();
                            },
                            error: function (xhr) {
                                let errorMsg = 'No se pudo actualizar el consumer.';
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

            // Regenerar Secret
            jQuery('#consumersTable').on('click', '.regen-btn', function () {
                var id = jQuery(this).data('id');
                var name = jQuery(this).data('name');

                Swal.fire({
                    title: 'Regenerar Secret',
                    html: `<p>Se generara un nuevo secret para <strong>${name}</strong>.</p><p>El secret anterior dejara de funcionar inmediatamente.</p>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e65100',
                    cancelButtonColor: '#4b5563',
                    confirmButtonText: '<i class="ri-key-2-line"></i> Si, regenerar',
                    cancelButtonText: 'Cancelar',
                    background: '#262b3c',
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: "{{ url('psicometricas/admin/consumers') }}/" + id + "/regenerate-secret",
                            type: "POST",
                            dataType: "json",
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Secret regenerado',
                                    html: `
                                        <p>Guarda este nuevo secret, <strong>no se mostrara de nuevo</strong>:</p>
                                        <div style="background:#1a1e2e; padding:12px; border-radius:6px; margin-top:10px; word-break:break-all; font-family:monospace; font-size:13px; color:#4fc3f7;">
                                            ${response.data.secret}
                                        </div>
                                        <button onclick="navigator.clipboard.writeText('${response.data.secret}'); this.textContent='Copiado!'"
                                                class="btn btn-sm" style="margin-top:10px; background:#3d4e81;">
                                            Copiar Secret
                                        </button>
                                    `,
                                    confirmButtonColor: '#3d4e81',
                                    background: '#262b3c',
                                });
                            },
                            error: function (xhr) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo regenerar el secret.',
                                    confirmButtonColor: '#d32f2f',
                                    background: '#262b3c',
                                });
                            }
                        });
                    }
                });
            });

            // Eliminar Consumer
            jQuery('#consumersTable').on('click', '.delete-btn', function () {
                var id = jQuery(this).data('id');

                Swal.fire({
                    title: 'Eliminar Consumer?',
                    text: "Esta accion no se puede deshacer. Las plataformas que usen este consumer perderan acceso.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d32f2f',
                    cancelButtonColor: '#4b5563',
                    confirmButtonText: '<i class="ri-delete-bin-6-line"></i> Si, eliminar',
                    cancelButtonText: 'Cancelar',
                    background: '#262b3c',
                    showClass: { popup: 'animate__animated animate__fadeIn' },
                    hideClass: { popup: 'animate__animated animate__fadeOut' }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: "{{ url('psicometricas/admin/consumers') }}/" + id,
                            type: "DELETE",
                            dataType: "json",
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Eliminado',
                                    text: response.message,
                                    confirmButtonColor: '#3d4e81',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    background: '#262b3c',
                                });
                                reloadTable();
                            },
                            error: function (xhr) {
                                let errorMsg = 'No se pudo eliminar el consumer.';
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

            if (typeof M !== 'undefined') {
                M.Tooltip.init(document.querySelectorAll('.tooltipped'));
            }
        } catch (error) {
            console.error('Error al inicializar la tabla:', error);
            alert('Ocurrio un error al inicializar la aplicacion: ' + error.message);
        }
    }
</script>
@endsection
