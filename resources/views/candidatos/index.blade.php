@extends('layout.app')
@section('title', 'Gestión de Candidatos')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="card-panel gradient-card">
                <div class="row valign-wrapper mb-0">
                    <div class="col s6">
                        <h4 class="white-text"><i class="material-icons left">person</i>Gestión de Candidatos</h4>
                    </div>
                    <div class="col s6 right-align">
                        <a id="registrarCandidatoBtn" class="waves-effect waves-light btn-large green">
                            <i class="material-icons left">person_add</i>Registrar Candidato
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Tabla de candidatos -->
    <div class="row">
        <div class="col s12">
            <div class="card z-depth-3">
                <div class="card-content">
                    <table id="candidatosTable" class="highlight responsive-table centered striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Fecha Nacimiento</th>
                                <th>Género</th>
                                <th>Código Postal</th>
                                <th>Celular</th>
                                <th>Fecha Registro</th>
                                <th>Compañía</th>
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

<!-- ESTILOS -->
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
    .inline-input {
        border: none;
        border-bottom: 1px solid #2196F3;
        outline: none;
        font-size: inherit;
        background-color: #f3f3f3;
    }
    .editable {
        cursor: pointer;
    }
</style>


<!-- SCRIPT -->
<script>
    $(document).ready(function () {
        const table = $('#candidatosTable').DataTable({
            ajax: "{{ route('candidatos.datatable') }}",
            dataSrc: 'data',
            columns: [
                { data: 'id' },
                {
                    data: 'name',
                    render: function (data, type, row) {
                        return `<span class="editable" data-id="${row.id}" data-field="name">${data}</span>`;
                    }
                },
                {
                    data: 'email',
                    render: function (data, type, row) {
                        return `<span class="editable" data-id="${row.id}" data-field="email">${data}</span>`;
                    }
                },
                {
                    data: 'fecha_nacimiento',
                    render: function (data) {
                        return data ? new Date(data).toLocaleDateString() : '-';
                    }
                },
                { 
                    data: 'genero',
                    render: function (data, type, row) {
                        return `<span class="editable" data-id="${row.id}" data-field="genero">${data ?? '-'}</span>`;
                    }
                },
                { 
                    data: 'codigo_postal',
                    render: function (data, type, row) {
                        return `<span class="editable" data-id="${row.id}" data-field="codigo_postal">${data ?? '-'}</span>`;
                    }
                },
                { 
                    data: 'celular',
                    render: function (data, type, row) {
                        return `<span class="editable" data-id="${row.id}" data-field="celular">${data ?? '-'}</span>`;
                    }
                },
                {
                    data: 'created_at',
                    render: function (data) {
                        return new Date(data).toLocaleString();
                    }
                },
                { 
                    data: 'company_name',
                    render: function (data) {
                        return data ?? '-';
                    }
                },
                {
                    data: null,
                    render: function (data, type, row) {
                        let botones = `
                            <a class="btn-floating btn-small red delete-btn tooltipped" data-id="${row.id}" data-tooltip="Eliminar">
                                <i class="material-icons">delete</i>
                            </a>
                        `;

                        @auth
                            @if ((bool) auth()->user()->is_admin && !(bool) auth()->user()->is_super_admin)
                                botones += `
                                    <a class="btn-floating btn-small blue generar-codigo-btn tooltipped" data-id="${row.id}" data-tooltip="Generar Código">
                                        <i class="material-icons">vpn_key</i>
                                    </a>
                                `;
                            @endif
                        @endauth

                        return botones;
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

        // Hacer registro de candidato editable con doble clic
        $(document).on('dblclick', '.editable', function () {
            const span = $(this);
            const original = span.text();
            const field = span.data('field');
            const id = span.data('id');

            const input = $('<input type="text" class="inline-input"/>')
                .val(original)
                .css('width', '100%');

            span.replaceWith(input);
            input.focus();

            input.on('blur keydown', function (e) {
                if (e.type === 'blur' || e.key === 'Enter') {
                    const newValue = input.val();

                    if (newValue !== original) {
                        $.ajax({
                            url: `/admin/candidatos/${id}`,
                            method: 'PUT',
                            data: {
                                _token: "{{ csrf_token() }}",
                                [field]: newValue
                            },
                            success: function () {
                                const nuevoSpan = $(`<span class="editable" data-id="${id}" data-field="${field}">${newValue}</span>`);
                                input.replaceWith(nuevoSpan);
                                M.toast({ html: 'Actualizado correctamente', classes: 'green' });
                            },
                            error: function () {
                                input.replaceWith(`<span class="editable" data-id="${id}" data-field="${field}">${original}</span>`);
                                M.toast({ html: 'Error al actualizar', classes: 'red' });
                            }
                        });
                    } else {
                        input.replaceWith(`<span class="editable" data-id="${id}" data-field="${field}">${original}</span>`);
                    }
                }
            });
        });

        //Ir a formulario de registro de candidato
        $('#registrarCandidatoBtn').click(function () {
            window.location.href = "{{ route('candidatos.crear') }}";
        });


        //editar candidato        
        $(document).on('click', '.edit-btn', function () {
            const id = $(this).data('id');

            $.get(`/candidatos/${id}`, function (data) {
                Swal.fire({
                    title: 'Editar Candidato',
                    html: `
                        <input id="edit-nombre" class="swal2-input" placeholder="Nombre" value="${data.name}">
                        <input id="edit-email" class="swal2-input" placeholder="Email" value="${data.email}">
                    `,
                    confirmButtonText: 'Guardar',
                    showCancelButton: true,
                    preConfirm: () => {
                        const name = $('#edit-nombre').val().trim();
                        const email = $('#edit-email').val().trim();

                        if (!name || !email) {
                            Swal.showValidationMessage('Todos los campos son requeridos');
                            return false;
                        }
                        return $.ajax({
                            url: `/admin/candidatos/${id}`,
                            method: 'PUT',
                            data: {
                                name: name,
                                email: email,
                                _token: "{{ csrf_token() }}"
                            }
                        }).then(response => {
                            table.ajax.reload();
                            return response;
                        }).catch(() => {
                            Swal.showValidationMessage('Error al guardar');
                        });
                    }
                });
            });
        });


        //eliminar candidato
        $(document).on('click', '.delete-btn', function () {
            const id = $(this).data('id');

            Swal.fire({
                title: '¿Eliminar candidato?',
                text: 'Esta acción no se puede deshacer',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then(result => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/candidatos/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function () {
                            table.ajax.reload();
                            Swal.fire('Eliminado', 'Candidato eliminado correctamente', 'success');
                        },
                        error: function () {
                            Swal.fire('Error', 'No se pudo eliminar el candidato', 'error');
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
        // generar código individual
        $(document).on('click', '.generar-codigo-btn', function () {
        const userId = $(this).data('id');
        Swal.fire({
            title: 'Generar código',
            html: `
                <p>Introduce el nombre de la vacante para este candidato:</p>
                <input id="vacanteInput" class="swal2-input" placeholder="Vacante">
            `,
            showCancelButton: true,
            confirmButtonText: 'Generar',
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                const vacante = $('#vacanteInput').val().trim();
                if (!vacante) {
                    Swal.showValidationMessage('La vacante es obligatoria');
                    return false;
                }

                return $.post("{{ route('guardar.codigo') }}", {
                    user_id: userId,
                    vacante: vacante,
                    _token: "{{ csrf_token() }}"
                })
                .then(response => {
                    return response;
                })
                .catch(xhr => {
                    if (xhr.status === 422) {
                        const errores = xhr.responseJSON?.errors;
                        console.error("Errores de validación:", errores);
                        Swal.showValidationMessage(
                            Object.values(errores).flat().join('<br>')
                        );
                    } else {
                        console.error(xhr);
                        Swal.showValidationMessage('Error inesperado al generar el código');
                    }
                });
            }
        }).then(result => {
            if (result.isConfirmed && result.value) {
                const code = result.value.code;
                Swal.fire({
                    title: '¡Código generado!',
                    html: `
                        <p><strong>Código:</strong></p>
                        <input type="text" id="codigoGenerado" class="swal2-input" value="${code}" readonly>
                        <button id="btnCopiarCodigo" class="swal2-confirm swal2-styled">Copiar</button>
                    `,
                    showConfirmButton: false,
                    didOpen: () => {
                        $('#btnCopiarCodigo').click(function () {
                            const input = document.getElementById('codigoGenerado');
                            input.select();
                            input.setSelectionRange(0, 99999); // Para móviles

                            try {
                                const copiado = document.execCommand('copy');
                                if (copiado) {
                                    Swal.fire('Copiado', 'Código copiado al portapapeles', 'success');
                                } else {
                                    Swal.fire('Ups', 'No se pudo copiar automáticamente', 'warning');
                                }
                            } catch (err) {
                                console.error('Error al copiar:', err);
                                Swal.fire('Error', 'Hubo un problema al copiar el código', 'error');
                            }
                        });
                    }
                });
            }
        });
    });


    });   
</script>
@endsection
