@extends('layout.admin')
@section('title', 'Gestión de Candidatos')
@section('content')

<head>
    <style>
        .btn-azul {
            margin: 5px;
            margin-left: 0px;
            background-color: #8b8b8b;
            color: white;
        }

        .btn-azul:hover {
            color: white;
            background-color: #6b6a6a;
        }

        .btn-codigo {
            margin: 5px;
            margin-left: 0px;
            color: white;
            background-color: #4b4fa9;
        }

        .btn-codigo:hover {
            color: white;;
            background-color: #666cff;
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
            margin: 5px;
            margin-left: 0px;
            background-color: #a12e2e;
            color: white;
        }

        .btn-rojo:hover {
            color: white;
            background-color: #8b1a1a;
        }

    </style>
</head>

    <div class="container">
        <input type="hidden" id="conVacante" value="{{ $conVacante }}">
        <!-- emcabezado-->
        <div class="row" style="padding-bottom: 10px">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <h4 class="white-text mb-0" style="margin: 0;">
                            @if ($conVacante == 1)
                                Gestionar y ver información de Candidatos con Vacante
                            @else
                                Gestionar y ver información de Candidatos sin Vacante
                            @endif
                        </h4>
                        <button class="btn" id="btnAgregarCandidato" onclick="abrirModalCandidato()" style="white-space: nowrap; padding-right:20px; !important padding-left:20px; !important; background-color: #3d4e81; color:white;">Añadir un candidato</button>
                    </div>
                </div>
            </div>
        </div>


        <!--Modal para insertar formulario de creación de candidatos-->
        <!-- Modal -->
        <div class="modal fade" id="modalCandidato" tabindex="-1" aria-labelledby="modalCandidatoLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    @include('partials.form_crear_candidato')
                </div>
            </div>
        </div>
        </div>

        <!-- Tabla de candidatos -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="candidatosTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha Registro</th>
                                <th>Nombre</th>
                                <th>Fecha Nacimiento</th>
                                <th>Género legal</th>
                                <th>Celular</th>
                                <th>Email</th>
                                
                                @if (auth()->user()?->config?->role?->isSuperAdmin())
                                    <th>Compañía</th>
                                @endif
                                @if ($conVacante == 1)
                                    <th>Vacantes</th>
                                @endif
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
        @php
            $userPermissions = [
                'isAuthenticated' => auth()->check(),
                'isAdmin' => auth()->user()?->config?->role?->isAdmin() ?? false,
                'isSuperAdmin' => auth()->user()?->config?->role?->isSuperAdmin() ?? false,
            ];
        @endphp
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
                    var userPermissions = @json($userPermissions);
                    var conVacante = @json($conVacante ? 1 : 0);
                    try {
                       var columns = [
                            {data: 'id'},
                            {
                                data: 'created_at',
                                render: function (data) {
                                    return data ? data : '-';
                                }
                            },
                            {
                                data: 'name',
                                render: function (data, type, row) {
                                    return `<span class="editable" data-id="${row.id}" data-field="name">${data}</span>`;
                                }
                            },
                            {
                                data: 'fecha_nacimiento',
                                render: function (data) {
                                    return data ? data : '-';
                                }
                            },
                            { 
                                data: 'genero',
                                render: function (data, type, row) {
                                    return `<span class="editable" data-id="${row.id}" data-field="genero">${data ?? '-'}</span>`;
                                }
                            },
                            { 
                                data: 'celular',
                                render: function (data, type, row) {
                                    return `<span class="editable" data-id="${row.id}" data-field="celular">${data ?? '-'}</span>`;
                                }
                            },
                            {
                                data: 'email',
                                render: function (data, type, row) {
                                    return `<span class="editable" data-id="${row.id}" data-field="email">${data}</span>`;
                                }
                            },
                            // Solo mostrar columna compañía si es superAdmin
                            userPermissions.isSuperAdmin ? {
                                data: 'company_name',
                                title: 'Compañía',
                                render: function(data, type, row) {
                                    return data ?? 'Sin compañía';
                                }
                            } : null,

                            //solo mostrar columna si es candidatos que tienen vacante
                            conVacante == 1 ? {
                                data: 'vacante',
                                title: 'Vacante',
                                render: function(data) {
                                    return data ?? '-';
                                }
                            } : null,
                            {
                                data: null,
                                render: function(data, type, row){
                                    return `
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-rojo waves-effect waves-light delete-btn tooltipped"
                                                style="margin=8px; margin-left:0px"
                                                    data-position="top" data-tooltip="Eliminar" data-id="${row.id}">
                                                <i class="ri-delete-bin-6-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-azul waves-effect waves-light ver-perfil-btn tooltipped"
                                               style="margin=8px; margin-left:0px"
                                                    data-position="top" data-tooltip="Ver perfil" data-id="${row.id}">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button type="button" class="btn btn-codigo waves-effect waves-light generar-codigo-btn tooltipped"
                                                style="margin=8px; margin-left:0px"
                                                data-id="${row.id}" data-tooltip="Generar Código">
                                                <i class="ri-key-fill"></i>
                                            </button>
                                        </div>
                                    `;
                                }
                            }
                        ].filter(Boolean);

                        var table = jQuery('#candidatosTable').DataTable({
                            ajax: {
                                url: "{{ route('candidatos.datatable')}}",
                                data: function(d) {
                                    d.conVacante = jQuery('#conVacante').val();
                                },
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
                            columns: columns,
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
                                            url: `psicometricas/admin/candidatos/${id}`,
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
                        jQuery('#candidatosTable').on('click', '.delete-btn', function () {
                            if (typeof Swal === 'undefined') {
                                alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                                return;
                            }
                            var id = jQuery(this).data('id');

                            Swal.fire({
                                title: '¿Eliminar Candidato?',
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
                                        url: "/psicometricas/admin/candidatos/${id}" + id,
                                        method: "DELETE",
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
                                            let errorMsg = 'No se pudo eliminar al candidato.';
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

                        //Ver perfil del candidato
                        jQuery('#candidatosTable').on('click', '.ver-perfil-btn', function () {
                            var id = jQuery(this).data('id');

                            window.location.href = `/psicometricas/admin/candidatos/perfil/${id}`;
                        });
                        
                        //Ir a formulario de registro de candidato
                        $('#registrarCandidatoBtn').click(function () {
                            window.location.href = "{{ route('candidatos.crear') }}";
                        });

                        //eliminar candidato
                        $(document).on('click', '.delete-btn', function () {
                            const id = $(this).data('id');

                            Swal.fire({
                                title: '¿Eliminar candidato?',
                                text: 'Esta acción no se puede deshacer',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then(result => {
                                if (result.isConfirmed) {
                                    $.ajax({
                                        url: `/psicometricas/admin/candidatos/${id}`,
                                        method: 'DELETE',
                                        data: {
                                            _token: "{{ csrf_token() }}"
                                        },
                                        success: function () {
                                            table.ajax.reload();
                                            Swal.fire('Eliminado', 'Candidato eliminado correctamente', 'success');
                                        },
                                        error: function () {
                                            Swal.fire('Error', 'No se pudo eliminar el candidato', 'error');
                                        }
                                    });
                                }
                            });
                        });

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        
                        // generar código individual
                        $(document).on('click', '.generar-codigo-btn', function () {
                            const userId = $(this).data('id');
                            Swal.fire({
                                title: 'Generar código',
                                html: `
                                    <p>Introduce el nombre de la vacante para este candidato:</p>
                                    <input id="vacanteInput" class="swal2-input" placeholder="Vacante">
                                `,
                                showCancelButton: true,
                                confirmButtonText: 'Generar',
                                cancelButtonText: 'Cancelar',
                                preConfirm: () => {
                                    const vacante = $('#vacanteInput').val().trim();
                                    if (!vacante) {
                                        Swal.showValidationMessage('La vacante es obligatoria');
                                        return false;
                                    }

                                    return $.post("{{ route('guardar.codigo') }}", {
                                        user_id: userId,
                                        vacante: vacante,
                                        _token: "{{ csrf_token() }}"
                                    })
                                    .then(response => {
                                        return response;
                                    })
                                    .catch(xhr => {
                                        if (xhr.status === 422) {
                                            const errores = xhr.responseJSON?.errors;
                                            console.error("Errores de validación:", errores);
                                            Swal.showValidationMessage(
                                                Object.values(errores).flat().join('<br>')
                                            );
                                        } else {
                                            console.error(xhr);
                                            Swal.showValidationMessage('Error inesperado al generar el código');
                                        }
                                    });
                                }
                            }).then(result => {
                                if (result.isConfirmed && result.value) {
                                    const code = result.value.code;
                                    Swal.fire({
                                        title: '¡Código generado!',
                                        html: `
                                            <p><strong>Código:</strong></p>
                                            <input type="text" id="codigoGenerado" class="swal2-input" value="${code}" readonly>
                                            <button id="btnCopiarCodigo" class="swal2-confirm swal2-styled">Copiar</button>
                                        `,
                                        showConfirmButton: false,
                                        didOpen: () => {
                                            $('#btnCopiarCodigo').click(function () {
                                                const input = document.getElementById('codigoGenerado');
                                                input.select();
                                                input.setSelectionRange(0, 99999); // Para móviles

                                                try {
                                                    const copiado = document.execCommand('copy');
                                                    if (copiado) {
                                                        Swal.fire('Copiado', 'Código copiado al portapapeles', 'success');
                                                    } else {
                                                        Swal.fire('Ups', 'No se pudo copiar automáticamente', 'warning');
                                                    }
                                                } catch (err) {
                                                    console.error('Error al copiar:', err);
                                                    Swal.fire('Error', 'Hubo un problema al copiar el código', 'error');
                                                }
                                            });
                                        }
                                    });
                                    reloadTable();
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

    <script>
    document.addEventListener('shown.bs.modal', function (e) {
        if (e.target.id === 'modalCandidato') {
        const selects = e.target.querySelectorAll('select');
        M.FormSelect.init(selects);
        }
    });
    </script>
@endsection