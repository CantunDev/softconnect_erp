@extends('layouts.master')
@section('title')
    Dashboard |
@endsection
@section('content')
    <x-date-component/>
   {{-- Selector de mes/año --}}
    <div class="row">
        <div class="col-xl-12">
            <div class="card" style="border: 2px solid #ccc">
                <div class="row mb-2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0">
                            <div class="card-body py-2">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div class="d-flex align-items-center gap-2 flex-wrap">
                                        <span class="fw-semibold text-muted small">Período:</span>
                                        <select id="sel-month" class="form-select form-select-sm w-auto">
                                            @foreach(range(1, 12) as $m)
                                                <option value="{{ $m }}" {{ $m == now()->month ? 'selected' : '' }}>
                                                    {{ \Carbon\Carbon::create()->month($m)->isoFormat('MMMM') }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <select id="sel-year" class="form-select form-select-sm w-auto">
                                            @foreach(range(now()->year - 2, now()->year) as $y)
                                                <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>
                                                    {{ $y }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <span class="text-muted small">ó</span>
                                        <div class="input-group input-group-sm w-auto">
                                            <span class="input-group-text bg-light">
                                                <i class="bx bx-calendar"></i>
                                            </span>
                                            <input type="text" id="start-date"
                                                class="form-control"
                                                placeholder="Desde"
                                                style="width:120px;" autocomplete="off">
                                        </div>
                                        <div class="input-group input-group-sm w-auto">
                                            <span class="input-group-text bg-light">
                                                <i class="bx bx-calendar"></i>
                                            </span>
                                            <input type="text" id="end-date"
                                                class="form-control"
                                                placeholder="Hasta"
                                                style="width:120px;" autocomplete="off">
                                        </div>
                                        <button id="btn-filter" class="btn btn-sm btn-primary">
                                            <i class="bx bx-filter-alt me-1"></i>Filtrar
                                        </button>
                                        <button id="btn-clear-range" class="btn btn-sm btn-outline-secondary d-none">
                                            <i class="bx bx-x me-1"></i>Limpiar
                                        </button>
                                        <span id="loading-indicator"
                                            class="spinner-border spinner-border-sm text-primary d-none"
                                            role="status">
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button id="btn-export-excel" class="btn btn-sm btn-outline-success">
                                            <i class="bx bx-file me-1"></i>Excel
                                        </button>
                                        <button id="btn-export-pdf" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bxs-file-pdf me-1"></i>PDF
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-4">Ventas del mes Restaurante</h4> --}}
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurant->color_primary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}"
                                    class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseV"
                                    aria-expanded="true" aria-controls="flush-collapseV">
                                    <span>
                                        <i class="bx bx-dollar font-size-12 align-middle me-1"></i>
                                        Ventas del mes {{ $restaurant->name }}
                                    </span>
                                </button>
                            </h2>
                        </div>
                        <div id="flush-collapseV" class="accordion-collapse collapse show mb-4"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                            <div class="row">
                                <div class="table-rep-plugin mt-2 ">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="datatable_ventas"
                                            class="table table-sm table-bordered dt-responsive nowrap w-100">
                                            <thead
                                                style="background-color: {{ $restaurant->color_secondary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}">
                                                <tr>
                                                    <th data-priority="1">Fecha</th>
                                                    <th data-priority="3" class="text-center">Clientes</th>
                                                    <th data-priority="1">Total</th>
                                                    <th data-priority="3">Iva</th>
                                                    <th data-priority="3">Subtotal</th>
                                                    <th data-priority="6">Efectivo</th>
                                                    <th data-priority="6">Propinas</th>
                                                    <th data-priority="6">Tarjeta</th>
                                                    <th data-priority="6">Descuento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @include('home.partials._rows-ventas')
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div id="chart" class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-4">Alimentos/Bebidas del mes Restaurante</h4> --}}
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurant->color_primary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}"
                                    class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseC"
                                    aria-expanded="true" aria-controls="flush-collapseC">
                                    <span>
                                        <i class="bx bx-restaurant font-size-12 align-middle me-1"></i>
                                        Alimentos/Bebidas del mes {{ $restaurant->name }}
                                    </span>
                                </button>
                            </h2>
                        </div>
                        <div id="flush-collapseC" class="accordion-collapse collapse show"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                            <div class="row">
                                <div class="table-rep-plugin mt-2 ">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="datatable_food_drink"
                                            class="table table-sm table-bordered dt-responsive nowrap w-100">
                                            <thead
                                                style="background-color: {{ $restaurant->color_secondary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}">
                                                <tr>
                                                    <th class="text-center" data-priority="1">Fecha</th>
                                                    <th class="text-center" data-priority="1">Total Ali</th>
                                                    <th class="text-center" data-priority="1">Desc Ali</th>
                                                    <th class="text-center" data-priority="1">% Ali</th>
                                                    <th class="text-center" data-priority="3">Total Beb</th>
                                                    <th class="text-center" data-priority="1">Desc Beb</th>
                                                    <th class="text-center" data-priority="3">% Beb</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @include('home.partials._rows-food-drink')
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div id="food_drink_line" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-4">Clientes del mes Restaurante</h4> --}}
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurant->color_primary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}"
                                    class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseCh"
                                    aria-expanded="true" aria-controls="flush-collapseCh">
                                    <span>
                                        <i class="bx bx-male font-size-12 align-middle me-1"></i>
                                        Clientes del mes {{ $restaurant->name }}
                                    </span>
                                </button>
                            </h2>
                        </div>
                        <div id="flush-collapseCh" class="accordion-collapse collapse show"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                            <div class="row">
                                <div class="table-rep-plugin mt-2 ">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="table_clientes"
                                            class="table table-sm table-bordered dt-responsive nowrap w-100">
                                            <thead
                                                style="background-color: {{ $restaurant->color_secondary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}">
                                                <tr>
                                                    <th data-priority="1">Fecha</th>
                                                    <th data-priority="3" class="text-center">Cuentas</th>
                                                    <th data-priority="3" class="text-center">Clientes</th>
                                                    <th data-priority="1">Ticket</th>
                                                    {{-- <th data-priority="1">Frecuencia de Compra</th> --}}
                                                    <th data-priority="1">Ocupacidad</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @include('home.partials._rows-clientes')

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div id="client_ticket" class="apex-charts" dir="ltr"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
@endsection
@section('js')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
    // ── Variables globales de charts ──────────────────────────────
    var chartVentas    = null;
    var chartFoodDrink = null;
    var chartClientes  = null;

    // ── Colores globales ──────────────────────────────────────────
    var primaryColor   = @json($restaurant->color_primary)   ? "#{{ ltrim($restaurant->color_primary, '#') }}"   : "#C62300";
    var secondaryColor = @json($restaurant->color_secondary) ? "#{{ ltrim($restaurant->color_secondary, '#') }}" : "#006A67";

    // ── Función global renderCharts ───────────────────────────────
    function renderCharts(data, primaryColor, secondaryColor) {

        // Destruir instancias anteriores
        if (chartVentas)    { chartVentas.destroy();    chartVentas    = null; document.querySelector("#chart").innerHTML = ''; }
        if (chartFoodDrink) { chartFoodDrink.destroy(); chartFoodDrink = null; document.querySelector("#food_drink_line").innerHTML = ''; }
        if (chartClientes)  { chartClientes.destroy();  chartClientes  = null; document.querySelector("#client_ticket").innerHTML = ''; }

        // ── Markers Ventas ────────────────────────────────────────
        var discreteVentas = data.days_total.map((val, index) => {
            let meta = data.projections_total[index] || 0;
            let avg  = data.projections_avg[index]   || 0;
            let color = '#00ff00';
            if (val < meta && val >= avg) color = '#FFA500';
            else if (val < avg)           color = '#FF0000';
            return { seriesIndex: 0, dataPointIndex: index, fillColor: color, strokeColor: '#000000', size: 6 };
        });

        // ── Chart Ventas ──────────────────────────────────────────
        chartVentas = new ApexCharts(document.querySelector("#chart"), {
            chart: { type: 'line', height: 350, zoom: { enabled: true }, toolbar: { show: true } },
            tooltip: { theme: 'dark' },
            plotOptions: { bar: { borderRadius: 10, dataLabels: { position: 'top' }, distributed: true } },
            colors: [primaryColor, '#56021F', '#003092'],
            dataLabels: {
                enabled: true,
                formatter: val => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(val),
                offsetY: -10,
                style: { fontSize: '12px', colors: [primaryColor] },
                background: { enabled: false }
            },
            stroke: { width: [5, 2, 2], curve: ['straight', 'monotoneCubic'] },
            series: [
                { name: 'Venta Real',      data: data.days_total },
                { name: 'Meta Vta Diaria', data: data.projections_total }
            ],
            xaxis: { categories: data.daysInMonth, axisBorder: { show: true }, tooltip: { enabled: true } },
            yaxis: { axisBorder: { show: true } },
            title: { text: 'Ventas de Restaurante', floating: true, offsetY: 330, align: 'center', style: { color: primaryColor } },
            markers: { size: [0, 5, 1, 1], discrete: discreteVentas },
            legend: { show: false }
        });
        chartVentas.render();

        // ── Chart Alimentos/Bebidas ───────────────────────────────
        chartFoodDrink = new ApexCharts(document.querySelector("#food_drink_line"), {
            series: [
                { name: 'Alimentos', data: data.days_total_food },
                { name: 'Bebidas',   data: data.days_total_drink }
            ],
            chart: {
                height: 350, type: 'line',
                dropShadow: { enabled: true, color: '#0000', top: 18, left: 7, blur: 10, opacity: 0.5 },
                zoom: { enabled: true }, toolbar: { show: true }
            },
            tooltip: { theme: 'dark' },
            colors: [primaryColor, secondaryColor],
            dataLabels: {
                enabled: true,
                formatter: val => new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(val),
                background: { enabled: false }
            },
            stroke: { curve: 'smooth' },
            grid: { borderColor: '#e7e7e7', row: { opacity: 0.5 } },
            markers: { size: 1 },
            xaxis: { categories: data.daysInMonth },
            legend: { position: 'top', horizontalAlign: 'right', floating: true, offsetY: -25, offsetX: -5 }
        });
        chartFoodDrink.render();

        // ── Markers Clientes ──────────────────────────────────────
        var discreteClientes = data.days_total_ticket.map((val, index) => {
            let meta = data.projections_check[index]     || 0;
            let avg  = data.projections_check_avg[index] || 0;
            let color = '#00ff00';
            if (val < meta && val >= avg) color = '#FFA500';
            else if (val < avg)           color = '#FF0000';
            return { seriesIndex: 1, dataPointIndex: index, fillColor: color, strokeColor: '#000000', size: 6 };
        });

        // ── Chart Clientes/Ticket ─────────────────────────────────
        chartClientes = new ApexCharts(document.querySelector("#client_ticket"), {
            chart: { height: 350, type: 'line', stacked: false },
            colors: [primaryColor, secondaryColor, '#56021F', '#003092'],
            series: [
                { name: 'Clientes',     type: 'column', data: data.days_total_client },
                { name: 'Tkt Promedio', type: 'line',   data: data.days_total_ticket },
                { name: 'Meta Tkt Pro', type: 'line',   data: data.projections_check },
                { name: 'Tkt Pro',      type: 'line',   data: data.projections_check_avg }
            ],
            stroke: { width: [0, 5, 2, 2], curve: ['straight', 'monotoneCubic', 'straight'] },
            markers: { size: [1, 5, 1, 1], discrete: discreteClientes },
            plotOptions: { bar: { columnWidth: '40%' } },
            xaxis: { categories: data.daysInMonth, title: { text: 'Días' } },
            yaxis: [
                {
                    seriesName: 'Clientes',
                    axisTicks: { show: true },
                    axisBorder: { show: true },
                    labels: { formatter: v => Math.round(v) }
                },
                {
                    opposite: true,
                    seriesName: 'Tkt Promedio',
                    labels: { formatter: v => '$' + v.toFixed(2) }
                }
            ],
            tooltip: {
                shared: true, intersect: false,
                y: {
                    formatter: (v, { seriesIndex }) => seriesIndex === 0
                        ? v + ' clientes'
                        : '$' + v.toFixed(2)
                }
            },
            legend: { show: false }
        });
        chartClientes.render();
    }

    // ── Render inicial con datos de Blade ─────────────────────────
    var initialData = {
        daysInMonth:           @json($daysInMonth),
        days_total:            @json($days_total),
        days_total_food:       @json($days_total_food),
        days_total_drink:      @json($days_total_drink),
        days_total_client:     @json($days_total_client),
        days_total_ticket:     @json($days_total_ticket),
        projections_total:     @json($projections_total),
        projections_avg:       @json($projections_avg),
        projections_check:     @json($projections_check),
        projections_check_avg: @json($projections_check_avg),
    };

    renderCharts(initialData, primaryColor, secondaryColor);
