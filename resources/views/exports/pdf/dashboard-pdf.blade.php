<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 4;
            padding: 1;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #333333;
            background: #ffffff;
            margin: 0;
            padding: 25px;
        }

        .report-header {
            margin-bottom: 25px;
            border-bottom: 2px solid {{ $restaurant->color_primary ?? '#333333' }};
            padding-bottom: 10px;
        }

        .report-title {
            font-size: 24px;
            font-weight: 600;
            color: {{ $restaurant->color_secondary ?? '#333333' }};
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .report-subtitle {
            font-size: 11px;
            color: #666666;
            font-style: italic;
            margin-bottom: 10px;
        }

        .report-description {
            font-size: 9px;
            color: #555555;
            line-height: 1.6;
            margin-bottom: 15px;
            max-width: 80%;
        }

        /* Información del reporte */
        .report-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 8px 0;
            border-bottom: 1px dashed #cccccc;
        }

        .report-info-left {
            font-size: 9px;
            color: {{ $restaurant->color_primary ?? '#333333' }};
            font-weight: 600;
        }

        .report-info-right {
            font-size: 9px;
            color: #666666;
        }

        .header h1 {
            font-size: 16px;
        }

        .header p {
            font-size: 10px;
            margin-top: 2px;
        }

        /* Logo */
        .logo-container {
            text-align: right;
            margin-bottom: 10px;
        }

        .logo {
            max-height: 50px;
            max-width: 180px;
        }

        .section-title {
            font-size: 11px;
            font-weight: bold;
            padding: 5px 8px;
            margin: 12px 0 5px;
            background-color: {{ $restaurant->color_secondary ?? '#555' }};
            color: {{ $restaurant->color_accent ?? '#fff' }};
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        th {
            background-color: {{ $restaurant->color_secondary ?? '#555' }};
            color: {{ $restaurant->color_accent ?? '#fff' }};
            padding: 4px 6px;
            text-align: center;
            font-size: 8px;
        }

        td {
            padding: 3px 6px;
            border-bottom: 1px solid #e0e0e0;
            text-align: right;
        }

        td:first-child {
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .totals-row {
            font-weight: bold;
            background-color: #f0f0f0 !important;
            border-top: 2px solid #ccc;
        }

        .chart-img {
            width: 100%;
            margin: 8px 0 14px;
            border-radius: 4px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    {{-- ENCABEZADO --}}
    <div class="report-header">
        <div class="logo-container">
            @if ($restaurant->logo)
                <img src="{{ public_path('/' . $restaurant->restaurant_file) }}" class="logo" alt="Logo">
            @endif
        </div>
        <div class="report-title">REPORTE DE VENTAS DE {{ strtoupper($restaurant->name) }}</div>
    </div>
    {{-- informacion del reporte  --}}
    <div class="report-info">
        <div class="report-info-right">Generado: {{ now()->isoFormat('D MMMM YYYY, HH:mm') }}</div>
    </div>
    {{-- TABLA VENTAS --}}
    <div class="table-title">VENTAS DEL PERÍODO</div>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Clientes</th>
                <th>Total</th>
                <th>IVA</th>
                <th>Subtotal</th>
                <th>Efectivo</th>
                <th>Propinas</th>
                <th>Tarjeta</th>
                <th>Descuento</th>
            </tr>
        </thead>
        <tbody>
            @php $totals = array_fill_keys(['cuentas','clientes','venta','iva','subtotal','efectivo','propina','tarjeta','descuento'], 0); @endphp
            @foreach ($cortes as $corte)
                @php
                    $totals['clientes'] += $corte->total_clientes;
                    $totals['venta'] += $corte->total_venta;
                    $totals['iva'] += $corte->total_iva;
                    $totals['subtotal'] += $corte->total_subtotal;
                    $totals['efectivo'] += $corte->total_efectivo;
                    $totals['propina'] += $corte->total_propina;
                    $totals['tarjeta'] += $corte->total_tarjeta;
                    $totals['descuento'] += $corte->total_descuento;
                @endphp
                <tr>
                    <td>{{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd D MMM')) }}</td>
                    <td>{{ $corte->total_clientes }}</td>
                    <td>${{ number_format($corte->total_venta, 2) }}</td>
                    <td>${{ number_format($corte->total_iva, 2) }}</td>
                    <td>${{ number_format($corte->total_subtotal, 2) }}</td>
                    <td>${{ number_format($corte->total_efectivo, 2) }}</td>
                    <td>${{ number_format($corte->total_propina, 2) }}</td>
                    <td>${{ number_format($corte->total_tarjeta, 2) }}</td>
                    <td>${{ number_format($corte->total_descuento, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
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
    </table>

    @if ($chart_ventas)
        <img src="{{ $chart_ventas }}" class="chart-img" alt="Gráfica Ventas">
    @endif

    <div class="page-break"></div>

    {{-- TABLA ALIMENTOS/BEBIDAS --}}
    <div class="header">
        <div>
            <h1>{{ $restaurant->name }}</h1>
            <p>Período: {{ $periodo }}</p>
        </div>
    </div>
    <div class="section-title"><i>🍽</i> Alimentos y Bebidas</div>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Total Ali</th>
                <th>Desc Ali</th>
                <th>% Ali</th>
                <th>Total Beb</th>
                <th>Desc Beb</th>
                <th>% Beb</th>
            </tr>
        </thead>
        <tbody>
            @php
                $tAli = 0;
                $tBeb = 0;
            @endphp
            @foreach ($cortes as $corte)
                @php
                    $ali = $corte->total_alimentos ?? 0;
                    $beb = $corte->total_bebidas ?? 0;
                    $tAli += $ali;
                    $tBeb += $beb;
                    $pctAli = $corte->total_venta > 0 ? round(($ali * 100) / $corte->total_venta, 2) : 0;
                    $pctBeb = $corte->total_venta > 0 ? round(($beb * 100) / $corte->total_venta, 2) : 0;
                @endphp
                <tr>
                    <td>{{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd D MMM')) }}</td>
                    <td>${{ number_format($ali, 2) }}</td>
                    <td>${{ number_format($corte->total_dalimentos ?? 0, 2) }}</td>
                    <td>{{ $pctAli }}%</td>
                    <td>${{ number_format($beb, 2) }}</td>
                    <td>${{ number_format($corte->total_dbebidas ?? 0, 2) }}</td>
                    <td>{{ $pctBeb }}%</td>
                </tr>
            @endforeach
            <tr class="totals-row">
                <td>TOTAL</td>
                <td>${{ number_format($tAli, 2) }}</td>
                <td>-</td>
                <td>-</td>
                <td>${{ number_format($tBeb, 2) }}</td>
                <td>-</td>
                <td>-</td>
            </tr>
        </tbody>
    </table>

    @if ($chart_food_drink)
        <img src="{{ $chart_food_drink }}" class="chart-img" alt="Gráfica Alimentos/Bebidas">
    @endif

    <div class="page-break"></div>

    {{-- TABLA CLIENTES --}}
    <div class="header">
        <div>
            <h1>{{ $restaurant->name }}</h1>
            <p>Período: {{ $periodo }}</p>
        </div>
    </div>
    <div class="section-title"><i>👥</i> Clientes y Ticket Promedio</div>
    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Cuentas</th>
                <th>Clientes</th>
                <th>Ticket Promedio</th>
                @if ($projections)
                    <th>Meta Ticket</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @php
                $tCuentas = 0;
                $tClientes = 0;
                $tVenta = 0;
            @endphp
            @foreach ($cortes as $corte)
                @php
                    $tCuentas += $corte->total_cuentas;
                    $tClientes += $corte->total_clientes;
                    $tVenta += $corte->total_venta;
                    $ticket = $corte->total_clientes > 0 ? round($corte->total_venta / $corte->total_clientes, 2) : 0;
                @endphp
                <tr>
                    <td>{{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd D MMM')) }}</td>
                    <td>{{ $corte->total_cuentas }}</td>
                    <td>{{ $corte->total_clientes }}</td>
                    <td>${{ number_format($ticket, 2) }}</td>
                    @if ($projections)
                        <td>${{ number_format($projections->projected_check ?? 0, 2) }}</td>
                    @endif
                </tr>
            @endforeach
            <tr class="totals-row">
                <td>TOTAL / PROM</td>
                <td>{{ $tCuentas }}</td>
                <td>{{ $tClientes }}</td>
                <td>${{ $tClientes > 0 ? number_format($tVenta / $tClientes, 2) : '0.00' }}</td>
                @if ($projections)
                    <td>-</td>
                @endif
            </tr>
        </tbody>
    </table>

    @if ($chart_clientes)
        <img src="{{ $chart_clientes }}" class="chart-img" alt="Gráfica Clientes">
    @endif

</body>

</html>
