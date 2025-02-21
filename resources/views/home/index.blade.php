@extends('layouts.master')
@section('title')
    Dashboard |
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row ">
                        <div class="col-xl-2 d-flex justify-content-center align-items-center">
                            <div class="mt-4 text-center">
                                <img src="{{ $restaurant->restaurant_file ? asset($restaurant->restaurant_file) : 'https://avatar.oxro.io/avatar.svg?name=' . urlencode($restaurant->name) . '&background=' . ltrim($restaurant->color_primary, '#') . '&color=' . ltrim($restaurant->color_accent, '#') }}"
                                    alt="{{ $restaurant->name }}"
                                    class="avatar-lg rounded-circle img-thumbnail mx-auto d-block">
                            </div>
                        </div>
                        <div class="col-xl-10">
                            <div class="row text-center">
                                <div class="col-xl-3">
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">INICIO MES</p>
                                        <h5>{{ $startOfMonth }}</h5>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">TERMINO MES</p>
                                        <h5>{{ $endOfMonth }}</h5>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">MES</p>
                                        <h5 class="text-uppercase">{{ $month }} </h5>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">TOTAL DIAS</p>
                                        <h5>{{ $daysInMonth }} </h5>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">DIAS</p>
                                        <h5>{{ $daysPass }} </h5>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">% ALCANCE</p>
                                        <h5 class="percentage">{{ $rangeMonth }}</h5>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mt-4">
                                        <img src="{{ Auth::user()->business->first()->business_file ?? 'https://avatar.oxro.io/avatar.svg?name=' . urlencode(Auth::user()->business->first()->business_name) }}"
                                            alt="" class="avatar-lg rounded-circle d-block mx-auto">
                                        {{-- <span>{{ Auth::user()->business->pluck('business_name')[0] ?? '' }}</span> --}}

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
                                    style="background-color: {{ $restaurant->color_primary ?? '' }}; color: {{ $restaurant->business->first()->color_accent ?? '' }}"
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
                        <div id="flush-collapseV" class="accordion-collapse collapse show"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                            <div class="row">
                                <div class="table-rep-plugin mt-2 ">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="datatable"
                                            class="table table-sm table-bordered dt-responsive nowrap w-100">
                                            <thead
                                                style="background-color: {{ $restaurant->color_secondary ?? '' }}; color: {{ $restaurant->business->first()->color_accent ?? '' }}">
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
                                                @foreach ($cortes as $corte)
                                                    <tr>
                                                        <td>
                                                            {{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd')) }}
                                                            {{ \Carbon\Carbon::parse($corte->dia)->isoFormat('D MMM') }}
                                                        </td>
                                                        <td class="text-center">{{ $corte->total_clientes }}</td>
                                                        <td class="price">{{ $corte->total_venta }}</td>
                                                        <td class="price">{{ $corte->total_iva }}</td>
                                                        <td class="price">{{ $corte->total_subtotal }}</td>
                                                        <td class="price">{{ $corte->total_efectivo }}</td>
                                                        <td class="price">{{ $corte->total_propina }}</td>
                                                        <td class="price">{{ $corte->total_tarjeta }}</td>
                                                        <td class="price">{{ $corte->total_descuento }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                                        <table id="datatable"
                                            class="table table-sm table-bordered dt-responsive nowrap w-100">
                                            <thead
                                                style="background-color: {{ $restaurant->color_secondary ?? '' }}; color: {{ $restaurant->business->first()->color_accent ?? '' }}">
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
                                                @foreach ($cortes as $corte)
                                                    <tr>
                                                        <td>
                                                            {{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd')) }}
                                                            {{ \Carbon\Carbon::parse($corte->dia)->isoFormat('D MMM') }}
                                                        </td>
                                                        <td class="price text-center">{{ $alimentos = $corte->total_alimentos }}</td>
                                                        <td class="price text-center">{{ $corte->total_dalimentos }}</td>
                                                        <td class="percentage text-center">{{ round((($alimentos * 100) / $corte->total_venta),2) }}</td>
                                                        <td class="price text-center">{{ $bebidas = $corte->total_bebidas }}</td>
                                                        <td class="price text-center">{{ $corte->total_dbebidas}}</td>
                                                        <td class="percentage text-center">{{ round((($bebidas * 100) / $corte->total_venta),2) }}</td>
                                                    </tr>
                                                @endforeach
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
                                                style="background-color: {{ $restaurant->color_secondary ?? '' }}; color: {{ $restaurant->business->first()->color_accent ?? '' }}">
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
                                                @foreach ($cortes as $corte)
                                                    <tr>
                                                        <td>
                                                            {{ ucfirst(\Carbon\Carbon::parse($corte->dia)->isoFormat('ddd')) }}
                                                            {{ \Carbon\Carbon::parse($corte->dia)->isoFormat('D MMM') }}
                                                        </td>
                                                        <td class="text-center">{{ $corte->total_cuentas }}</td>
                                                        <td class="text-center">{{ $corte->total_clientes }}</td>
                                                        <td class="text-center price">
                                                            {{ round($corte->total_venta / $corte->total_clientes, 2) }}
                                                        </td>
                                                        {{-- <td class="text-center">{{ round($corte->total_cuentas / $corte->total_clientes,2) }}</td> --}}
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
<script>
 $(document).ready(function () {
        $('#table_clientes').DataTable();
    });
</script>
<script>
    var chartData = {
        days: @json($days), // Días del mes
        days_total: @json($days_total), // Totales de alimentos por día
        projection_day: @json($projections_total), // Meta de ventas por día
        projection_avg: @json($projections_avg) // Promedio de ventas por día
    };

    // Asegurar que el color primario esté limpio sin #
    var primaryColor = @json($restaurant->color_primary) ? "#{{ ltrim($restaurant->color_primary, '#') }}" : "#C62300";

    // Definir colores de los marcadores según las condiciones
    var discreteMarkers = chartData.days_total.map((ventaReal, index) => {
        let metaDiaria = chartData.projection_day[index] || 0;
        let promedioDiario = chartData.projection_avg[index] || 0;
        let color = "#00ff00"; // Verde (si supera la meta)

        if (ventaReal < metaDiaria && ventaReal >= promedioDiario) {
            color = "#FFA500"; // Naranja (si está debajo de la meta pero sobre el promedio)
        } else if (ventaReal < promedioDiario) {
            color = "#FF0000"; // Rojo (si está debajo del promedio)
        }

        return {
            seriesIndex: 0, // Índice de la serie "Venta Real"
            dataPointIndex: index, // Índice del punto de datos
            fillColor: color, // Color del marcador
            strokeColor: "#000000", // Borde del marcador (opcional)
            size: 6 // Tamaño del marcador
        };
    });

    var options = {
        chart: {
            type: 'line',
            height: 350,
            zoom: { enabled: true },
            toolbar: { show: true }
        },
        tooltip: {
            theme: 'dark'
        },
        plotOptions: {
            bar: {
                borderRadius: 10,
                dataLabels: { position: 'top' },
                distributed: true
            }
        },
        colors: [primaryColor, '#56021F', '#003092'],
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return new Intl.NumberFormat('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                }).format(val);
            },
            offsetY: -10,
            style: {
                fontSize: '12px',
                colors: [primaryColor]
            },
            background: { enabled: false }
        },
        stroke: {
            width: [5, 2, 2],
            curve: ['straight', 'monotoneCubic',]
        },
        series: [
            {
                name: 'Venta Real',
                data: chartData.days_total 
            },
            {
                name: "Meta Vta Diaria",
                data: chartData.projection_day
            },
        ],
        xaxis: {
            categories: chartData.days,
            axisBorder: { show: true },
            tooltip: { enabled: true }
        },
        yaxis: {
            axisBorder: { show: true }
        },
        title: {
            text: 'Ventas de Restaurante',
            floating: true,
            offsetY: 330,
            align: 'center',
            style: { color: primaryColor }
        },
        markers: {
            size: [0,5, 1, 1], // Tamaño base de los marcadores
            discrete: discreteMarkers // Se asignan colores individuales,
        },
        legend: { show: false }
    };

    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>

<script>
    var chartData = {
        days: @json($days),
        days_total_food: @json($days_total_food),
        days_total_drink: @json($days_total_drink)
    };
    var primaryColor = @json($restaurant->color_primary) ? "#{{ ltrim($restaurant->color_primary, '#') }}" : "#F14A00"; // Si está vacío, usa color de respaldo
    var secondaryColor = @json($restaurant->color_secondary) ? "#{{ ltrim($restaurant->color_secondary, '#') }}" : "#006A67"; // Si está vacío, usa color de respaldo

    var options = {
        series: [{
                name: "Alimentos",
                data: chartData.days_total_food
            },
            {
                name: "Bebidas",
                data: chartData.days_total_drink
            }
        ],
        chart: {

            height: 350,
            type: 'line',
            dropShadow: {
                enabled: true,
                color: '#0000',
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.5
            },

            zoom: {
                enabled: true
            },
            toolbar: {
                show: true
            }
        },
        tooltip: {
            theme: 'dark' // Cambia el tema del tooltip a oscuro, el texto será blanco automáticamente
        },
        colors: [primaryColor, secondaryColor],
        dataLabels: {
            enabled: true,
            formatter: function(val, opt) {
                var Formatter = new Intl.NumberFormat('es-MX', {
                    style: 'currency',
                    currency: 'MXN'
                });
                return Formatter.format(val);
            },
            background: {
                enabled: false // Desactiva el fondo de los dataLabels
            }
        },
        stroke: {
            curve: 'smooth'
        },
        markers: {
            size: 0,
            colors: undefined,
            strokeColors: '#fff',
            strokeWidth: 2,
            strokeOpacity: 0.9,
            strokeDashArray: 0,
            fillOpacity: 1,
            discrete: [],
            shape: "circle",
            offsetX: 0,
            offsetY: 0,
            onClick: undefined,
            onDblClick: undefined,
            showNullDataPoints: true,
            hover: {
                size: undefined,
                sizeOffset: 3
            }

        },
        // title: {
        //   text: 'Average High & Low Temperature',
        //   align: 'left'
        // },
        grid: {
            borderColor: '#e7e7e7',
            row: {
                // colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                opacity: 0.5
            },
        },
        markers: {
            size: 1
        },
        xaxis: {
            categories: chartData.days,
            //  title: {
            //  text: ''
            //  }
        },
        yaxis: {
            // title: {
            //   text: 'Temperature'
            // },
            // min: 5,
            // max: 40
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            floating: true,
            offsetY: -25,
            offsetX: -5
        }
    };

    var chart = new ApexCharts(document.querySelector("#food_drink_line"), options);
    chart.render();
</script>
<script>
    var chartData = {
        days: @json($days),
        days_total_client: @json($days_total_client), // Clientes por día
        days_total_ticket: @json($days_total_ticket), // Ticket promedio por día
        days_total_check: @json($projections_check),
        days_total_avg_check: @json($projections_check_avg)
    };
    var primaryColor = @json($restaurant->color_primary) ? "#{{ ltrim($restaurant->color_primary, '#') }}" : "#F14A00"; // Si está vacío, usa color de respaldo
    var secondaryColor = @json($restaurant->color_secondary) ? "#{{ ltrim($restaurant->color_secondary, '#') }}" : "#006A67"; // Si está vacío, usa color de respaldo
   
    var discreteMarkers = chartData.days_total_ticket.map((tktPromedio, index) => {
        let metaDiaria = chartData.days_total_check[index] || 0;
        let promedioDiario = chartData.days_total_avg_check[index] || 0;
        let color = "#00ff00"; // Verde (si supera la meta)
        console.log(`Index ${index}:`, {
        tktPromedio,
        metaDiaria,
        promedioDiario
    });

        if (tktPromedio < metaDiaria && tktPromedio >= promedioDiario) {
            color = "#FFA500"; // Naranja (si está debajo de la meta pero sobre el promedio)
        } else if (tktPromedio < promedioDiario) {
            color = "#FF0000"; // Rojo (si está debajo del promedio)
        }
        console.log(`Color asignado en index ${index}:`, color);

        return {
            seriesIndex: 1, // Índice de la serie "Venta Real"
            dataPointIndex: index, // Índice del punto de datos
            fillColor: color, // Color del marcador
            strokeColor: "#000000", // Borde del marcador (opcional)
            size: 6 // Tamaño del marcador
        };
    });

    var options = {
        chart: {
            height: 350,
            type: "line",
            stacked: false

        },
        zoom: {
            enabled: true, // Habilitar zoom
            type: 'x', // Zoom solo en el eje X
            autoScaleYaxis: true // Ajustar automáticamente el eje Y al hacer zoom
        },
        toolbar: {
            tools: {
                zoom: true,
                zoomin: true,
                zoomout: true,
                reset: true // Botón para restablecer
            },
            autoSelected: 'zoom' // Configura zoom como la herramienta inicial
        },
        colors: [primaryColor, secondaryColor, '#56021F', '#003092'], // Agregar un color extra
        series: [
            {
                 name: 'Clientes',
             type: 'column',
                 data: chartData.days_total_client
            },
            {
                name: "Tkt Promedio",
                type: 'line',
                data: chartData.days_total_ticket
            },
            {
                name: "Meta Tkt Pro",
                type: 'line',
                data: chartData.days_total_check
            },
            {
                name: "Tkt Pro",
                type: 'line',
                data: chartData.days_total_avg_check
            },
        ],
        stroke: {
            width: [0,5,2,2], // Grosor: columna no tiene borde, línea tiene grosor 4
            curve: ['straight', 'monotoneCubic', 'straight']
        },
        markers: {
            size: [1,5, 1, 1], // Tamaño base de los marcadores
            discrete: discreteMarkers // Se asignan colores individuales,
        },
        plotOptions: {
            bar: {
                columnWidth: "40%"
            }
        },
        xaxis: {
            categories: chartData.days,
            title: {
                text: "Días"
            }
        },
        yaxis: [{
                seriesName: 'Clientes',
                axisTicks: {
                    show: true
                },
                axisBorder: {
                    show: true,
                },
                // title: {
                //     text: "Clientes"
                // },
                labels: {
                    formatter: function(value) {
                        return Math.round(value); // Redondea los valores
                    }
                }
            },
            {
                opposite: true,
                seriesName: 'Ticket promedio',

                // title: {
                //     text: "Ticket Promedio"
                // },
                labels: {
                    formatter: function(value) {
                        return "$" + value.toFixed(2); // Formato de moneda
                    }
                }
            }
        ],
        tooltip: {
            shared: true, // Mostrar ambos valores al pasar el cursor
            intersect: false, // Evitar intersección
            y: {
                formatter: function(value, {
                    seriesIndex,
                    dataPointIndex,
                    w
                }) {
                    if (seriesIndex === 0) {
                        return value + " clientes"; // Tooltip para clientes
                    } else {
                        return "$" + value.toFixed(2); // Tooltip para ticket promedio
                    }
                }
            },

        },

        legend: {
            show: false,
        }
    };

    var chart = new ApexCharts(document.querySelector("#client_ticket"), options);

    chart.render();
</script>

@endsection