</script>

<script>
$(document).ready(function () {

    // ── Flatpickr ─────────────────────────────────────────────────
    var fpStart = flatpickr("#start-date", {
        locale: "es",
        dateFormat: "Y-m-d",
        disableMobile: true,
        onChange: function(selectedDates, dateStr) {
            fpEnd.set('minDate', dateStr);
            syncModeIndicator();
        }
    });

    var fpEnd = flatpickr("#end-date", {
        locale: "es",
        dateFormat: "Y-m-d",
        disableMobile: true,
        onChange: function(selectedDates, dateStr) {
            fpStart.set('maxDate', dateStr);
            syncModeIndicator();
        }
    });

    // ── Limpiar rango al cambiar mes/año ──────────────────────────
    $('#sel-month, #sel-year').on('change', function () {
        fpStart.clear();
        fpEnd.clear();
        fpStart.set('maxDate', null);
        fpEnd.set('minDate', null);
        syncModeIndicator();
    });

    // ── Indicador de modo activo ──────────────────────────────────
    function syncModeIndicator() {
        var startVal = $('#start-date').val();
        var endVal   = $('#end-date').val();
        var hasRange = startVal && endVal;

        if (hasRange) {
            $('#filter-mode-text').text(startVal + ' al ' + endVal);
            $('#btn-clear-range').removeClass('d-none');
            $('#sel-month, #sel-year').addClass('opacity-50').prop('disabled', true);
        } else {
            var month = $('#sel-month option:selected').text();
            var year  = $('#sel-year').val();
            $('#filter-mode-text').text(month + ' ' + year);
            $('#btn-clear-range').addClass('d-none');
            $('#sel-month, #sel-year').removeClass('opacity-50').prop('disabled', false);
        }
    }

    // ── Limpiar rango ─────────────────────────────────────────────
    $('#btn-clear-range').on('click', function () {
        fpStart.clear();
        fpEnd.clear();
        fpStart.set('maxDate', null);
        fpEnd.set('minDate', null);
        syncModeIndicator();
    });

    // ── Filtrar ───────────────────────────────────────────────────
    $('#btn-filter').on('click', function () {
        var startVal = $('#start-date').val();
        var endVal   = $('#end-date').val();
        var hasRange = startVal && endVal;

        if ((startVal && !endVal) || (!startVal && endVal)) {
            alert('Por favor selecciona tanto la fecha inicio como la fecha fin.');
            return;
        }

        var payload = hasRange
            ? { start_date: startVal, end_date: endVal }
            : { month: $('#sel-month').val(), year: $('#sel-year').val() };

        $('#loading-indicator').removeClass('d-none');
        $('#btn-filter').prop('disabled', true);

        $.ajax({
            url: @if($restaurant->business_id)
                    '{{ route("business.restaurants.home.filter", [
                        "business"     => $restaurant->business->slug,
                        "restaurants"  => $restaurant->slug
                    ]) }}'
                @else
                    '{{ route("restaurants.independent.home.filter", [
                        "restaurant" => $restaurant->slug
                    ]) }}'
                @endif,
            method: 'GET',
            data: payload,
            success: function (response) {
                $('#datatable_ventas tbody').html(response.rowsVentas);
                $('#datatable_food_drink tbody').html(response.rowsFoodDrink);
                $('#table_clientes tbody').html(response.rowsClientes);

                try {
                    renderCharts(response, primaryColor, secondaryColor);
                } catch (e) {
                    console.error('Error al renderizar charts:', e);
                }

                syncModeIndicator();
            },
            error: function (xhr) {
                console.error('Error:', xhr.responseJSON?.message ?? xhr.responseText);
                alert('Error al cargar los datos: ' + (xhr.responseJSON?.message ?? 'Intenta de nuevo.'));
            },
            complete: function () {
                $('#loading-indicator').addClass('d-none');
                $('#btn-filter').prop('disabled', false);
            }
        });
    });

    // Estado inicial
    syncModeIndicator();
});

