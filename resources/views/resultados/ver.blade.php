@extends('layout.admin')

@section('content')
<div class="container my-4">
    <div class="row">
        <div class="col s12">
            <div class="card-panel dark-gradient">
                <div class="row valign-wrapper mb-0">
                    <div class="col s8">
                        <h4 class="white-text">Resultados del Candidato</h4>
                    </div>
                    <div class="col s4 right-align">
                        <a href="{{ route('resultados.index') }}" class="btn btn-secondary">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingResults" class="center-align" style="padding: 40px;">
        <div class="preloader-wrapper active">
            <div class="spinner-layer spinner-blue-only">
                <div class="circle-clipper left"><div class="circle"></div></div>
                <div class="gap-patch"><div class="circle"></div></div>
                <div class="circle-clipper right"><div class="circle"></div></div>
            </div>
        </div>
        <p>Cargando resultados...</p>
    </div>

    <div id="resultsContent" style="display: none;">
        <div class="card shadow-lg mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label class="fw-bold">Nombre:</label>
                        <p id="candidatoNombre"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Correo:</label>
                        <p id="candidatoEmail"></p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold">Vacante:</label>
                        <p id="candidatoVacante"></p>
                    </div>
                </div>
            </div>
        </div>

        <div id="scoresContainer"></div>
    </div>

    <div id="errorContainer" style="display: none;">
        <div class="alert alert-danger" id="errorMessage"></div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
<script>
$(document).ready(function() {
    const candidatoId = @json($id);

    $.ajax({
        url: "{{ route('admin.buscar.resultados') }}",
        type: "GET",
        data: { user_id: candidatoId },
        dataType: "json",
        success: function(response) {
            $("#loadingResults").hide();

            if (response.status === 'success') {
                $("#resultsContent").show();
                $("#candidatoNombre").text(response.usuario.name);
                $("#candidatoEmail").text(response.usuario.email);
                $("#candidatoVacante").text(response.aplicacion ? response.aplicacion.vacancy : '---');

                if (response.scores && response.scores.length > 0) {
                    response.scores.forEach(function(testResult) {
                        let html = `<div class="card shadow-lg mb-3">
                            <div class="card-header"><h5>${testResult.test_title}</h5></div>
                            <div class="card-body">`;

                        if (testResult.metricas) {
                            testResult.metricas.forEach(function(m) {
                                const color = m.puntuacion >= 70 ? '#4caf50' : (m.puntuacion >= 40 ? '#ff9800' : '#f44336');
                                html += `
                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between">
                                            <strong>${m.titulo}</strong>
                                            <span>${m.puntaje_bruto}/${m.maximo} (${m.puntuacion}%)</span>
                                        </div>
                                        <div class="progress" style="height: 20px; background: #e0e0e0; border-radius: 10px; margin-top: 5px;">
                                            <div style="width: ${m.puntuacion}%; background: ${color}; height: 100%; border-radius: 10px; transition: width 0.5s;"></div>
                                        </div>
                                        <div class="d-flex justify-content-between" style="font-size: 0.8em; color: #888;">
                                            <span>${m.etiqueta_izq}</span>
                                            <span>${m.etiqueta_der}</span>
                                        </div>
                                        <p style="font-size: 0.9em; color: #666;">${m.descripcion}</p>
                                    </div>`;
                            });
                        }

                        html += `</div></div>`;
                        $("#scoresContainer").append(html);
                    });
                } else {
                    $("#scoresContainer").html('<div class="alert alert-info">No se encontraron resultados de scoring para este candidato.</div>');
                }
            }
        },
        error: function(xhr) {
            $("#loadingResults").hide();
            $("#errorContainer").show();
            let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Error al cargar los resultados.';
            $("#errorMessage").text(msg);
        }
    });
});
</script>
@endsection
