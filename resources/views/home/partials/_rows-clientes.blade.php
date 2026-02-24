@foreach ($cortes as $corte)
    <tr>
        <td>
            {{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd')) }}
            {{ \Carbon\Carbon::parse($corte->dia)->isoFormat('D MMM') }}
        </td>
        <td class="text-center">{{ $corte->total_cuentas }}</td>
        <td class="text-center">{{ $corte->total_clientes }}</td>
        <td class="text-center price">
            {{ $corte->total_clientes > 0 ? round($corte->total_venta / $corte->total_clientes, 2) : 0 }}
        </td>
    </tr>
@endforeach