// --- Exportar a Excel ---
$('#btn-excel').on('click', function () {
    const table = $('#datatable_ventas').DataTable();
    const data = table.rows().data().toArray();

    if (data.length === 0) {
        alert('No hay datos para exportar.');
        return;
    }

    // Crear HTML de la tabla
    let html = '<table border="1"><thead><tr>';

    // Columnas
    $('#datatable_ventas thead th').each(function () {
        html += '<th>' + $(this).text() + '</th>';
    });
    html += '</tr></thead><tbody>';

    // Filas
    data.forEach(row => {
        html += '<tr>';
        row.forEach(cell => {
            html += '<td>' + cell + '</td>';
        });
        html += '</tr>';
    });

    html += '</tbody></table>';

    // Crear Blob y descargar
    const blob = new Blob([html], { type: 'application/vnd.ms-excel' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'ventas_' + new Date().toISOString().slice(0, 10) + '.xls';
    a.click();
    URL.revokeObjectURL(url);
});

// --- Exportar a PDF ---
$('#btn-pdf').on('click', function () {
    const table = $('#datatable_ventas').DataTable();
    const data = table.rows().data().toArray();

    if (data.length === 0) {
        alert('No hay datos para exportar.');
        return;
    }

    // Crear HTML de la tabla
    let html = '<table border="1"><thead><tr>';

    // Columnas
    $('#datatable_ventas thead th').each(function () {
        html += '<th>' + $(this).text() + '</th>';
    });
    html += '</tr></thead><tbody>';

    // Filas
    data.forEach(row => {
        html += '<tr>';
        row.forEach(cell => {
            html += '<td>' + cell + '</td>';
        });
        html += '</tr>';
    });

    html += '</tbody></table>';

    // Crear Blob y descargar
    const blob = new Blob([html], { type: 'application/pdf' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'ventas_' + new Date().toISOString().slice(0, 10) + '.pdf';
    a.click();
    URL.revokeObjectURL(url);
});


// ── Helpers de exportación ────────────────────────────────────
async function getChartsAsBase64() {
    const charts = [
        { chart: chartVentas,    key: 'chart_ventas' },
        { chart: chartFoodDrink, key: 'chart_food_drink' },
        { chart: chartClientes,  key: 'chart_clientes' },
    ];

    const images = {};
    for (const item of charts) {
        if (item.chart) {
            const { imgURI } = await item.chart.dataURI();
            images[item.key] = imgURI; // base64 png
        }
    }
    return images;
}

function getActivePeriod() {
    var startVal = $('#start-date').val();
    var endVal   = $('#end-date').val();
    return startVal && endVal
        ? { start_date: startVal, end_date: endVal }
        : { month: $('#sel-month').val(), year: $('#sel-year').val() };
}

function submitExportForm(url, extraData) {
    var form = $('<form method="POST" style="display:none"></form>');
    form.attr('action', url);
    form.append('<input type="hidden" name="_token" value="' + $('meta[name="csrf-token"]').attr('content') + '">');
    $.each(extraData, function(key, val) {
        form.append('<input type="hidden" name="' + key + '" value="' + val + '">');
    });
    $('body').append(form);
    form.submit();
    form.remove();
}

// ── Exportar PDF ──────────────────────────────────────────────
$('#btn-export-pdf').on('click', async function () {
    $(this).prop('disabled', true).html('<i class="bx bx-loader bx-spin me-1"></i>Generando...');

    try {
        const images = await getChartsAsBase64();
        const period = getActivePeriod();

        submitExportForm(
            @if($restaurant->business_id)
                '{{ route("business.restaurante.export.pdf.monthly", ["business" => $restaurant->business->slug, "restaurants" => $restaurant->slug]) }}'
            @else
                '{{ route("restaurante.export.pdf.monthly", ["restaurant" => $restaurant->slug]) }}'
            @endif,
            { ...period, ...images }
        );
    } catch(e) {
        console.error('Error capturando charts:', e);
        alert('Error al generar el PDF.');
    } finally {
        setTimeout(() => {
            $('#btn-export-pdf').prop('disabled', false).html('<i class="bx bxs-file-pdf me-1"></i>PDF');
        }, 2000);
    }
});

// ── Exportar Excel ────────────────────────────────────────────
$('#btn-export-excel').on('click', function () {
    $(this).prop('disabled', true).html('<i class="bx bx-loader bx-spin me-1"></i>Generando...');
    const period = getActivePeriod();

    submitExportForm(
        @if($restaurant->business_id)
            '{{ route("business.restaurante.export.excel.monthly", ["business" => $restaurant->business->slug, "restaurants" => $restaurant->slug]) }}'
        @else
            '{{ route("restaurante.export.excel.monthly", ["restaurant" => $restaurant->slug]) }}'
        @endif,
        period
    );

    setTimeout(() => {
        $('#btn-export-excel').prop('disabled', false).html('<i class="bx bxs-file me-1"></i>Excel');
    }, 3000);
});
</script>
@endsection
