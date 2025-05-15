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
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </form>

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
                                        <th>Estado</th>
                                        <!--Completado, pendiente por terminar, No ha iniciado -->
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div id="resultadosContainer"></div>
                <div id="graficasContainer" class="mt-5"></div>

                
            </div>
        </div>
    </div>

    <!-- jQuery (si no lo incluyes globalmente) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
    <!-- Chart.js desde CDN (si quieres mostrar gráficas) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

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
                                                        <p>${aplicacion ? aplicacion.cargo_aplicado : '--'}</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label class="fw-bold">Correo:</label>
                                                        <p>${usuario.email}</p>
                                                    </div>
                                                </div>
                                            </div>`;

                            $("#resultadosContainer").append(infoHtml);

                            // 2. Construir tabla de respuestas
                            let tablaHtml = `
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Pregunta</th>
                                            <th>Respuesta del Usuario</th>
                                            <th>Respuesta Correcta</th>
                                            <th>Resultado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                            `;

                            $.each(respuestas, function(i, rUser){
                                // Texto de la pregunta
                                let preguntaTexto = rUser.pregunta && rUser.pregunta.pregunta
                                    ? rUser.pregunta.pregunta
                                    : 'Pregunta no encontrada';

                                // Texto de la respuesta del usuario
                                let respuestaUsuarioTexto = rUser.respuesta && rUser.respuesta.respuesta
                                    ? rUser.respuesta.respuesta
                                    : 'Sin respuesta';

                                // Texto de la respuesta correcta
                                let respuestaCorrectaTexto = (rUser.respuestaCorrecta
                                    && rUser.respuestaCorrecta.respuesta
                                    && rUser.respuestaCorrecta.respuesta.respuesta)
                                    ? rUser.respuestaCorrecta.respuesta.respuesta
                                    : 'No registrada';

                                // Obtención del id de la respuesta correcta
                                let respuestaCorrectaId = (rUser.respuestaCorrecta && rUser.respuestaCorrecta.respuestas_id)
                                    ? rUser.respuestaCorrecta.respuestas_id
                                    : null;

                                // Se considera que la respuesta es correcta si existe respuesta correcta y coincide el id
                                let esCorrecta = respuestaCorrectaId && (respuestaCorrectaId == rUser.respuesta_id);

                                // Definir cómo se muestra la respuesta del usuario:
                                // Si es correcta → verde; si es incorrecta (o no hay respuesta correcta) → rojo.
                                let respuestaUsuarioHTML = esCorrecta
                                    ? `<span class="text-success">${respuestaUsuarioTexto}</span>`
                                    : `<span class="text-danger">${respuestaUsuarioTexto}</span>`;

                                // La respuesta correcta se muestra en verde siempre.
                                let respuestaCorrectaHTML = `<span class="text-success">${respuestaCorrectaTexto}</span>`;

                                // Resultado: 1 si es correcta, 0 si es incorrecta.
                                let resultadoValor = esCorrecta ? 1 : 0;

                                // Construir la fila de la tabla
                                tablaHtml += `
                                            <tr>
                                                <td>${preguntaTexto}</td>
                                                <td>${respuestaUsuarioHTML}</td>
                                                <td>${respuestaCorrectaHTML}</td>
                                                <td>${resultadoValor}</td>
                                            </tr>
                                        `;
                                    });


                                    tablaHtml += `
                                    </tbody>
                                </table>
                            </div>
                            `;

                            $("#resultadosContainer").append(tablaHtml);

                            // 3. Botón para exportar PDF (si existe el ID del token)
                            if (response.token && response.token.id) {
                                let pdfHtml = `<button class="btn btn-danger btn-exportar-pdf" data-token="${response.token.id}">
                                                    Exportar PDF
                                            </button>`;
                                $("#pdfContainer").append(pdfHtml);
                            }

                            // 4. (Opcional) Mostrar gráficas por sección: correctas vs. incorrectas
                            //    Agrupamos las respuestas según la sección y contamos cuántas
                            //    fueron correctas e incorrectas.
                            let sectionsData = {};
                            $.each(respuestas, function(i, rUser){
                                let tituloSeccion = (rUser.pregunta
                                    && rUser.pregunta.seccion
                                    && rUser.pregunta.seccion.titulo)
                                    ? rUser.pregunta.seccion.titulo
                                    : 'Sin sección';

                                let correctId = (rUser.respuestaCorrecta && rUser.respuestaCorrecta.respuestas_id)
                                    ? rUser.respuestaCorrecta.respuestas_id
                                    : null;

                                let isCorrect = (correctId && (correctId == rUser.respuesta_id));

                                if(!sectionsData[tituloSeccion]) {
                                    sectionsData[tituloSeccion] = { correct: 0, incorrect: 0 };
                                }

                                if(correctId) {
                                    if(isCorrect) {
                                        sectionsData[tituloSeccion].correct++;
                                    } else {
                                        sectionsData[tituloSeccion].incorrect++;
                                    }
                                } else {
                                    // Si no hay respuesta correcta registrada,
                                    // podríamos contarla como "no evaluada" o incorrecta.
                                    sectionsData[tituloSeccion].incorrect++;
                                }
                            });

                            // Construimos los canvas de Chart.js si hay datos
                            if(Object.keys(sectionsData).length > 0){
                                let graficasHtml = `<h4 class="mt-5">Gráficas por Sección</h4>`;

                                $.each(sectionsData, function(sectionName, counts){
                                    let canvasId = 'chart_' + sectionName.replace(/\s+/g, '_');
                                    graficasHtml += `
                                <div class="card my-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">${sectionName}</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="${canvasId}" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            `;
                                });
                                $("#graficasContainer").append(graficasHtml);

                                // Crear la gráfica para cada sección
                                $.each(sectionsData, function(sectionName, counts){
                                    let canvasId = 'chart_' + sectionName.replace(/\s+/g, '_');
                                    let ctx = document.getElementById(canvasId).getContext('2d');
                                    new Chart(ctx, {
                                        type: 'pie',
                                        data: {
                                            labels: ['Correctas', 'Incorrectas'],
                                            datasets: [{
                                                data: [counts.correct, counts.incorrect],
                                                backgroundColor: ['#28a745', '#dc3545']
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            plugins: {
                                                legend: {
                                                    position: 'top'
                                                },
                                                title: {
                                                    display: false
                                                }
                                            }
                                        }
                                    });
                                });
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
