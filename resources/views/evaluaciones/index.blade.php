@extends('layout.app')
@section('title', 'Gestión de Aplicaciones')
@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card-panel gradient-card">
                <div class="row valign-wrapper mb-0">
                    <div class="col s8">
                        <h4 class="white-text"><i class="material-icons left">work</i>Gestión de Aplicaciones</h4>
                    </div>
                    <div class="col s4 right-align">
                        <a id="createAplicacionBtn" class="waves-effect waves-light btn-large pulse">
                            <i class="material-icons left">add_circle</i>Nueva Aplicación
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla --}}
    <div class="row">
        <div class="col s12">
            <div class="card z-depth-3">
                <div class="card-content">
                    <table id="aplicacionesTable" class="highlight responsive-table centered striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Vacante</th>
                                <th>Código</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .gradient-card {
        background: linear-gradient(to right, #1e88e5, #42a5f5);
        border-radius: 8px;
        margin-top: 20px;
    }
</style>

<script>
    $(document).ready(function() {
        var table = $('#aplicacionesTable').DataTable({
            ajax: "{{ route('aplicaciones.datatable') }}",
            columns: [
                { data: 'id' },
                { data: 'usuario.nombre' },
                { data: 'vacante' },
                { data: 'codigo' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <a class="btn-floating blue edit-btn tooltipped" data-id="${row.id}" data-tooltip="Editar">
                                <i class="material-icons">edit</i>
                            </a>
                            <a class="btn-floating red delete-btn tooltipped" data-id="${row.id}" data-tooltip="Eliminar">
                                <i class="material-icons">delete</i>
                            </a>
                        `;
                    }
                }
            ],
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
            },
            drawCallback: function() {
                $('.tooltipped').tooltip();
            }
        });

        function reloadTable() {
            table.ajax.reload();
        }

        // Crear Aplicación
        $('#createAplicacionBtn').click(function() {
            $.when(
                $.get("{{ route('usuarios.all') }}"),
                $.get("{{ route('vacantes.all') }}")
            ).done(function(usuariosRes, vacantesRes) {
                const usuarios = usuariosRes[0];
                const vacantes = vacantesRes[0];

                let userOptions = '<option disabled selected>Seleccionar usuario</option>';
                usuarios.forEach(user => {
                    userOptions += `<option value="${user.id}">${user.nombre}</option>`;
                });

                let vacanteOptions = '<option disabled selected>Seleccionar vacante</option>';
                vacantes.forEach(vac => {
                    vacanteOptions += `<option value="${vac.id}">${vac.titulo}</option>`;
                });

                Swal.fire({
                    title: 'Nueva Aplicación',
                    html: `
                        <div class="input-field">
                            <select id="user_id" class="browser-default">${userOptions}</select>
                        </div>
                        <div class="input-field">
                            <select id="vacante" class="browser-default">${vacanteOptions}</select>
                        </div>
                        <div class="input-field">
                            <input id="codigo" type="text" placeholder="Código generado">
                        </div>
                    `,
                    confirmButtonText: 'Guardar',
                    showCancelButton: true,
                    didOpen: () => {
                        $('select').formSelect();
                    },
                    preConfirm: () => {
                        return {
                            user_id: $('#user_id').val(),
                            vacante: $('#vacante').val(),
                            codigo: $('#codigo').val()
                        }
                    }
                }).then(result => {
                    if (result.isConfirmed) {
                        $.post("{{ route('aplicaciones.store') }}", result.value, function(res) {
                            Swal.fire('¡Guardado!', res.message, 'success');
                            reloadTable();
                        }).fail(err => {
                            Swal.fire('Error', 'No se pudo guardar la aplicación.', 'error');
                        });
                    }
                });
            });
        });

    });
</script>
@endsection
