@extends('layout.app')
@section('title', 'Gestión de Evaluaciones')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card-panel gradient-card">
                <div class="row valign-wrapper mb-0">
                    <div class="col s6">
                        <h4 class="white-text"><i class="material-icons left">assignment</i>Gestión de Evaluaciones</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de aplicaciones -->
    <div class="row">
        <div class="col s12">
            <div class="card z-depth-3">
                <div class="card-content">
                    <table id="aplicacionesTable" class="highlight responsive-table centered striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Vacante</th>
                                <th>Código</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Llenado vía AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .gradient-card {
        background: linear-gradient(to right, #1976d2, #64b5f6);
        border-radius: 8px;
        margin-top: 20px;
    }

    .btn {
        margin: 0 5px;
    }

    .card {
        border-radius: 8px;
        margin-top: 10px;
    }
</style>
@endsection

@section('scripts')
<script>
    
    $(document).ready(function () {
        const tablaAplicaciones = $('#aplicacionesTable').DataTable({
            ajax: "{{ route('admin.aplicaciones.datatable') }}",
            dataSrc: 'data',
            columns: [
                { data: 'id' },
                { data: 'nombre' },
                { data: 'email' },
                { data: 'vacante' },
                { data: 'codigo' },
                {
                    data: null,
                    render: function (data, type, row) {
                        console.log(row);
                        return `
                            <a class="btn-small green darken-1 asignar-evaluacion-btn tooltipped" data-id="${row.user_id}" data-tooltip="Añadir evaluación">
                                <i class="material-icons">add</i>
                            </a>
                            <a class="btn-small blue darken-1 ver-evaluaciones-btn tooltipped" data-id="${row.user_id}" data-tooltip="Ver evaluaciones">
                                <i class="material-icons">visibility</i>
                            </a>
                            <a class="btn-small red darken-1 eliminar-aplicacion-btn tooltipped" data-id="${row.id}" data-tooltip="Eliminar aplicación">
                                <i class="material-icons">delete</i>
                            </a>
                        `;
                    }
                }
            ],
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
            },
            drawCallback: function () {
                $('.tooltipped').tooltip();
            }
        });

        //ver las evalauciones ya asignadas a un usuario
        $(document).on('click', '.ver-evaluaciones-btn', function () {
            const userId = $(this).data('id');

            $.get(`/admin/evaluaciones/usuario/${userId}`, function (categorias) {
                if (!categorias || categorias.length === 0) {
                    Swal.fire('Evaluaciones', 'Este usuario no tiene evaluaciones asignadas.', 'info');
                    return;
                }

                const checkboxes = categorias.map(cat => `
                    <div style="text-align:left;">
                        <label>
                            <input type="checkbox" class="filled-in eval-checkbox" value="${cat.id}" />
                            <span>${cat.titulo_cuestionario}</span>
                        </label>
                    </div>
                `).join('');

                Swal.fire({
                    title: 'Evaluaciones asignadas',
                    html: `
                        <p>Selecciona las evaluaciones que deseas eliminar:</p>
                        ${checkboxes}
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Eliminar seleccionadas',
                    cancelButtonText: 'Cerrar',
                    preConfirm: () => {
                        const seleccionadas = $('.eval-checkbox:checked').map(function () {
                            return $(this).val();
                        }).get();

                        if (seleccionadas.length === 0) {
                            Swal.showValidationMessage('Debes seleccionar al menos una evaluación para eliminar.');
                            return false;
                        }

                        Swal.showLoading();

                        return $.ajax({
                            url: `/admin/evaluaciones/eliminar`,
                            method: 'POST',
                            data: {
                                user_id: userId,
                                categorias: seleccionadas,
                                _token: "{{ csrf_token() }}"
                            }
                        }).then(response => {
                            Swal.hideLoading();

                            // Quitar checkboxes eliminados del DOM
                            seleccionadas.forEach(id => {
                                $(`.eval-checkbox[value="${id}"]`).closest('div').remove();
                            });

                            return false; // NO cerrar el modal
                        }).catch(() => {
                            Swal.hideLoading();
                            Swal.showValidationMessage('Error al eliminar evaluaciones.');
                            return false;
                        });
                    }
                });
            }).fail(function () {
                Swal.fire('Error', 'No se pudo obtener la lista de evaluaciones.', 'error');
            });
        });

        //asignar una evalaución a una aplicacion
        $(document).on('click', '.asignar-evaluacion-btn', function () {
            const userId = $(this).data('id');

            $.get("{{ route('admin.categorias.listar') }}", function (categorias) {
                let opciones = categorias.map(cat => `<option value="${cat.id}">${cat.titulo_cuestionario}</option>`).join('');

                Swal.fire({
                    title: 'Asignar Evaluaciones',
                    html: `
                        <p>Selecciona una o varias categorías:</p>
                        <select id="categoriasSelect" class="browser-default" multiple style="width:100%;height:150px;">
                            ${opciones}
                        </select>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Asignar',
                    cancelButtonText: 'Cancelar',
                    preConfirm: () => {
                        const seleccionadas = $('#categoriasSelect').val();

                        if (!seleccionadas || seleccionadas.length === 0) {
                            Swal.showValidationMessage('Debes seleccionar al menos una categoría');
                            return false;
                        }

                        console.log({
                            user_id: userId,
                            categorias: seleccionadas
                        });

                        $.ajax({
                            url: "http://practicas-psico/admin/evaluaciones/asignar",
                            method: 'POST',
                            data: {
                                user_id: userId,
                                categorias: seleccionadas,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                console.log(response); // Para ver cómo es la respuesta

                                if (response && response.success) {
                                    Swal.fire('Éxito', 'Las evaluaciones fueron asignadas correctamente.', 'success');
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: '¡Oops!',
                                        text: response.message || 'Error al asignar evaluaciones'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                Swal.showValidationMessage('Error al asignar evaluaciones');
                                console.log('Error:', status, error);
                            }
                        });

                    }

                });
            });
        });

        //eliminar un registro con código/aplicacino. (El candidato ya no tiene que hacer las pruebas)
        $(document).on('click', '.eliminar-aplicacion-btn', function () {
            const aplicacionId = $(this).data('id');

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción eliminará la aplicación del candidato.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/aplicaciones/${aplicacionId}`,
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire('Eliminado', 'La aplicación ha sido eliminada.', 'success');
                            $('#aplicacionesTable').DataTable().ajax.reload();
                        },
                        error: function () {
                            Swal.fire('Error', 'No se pudo eliminar la aplicación.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>
@endsection