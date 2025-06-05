@extends('layout.admin')

@section('content')

<style>
    #loaderPDF {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.7);
        z-index: 10000;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        color: white;
    }

    .hidden {
        display: none !important;
    }

    .form-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .form-flex p {
        margin: 0;
    }

    table.dataTable > tbody > tr.selected > * {
        /* Quitar el box-shadow agresivo */
        box-shadow: none !important;

        /* Usar un background más suave, con opacidad */
        background-color: rgba(13, 110, 253, 0.3) !important;

        /* Color de texto un poco más suave */
        color: #f0f0f0 !important;
    }

</style>
    <!-- loader para cuando se exporta PDF-->
    <div id="loaderPDF" class="hidden">
        <div class="preloader-wrapper active"></div>
        <span>Cargando PDF, por favor espere...</span>
    </div>

    <div class="container my-4">

        <div class="row">
            <div class="col s12">
                <div class="card-panel dark-gradient">
                    <div class="row valign-wrapper mb-0">
                        <div class="col s8">
                            <h4 class="white-text">Estatus de las evaluaciones</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-lg">
            <div class="card-body">
                <!-- Formulario para buscar resultados por token -->
                <form id="buscarResultadosForm" class="mb-4 form-flex">
                    @csrf
                    <p>Seleccione evaluaciones en la tabla, y luego de clic al botón para obtener sus resultados.</p>
                    <!--<input type="text" name="token" class="form-control" placeholder="Ingrese el token" required>-->
                    <button type="submit" class="btn btn-primary">Obtener Resultados</button>
                </form>
                <div id="resultadosContainer"></div>
            </div>
        </div>
        <br>

        <!-- Tabla de tokens -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="tokensTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Id candidato</th>
                                <th>Nombre candidato</th>
                                <th>Evaluación</th>
                                <th>Secciones evaluadas</th>
                                <th>Estado</th>
                                <th>Seleccionar Evaluación</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery (si no lo incluyes globalmente) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <!-- Chart.js desde CDN (si quieres mostrar gráficas) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>


    <!--Script para datatable-->
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
            try{
                var table = jQuery('#tokensTable').DataTable({
                    ajax: {
                        url: "{{ route('resultados.datatable') }}",
                        dataSrc: 'data',
                        error: function (xhr, error, thrown) {
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
                        {data: 'id_candidato'},
                        {data: 'nombre'},
                        {data: 'cuestionario'},
                        {data: 'secciones_completadas',
                            render: function(data, type, row) {
                                const colores = ['primary', 'warning', 'info', 'danger', 'success'];

                                return data.map(function(nombre, index) {
                                    const color = colores[index % colores.length];
                                    /*La operación con módulo deja que sea cícloco, recorriento los elementos de colores (que van de 0 a 4).
                                        index(seccion en el array) / 5 (cantidad de colores)
                                        0/5 = 0, color elegido = 0 (primary)
                                        1/5 = 1, color elegido = 1 (warning)
                                        y así.
                                    */

                                    return `
                                        <div class="card shadow-none bg-transparent border border-${color} mb-1">
                                            <div class="card-body text-${color}">
                                                <p class="card-text">${nombre}</p>
                                            </div>
                                        </div>
                                    `;
                                }).join('<br>');
                            }
                        },
                        {data: 'estado'},
                        {data: 'token',
                            className: 'select-checkbox',
                            render: function(data, type, row) {
                                const tokenCorto = data.length > 10 ? data.substring(0, 10) + '...' : data;
                                const idBtn = 'copyBtn-' + row.id_candidato + '-' + Math.floor(Math.random() * 10000);

                                return  `
                                    <span id="tokenText-${idBtn}">
                                        <i class="ri-checkbox-blank-line" data-token="${data}" style="font-size: 1.5rem;"></i>
                                    </span>
                                `;
                            }
                        }
                    ],
                    select: {
                        style: 'multi',    // permite seleccionar varias filas
                        selector: 'td.select-checkbox'  // solo selecciona con click en la columna checkbox
                    },
                    responsive: true,
                    // Se elimina la opción de idioma para evitar textos extra de traducción
                    drawCallback: function () {
                    },
                });

                //seleccion de varias filas
               table.on('select.dt deselect.dt', function (e, api, type, indexes) {
                    if (type !== 'row') return;

                    const isSelect = e.type === 'select';

                    const selectedData = table.rows({ selected: true }).data().toArray();
                    const idsCandidatos = selectedData.map(row => row.id_candidato);
                    const uniqueIds = [...new Set(idsCandidatos)];

                    // Revisión de múltiples candidatos seleccionados
                    if (isSelect && uniqueIds.length > 1) {
                        const lastChangedRow = table.row(indexes);
                        lastChangedRow.deselect();

                        Swal.fire({
                            icon: 'warning',
                            title: 'Selección inválida',
                            text: 'Las evaluaciones que selecciones para generar resultados deben pertenecer al mismo candidato.',
                            background: '#262b3c',
                            color: '#fff',
                            confirmButtonColor: '#3d4e81'
                        });

                        return;
                    }

                    indexes.forEach(index => {
                        const rowNode = table.row(index).node();
                        const rowData = table.row(index).data();
                        const icon = $(rowNode).find(`i[data-token='${rowData.token}']`);

                        // Cambiar ícono al seleccionar o deseleccionar
                        if ($(rowNode).hasClass('selected')) {
                            icon.removeClass('ri-checkbox-blank-line').addClass('ri-checkbox-fill text-primary');
                        } else {
                            icon.removeClass('ri-checkbox-fill text-primary').addClass('ri-checkbox-blank-line').removeClass('text-primary');
                        }

                        // Mostrar advertencia si evaluación está incompleta
                        if (isSelect && rowData.estado && rowData.estado.toLowerCase().includes('pendiente')) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Evaluación incompleta',
                                text: 'Este candidato aún no completa todas las secciones de su evaluación. Si genera un reporte de sus resultados, tenga en cuenta que será incompleto.',
                                showCancelButton: true,
                                confirmButtonText: 'Continuar',
                                cancelButtonText: 'Cancelar',
                                confirmButtonColor: '#f1c40f',
                                cancelButtonColor: '#d33',
                                background: '#2c2f38',
                                color: '#ffffff',
                            }).then((result) => {
                                if (!result.isConfirmed) {
                                    table.row(index).deselect();
                                }
                            });
                        }
                    });
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

            }catch (error) {
                console.error('Error al inicializar la tabla:', error);
                alert('Ocurrió un error al inicializar la aplicación: ' + error.message);
            }
        }
    </script>

    <!--Script para PDF-->
    <script>
        $(document).ready(function(){
            //limpiar contenedores
            function clearDisplay() {
                $("#resultadosContainer").empty();
                $("#graficasContainer").empty();
                $("#pdfContainer").empty();
            }

            //Interceptar el submit del formulario
            $("#buscarResultadosForm").submit(function(e){
                e.preventDefault();
                clearDisplay();

                /*let tokenInput = $(this).find("input[name='token']").val();*/

                let filasSeleccionadas = $('#tokensTable tbody tr.selected');
                if (filasSeleccionadas.length === 0) {
                    alert("Por favor selecciona al menos una evaluación para generar un PDF de resultados.");
                    return;
                }

                let tabla = $('#tokensTable').DataTable();
                let tokenSeleccionado = tabla.row(filasSeleccionadas.first()).data().token;
                if (!tokenSeleccionado) {
                    alert("No se pudo obtener el token de la selección.");
                    return;
                }

                let evaluacionesSeleccionadas = [];
                filasSeleccionadas.each(function() {
                    let evaluacion = $(this).find('td').eq(2).text().trim(); //columna de evaluacion
                    if (evaluacion && !evaluacionesSeleccionadas.includes(evaluacion)) {
                        evaluacionesSeleccionadas.push(evaluacion);
                    }
                });

                $.ajax({
                    url: "{{ route('admin.buscar.resultados') }}",
                    type: "GET",
                    data: { 
                        token: tokenSeleccionado, 
                        evaluaciones: evaluacionesSeleccionadas
                    },
                    dataType: "json",
                    success: function(response) {
                        if(response.status === 'success'){
                            let usuario = response.usuario;
                            let aplicacion = response.aplicacion;
                            let respuestas = response.respuestas;

                            // 1. Mostrar datos del usuario y su aplicación
                            let infoHtml = `<div class="mb-4">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div id="pdfContainer" class="mt-3"></div>
                                                    </div> 
                                                    <div class="col-md-3">
                                                        <label class="fw-bold">Nombre:</label>
                                                        <p>${usuario.name}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="fw-bold">Vacante:</label>
                                                        <p>${aplicacion ? aplicacion.vacancy : '--'}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="fw-bold">Correo:</label>
                                                        <p>${usuario.email}</p>
                                                    </div>
                                                </div>
                                            </div>`;

                            $("#resultadosContainer").append(infoHtml);


                            // 3. Botón para exportar PDF (si existe el ID del token)
                            if (response.token && response.token.id) {
                                let pdfHtml = `<button class="btn btn-danger btn-exportar-pdf" data-token="${response.token.id}">
                                                    Exportar PDF
                                            </button>`;
                                $("#pdfContainer").append(pdfHtml);
                            }

                        }
                    },
                    error: function(xhr){
                        let errorMsg = (xhr.responseJSON && xhr.responseJSON.message)
                            ? xhr.responseJSON.message
                            : 'Error al cargar los resultados.';
                        $("#resultadosContainer").html(`<div class="alert alert-danger">${errorMsg}</div>`);
                    }
                });
            });

            // Delegación para botón PDF dinámico
            $(document).on("click", ".btn-exportar-pdf", function () {
                const tokenId = $(this).data("token");
                $("#loaderPDF").removeClass("hidden");

                $.get(`{{ url('/psicometricas/admin/renderizar-metricas') }}/${tokenId}`, function (html) {
                    const container = $('<div id="previewMetricas"  style="position: fixed; top: -9999px; left: -9999px; opacity: 1; z-index: -1;"></div>').html(html);
                    $("body").append(container);
                    $('head').append('<link rel="stylesheet" href="{{ asset('assets/css/pdf.css') }}">');

                    const graficas = container.find(".contenedor-metrica");
                    const imagenes = [];
                    let promesas = [];

                    graficas.each(function () {
                        let grafica = this;
                        $(grafica).css({
                            backgroundColor: 'white',
                            padding: '10px',
                            border: 'none',
                            boxShadow: 'none'
                        });
                        let promesa = html2canvas(grafica, {
                            willReadFrequently: true
                        }).then(canvas => {
                            imagenes.push(canvas.toDataURL("image/png"));
                        }).catch(error => {
                            console.error("Error al capturar la gráfica: ", error);
                        });
                        promesas.push(promesa);
                    });

                    Promise.all(promesas).then(() => {
                        $.post(`/psicometricas/admin/exportar-pdf/${tokenId}`, {
                            imagenes: imagenes,
                            _token: '{{ csrf_token() }}'
                        }).done(() => {
                            window.open(`/psicometricas/admin/exportar-pdf/token-id/${tokenId}`, '_blank');
                        }).always(() => {
                            $("#loaderPDF").addClass("hidden");
                            container.remove();
                        });
                    });
                });
            });
        });
    </script>
@endsection
