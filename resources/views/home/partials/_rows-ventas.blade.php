@php $totals = array_fill_keys(['cuentas','clientes','venta','iva','subtotal','efectivo','propina','tarjeta','descuento'], 0); @endphp
@foreach ($cortes as $corte)
    @php
        $totals['clientes']  += $corte->total_clientes;
        $totals['venta']     += $corte->total_venta;
        $totals['iva']       += $corte->total_iva;
        $totals['subtotal']  += $corte->total_subtotal;
        $totals['efectivo']  += $corte->total_efectivo;
        $totals['propina']   += $corte->total_propina;
        $totals['tarjeta']   += $corte->total_tarjeta;
        $totals['descuento'] += $corte->total_descuento;
    @endphp
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
    <tfoot style="background-color: {{ $restaurant->color_secondary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}" >
        <tr class="totals-row">
            <td>TOTAL</td>
            <td>{{ $totals['clientes'] }}</td>
            <td>${{ number_format($totals['venta'], 2) }}</td>
            <td>${{ number_format($totals['iva'], 2) }}</td>
            <td>${{ number_format($totals['subtotal'], 2) }}</td>
            <td>${{ number_format($totals['efectivo'], 2) }}</td>
            <td>${{ number_format($totals['propina'], 2) }}</td>
            <td>${{ number_format($totals['tarjeta'], 2) }}</td>
            <td>${{ number_format($totals['descuento'], 2) }}</td>
        </tr>
    </tfoot>
    