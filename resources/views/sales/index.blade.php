@extends('layouts.master')
@section('title')
    Acumulado Ventas |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
        @endslot
        @slot('bcPrevText')
            Ventas
        @endslot
        @slot('bcPrevLink')
            {{-- {{ route('config.roles_permissions.index') }} --}}
        @endslot
        @slot('bcActiveText')
            Mensuales
        @endslot
    @endcomponent
    <x-date-component />
    <x-date-searcher-component />
    {{-- <x-sales.monthly-sales-component :restaurants="$restaurants" :errors="$errors" /> --}}
    {{-- <x-sales.monthly-sales-food :restaurants="$restaurants" /> --}}
    <div class="row">
        <div class="col-lg-12">
            <div class="card" style="border: 2px solid #ccc">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-4">Ventas del mes Restaurante</h4> --}}
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurants->color_primary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}"
                                    class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseV"
                                    aria-expanded="true" aria-controls="flush-collapseV">
                                    <span>
                                        <i class="bx bx-dollar font-size-12 align-middle me-1"></i>
                                        Movimientos de caja {{ $restaurants->name }}
                                    </span>
                                </button>
                            </h2>
                        </div>
                        <div id="flush-collapseV" class="accordion-collapse collapse show mb-4"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                            <div class="row">
                                <div class="table-rep-plugin mt-2 ">
                                    <div class="table-responsive mb-0" data-pattern="priority-columns">
                                        <table id="salesMonthlyTable" class="table table-bordered table-striped">
                                            <thead
                                                style="background-color: {{ $restaurants->color_secondary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}">
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
                                                <!-- Los datos se cargarán vía AJAX -->
                                            </tbody>
                                            <tfoot
                                                style="background-color: {{ $restaurants->color_secondary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}">
                                                <tr>
                                                    <th>Total</th>
                                                    <th id="total_clientes"></th>
                                                    <th id="total_venta"></th>
                                                    <th id="total_iva"></th>
                                                    <th id="total_subtotal"></th>
                                                    <th id="total_efectivo"></th>
                                                    <th id="total_propina"></th>
                                                    <th id="total_tarjeta"></th>
                                                    <th id="total_descuento"></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
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
    <script>
        $(document).ready(function() {
            flatpickr('#start-date', {
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates, dateStr) {
                    if (dateStr) {
                        endPicker.set('minDate', dateStr);
                        syncModeIndicator();
                    }
                }
            });
            var endPicker = flatpickr('#end-date', {
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates, dateStr) {
                    syncModeIndicator();
                }
            });

            var table = $('#salesMonthlyTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                pageLength: -1,
                order: [
                    [0, 'asc']
                ],
                ajax: {
                    url: '{!! route('business.restaurants.home.index', [
                        'business' => request()->route('business'),
                        'restaurants' => request()->route('restaurants'),
                    ]) !!}',
                    data: function(d) {
                        var startDate = $('#start-date').val();
                        var endDate = $('#end-date').val();

                        if (startDate && endDate) {
                            d.start_date = startDate;
                            d.end_date = endDate;
                            d.month = null;
                            d.year = null;
                        } else {
                            d.month = $('#sel-month').val();
                            d.year = $('#sel-year').val();
                            d.start_date = null;
                            d.end_date = null;
                        }
                        d.ajax = true;
                    },
                    beforeSend: function() {
                        $('#loading-indicator').removeClass('d-none');
                    },
                    complete: function() {
                        $('#loading-indicator').addClass('d-none');
                    },
                    error: function(xhr) {
                        $('#loading-indicator').addClass('d-none');
                        Swal.fire('Error', 'Error al cargar los datos', 'error');
                    }
                },
                columns: [{
                        data: 'fecha_formateada',
                        name: 'fecha',
                        className: 'text-center'
                    },
                    {
                        data: 'total_clientes',
                        name: 'total_clientes',
                        className: 'text-center'
                    },
                    {
                        data: 'total_venta',
                        name: 'total_venta'
                    },
                    {
                        data: 'total_iva',
                        name: 'total_iva'
                    },
                    {
                        data: 'total_subtotal',
                        name: 'total_subtotal'
                    },
                    {
                        data: 'total_efectivo',
                        name: 'total_efectivo'
                    },
                    {
                        data: 'total_propina',
                        name: 'total_propina'
                    },
                    {
                        data: 'total_tarjeta',
                        name: 'total_tarjeta'
                    },
                    {
                        data: 'total_descuento',
                        name: 'total_descuento'
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    // Función para formatear moneda
                    var formatCurrency = function(value) {
                        return new Intl.NumberFormat('es-MX', {
                            style: 'currency',
                            currency: 'MXN',
                            minimumFractionDigits: 2
                        }).format(value);
                    };

                    // Calcular totales
                    var totalClientes = api.column(1, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseInt(b) || 0);
                    }, 0);

                    var totalVenta = api.column(2, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseFloat(b) || 0);
                    }, 0);

                    var totalIva = api.column(3, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseFloat(b) || 0);
                    }, 0);

                    var totalSubtotal = api.column(4, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseFloat(b) || 0);
                    }, 0);

                    var totalEfectivo = api.column(5, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseFloat(b) || 0);
                    }, 0);

                    var totalPropina = api.column(6, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseFloat(b) || 0);
                    }, 0);

                    var totalTarjeta = api.column(7, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseFloat(b) || 0);
                    }, 0);

                    var totalDescuento = api.column(8, {
                        search: 'applied'
                    }).data().reduce(function(a, b) {
                        return a + (parseFloat(b) || 0);
                    }, 0);

                    // Actualizar totales en el footer
                    $('#total_clientes').text(totalClientes);
                    $('#total_venta').text(formatCurrency(totalVenta));
                    $('#total_iva').text(formatCurrency(totalIva));
                    $('#total_subtotal').text(formatCurrency(totalSubtotal));
                    $('#total_efectivo').text(formatCurrency(totalEfectivo));
                    $('#total_propina').text(formatCurrency(totalPropina));
                    $('#total_tarjeta').text(formatCurrency(totalTarjeta));
                    $('#total_descuento').text(formatCurrency(totalDescuento));
                }
            });
            $('#btn-filter').on('click', function() {
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();

                if ((startDate && !endDate) || (!startDate && endDate)) {
                    Swal.fire('Atención', 'Selecciona tanto la fecha inicio como la fecha fin.', 'warning');
                    return;
                }

                table.ajax.reload();
            });
            // ── Limpiar rango ────────────────────────────────────────────
            $('#btn-clear-range').on('click', function() {
                $('#start-date').val('');
                $('#end-date').val('');
                $(this).addClass('d-none');
                syncModeIndicator();
                table.ajax.reload();
            });
            // ── Mostrar botón limpiar cuando hay rango completo ──────────
            $('#start-date, #end-date').on('change', function() {
                var hasRange = $('#start-date').val() && $('#end-date').val();
                $('#btn-clear-range').toggleClass('d-none', !hasRange);
                syncModeIndicator();
            });
            // ── Cambio de mes/año limpia el rango y recarga ───────────────
            $('#sel-month, #sel-year').on('change', function() {
                $('#start-date').val('');
                $('#end-date').val('');
                $('#btn-clear-range').addClass('d-none');
                syncModeIndicator();
                table.ajax.reload();
            });
        });
        // ── Indicador visual del modo activo ────────────────────────────
        function syncModeIndicator() {
            var hasRange = $('#start-date').val() && $('#end-date').val();
            if (hasRange) {
                $('#sel-month, #sel-year').addClass('opacity-50');
            } else {
                $('#sel-month, #sel-year').removeClass('opacity-50');
            }
        }
    </script>
@endsection
