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
                            <h4 class="white-text">Mis evaluaciones</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabla de Evaluaciones -->
        <div class="row">
            <div class="col s12">
                <div class="card dark-card z-depth-3">
                    <div class="card-datatable table-responsive">
                        <table id="EvaluacionesTable" class="dt-responsive table table-bordered">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Cuestionario</th>
                                <th>Tiempo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            @if ($categorias->isEmpty())
                                <p>No tienes evaluaciones asignadas por el momento.</p>
                            @else
                            <tbody>
                                @foreach ($categorias as $categoria)
                                    @foreach ($categoria->secciones as $seccion)
                                        <tr>
                                            <td class="text-truncate">
                                                <span class="text-heading">{{ $seccion->titulo }}</span>
                                            </td>
                                            <td class="text-truncate">
                                                <i class="ri-question-answer-line me-2" width="22" height="22"></i>
                                                <span class="text-heading">{{ $categoria->titulo_cuestionario }}</span>
                                            </td>
                                            <td class="text-truncate">
                                                <span class="text-heading">{{ $seccion->tiempo_evaluacion }}</span>
                                            </td>
                                            <td class="text-truncate">
                                                @if (in_array($seccion->id, $seccionesCompletadas))
                                                    <span class="badge bg-success">Completada</span>
                                                @else
                                                    <span class="badge bg-warning">Pendiente</span>
                                                @endif
                                            </td>
                                            <td class="text-truncate">
                                                @if (in_array($seccion->id, $seccionesCompletadas))
                                                    <!-- Botón deshabilitado -->
                                                    <a href="" class="btn btn-sm btn-secondary" tabindex="-1" aria-disabled="true" style="pointer-events: none; cursor: not-allowed;">
                                                        Evaluación Completada
                                                    </a>
                                                @else
                                                    <!-- Botón activo -->
                                                    <a href="{{ route('permisos-preliminares') }}?categoria_id={{ $categoria->id }}&seccion_id={{ $seccion->id }}" class="btn btn-sm btn-primary">
                                                        Iniciar Evaluación
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                            
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- jQuery y Scripts adicionales -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <style>
        #EvaluacionesTable {
            width: 100% !important;
            table-layout: auto;
        }

        #EvaluacionesTable td:nth-child(4),
        #EvaluacionesTable td:nth-child(5),
        #EvaluacionesTable th:nth-child(4),
        #EvaluacionesTable th:nth-child(5) {
            width: auto !important;  /* Ajusta automáticamente el ancho de las columnas 'Estado' y 'Acciones' */
            white-space: nowrap;     /* Evita que el texto de esas celdas se divida en múltiples líneas */
        }

        table.dt-responsive th, table.dt-responsive td {
            text-overflow: unset; /* Elimina los puntos suspensivos */
            overflow: unset; /* Elimina el ocultamiento del texto */
            white-space: normal; /* Permite que el texto ocupe múltiples líneas si es necesario */
        }

        .table-responsive {
            overflow-x: visible; /* Evita el scroll horizontal */
        }

    </style>

    <script>
        $(document).ready(function() {
            $('#EvaluacionesTable').DataTable({
                responsive: true,
                "searching": false,
                "paging": false,
                "info": false,
                "lengthChange": false
            });
        });
    </script>
@endsection
