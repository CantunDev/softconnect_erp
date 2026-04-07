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
    <x-sales.monthly-sales-component :restaurants="$restaurants" :errors="$errors" />
    <x-sales.monthly-sales-food :restaurants="$restaurants" />
@endsection
@section('js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    {{-- Script 2: Tabla y Filtros --}}
    <script>
        // ── Flatpickr ────────────────────────────────────────────────
        flatpickr('#start-date', {
            dateFormat: 'Y-m-d',
            locale: 'es',
            onChange: function(selectedDates, dateStr) {
                if (dateStr) {
                    endPicker.set('minDate', dateStr);
                    // Limpiar mes/año visualmente
                    syncModeIndicator();
                }
            }
        });

        var endPicker = flatpickr('#end-date', {
            dateFormat: 'Y-m-d',
            locale: 'es',
            onChange: function(selectedDates, dateStr) {
                syncModeIndicator();
            }
        });
        let table;
        let tableFood;

        // =========================
        // FUNCIONES GLOBALES
        // =========================

        function recalcularTotales() {
            if (!table) return;

            let total_clientes = 0;
            let total_venta = 0;
            let total_iva = 0;
            let total_subtotal = 0;
            let total_efectivo = 0;
            let total_propina = 0;
            let total_tarjeta = 0;
            let total_descuento = 0;

            table.rows({
                search: 'applied'
            }).every(function() {
                let rowData = this.data();
                if (rowData) {
                    total_clientes += parseFloat(rowData[1]) || 0;
                    total_venta += parseFloat(rowData[2]?.toString().replace(/[$,]/g, '')) || 0;
                    total_iva += parseFloat(rowData[3]?.toString().replace(/[$,]/g, '')) || 0;
                    total_subtotal += parseFloat(rowData[4]?.toString().replace(/[$,]/g, '')) || 0;
                    total_efectivo += parseFloat(rowData[5]?.toString().replace(/[$,]/g, '')) || 0;
                    total_propina += parseFloat(rowData[6]?.toString().replace(/[$,]/g, '')) || 0;
                    total_tarjeta += parseFloat(rowData[7]?.toString().replace(/[$,]/g, '')) || 0;
                    total_descuento += parseFloat(rowData[8]?.toString().replace(/[$,]/g, '')) || 0;
                }
            });

            actualizarFooterTotales({
                clientes: total_clientes,
                venta: total_venta,
                iva: total_iva,
                subtotal: total_subtotal,
                efectivo: total_efectivo,
                propina: total_propina,
                tarjeta: total_tarjeta,
                descuento: total_descuento
            });
        }

        function recalcularTotalesFood() {
            if (!tableFood) return;

            let total_food = 0;
            let total_desc_food = 0;
            let total_drinks = 0;
            let total_desc_drinks = 0;
            let total_pct_food = 0;
            let total_pct_drinks = 0;
            let contador = 0;

            tableFood.rows({
                search: 'applied'
            }).every(function() {
                let rowData = this.data();
                if (rowData) {
                    total_food += parseFloat(rowData[1]?.toString().replace(/[$,]/g, '')) || 0;
                    total_desc_food += parseFloat(rowData[2]?.toString().replace(/[$,]/g, '')) || 0;
                    total_drinks += parseFloat(rowData[4]?.toString().replace(/[$,]/g, '')) || 0;
                    total_desc_drinks += parseFloat(rowData[5]?.toString().replace(/[$,]/g, '')) || 0;

                    total_pct_food += parseFloat(rowData[3]?.toString().replace(/[%]/g, '')) || 0;
                    total_pct_drinks += parseFloat(rowData[6]?.toString().replace(/[%]/g, '')) || 0;

                    contador++;
                }
            });

            let avg_food = contador ? total_pct_food / contador : 0;
            let avg_drinks = contador ? total_pct_drinks / contador : 0;

            actualizarFooterTotalesFood({
                total_food,
                total_desc_food,
                avg_food,
                total_drinks,
                total_desc_drinks,
                avg_drinks
            });
        }

        function actualizarFooterTotales(t) {
            $('#total_clientes').text(t.clientes.toFixed(0));
            $('#total_venta').text('$' + t.venta.toFixed(2));
            $('#total_iva').text('$' + t.iva.toFixed(2));
            $('#total_subtotal').text('$' + t.subtotal.toFixed(2));
            $('#total_efectivo').text('$' + t.efectivo.toFixed(2));
            $('#total_propina').text('$' + t.propina.toFixed(2));
            $('#total_tarjeta').text('$' + t.tarjeta.toFixed(2));
            $('#total_descuento').text('$' + t.descuento.toFixed(2));
        }

        function actualizarFooterTotalesFood(t) {
            $('#total_food').text('$' + t.total_food.toFixed(2));
            $('#total_desc_food').text('$' + t.total_desc_food.toFixed(2));
            $('#avg_food').text(t.avg_food.toFixed(1) + '%');
            $('#total_drinks').text('$' + t.total_drinks.toFixed(2));
            $('#total_desc_drinks').text('$' + t.total_desc_drinks.toFixed(2));
            $('#avg_drinks').text(t.avg_drinks.toFixed(1) + '%');
        }

        function actualizarTabla(selector, html, callback) {
            if ($.fn.DataTable.isDataTable(selector)) {
                $(selector).DataTable().destroy();
            }

            let temp = $('<div>').html(html);
            let tbody = temp.find(selector + ' tbody').html();

            $(selector + ' tbody').html(tbody);

            return $(selector)
                .on('init.dt draw.dt', callback)
                .DataTable({
                    responsive: true,
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: -1
                });
        }

        // =========================
        // READY
        // =========================

        $(document).ready(function() {

            // Ventas
            table = $('#datatable_ventas')
                .on('init.dt draw.dt', recalcularTotales)
                .DataTable({
                    responsive: true,
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: -1
                });

            // Food & Drinks
            tableFood = $('#datatable_ventas_food')
                .on('init.dt draw.dt', recalcularTotalesFood)
                .DataTable({
                    responsive: true,
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: -1
                });

            // =========================
            // FILTRO
            // =========================
            $('#btn-filter').on('click', function() {

                let start = $('#start-date').val();
                let end = $('#end-date').val();

                if ((start && !end) || (!start && end)) {
                    alert('Selecciona ambas fechas');
                    return;
                }

                let payload = (start && end) ? {
                    start_date: start,
                    end_date: end
                } : {
                    month: $('#sel-month').val(),
                    year: $('#sel-year').val()
                };

                $('#loading-indicator').removeClass('d-none');
                $('#btn-filter').prop('disabled', true);

                $.ajax({
                    url: @if ($restaurants->business_id)
                        '{{ route('business.restaurants.home.filter', ['business' => $restaurants->business->slug, 'restaurants' => $restaurants->slug]) }}'
                    @else
                        '{{ route('restaurants.home.filter', ['restaurants' => $restaurants->slug]) }}'
                    @endif ,
                    method: 'GET',
                    data: payload,

                    success: function(res) {

                        if (res.rowsVentas) {
                            table = actualizarTabla('#datatable_ventas', res.rowsVentas,
                                recalcularTotales);
                        }

                        if (res.rowsFoodDrink) {
                            tableFood = actualizarTabla('#datatable_ventas_food', res
                                .rowsFoodDrink, recalcularTotalesFood);
                        }
                    },

                    complete: function() {
                        $('#loading-indicator').addClass('d-none');
                        $('#btn-filter').prop('disabled', false);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Exportar PDF
            $('#btn-export-pdf').on('click', function(e) {
                e.preventDefault();
                // Mostrar spinner
                $(this).prop('disabled', true);
                $('#pdf-spinner').removeClass('d-none');
                // Obtener filtros actuales
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();
                var month = $('#sel-month').val();
                var year = $('#sel-year').val();
                console.log(startDate, endDate, month, year);

                var URL =
                    @if ($restaurants->business_id)
                        '{{ route('business.restaurants.export.pdf.monthly', [
                            'business' => $restaurants->business->slug,
                            'restaurants' => $restaurants->slug,
                        ]) }}'
                    @else
                        '{{ route('restaurants.export.pdf.monthly', [
                            'restaurants' => $restaurants->slug,
                        ]) }}'
                    @endif ;
                // Construir parámetros
                var params = new URLSearchParams();

                if (startDate && endDate) {
                    params.append('start_date', startDate);
                    params.append('end_date', endDate);
                } else {
                    params.append('month', month);
                    params.append('year', year);
                }

                window.location.href = URL + '?' + params.toString();

                setTimeout(function() {
                    $('#btn-export-pdf').prop('disabled', false);
                    $('#pdf-spinner').addClass('d-none');
                }, 3000);
            });
        });
    </script>
@endsection
