@forelse ($tests as $test)
<tr>
    <td>{{ $test['titulo'] }}</td>
    <td>{{ $test['tipo'] }}</td>
    <td>{{ $test['categoria'] }}</td>
    <td>{{ $test['deleted_at'] ?? 'N/D' }}</td>
    <td>
        <button type="button"
                class="btn btn-azul waves-effect waves-light tooltipped restore-btn"
                style="margin: 8px; margin-left: 0px"
                data-position="top"
                data-tooltip="Restaurar"
                title="Restaurar"
                data-id="{{ $test['id'] }}">
            <i class="ri-inbox-unarchive-fill"></i>
        </button>
        <button type="button"
                class="btn btn-rojo waves-effect waves-light tooltipped force-delete-btn"
                style="margin: 8px; margin-left: 0px"
                data-position="top"
                data-tooltip="Eliminar definitivamente"
                title="Eliminar definitivamente"
                data-id="{{ $test['id'] }}">
            <i class="ri-delete-bin-6-line"></i>
        </button>

    </td>
</tr>
@empty
<tr><td colspan="5">No hay pruebas eliminadas.</td></tr>
@endforelse