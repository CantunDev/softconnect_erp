@foreach ($cortes as $corte)
    <tr>
        <td>
            {{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd')) }}
            {{ \Carbon\Carbon::parse($corte->dia)->isoFormat('D MMM') }}
        </td>
        <td class="price text-center">{{ $alimentos = $corte->total_alimentos }}</td>
        <td class="price text-center">{{ $corte->total_dalimentos }}</td>
        <td class="percentage text-center">{{ $corte->total_venta > 0 ? round((($alimentos * 100) / $corte->total_venta), 2) : 0 }}</td>
        <td class="price text-center">{{ $bebidas = $corte->total_bebidas }}</td>
        <td class="price text-center">{{ $corte->total_dbebidas }}</td>
        <td class="percentage text-center">{{ $corte->total_venta > 0 ? round((($bebidas * 100) / $corte->total_venta), 2) : 0 }}</td>
    </tr>
@endforeach