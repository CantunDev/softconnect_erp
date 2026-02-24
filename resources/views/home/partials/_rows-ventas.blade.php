@foreach ($cortes as $corte)
    <tr>
        <td>
            {{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd')) }}
            {{ \Carbon\Carbon::parse($corte->dia)->isoFormat('D MMM') }}
        </td>
        <td class="text-center">{{ $corte->total_cuentas }}</td>
        <td class="price">{{ $corte->total_venta }}</td>
        <td class="price">{{ $corte->total_iva }}</td>
        <td class="price">{{ $corte->total_subtotal }}</td>
        <td class="price">{{ $corte->total_efectivo }}</td>
        <td class="price">{{ $corte->total_propina }}</td>
        <td class="price">{{ $corte->total_tarjeta }}</td>
        <td class="price">{{ $corte->total_descuento }}</td>
    </tr>
@endforeach