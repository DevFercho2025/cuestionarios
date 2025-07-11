@extends('layout.admin')
@section('title', 'Gestión de pruebas')
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

        /*input cuando se elimina un test */
        .swal2-popup input.swal-confirm-input {
            background-color: #1e2333;
            color: white;
            border: 1px solid #4b5563;
            padding: 10px;
            border-radius: 6px;
            transition: border 0.2s ease, box-shadow 0.2s ease;
        }

        .swal2-popup input.swal-confirm-input::placeholder {
            color: #9ca3af;
        }

        .swal2-popup input.swal-confirm-input:focus {
            outline: none;
            border: 1px solid #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.4);
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
                            <h4 class="white-text">Gestión de Pruebas</h4>
                        </div>
                        <div class="col s4 right-align">
                            <div style="text-align: right;">
                                <a id="TestBtn" class="btn btn-large gradient-btn pulse" style="color: white; display: inline-block; background-color:#4f52b5">
                                Crear una Prueba
                                </a>
                            </div>
                        </div>
                        <!--<div class="col s4 right-align">
                            <div style="text-align: right;">
                                <a id="createTestBtn" class="btn btn-large gradient-btn pulse" style="color: white; display: inline-block; background-color:#4f52b5">
                                Crear una nueva Prueba
                                </a>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
        @include('partials.form_crear_prueba_completa') 
        <!-- Tabla de Pruebas -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="testsTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Título de Evaluación</th>
                                <th>Tipo</th>
                                <th>Categoria</th>
                                <th>Total de Secciones</th>
                                <th>Total de Preguntas</th>
                                <th>Tiempo estimado de realización</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Botón para abrir modal de evaluaciones eliminadas-->
    <div class="col s4 right-align mt-2">
        <div style="text-align: right; padding-right:1.5rem;">
            <a id="trashBtn" class="btn btn-large gradient-btn pulse" style="color: white; display: inline-block; background-color:#4f52b5;">
            Ver eliminadas
            </a>
        </div>
    </div>

    <!--Modal para ver evaluaciones eliminadas-->
    <div class="modal fade" id="modalEliminados" tabindex="-1" aria-labelledby="modalEliminadosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pruebas eliminadas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Categoría</th>
                                <th>Fecha de eliminación</th>
                                <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="deletedTestsTable">
                                <!--dinámico-->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--Modal para añadir preguntas a pruebas ya creadas-->
    <div class="modal fade" id="modal-add-questions" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullheight">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="add-questions" class="content fade">
                        <div class="col-md-12">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" id="tabs-secciones" role="tablist">
                                <!--Aquí van pestañas de secciones-->
                            </ul>
                            <!-- Tab content -->
                            <div class="tab-content mt-3" id="contenido-secciones">
                                <!--Contenido para crear preguntas y sus respuestas-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--Botón para cerrar ventana-->
                <div class="modal-footer">
                    <button class="modal-close btn btn-azul">Cerrar</button>
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
            //M.FormSelect.init(document.querySelectorAll('select'));
            M.Tooltip.init(document.querySelectorAll('.tooltipped'));
            const selectsFueraDelModal = document.querySelectorAll('.no-bootstrap select');
            M.FormSelect.init(document.querySelectorAll('.materialize-only select'));
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
            var table = jQuery('#testsTable').DataTable({
                ajax: {
                    url: "{{ route('pruebas.datatable') }}",
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
                    {data: 'tipo'},
                    {data: 'categoria'},
                    {data: 'secciones'},
                    {data: 'preguntas'},
                    {data: 'time_at'},
                    {
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button type="button" class="btn btn-azul waves-effect waves-light edit-btn tooltipped"
                                            style="margin: 8px; margin-left: 0px" data-position="top" data-tooltip="Editar" data-id="${row.id}">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button type="button" class="btn btn-rojo waves-effect waves-light delete-btn tooltipped"
                                            style="margin-right: 8px; margin-left: 0px" data-position="top" data-tooltip="Eliminar" data-id="${row.id}">
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


            // Editar una evaluación
            jQuery('#testsTable').on('click', '.edit-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }

                var id = jQuery(this).data('id');
                let table = jQuery('#testsTable').DataTable();
                let row = table.row(jQuery(this).parents('tr')).data();

                // Cargar categorías y tipos
                jQuery.ajax({
                    url: "{{ route('pruebas.categorias.tipos') }}",
                    type: "GET",
                    dataType: "json",
                    success: function (categories) {
                        // Opciones para categorías
                        let catOptions = '';
                        categories.forEach(cat => {
                            const selected = row.categoria_id == cat.id ? 'selected' : '';
                            catOptions += `<option value="${cat.id}" ${selected}>${cat.category_name}</option>`;
                        });

                        // Encontrar categoría y obtener sus tipos
                        let selectedCategory = categories.find(cat => cat.id == row.categoria_id);
                        let tipos = selectedCategory ? selectedCategory.test_types : [];

                        // Opciones para tipos
                        let typeOptions = '';
                        tipos.forEach(type => {
                            const selected = row.tipo_id == type.id ? 'selected' : '';
                            typeOptions += `<option value="${type.id}" ${selected}>${type.type_name}</option>`;
                        });

                        Swal.fire({
                            html: `
                                <div class="col-md mb-6 mb-md-0">
                                    <div class="card">
                                        <h2 class="card-header">Editar Test</h2>
                                        <div class="card-body">
                                            <div class="form-floating form-floating-outline mb-6">
                                                <input id="swal-titulo" type="text" class="form-control" placeholder="Título" required value="${row.titulo}">
                                                <label for="swal-titulo">Título</label>
                                            </div>

                                            <div class="form-floating form-floating-outline mb-6">
                                                <select id="swal-categoria" class="form-select" required>
                                                    ${catOptions}
                                                </select>
                                                <label for="swal-categoria">Categoría</label>
                                            </div>

                                            <div class="form-floating form-floating-outline mb-6">
                                                <select id="swal-tipo" class="form-select" required>
                                                    ${typeOptions}
                                                </select>
                                                <label for="swal-tipo">Tipo</label>
                                            </div>

                                            <button type="button" class="btn btn-azul waves-effect waves-light add-questions"  data-id="${id}" style="margin-top: 10px;">
                                                <i class="ri-add-line me-1"></i> Añadir más preguntas
                                            </button>
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
                            buttonsStyling: true,
                            background: '#262b3c',
                            preConfirm: () => {
                                return {
                                    titulo: document.getElementById('swal-titulo').value,
                                    categoria_id: document.getElementById('swal-categoria').value,
                                    tipo_id: document.getElementById('swal-tipo').value,
                                    _token: '{{ csrf_token() }}'
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                jQuery.ajax({
                                    url: `{{ url('psicometricas/admin/pruebas') }}/${id}`, 
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
                                        table.ajax.reload(null, false);
                                    },
                                    error: function (xhr) {
                                        let errorMsg = 'No se pudo actualizar el test.';
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

                        // Cuando cambie la categoría, actualizar el select de tipos
                        jQuery(document).off('change', '#swal-categoria'); // Remover listener previo para evitar duplicados
                        jQuery(document).on('change', '#swal-categoria', function () {
                            let catId = jQuery(this).val();
                            let categoriaSeleccionada = categories.find(cat => cat.id == catId);
                            let tiposNuevaCategoria = categoriaSeleccionada ? categoriaSeleccionada.test_types : [];

                            let newTypeOptions = '';
                          
                            if (!Array.isArray(tiposNuevaCategoria) || tiposNuevaCategoria.length === 0) {
                                newTypeOptions = `<option value="" disabled selected>Categoría sin tipos</option>`;
                            } else {
                                tiposNuevaCategoria.forEach((type, index) => {
                                    // Selecciona el primero por defecto
                                    let selected = index === 0 ? 'selected' : '';
                                    newTypeOptions += `<option value="${type.id}" ${selected}>${type.type_name}</option>`;
                                });
                            }

                            jQuery('#swal-tipo').html(newTypeOptions);
                        });
                    },
                    error: function () {
                        M.toast({
                            html: '<i class="material-icons left">error</i> No se pudieron cargar las categorías',
                            classes: 'red rounded'
                        });
                    }
                });
            });

            jQuery(document).off('click', '.add-questions');
            jQuery(document).on('click', '.add-questions', function () {
                const modal = document.getElementById('modal-add-questions');
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();
                document.getElementById('modal-add-questions').style.zIndex = '20001';

                const id = $(this).data('id');

                $.ajax({
                    url: `secciones/by-test/${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function (secciones) {
                        $('#tabs-secciones').empty();
                        $('#contenido-secciones').empty();

                        secciones.forEach((seccion, index) => {
                            const seccionId = 'seccion-' + seccion.id;
                            const titulo = seccion.title;

                            const tab = `
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link ${index === 0 ? 'active' : ''}" 
                                            id="${seccionId}-tab" 
                                            data-bs-toggle="tab" 
                                            data-bs-target="#${seccionId}" 
                                            type="button" 
                                            role="tab" 
                                            aria-controls="${seccionId}" 
                                            aria-selected="${index === 0 ? 'true' : 'false'}">
                                        ${titulo}
                                    </button>
                                </li>`;

                            const contenido = `
                                <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" 
                                    id="${seccionId}" 
                                    role="tabpanel" 
                                    aria-labelledby="${seccionId}-tab"
                                    data-test-id="${seccion.test_id}" 
                                    data-section-id="${seccion.id}">
                                    <p>Preguntas para <strong>${titulo}</strong> van aquí.</p>
                                </div>`;
                            jQuery('#tabs-secciones').append(tab);
                            jQuery('#contenido-secciones').append(contenido);

                            // Activar la primera pestaña
                            if (index === 0) {
                                const tabTriggerEl = document.querySelector(`#${seccionId}-tab`);
                                const tabTrigger = new bootstrap.Tab(tabTriggerEl);
                                tabTrigger.show();
                            }
                        });

                    },
                    error: function () {
                        console.error('No se pudieron cargar las secciones.');
                    }
                });
            });


            //Eliminar una evaluación
            jQuery('#testsTable').on('click', '.delete-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }
                var id = jQuery(this).data('id');
                let table = jQuery('#testsTable').DataTable();

                let row = jQuery(this).closest('tr');
                let rowData = table.row(row).data();
                let testTitle = rowData.titulo;

                Swal.fire({
                    title: '<span style="color: white;">¿Eliminar evaluación?</span>',
                    html: `
                            <span style="color: #d32f2f;">
                                Al eliminar la evaluación <span style="color: white;">${testTitle}</span>, también se eliminarán todas las secciones, preguntas y respuestas asociadas. 
                                Los candidatos no podrán realizarla, y tampoco se podrá generar reportes de análisis de respuestas. 
                                <br><br> 
                                Esta acción no se puede deshacer.
                            </span>
                        `,
                    input: 'text',
                    inputPlaceholder: 'Escriba el nombre exacto de la evaluación',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d32f2f',
                    cancelButtonColor: '#4b5563',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    background: '#262b3c',
                    customClass: {
                        input: 'swal-confirm-input'
                    },
                    showClass: { popup: 'animate__animated animate__fadeIn' },
                    hideClass: { popup: 'animate__animated animate__fadeOut' },
                    preConfirm: (inputValue) => {
                        if (inputValue !== testTitle) {
                            Swal.showValidationMessage('El nombre no coincide. Escriba el nombre exacto de la evaluación.');
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery.ajax({
                            url: `{{ url('psicometricas/admin/pruebas') }}/${id}`, 
                            type: 'DELETE',
                            data: { _token: '{{ csrf_token() }}' },
                            dataType: 'json',
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: '<span style="color: white;">¡Eliminado!</span>',
                                    text: response.message,
                                    confirmButtonColor: '#3d4e81',
                                    timer: 2000,
                                    timerProgressBar: true,
                                    background: '#262b3c',
                                });
                                table.ajax.reload(null, false);
                            },
                            error: function (xhr) {
                                let errorMsg = 'No se pudo eliminar el test.';
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

    //abrir modal de evaluaciones eliminadas
    document.getElementById('trashBtn').addEventListener('click', function () {
        jQuery.ajax({
            url:"{{ route('tests.deleted') }}",
            method: 'GET',
            dataType: 'json',
            success: function (data) {
                $('#deletedTestsTable').html(data.html);
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar las pruebas eliminadas:', error);
                alert('No se pudieron cargar las pruebas eliminadas.');
            }
        });

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalEliminados'));
        modal.show();

    });

        $(document).on('click', '.restore-btn', function () {
            const id = $(this).data('id');

            $.ajax({
                url: `/pruebas/${id}/restore`,
                type: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    console.log("Restaurado correctamente");
                    location.reload(); // O puedes eliminar el <tr> del DOM directamente
                },
                error: function (xhr) {
                    alert('Error al restaurar el test.');
                    console.error(xhr.responseText);
                }
            });
        });
</script>
@endsection
