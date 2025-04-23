@extends('layout.admin')
@section('title', 'Gestión de Respuestas Correctas')
@section('content')
    <div class="container">
        <!-- Encabezado -->
        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Gestión de Respuestas Correctas</h4>
                        </div>
                        <div class="col s4 right-align">
                            <a id="createRCBtn" class="btn btn-large gradient-btn pulse">
                                Nueva Relación
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
                        <table id="rcTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Pregunta</th>
                                <th>Respuesta Correcta</th>
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


    function initializeDataTable() {
    try {
        var table = jQuery('#rcTable').DataTable({
            ajax: {
                url: "{{ route('respuestas_correctas.datatable') }}",
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
                { data: 'id' },
                {
                    data: 'pregunta.pregunta',
                    defaultContent: '<span class="grey-text">Sin Pregunta</span>'
                },
                {
                    data: 'respuesta.respuesta',
                    defaultContent: '<span class="grey-text">Sin Respuesta</span>'
                },
                {
                    data: null,
                    render: function(data, type, row) {
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
        
        // Crear Relación Respuesta Correcta
        $("#createRCBtn").click(function(){
            // Añadir meta CSRF para todas las solicitudes AJAX
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Se requiere cargar preguntas y respuestas para crear la relación
            $.when(
                $.ajax({ url: "{{ route('preguntas.datatable') }}", type: "GET", dataType: "json" }),
                $.ajax({ url: "{{ route('respuestas.datatable') }}", type: "GET", dataType: "json" })
            ).done(function(preguntasData, respuestasData) {
                let preguntas = preguntasData[0];
                let respuestas = respuestasData[0];
                let opcionesPreguntas = '<option value="" disabled selected>Seleccione una pregunta</option>';
                let opcionesRespuestas = '<option value="" disabled selected>Seleccione la respuesta correcta</option>';

                $.each(preguntas, function(i, p){
                    opcionesPreguntas += `<option value="${p.pregunta_id}">${p.pregunta}</option>`;
                });
                $.each(respuestas, function(i, r){
                    opcionesRespuestas += `<option value="${r.respuesta_id}">${r.respuesta} (Opción: ${r.opcion})</option>`;
                });

                Swal.fire({
                    title: '<i class="material-icons">add_circle_outline</i> Crear Relación',
                    html: `
                        <div class="input-field">
                            <i class="material-icons prefix">help</i>
                            <select id="swal-pregunta" class="browser-default">${opcionesPreguntas}</select>
                        </div>
                        <div class="input-field" style="margin-top: 20px;">
                            <i class="material-icons prefix">verified</i>
                            <select id="swal-respuesta" class="browser-default">${opcionesRespuestas}</select>
                        </div>
                    `,
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    },
                    focusConfirm: false,
                    confirmButtonText: '<i class="material-icons left">check</i> Crear',
                    confirmButtonColor: '#26a69a',
                    cancelButtonText: '<i class="material-icons left">close</i> Cancelar',
                    cancelButtonColor: '#ef5350',
                    showCancelButton: true,
                    buttonsStyling: true,
                    preConfirm: () => {
                        return {
                            pregunta_id: document.getElementById('swal-pregunta').value,
                            respuestas_id: document.getElementById('swal-respuesta').value,
                        }
                    }
                }).then((result) => {
                    if(result.isConfirmed){
                        $.ajax({
                            url: "{{ route('respuestas_correctas.store') }}",
                            type: "POST",
                            data: result.value,
                            dataType: "json",
                            success: function(response){
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: response.message,
                                    confirmButtonColor: '#26a69a',
                                    timer: 2000,
                                    timerProgressBar: true
                                });
                                reloadTable();
                            },
                            error: function(xhr){
                                let errorMsg = 'No se pudo crear la relación.';
                                if(xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMsg = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: errorMsg,
                                    confirmButtonColor: '#ef5350'
                                });
                            }
                        });
                    }
                });

                // Activar componentes de Materialize dentro de SweetAlert
                setTimeout(function(){
                    $('select.browser-default').formSelect();
                }, 100);
            });
        });

        // Editar Relación Respuesta Correcta
        $('#rcTable').on('click', '.edit-btn', function(){
            var id = $(this).data('id');
            $.ajax({
                url: "/admin/respuestas_correctas/" + id,
                type: "GET",
                dataType: "json",
                success: function(relacion){
                    // Cargar preguntas y respuestas
                    $.when(
                        $.ajax({ url: "{{ route('preguntas.datatable') }}", type: "GET", dataType: "json" }),
                        $.ajax({ url: "{{ route('respuestas.datatable') }}", type: "GET", dataType: "json" })
                    ).done(function(preguntasData, respuestasData){
                        let preguntas = preguntasData[0];
                        let respuestas = respuestasData[0];
                        let opcionesPreguntas = '';
                        let opcionesRespuestas = '';

                        $.each(preguntas, function(i, p){
                            let selected = p.pregunta_id == relacion.pregunta_id ? 'selected' : '';
                            opcionesPreguntas += `<option value="${p.pregunta_id}" ${selected}>${p.pregunta}</option>`;
                        });
                        $.each(respuestas, function(i, r){
                            let selected = r.respuesta_id == relacion.respuestas_id ? 'selected' : '';
                            opcionesRespuestas += `<option value="${r.respuesta_id}" ${selected}>${r.respuesta} (Opción: ${r.opcion})</option>`;
                        });

                        Swal.fire({
                            title: '<i class="material-icons">edit</i> Editar Relación',
                            html: `
                                <div class="input-field">
                                    <i class="material-icons prefix">help</i>
                                    <select id="swal-pregunta" class="browser-default">${opcionesPreguntas}</select>
                                </div>
                                <div class="input-field" style="margin-top: 20px;">
                                    <i class="material-icons prefix">verified</i>
                                    <select id="swal-respuesta" class="browser-default">${opcionesRespuestas}</select>
                                </div>
                            `,
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            },
                            focusConfirm: false,
                            confirmButtonText: '<i class="material-icons left">save</i> Actualizar',
                            confirmButtonColor: '#26a69a',
                            cancelButtonText: '<i class="material-icons left">close</i> Cancelar',
                            cancelButtonColor: '#ef5350',
                            showCancelButton: true,
                            preConfirm: () => {
                                return {
                                    pregunta_id: document.getElementById('swal-pregunta').value,
                                    respuestas_id: document.getElementById('swal-respuesta').value,
                                }
                            },
                        }).then((result) => {
                            if(result.isConfirmed){
                                $.ajax({
                                    url: "/admin/respuestas_correctas/" + id,
                                    type: "PUT",
                                    data: {
                                        ...result.value,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    dataType: "json",
                                    success: function(response){
                                        Swal.fire({
                                            icon: 'success',
                                            title: '¡Actualizado!',
                                            text: response.message,
                                            confirmButtonColor: '#26a69a',
                                            timer: 2000,
                                            timerProgressBar: true
                                        });
                                        reloadTable();
                                    },
                                    error: function(xhr){
                                        let errorMsg = 'No se pudo actualizar la relación.';
                                        if(xhr.responseJSON && xhr.responseJSON.message) {
                                            errorMsg = xhr.responseJSON.message;
                                        }
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: errorMsg,
                                            confirmButtonColor: '#ef5350'
                                        });
                                    }
                                });
                            }
                        });

                        // Activar componentes de Materialize dentro de SweetAlert
                        setTimeout(function(){
                            $('select.browser-default').formSelect();
                        }, 100);
                    });
                },
                error: function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo obtener los datos de la relación.',
                        confirmButtonColor: '#ef5350'
                    });
                }
            });
        });

        // Eliminar Relación Respuesta Correcta
        $('#rcTable').on('click', '.delete-btn', function(){
            var id = $(this).data('id');

            Swal.fire({
                title: '¿Eliminar Relación?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f44336',
                cancelButtonColor: '#9e9e9e',
                confirmButtonText: '<i class="material-icons left">delete</i> Sí, eliminar',
                cancelButtonText: '<i class="material-icons left">cancel</i> Cancelar',
                showClass: {
                    popup: 'animate__animated animate__fadeIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut'
                }
            }).then((result) => {
                if(result.isConfirmed){
                    $.ajax({
                        url: "/admin/respuestas_correctas/" + id,
                        type: "DELETE",
                        data: { _token: '{{ csrf_token() }}' },
                        dataType: "json",
                        success: function(response){
                            Swal.fire({
                                icon: 'success',
                                title: '¡Eliminada!',
                                text: response.message,
                                confirmButtonColor: '#26a69a',
                                timer: 2000,
                                timerProgressBar: true
                            });
                            reloadTable();
                        },
                        error: function(xhr){
                            let errorMsg = 'No se pudo eliminar la relación.';
                            if(xhr.responseJSON && xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMsg,
                                confirmButtonColor: '#ef5350'
                            });
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
