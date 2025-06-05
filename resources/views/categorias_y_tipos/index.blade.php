@extends('layout.admin')
@section('title', 'Gestión de Secciones')
@section('content')

<head>
    <style>
        .btn-azul {
            background-color: #3d4e81;
            color: white;
        }

        .btn-editar {
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
    </style>
</head>
    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Gestión de Categorías y Tipos de Pruebas</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createCategoriaBtn" class="btn btn-large gradient-btn pulse">
                               Nueva categoría
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla de Categorias y sus tipos -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="categoriasTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Id categoría</th>
                                <th>Título de la Categoría</th>
                                <th>Id de Tipo</th>
                                <th>Tipo</th>
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
            var table = jQuery('#categoriasTable').DataTable({
                ajax: {
                    url: "{{ route('categorias.datatable') }}",
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
                    { data: 'category_id', title: 'Id categoría' },
                    {
                        data: 'category_name',
                        title: 'Título de la Categoría' ,
                        render: function (data, type, row) {

                            return `
                                <div style="display: flex; flex-direction: column; align-items: start;">
                                    <span style="margin-bottom: 6px;">${data}</span>
                                    <button class="btn btn-sm btn-azul edit-btn" data-id="${row.category_id}" style="font-size: 12px;">
                                        <i class="ri-edit-2-line" style="margin-right: 4px;"></i>
                                    </button>
                                </div> 
                            `;
                        }
                    },
                    { data: 'type_id', title: 'Id de Tipo' },
                    { data: 'type_name', title: 'Tipo' },
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <div class="action-buttons">

                                    <button type="button" class="btn btn-rojo waves-effect waves-light delete-btn tooltipped"
                                            data-position="top" data-tooltip="Eliminar" data-id="${row.type_id}">
                                        <i class="ri-delete-bin-6-line"></i>
                                    </button>
                                </div>
                            `;
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                responsive: true,
                drawCallback: function () {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var last = null;
                    var rowspan = 1;

                    api.column(0, { page: 'current' }).data().each(function(categoryId, i) {
                        if (last !== categoryId) {
                            if (last !== null) {
                                $(rows).eq(i - rowspan).find('td').eq(0).attr('rowspan', rowspan).show();
                                $(rows).eq(i - rowspan).find('td').eq(1).attr('rowspan', rowspan).show();
                            }
                            last = categoryId;
                            rowspan = 1;
                        } else {
                            $(rows).eq(i).find('td').eq(0).hide();
                            $(rows).eq(i).find('td').eq(1).hide();
                            rowspan++;
                        }
                    });

                    // Último grupo
                    if (last !== null) {
                        var count = api.rows({ page: 'current' }).count();
                        $(rows).eq(count - rowspan).find('td').eq(0).attr('rowspan', rowspan).show();
                        $(rows).eq(count - rowspan).find('td').eq(1).attr('rowspan', rowspan).show();
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


            //crear una categoria y agregarle tipos
            jQuery('#createCategoriaBtn').on('click', function () {
                if (typeof Swal === 'undefined') {
                    alert('Falta SweetAlert2.');
                    return;
                }

                Swal.fire({
                    html: `
                    <div class="col-md mb-6 mb-md-0">
                        <div class="card">
                            <h2 class="card-header">Crear nueva Categoría</h2>
                            <div class="card-body">
                                <div class="form-floating form-floating-outline mb-6">
                                    <input id="swal-category-name" type="text" class="form-control" placeholder="Nombre de la categoría" required>
                                    <label for="swal-category-name">Nombre de la categoría</label>
                                </div>
                                <div id="types-container" style="text-align:left;">
                                    <label>Tipos</label>
                                    <div class="type-input" style="display:flex; gap:5px; margin-bottom:5px;">
                                        <input type="text" class="form-control type-name" placeholder="Nombre tipo 1" required style="flex:1;">
                                        <button type="button" class="remove-type btn btn-rojo btn-sm" title="Eliminar tipo" style="align-self:center;">×</button>
                                    </div>
                                </div>
                                <button type="button" id="add-type-btn" class="btn btn-azul mt-2" style="width:100%;">
                                    + Añadir tipo
                                </button>
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
                    cancelButtonColor: '#a12e2e',
                    showCancelButton: true,
                    buttonsStyling: true,
                    background: '#262b3c',
                    preConfirm: () => {
                        const categoryName = document.getElementById('swal-category-name').value.trim();
                        if (!categoryName) {
                            Swal.showValidationMessage('El nombre de la categoría es obligatorio');
                            return false;
                        }

                        const typeInputs = document.querySelectorAll('.type-name');
                        const tipos = [];
                        for (const input of typeInputs) {
                            const val = input.value.trim();
                            if (val) tipos.push(val);
                        }

                        if (tipos.length === 0) {
                            Swal.showValidationMessage('Debe agregar al menos un tipo');
                            return false;
                        }

                        return { categoryName, tipos };
                    },
                    didOpen: () => {
                        const container = document.getElementById('types-container');
                        const addBtn = document.getElementById('add-type-btn');

                        function updateRemoveButtons() {
                            const removeBtns = container.querySelectorAll('.remove-type');
                            removeBtns.forEach(btn => {
                                btn.onclick = function () {
                                    if (container.querySelectorAll('.type-input').length > 1) {
                                        btn.parentElement.remove();
                                    }
                                };
                            });
                        }

                        addBtn.onclick = () => {
                            const index = container.querySelectorAll('.type-input').length + 1;
                            const div = document.createElement('div');
                            div.className = 'type-input';
                            div.style.cssText = 'display:flex; gap:5px; margin-bottom:5px;';
                            div.innerHTML = `
                                <input type="text" class="form-control type-name" placeholder="Nombre tipo ${index}" required style="flex:1;">
                                <button type="button" class="remove-type btn btn-rojo btn-sm" title="Eliminar tipo" style="align-self:center;">×</button>
                            `;
                            container.appendChild(div);
                            updateRemoveButtons();
                        };

                        updateRemoveButtons();
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: '{{ route("categorias.store") }}',
                            method: 'POST',
                            data: {
                                category_name: result.value.categoryName,
                                tipos: result.value.tipos,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Categoría creada!',
                                    text: response.message || 'La categoría se ha creado con éxito.',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    background: '#262b3c',
                                    confirmButtonColor: '#3d4e81',
                                });
                                jQuery('#categoriasTable').DataTable().ajax.reload(null, false);
                            },
                            error: function(xhr) {
                                let errorMsg = 'Error al crear la categoría.';
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

            //editar una categoria existente y sus tipos
            jQuery(document).on('click', '.edit-btn', function () {
                const categoryId = jQuery(this).data('id');

                jQuery.ajax({
                    url: `/psicometricas/admin/categorias/${categoryId}`,
                    method: 'GET',
                    success: function (data) {
                        const { category_name, tipos } = data;

                        let tiposHtml = '';
                        tipos.forEach((tipo, index) => {
                            tiposHtml += `
                                <div class="type-input" style="display:flex; gap:5px; margin-bottom:5px;">
                                    <input type="text" class="form-control type-name" placeholder="Nombre tipo ${index + 1}" value="${tipo}" required style="flex:1;">
                                    <button type="button" class="remove-type btn btn-rojo btn-sm" title="Eliminar tipo" style="align-self:center;">×</button>
                                </div>
                            `;
                        });

                        Swal.fire({
                            html: `
                                <div class="col-md mb-6 mb-md-0">
                                    <div class="card">
                                        <h2 class="card-header">Editar Categoría</h2>
                                        <div class="card-body">
                                            <div class="form-floating form-floating-outline mb-6">
                                                <input id="swal-category-name" type="text" class="form-control" value="${category_name}" required>
                                                <label for="swal-category-name">Nombre de la categoría</label>
                                            </div>
                                            <div id="types-container" style="text-align:left;">
                                                <label>Tipos</label>
                                                ${tiposHtml}
                                            </div>
                                            <button type="button" id="add-type-btn" class="btn btn-azul mt-2" style="width:100%;">
                                                + Añadir tipo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Actualizar',
                            cancelButtonText: 'Cancelar',  
                            background: '#262b3c', 
                            preConfirm: () => {
                                const newName = document.getElementById('swal-category-name').value.trim();
                                if (!newName) {
                                    Swal.showValidationMessage('El nombre de la categoría es obligatorio');
                                    return false;
                                }

                                const typeInputs = document.querySelectorAll('.type-name');
                                const newTipos = [];
                                for (const input of typeInputs) {
                                    const val = input.value.trim();
                                    if (val) newTipos.push(val);
                                }

                                if (newTipos.length === 0) {
                                    Swal.showValidationMessage('Debe agregar al menos un tipo');
                                    return false;
                                }

                                return { category_name: newName, tipos: newTipos };
                            },
                            didOpen: () => {
                                const container = document.getElementById('types-container');
                                const addBtn = document.getElementById('add-type-btn');

                                function updateRemoveButtons() {
                                    const removeBtns = container.querySelectorAll('.remove-type');
                                    removeBtns.forEach(btn => {
                                        btn.onclick = function () {
                                            if (container.querySelectorAll('.type-input').length > 1) {
                                                btn.parentElement.remove();
                                            }
                                        };
                                    });
                                }

                                addBtn.onclick = () => {
                                    const index = container.querySelectorAll('.type-input').length + 1;
                                    const div = document.createElement('div');
                                    div.className = 'type-input';
                                    div.style.cssText = 'display:flex; gap:5px; margin-bottom:5px;';
                                    div.innerHTML = `
                                        <input type="text" class="form-control type-name" placeholder="Nombre tipo ${index}" required style="flex:1;">
                                        <button type="button" class="remove-type btn btn-rojo btn-sm" title="Eliminar tipo" style="align-self:center;">×</button>
                                    `;
                                    container.appendChild(div);
                                    updateRemoveButtons();
                                };

                                updateRemoveButtons();
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                jQuery.ajax({
                                    url: `/psicometricas/admin/categorias/${categoryId}`,
                                    method: 'PUT',
                                    data: {
                                        category_name: result.value.category_name,
                                        tipos: result.value.tipos,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Categoría actualizada!',
                                            text: response.message || 'La categoría ha sido actualizada con éxito.',
                                            timer: 2000,
                                            background: '#262b3c',
                                            confirmButtonColor: '#3d4e81',
                                        });
                                        jQuery('#categoriasTable').DataTable().ajax.reload(null, false);
                                    },
                                    error: function (xhr) {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: xhr.responseJSON?.message || 'No se pudo actualizar la categoría.',
                                            background: '#262b3c',
                                            confirmButtonColor: '#d32f2f',
                                        });
                                    }
                                });
                            }
                        });
                    },
                    error: function () {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo obtener la información de la categoría.',
                            background: '#262b3c',
                            confirmButtonColor: '#d32f2f',
                        });
                    }
                });
            });


            // Eliminar Categoría (y sus tipos)
            jQuery('#categoriasTable').on('click', '.delete-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta SweetAlert2.');
                    return;
                }
                var categoryId = jQuery(this).data('id');

                Swal.fire({
                    title: '¿Eliminar Categoría?',
                    text: "Esta acción eliminará la categoría y todos sus tipos. No se puede deshacer.",
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
                            url: `/psicometricas/admin/categorias/${categoryId}`,
                            type: "DELETE",
                            data: {_token: '{{ csrf_token() }}'},
                            dataType: "json",
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Eliminada!',
                                    text: response.message || 'La categoría y sus tipos han sido eliminados.',
                                    confirmButtonColor: '#3d4e81',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    background: '#262b3c',
                                });
                                // Recargar tabla
                                jQuery('#categoriasTable').DataTable().ajax.reload(null, false);
                            },
                            error: function (xhr) {
                                let errorMsg = 'No se pudo eliminar la categoría.';
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