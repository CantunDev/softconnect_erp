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
        let table;
        let tableFood;

        $(document).ready(function() {
            // Inicializar DataTable de ventas
            table = $('#datatable_ventas').DataTable({
                responsive: true,
                order: [
                    [0, 'asc']
                ],
                pageLength: -1,
                drawCallback: function() {
                    recalcularTotales();
                },
                initComplete: function() {
                    console.log('DataTable ventas inicializado');
                    recalcularTotales();
                }
            });

            // Inicializar DataTable de alimentos y bebidas
            tableFood = $('#datatable_ventas_food').DataTable({
                responsive: true,
                order: [
                    [0, 'asc']
                ],
                pageLength: -1,
                drawCallback: function() {
                    recalcularTotalesFood();
                },
                initComplete: function() {
                    console.log('DataTable alimentos inicializado');
                    // IMPORTANTE: Forzar cálculo inmediato después de inicializar
                    setTimeout(function() {
                        recalcularTotalesFood();
                    }, 200);
                }
            });

            // Forzar cálculos iniciales para ambas tablas
            setTimeout(function() {
                recalcularTotales();
                recalcularTotalesFood();
            }, 300);

            // ── Flatpickr y resto del código existente ──────────────────
            // ... (mantén todo tu código de flatpickr aquí) ...

            // ── Filtrar ───────────────────────────────────────────────────
            $('#btn-filter').on('click', function() {
                var startVal = $('#start-date').val();
                var endVal = $('#end-date').val();
                var hasRange = startVal && endVal;

                if ((startVal && !endVal) || (!startVal && endVal)) {
                    alert('Por favor selecciona tanto la fecha inicio como la fecha fin.');
                    return;
                }

                var payload = hasRange ? {
                    start_date: startVal,
                    end_date: endVal
                } : {
                    month: $('#sel-month').val(),
                    year: $('#sel-year').val()
                };

                $('#loading-indicator').removeClass('d-none');
                $('#btn-filter').prop('disabled', true);

                $.ajax({
                    url: @if ($restaurants->business_id)
                        '{{ route('business.restaurants.home.filter', [
                            'business' => $restaurants->business->slug,
                            'restaurants' => $restaurants->slug,
                        ]) }}'
                    @else
                        '{{ route('restaurants.home.filter', [
                            'restaurants' => $restaurants->slug,
                        ]) }}'
                    @endif ,
                    method: 'GET',
                    data: payload,
                    success: function(response) {
                        // Actualizar tabla de ventas
                        if (response.rowsVentas) {
                            actualizarTablaVentas(response.rowsVentas);
                        }

                        // Actualizar tabla de alimentos y bebidas
                        if (response.rowsFoodDrink) {
                            actualizarTablaFood(response.rowsFoodDrink);
                        }

                        syncModeIndicator();
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseJSON?.message ?? xhr.responseText);
                        alert('Error al cargar los datos: ' + (xhr.responseJSON?.message ??
                            'Intenta de nuevo.'));
                    },
                    complete: function() {
                        $('#loading-indicator').addClass('d-none');
                        $('#btn-filter').prop('disabled', false);
                    }
                });
            });

            // Función para actualizar tabla de ventas
            function actualizarTablaVentas(htmlContent) {
                if ($.fn.DataTable.isDataTable('#datatable_ventas')) {
                    $('#datatable_ventas').DataTable().destroy();
                }

                var tempDiv = $('<div>').html(htmlContent);
                var nuevoTbody = tempDiv.find('#datatable_ventas tbody').html();
                $('#datatable_ventas tbody').html(nuevoTbody);

                table = $('#datatable_ventas').DataTable({
                    responsive: true,
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: -1,
                    drawCallback: function() {
                        recalcularTotales();
                    },
                    initComplete: function() {
                        recalcularTotales();
                    }
                });
            }

            // Función para actualizar tabla de alimentos
            function actualizarTablaFood(htmlContent) {
                if ($.fn.DataTable.isDataTable('#datatable_ventas_food')) {
                    $('#datatable_ventas_food').DataTable().destroy();
                }

                var tempDiv = $('<div>').html(htmlContent);
                var nuevoTbody = tempDiv.find('#datatable_ventas_food tbody').html();
                $('#datatable_ventas_food tbody').html(nuevoTbody);

                tableFood = $('#datatable_ventas_food').DataTable({
                    responsive: true,
                    order: [
                        [0, 'asc']
                    ],
                    pageLength: -1,
                    drawCallback: function() {
                        recalcularTotalesFood();
                    },
                    initComplete: function() {
                        recalcularTotalesFood();
                    }
                });

                // Forzar recálculo después de reinicializar
                setTimeout(function() {
                    recalcularTotalesFood();
                }, 100);
            }

            // Estado inicial
            syncModeIndicator();
        });

        // Función para recalcular totales de ventas
        function recalcularTotales() {
            console.log('Recalculando totales de ventas...');

            if (!table) {
                calcularTotalesDirecto();
                return;
            }

            try {
                let total_clientes = 0;
                let total_venta = 0;
                let total_iva = 0;
                let total_subtotal = 0;
                let total_efectivo = 0;
                let total_propina = 0;
                let total_tarjeta = 0;
                let total_descuento = 0;

                if (table.rows && typeof table.rows === 'function') {
                    table.rows({
                        search: 'applied'
                    }).every(function() {
                        let rowData = this.data();
                        if (rowData && rowData.length > 0) {
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
                } else {
                    calcularTotalesDirecto();
                    return;
                }

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

            } catch (error) {
                console.error('Error en recalcularTotales:', error);
                calcularTotalesDirecto();
            }
        }

        // Método directo para ventas
        function calcularTotalesDirecto() {
            console.log('Usando método directo jQuery para ventas');

            let total_clientes = 0;
            let total_venta = 0;
            let total_iva = 0;
            let total_subtotal = 0;
            let total_efectivo = 0;
            let total_propina = 0;
            let total_tarjeta = 0;
            let total_descuento = 0;

            $('#datatable_ventas tbody tr').each(function() {
                var $row = $(this);
                if ($row.find('td[colspan]').length > 0) return;

                total_clientes += parseFloat($row.find('td:eq(1)').text().replace(/[$,]/g, '')) || 0;
                total_venta += parseFloat($row.find('td:eq(2)').text().replace(/[$,]/g, '')) || 0;
                total_iva += parseFloat($row.find('td:eq(3)').text().replace(/[$,]/g, '')) || 0;
                total_subtotal += parseFloat($row.find('td:eq(4)').text().replace(/[$,]/g, '')) || 0;
                total_efectivo += parseFloat($row.find('td:eq(5)').text().replace(/[$,]/g, '')) || 0;
                total_propina += parseFloat($row.find('td:eq(6)').text().replace(/[$,]/g, '')) || 0;
                total_tarjeta += parseFloat($row.find('td:eq(7)').text().replace(/[$,]/g, '')) || 0;
                total_descuento += parseFloat($row.find('td:eq(8)').text().replace(/[$,]/g, '')) || 0;
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

        // Función para recalcular totales de alimentos - VERSIÓN CORREGIDA
        function recalcularTotalesFood() {
            console.log('Calculando totales de alimentos y bebidas...');

            // Intentar con DataTable primero
            if (tableFood && tableFood.rows) {
                try {
                    let total_food = 0;
                    let total_desc_food = 0;
                    let total_drinks = 0;
                    let total_desc_drinks = 0;
                    let total_pct_food = 0;
                    let total_pct_drinks = 0;
                    let contadorFilas = 0;

                    tableFood.rows({
                        search: 'applied'
                    }).every(function() {
                        let rowData = this.data();
                        if (rowData && rowData.length > 0) {
                            // Limpiar y sumar valores
                            total_food += parseFloat(rowData[1]?.toString().replace(/[$,]/g, '')) || 0;
                            total_desc_food += parseFloat(rowData[2]?.toString().replace(/[$,]/g, '')) || 0;
                            total_drinks += parseFloat(rowData[4]?.toString().replace(/[$,]/g, '')) || 0;
                            total_desc_drinks += parseFloat(rowData[5]?.toString().replace(/[$,]/g, '')) || 0;

                            // Porcentajes (quitar %)
                            total_pct_food += parseFloat(rowData[3]?.toString().replace(/[%]/g, '')) || 0;
                            total_pct_drinks += parseFloat(rowData[6]?.toString().replace(/[%]/g, '')) || 0;

                            contadorFilas++;
                        }
                    });

                    // Calcular promedios
                    let avg_food_pct = contadorFilas > 0 ? total_pct_food / contadorFilas : 0;
                    let avg_drinks_pct = contadorFilas > 0 ? total_pct_drinks / contadorFilas : 0;

                    actualizarFooterTotalesFood({
                        total_food: total_food,
                        total_desc_food: total_desc_food,
                        avg_food: avg_food_pct,
                        total_drinks: total_drinks,
                        total_desc_drinks: total_desc_drinks,
                        avg_drinks: avg_drinks_pct
                    });

                    return;
                } catch (error) {
                    console.error('Error en recalcularTotalesFood con DataTable:', error);
                }
            }

            // Fallback: método directo con jQuery
            calcularTotalesFoodDirecto();
        }

        // Método directo para alimentos con jQuery
        function calcularTotalesFoodDirecto() {
            console.log('Usando método directo jQuery para alimentos');

            let total_food = 0;
            let total_desc_food = 0;
            let total_drinks = 0;
            let total_desc_drinks = 0;
            let total_pct_food = 0;
            let total_pct_drinks = 0;
            let contadorFilas = 0;

            $('#datatable_ventas_food tbody tr').each(function() {
                var $row = $(this);
                if ($row.find('td[colspan]').length > 0) return;

                total_food += parseFloat($row.find('td:eq(1)').text().replace(/[$,]/g, '')) || 0;
                total_desc_food += parseFloat($row.find('td:eq(2)').text().replace(/[$,]/g, '')) || 0;
                total_drinks += parseFloat($row.find('td:eq(4)').text().replace(/[$,]/g, '')) || 0;
                total_desc_drinks += parseFloat($row.find('td:eq(5)').text().replace(/[$,]/g, '')) || 0;

                total_pct_food += parseFloat($row.find('td:eq(3)').text().replace(/[%]/g, '')) || 0;
                total_pct_drinks += parseFloat($row.find('td:eq(6)').text().replace(/[%]/g, '')) || 0;

                contadorFilas++;
            });

            let avg_food_pct = contadorFilas > 0 ? total_pct_food / contadorFilas : 0;
            let avg_drinks_pct = contadorFilas > 0 ? total_pct_drinks / contadorFilas : 0;

            actualizarFooterTotalesFood({
                total_food: total_food,
                total_desc_food: total_desc_food,
                avg_food: avg_food_pct,
                total_drinks: total_drinks,
                total_desc_drinks: total_desc_drinks,
                avg_drinks: avg_drinks_pct
            });
        }

        // Función para actualizar el footer de ventas
        function actualizarFooterTotales(totales) {
            $('#total_clientes').text(totales.clientes.toFixed(0));
            $('#total_venta').text('$' + totales.venta.toFixed(2));
            $('#total_iva').text('$' + totales.iva.toFixed(2));
            $('#total_subtotal').text('$' + totales.subtotal.toFixed(2));
            $('#total_efectivo').text('$' + totales.efectivo.toFixed(2));
            $('#total_propina').text('$' + totales.propina.toFixed(2));
            $('#total_tarjeta').text('$' + totales.tarjeta.toFixed(2));
            $('#total_descuento').text('$' + totales.descuento.toFixed(2));
        }

        // Función para actualizar el footer de alimentos
        function actualizarFooterTotalesFood(totales) {
            $('#total_food').text('$' + totales.total_food.toFixed(2));
            $('#total_desc_food').text('$' + totales.total_desc_food.toFixed(2));
            $('#avg_food').text(totales.avg_food.toFixed(1) + '%');
            $('#total_drinks').text('$' + totales.total_drinks.toFixed(2));
            $('#total_desc_drinks').text('$' + totales.total_desc_drinks.toFixed(2));
            $('#avg_drinks').text(totales.avg_drinks.toFixed(1) + '%');
        }

        // Eventos para recalcular al ordenar
        $(document).on('click', '#datatable_ventas thead th', function() {
            setTimeout(recalcularTotales, 50);
        });

        $(document).on('click', '#datatable_ventas_food thead th', function() {
            setTimeout(recalcularTotalesFood, 50);
        });

        // Forzar recalculo cuando la página termine de cargar
        $(window).on('load', function() {
            setTimeout(function() {
                recalcularTotales();
                recalcularTotalesFood();
            }, 500);
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
