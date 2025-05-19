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

</style>
    <!-- loader para cuando se exporta PDF-->
    <div id="loaderPDF" class="hidden">
        <div class="preloader-wrapper active"></div>
        <span>Cargando PDF, por favor espere...</span>
    </div>

    <div class="container my-4">
        <div class="card shadow-lg">
            <div class="card-body">
                <!-- Formulario para buscar resultados por token -->
                <form id="buscarResultadosForm" class="mb-4">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="token" class="form-control" placeholder="Ingrese el token" required>
                        <button type="submit" class="btn btn-primary">Obtener Resultados</button>
                    </div>
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
                                <th>Cuestionario</th>
                                <th>Secciones completadas</th>
                                <th>token</th>
                                <th>Estado</th>
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
                        {data: 'token',
                            render: function(data, type, row) {
                                const tokenCorto = data.length > 10 ? data.substring(0, 10) + '...' : data;
                                const idBtn = 'copyBtn-' + row.id_candidato + '-' + Math.floor(Math.random() * 10000);

                                return  `
                                    <div style="display: inline-flex; align-items: center; gap: 8px;">
                                        <span id="tokenText-${idBtn}" style="white-space: nowrap;">${tokenCorto}</span>
                                        <button class="btn btn-small copy-btn" data-token="${data}" id="${idBtn}" title="Copiar token">
                                            <i class="ri-file-copy-line"></i>
                                        </button>
                                    </div>
                                `;
                            }
                        },
                        {data: 'estado'}
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

                $('#tokensTable').on('click', '.copy-btn', function() {
                    const token = $(this).data('token');
                    const row = $(this).closest('tr');
                    const estadoTexto = row.find('td').eq(5).text().trim(); //td 5 = columna de estado

                    // Verificamos si el estado contiene la palabra "Pendiente"
                    const esPendiente = estadoTexto.toLowerCase().includes('pendiente');

                    if (esPendiente) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Evaluación incompleta',
                            text: 'Este candidato aún no completa todas las secciones de su evaluación. Si genera un reporte de sus resultados, tenga en cuenta que será incompleto.',
                            showCancelButton: true,
                            confirmButtonText: 'Copiar de todas formas',
                            cancelButtonText: 'Cancelar',
                            confirmButtonColor: '#f1c40f',
                            cancelButtonColor: '#d33'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                copiarToken(token);
                            }
                        });
                    } else {
                        copiarToken(token);
                    }

                   function copiarToken(token) {
                        navigator.clipboard.writeText(token).then(() => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Token copiado correctamente',
                                text: 'Ahora puedes ver las respuestas de este candidato.',
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        }).catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error al copiar',
                                text: 'No se pudo copiar el token. Intenta manualmente.',
                            });
                        });
                    }
                });

                // Comprobar disponibilidad de SweetAlert2
                if (typeof Swal === 'undefined') {
                    console.error('SweetAlert2 no está disponible.');
                    var swalScript = document.createElement('script');
                    swalScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
                    document.body.appendChild(swalScript);
                }

                if (typeof M !== 'undefined') {
                    M.Tooltip.init(document.querySelectorAll('.tooltipped'));
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

                let tokenInput = $(this).find("input[name='token']").val();

                $.ajax({
                    url: "{{ route('admin.buscar.resultados') }}",
                    type: "GET",
                    data: { token: tokenInput },
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
                                                        <p>${aplicacion ? aplicacion.vacante : '--'}</p>
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

                $.get(`{{ url('/admin/renderizar-metricas') }}/${tokenId}`, function (html) {
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
                        $.post(`/admin/exportar-pdf/${tokenId}`, {
                            imagenes: imagenes,
                            _token: '{{ csrf_token() }}'
                        }).done(() => {
                            window.open(`/admin/exportar-pdf/token-id/${tokenId}`, '_blank');
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
