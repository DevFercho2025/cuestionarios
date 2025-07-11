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
                data-id="{{ $test['id'] }}">
            <i class="ri-pencil-line"></i>
        </button>
    </td>
</tr>
@empty
<tr><td colspan="5">No hay pruebas eliminadas.</td></tr>
@endforelse