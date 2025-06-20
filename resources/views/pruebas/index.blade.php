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

            // Crear nueva evaluación
            jQuery('#createTestBtn').on('click', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }

                // Cargar categorías y tipos
                jQuery.ajax({
                    url: "{{ route('pruebas.categorias.tipos') }}",
                    type: "GET",
                    dataType: "json",
                    success: function (categories) {
                        // Opciones para categorías
                        let catOptions = '';
                        categories.forEach(cat => {
                            catOptions += `<option value="${cat.id}">${cat.category_name}</option>`;
                        });

                        // Seleccionar la primera categoría para cargar sus tipos
                        let firstCategory = categories[0];
                        let tipos = firstCategory ? firstCategory.test_types : [];

                        // Opciones para tipos
                        let typeOptions = '';
                        tipos.forEach((type, index) => {
                            // Selecciona el primero por defecto
                            let selected = index === 0 ? 'selected' : '';
                            typeOptions += `<option value="${type.id}" ${selected}>${type.type_name}</option>`;
                        });

                        Swal.fire({
                            html: `
                                <div class="col-md mb-6 mb-md-0">
                                    <div class="card">
                                        <h2 class="card-header">Crear Test</h2>
                                        <div class="card-body">
                                            <div class="form-floating form-floating-outline mb-6">
                                                <input id="swal-titulo" type="text" class="form-control" placeholder="Título" required>
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
                                const titulo = document.getElementById('swal-titulo').value.trim();
                                const categoria_id = document.getElementById('swal-categoria').value;
                                const tipo_id = document.getElementById('swal-tipo').value;

                                if (!titulo) {
                                    Swal.showValidationMessage('El título es obligatorio');
                                    return false;
                                }

                                return {
                                    titulo,
                                    categoria_id,
                                    tipo_id,
                                    _token: '{{ csrf_token() }}'
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                jQuery.ajax({
                                    url: `{{ url('psicometricas/admin/pruebas') }}`, // POST para crear
                                    type: "POST",
                                    data: result.value,
                                    dataType: "json",
                                    success: function (response) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Creado!',
                                            text: response.message,
                                            confirmButtonColor: '#3d4e81',
                                            timer: 2000,
                                            timerProgressBar: true,
                                            background: '#262b3c',
                                        });
                                        let table = jQuery('#testsTable').DataTable();
                                        table.ajax.reload(null, false);
                                    },
                                    error: function (xhr) {
                                        let errorMsg = 'No se pudo crear el test.';
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
                        jQuery(document).off('change', '#swal-categoria'); // Evita listeners duplicados
                        jQuery(document).on('change', '#swal-categoria', function () {
                            let catId = jQuery(this).val();
                            let categoriaSeleccionada = categories.find(cat => cat.id == catId);
                            let tiposNuevaCategoria = categoriaSeleccionada ? categoriaSeleccionada.test_types : [];

                            let newTypeOptions = '';

                            if (!Array.isArray(tiposNuevaCategoria) || tiposNuevaCategoria.length === 0) {
                                newTypeOptions = `<option value="" disabled selected>Categoría sin tipos</option>`;
                            } else {
                                tiposNuevaCategoria.forEach((type, index) => {
                                    let selected = index === 0 ? 'selected' : '';
                                    newTypeOptions += `<option value="${type.id}" ${selected}>${type.type_name}</option>`;
                                });
                            }

                            jQuery('#swal-tipo').html(newTypeOptions);
                        });
                    },
                    error: function () {
                        if (typeof M !== 'undefined') {
                            M.toast({
                                html: '<i class="material-icons left">error</i> No se pudieron cargar las categorías',
                                classes: 'red rounded'
                            });
                        } else {
                            alert('No se pudieron cargar las categorías');
                        }
                    }
                });
            });

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
                            const selected = row.categoria === cat.category_name ? 'selected' : '';
                            catOptions += `<option value="${cat.id}" ${selected}>${cat.category_name}</option>`;
                        });

                        // Encontrar categoría y obtener sus tipos
                        let selectedCategory = categories.find(cat => cat.id == row.categoria_id);
                        let tipos = selectedCategory ? selectedCategory.test_types : [];

                        // Opciones para tipos
                        let typeOptions = '';
                        tipos.forEach(type => {
                            const selected = row.tipo === type.type_name ? 'selected' : '';
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

            //Eliminar una evaluación
            jQuery('#testsTable').on('click', '.delete-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }
                var id = jQuery(this).data('id');
                let table = jQuery('#testsTable').DataTable();

                Swal.fire({
                    title: '<span style="color: white;">¿Eliminar evaluación?</span>',
                    html: '<span style="color: #d32f2f;">Al eliminar esta evaluación, también se eliminarán todas las secciones, preguntas y respuestas asociadas. Los candidatos no podrán realizarla, y tampoco se podrá generar reportes de análisis de respuestas. <br><br> Esta acción no se puede deshacer.</span>',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d32f2f',
                    cancelButtonColor: '#4b5563',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar',
                    background: '#262b3c',
                    showClass: { popup: 'animate__animated animate__fadeIn' },
                    hideClass: { popup: 'animate__animated animate__fadeOut' }
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
</script>
@endsection
