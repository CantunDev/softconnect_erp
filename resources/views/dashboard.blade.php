{{-- <x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
      {{ __('Dashboard') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900 dark:text-gray-100">
          {{ __("You're logged in!") }}
        </div>
      </div>
    </div>
  </div>
</x-app-layout> --}}

@extends('layouts.master')
@section('title')
    Dashboard |
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="https://avatar.oxro.io/avatar.svg?name={{ Auth::user()->fullname }}"
                                        alt="" class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <p class="mb-2">Bienvenido a tu Dashboard de SoftConnect</p>
                                        <h5 class="mb-1">{{ Auth::user()->fullname }}</h5>
                                        <p class="mb-0">{{ Auth::user()->roles->pluck('name')[0] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Empresas</p>
                                            <h5 class="mb-0">{{ Auth::user()->business->count() }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Restaurantes</p>
                                            <h5 class="mb-0">{{ Auth::user()->restaurants->count() }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Compras</p>
                                            <h5 class="mb-0"></h5>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-lg-4 d-none d-lg-block">
            <div class="clearfix mt-4 mt-lg-0">
              <div class="dropdown float-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-haspopup="true"
                  aria-expanded="false">
                  <i class="bx bxs-cog align-middle me-1"></i> Setting
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else</a>
                </div>
              </div>
            </div>
          </div> --}}
                    </div>
                    <!-- end row -->
                </div>
            </div>
        </div>
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-xl-4">
            <div class="card bg-primary bg-soft">
                <div>
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                {{-- <h5 class="text-primary">B Back !</h5> --}}
                                <p>Informe de promedios</p>

                                <ul class="ps-3 mb-0">
                                    <li class="py-1">Clientes</li>
                                    <li class="py-1">Compras</li>
                                    <li class="py-1">Ticket</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                        <i class="bx bx-copy-alt"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Clientes</h5>
                            </div>
                            <div class="text-muted text-center mt-4">
                                <h4>{{ $clients_sum }} <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                <div class="d-flex">
                                    {{-- <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span
                  class="ms-2 text-truncate">From previous period</span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                        <i class="bx bx-archive-in"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Compras</h5>
                            </div>
                            <div class="text-muted text-center mt-4">
                                <h4>$ 0 <i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                <div class="d-flex">
                                    {{-- <span class="badge badge-soft-success font-size-12"> + 0.2% </span> <span
                  class="ms-2 text-truncate">From previous period</span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="avatar-xs me-3">
                                    <span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
                                        <i class="bx bx-purchase-tag-alt"></i>
                                    </span>
                                </div>
                                <h5 class="font-size-14 mb-0">Tickts</h5>
                            </div>
                            <div class="text-muted text-center mt-4">
                                <h4>{{ $tickets_avg }}%<i class="mdi mdi-chevron-up ms-1 text-center text-success"></i>
                                </h4>

                                <div class="d-flex">
                                    {{-- <span class="badge badge-soft-warning font-size-12"> 0% </span> <span
                  class="ms-2 text-truncate">From previous period</span> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="food_drink_line" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Alimentos - Bebidas </h4>

                    <div>
                        <div id="food_drinks" class="apex-charts"></div>
                    </div>

                    <div class="text-center text-muted">
                        <div class="row">
                            <div class="col-4 text-center">
                                <div class="mt-4">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle me-1" style="color: #F14A00"></i>
                                        Alimentos</p>
                                    <h6>$ {{ $food_sum }}</h6>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="mt-4">
                                    <p class="mb-2 text-truncate"><i class="mdi mdi-circle me-1" style="color: #006A67"></i>Bebidas</p>
                                    <h6>$ {{ $drink_sum }}</h6>
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
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="client_line" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="client_ticket" class="apex-charts" dir="ltr"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Ventas mensuales de {{ \Carbon\Carbon::parse($currentMonth)->format('F') }}</h4>
                    <p class="card-title-desc">Informacion de cortes de caja diarios del mes en curso.</p>

                    <div class="table-rep-plugin">
                        <div class="table-responsive mb-0" data-pattern="priority-columns">
                            <table id="datatable" class="table table-sm table-bordered dt-responsive nowrap w-100">
                                <thead class="thead-light">
                                    <tr>
                                        <th data-priority="1">Fecha</th>
                                        <th data-priority="3" class="text-center">Clientes</th>
                                        <th data-priority="1">Importe Total</th>
                                        <th data-priority="3">IVA</th>
                                        <th data-priority="3">Importe Sin IVA</th>
                                        <th data-priority="6">Efectivo</th>
                                        <th data-priority="6">Propinas</th>
                                        <th data-priority="6">Tarjeta</th>
                                        <th data-priority="6">Otros</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cortes as $corte)
                                        <tr>
                                            <td>{{ $corte->dia }}</td>
                                            <td class="text-center">{{ $corte->total_clientes }}</td>
                                            <td class="currency">{{ $corte->total_venta }}</td>
                                            <td>{{ $corte->total_iva }}</td>
                                            <td>{{ $corte->total_subtotal }}</td>
                                            <td>{{ $corte->total_efectivo }}</td>
                                            <td>{{ $corte->total_propina }}</td>
                                            <td>{{ $corte->total_tarjeta }}</td>
                                            <td>{{ $corte->total_otros }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
    <div class="card">
        <div class="card-body">
            {{-- <div class="d-sm-flex flex-wrap">
                <h4 class="card-title mb-4">Ventas</h4>
                <div class="ms-auto">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <button class="nav-link active" onclick="updateChart('week')">Semana</button>
                        <li class="nav-item">
                            <button class="nav-link" onclick="updateChart('month')">Mes</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link " onclick="updateChart('year')">Year</button>
                        </li>
                        <div>
                        </div>
                    </ul>
                </div>
            </div> --}}

            <div id="chart" class="apex-charts" dir="ltr"></div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const table = document.getElementById("datatable");
            const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

            let totalClientes = 0;
            let totalTotal = 0;
            let totalIva = 0;
            let totalSubtotal = 0;
            let totalEfectivo = 0;
            let totalPropinas = 0;
            let totalTarjeta = 0;
            let totalCreditos = 0;

            // Calcular totales
            for (let i = 0; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                totalClientes += parseInt(cells[1].textContent);
                totalTotal += parseInt(cells[2].textContent);
                totalIva += parseInt(cells[3].textContent);
                totalSubtotal += parseInt(cells[4].textContent);
                totalEfectivo += parseInt(cells[5].textContent);
                totalPropinas += parseInt(cells[6].textContent);
                totalTarjeta += parseInt(cells[7].textContent);
                totalCreditos += parseInt(cells[8].textContent) || 0;
            }

            // Crear fila de totales
            const totalRow = document.createElement("tr");
            totalRow.innerHTML = `
        <td><strong>Total</strong></td>
        <td class="text-center">${totalClientes}</td>
        <td>${totalTotal}</td>
        <td>${totalIva}</td>
        <td>${totalSubtotal}</td>
        <td>${totalEfectivo}</td>
        <td>${totalPropinas}</td>
        <td>${totalTarjeta}</td>
        <td>${totalCreditos}</td>
    `;

            // Agregar la fila de totales al final de la tabla
            table.getElementsByTagName("tbody")[0].appendChild(totalRow);
        });
    </script>
    <script>
        var chartData = {
            days: @json($days), // Dias del mes
            days_total: @json($days_total) // Totales de alimentos por día
        };

        var options = {
            chart: {
                type: 'line',
                height: 350,
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
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top', // top, center, bottom
                    },
                    distributed: true

                }
            },
            theme: {
                palette: 'palette7',
                shadeTo: 'dark',
            },
            dataLabels: {
                enabled: true,

                // formatter: function (val) {
                //     return val + "%";
                // },
                formatter: function(val, opt) {
                    var Formatter = new Intl.NumberFormat('es-MX', {
                        style: 'currency',
                        currency: 'MXN'
                    });
                    return Formatter.format(val);
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#C62300"]
                }
            },
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

            series: [{
                name: 'Venta',
                data: chartData.days_total,

            }],
            xaxis: {
                categories: chartData.days,
                // position: 'top',
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: false
                },
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#C62300',
                            colorTo: '#C62300',
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                        }
                    }
                },
                tooltip: {
                    enabled: true,
                }
            },
            yaxis: {

                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    // formatter: function (val) {
                    //     return ""val + "%";
                    // }
                }
            },
            title: {
                text: 'Ventas de restaurante',
                floating: true,
                offsetY: 330,
                align: 'center',
                style: {
                    color: '#C62300'
                }
            },
            markers: {
                size: 5,
            },
            legend: {
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        // Función para actualizar el gráfico si se necesita con un conjunto de datos
        function updateChart(period) {
            chart.updateOptions({
                series: [{
                    name: 'Ventas',
                    data: dataSets[period].data // Asegúrate de que dataSets esté definido
                }],
                xaxis: {
                    categories: dataSets[period].days_total
                }
            });
        }
    </script>

    <script>
        let foodPercentage = {{ $food_percentage }};
        let drinkPercentage = {{ $drink_percentage }};

        var options = {
            series: [foodPercentage, drinkPercentage], // Usamos foodSum directamente
            labels: ['Alimentos', 'Bebidas'],
            chart: {
                type: 'donut',
            },
            tooltip: {
                theme: 'dark'
            },
            colors: ['#F14A00', '#006A67'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }],
            legend: {
                show: false
            }
        };

        var chart = new ApexCharts(document.querySelector("#food_drinks"), options);
        chart.render();
    </script>
    <script>
        var chartData = {
            days: @json($days),
            days_total_food: @json($days_total_food),
            days_total_drink: @json($days_total_drink)
        };
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
            colors: ['#F14A00', '#006A67'],
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
            days: @json($days), // Días del mes
            days_total_client: @json($days_total_client) // Clientes por día
        };
        var options = {
            chart: {
                type: 'line',
                height: 350,
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
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: 'top', // Posición de los dataLabels (top, center, bottom)
                    },
                    distributed: true
                }
            },
            dataLabels: {
                enabled: true,
                offsetY: -10, // Ajusta la posición vertical del texto
                style: {
                    fontSize: '14px', // Tamaño del texto
                    colors: ['#FFFFFF'], // Color del texto (blanco)
                    fontWeight: 'bold' // Grosor del texto
                },
                background: {
                    enabled: false // Desactiva el fondo de los dataLabels
                }
            },
            legend: {
                labels: {
                    colors: '#FFFFFF' // Cambia el color del texto de la leyenda a blanco
                }
            },
            series: [{
                name: 'Clientes',
                data: chartData.days_total_client
            },],
            xaxis: {
                categories: chartData.days,
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: false,
                }
            },
            title: {
                text: 'Clientes',
                floating: true,
                offsetY: 330,
                align: 'center',
                style: {
                    color: '#FFFFFF' // Color del título (opcional)
                }
            },
            markers: {
                size: 5,
            },
            legend: {
                show: false // Oculta la leyenda
            }
        };

        var chart = new ApexCharts(document.querySelector("#client_line"), options);
        chart.render();
    </script>
    <script>
        var chartData = {
            days: @json($days),
            days_total_client: @json($days_total_client), // Clientes por día
            days_total_ticket: @json($days_total_ticket) // Ticket promedio por día
        };
    
        var options = {
            chart: {
                height: 350,
                type: "line",
                stacked: false
            
            },            zoom: {
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
            colors: ['#66C7F4','#99C2A2'],
            series: [
                {
                    name: 'Clientes',
                    type: 'column',
                    data: chartData.days_total_client
                },
                {
                    name: "Ticket Promedio",
                    type: 'line',
                    data: chartData.days_total_ticket
                },
            ],
            stroke: {
                width: [0, 4], // Grosor: columna no tiene borde, línea tiene grosor 4
                curve: 'smooth' // Línea suavizada
            },
            markers: {
                size: 5,
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
            yaxis: [
                {
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
                        formatter: function (value) {
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
                        formatter: function (value) {
                            return "$" + value.toFixed(2); // Formato de moneda
                        }
                    }
                }
            ],
            tooltip: {
                shared: true, // Mostrar ambos valores al pasar el cursor
                intersect: false, // Evitar intersección
                y: {
                    formatter: function (value, { seriesIndex, dataPointIndex, w }) {
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
