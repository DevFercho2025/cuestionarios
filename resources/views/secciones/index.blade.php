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
                    <div class="card-datatable table-responsive">
                        <table id="seccionesTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Bloque</th>
                                <th>Cuestionario</th>
                                <th>Tiempo</th>
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
                    {data: 'title'},
                    {data: 'block'},
                    {data: 'cuestionario'},
                    {data: 'time_at'},
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

                // Primero obtenemos las evaluaciones que existen
                jQuery.ajax({
                    url: "{{ route('tests.all') }}",
                    type: "GET",
                    dataType: "json",
                    success: function (tests) {
                        let options = '<option disabled selected>Selecciona una prueba</option>';
                        tests.forEach(test => {
                            options += `<option value="${test.id}">${test.test_title}</option>`;
                        });

                        Swal.fire({
                            html: `
                            <div class="col-md mb-6 mb-md-0">
                                <div class="card">
                                    <h2 class="card-header">Crear Sección</h2>
                                    <div class="card-body">
                                        <div class="form-floating form-floating-outline mb-6">
                                            <input id="swal-titulo" type="text" class="form-control" placeholder="Título" required>
                                            <label for="swal-titulo">Título</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-6">
                                            <input type="text" id="swal-bloque" class="form-control" placeholder="Bloque" required>
                                            <label for="swal-bloque">Bloque</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-6">
                                            <select id="swal-categoria" class="form-select">
                                                ${options}
                                            </select>
                                            <label for="swal-categoria">Prueba a la que pertenece</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-6">
                                            <input type="text" id="swal-time_at" class="form-control" placeholder="Tiempo (hh:mm:ss)" value="00:00:00" required>
                                            <label for="swal-time_at">Tiempo (hh:mm:ss)</label>
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
                                return {
                                    title: document.getElementById('swal-titulo').value,
                                    block: document.getElementById('swal-bloque').value,
                                    test_id: document.getElementById('swal-categoria').value,
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
                                            title: '¡Sección creada!',
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

                        $(document).on('input', '#swal-time_at', function (e) {
                            const input = $(this);
                            let value = input.val();
                            let cursorPosition = input.prop("selectionStart"); //Posición actual del cursor

                            //Filtra caracteres no válidos y mantiene sólo números y dos puntos
                            value = value.replace(/[^0-9:]/g, "");

                            //Divide el valor en partes (horas, minutos, segundos)
                            const partes = value.split(":");
                            const horas = partes[0]?.slice(0, 2) || "00";
                            const minutos = partes[1]?.slice(0, 2) || "00";
                            const segundos = partes[2]?.slice(0, 2) || "00";

                            //Reconstruye el valor con el formato correcto
                            const nuevoValor = `${horas}:${minutos}:${segundos}`;
                            input.val(nuevoValor);

                            //Ajuste de la posición del cursor según la cantidad de dígitos ingresados
                            if (cursorPosition <= 2) {
                                if (horas.length === 2 && cursorPosition === 2) {
                                    cursorPosition = 3; // Mueve el cursor después del primer ":"
                                }
                            } else if (cursorPosition <= 5) {
                                if (minutos.length === 2 && cursorPosition === 5) {
                                    cursorPosition = 6; // Mueve el cursor después del segundo ":"
                                }
                            } else if (cursorPosition <= 8) {
                                cursorPosition = Math.min(cursorPosition, 8);
                            }

                            // Ajusta el cursor para que se posicione correctamente
                            input.prop("selectionStart", cursorPosition);
                            input.prop("selectionEnd", cursorPosition);
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


            // Editar Sección
            jQuery('#seccionesTable').on('click', '.edit-btn', function () {
                if (typeof Swal === 'undefined') {
                    alert('No se puede mostrar el formulario. Falta una dependencia (SweetAlert2).');
                    return;
                }

                var id = jQuery(this).data('id');
                let row = jQuery('#seccionesTable').DataTable().row(jQuery(this).parents('tr')).data();

                jQuery.ajax({
                    url: "{{ route('tests.all') }}",
                    type: "GET",
                    dataType: "json",
                    success: function (tests) {
                        let options = '';
                        tests.forEach(test => {
                            const selected = row.test_id && row.test_id === test.id ? 'selected' : '';
                            options += `<option value="${test.id}" ${selected}>${test.test_title}</option>`;
                        });

                        Swal.fire({
                            html: `
                            <div class="col-md mb-6 mb-md-0">
                                <div class="card">
                                    <h2 class="card-header">Editar Sección</h2>
                                    <div class="card-body">
                                        <div class="form-floating form-floating-outline mb-6">
                                            <input id="swal-titulo" type="text" class="form-control" placeholder="Título" required value="${row.title}">
                                            <label for="swal-titulo">Título</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-6">
                                            <input id="swal-bloque" type="text" class="form-control" placeholder="Bloque" required value="${row.block}">
                                            <label for="swal-bloque">Bloque</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-6">
                                            <select id="swal-categoria" class="form-select">
                                                ${options}
                                            </select>
                                            <label for="swal-categoria">Categoría/Cuestionario</label>
                                        </div>
                                        <div class="form-floating form-floating-outline mb-6">
                                            <input id="swal-time_at" type="text" class="form-control" placeholder="Tiempo" required value="${row.time_at}">
                                            <label for="swal-time_at">Tiempo</label>
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
                                    title: document.getElementById('swal-titulo').value,
                                    block: document.getElementById('swal-bloque').value,
                                    test_id: document.getElementById('swal-categoria').value,
                                    time_at: document.getElementById('swal-time_at').value,
                                    _token: '{{ csrf_token() }}'
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                jQuery.ajax({
                                    url: `/psicometricas/admin/secciones/${id}`,  // Actualiza la URL para el modelo Sección
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
                    },
                    error: function () {
                        M.toast({
                            html: '<i class="material-icons left">error</i> No se pudieron cargar las categorías',
                            classes: 'red rounded'
                        });
                    }
                });
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
