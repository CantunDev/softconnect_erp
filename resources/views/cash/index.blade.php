@extends('layouts.master')
@section('title')
    Movimientos Caja |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
        @endslot
        @slot('bcPrevText')
            Caja
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
                                        <table id="cashMovementsTable" class="table table-bordered table-striped">
                                            <thead
                                                style="background-color: {{ $restaurants->color_secondary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}">
                                                <tr>
                                                    <th data-priority="1">#</th>
                                                    <th data-priority="1">Fecha</th>
                                                    <th data-priority="3" class="text-center">Folio</th>
                                                    <th data-priority="3">Concepto</th>
                                                    <th data-priority="3">Referencia</th>
                                                    <th data-priority="6">Tipo</th>
                                                    <th data-priority="6">Usuario</th>
                                                    <th data-priority="6">Estatus</th>
                                                    <th data-priority="6">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Los datos se cargarán vía AJAX -->
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="4"></th>
                                                    <th colspan="4" class="text-end">Total:</th>
                                                    <th class="text-center" id="totalImporte"></th>
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

            // ── DataTable ────────────────────────────────────────────────
            var table = $('#cashMovementsTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                searching: false,
                ajax: {
                    url: '{!! route('business.restaurants.cash_movements.index', [
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
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'fecha_formateada',
                        name: 'fecha',
                        class: 'text-center'
                    },
                    {
                        data: 'folio_formateado',
                        name: 'folio',
                        class: 'text-center'
                    },
                    {
                        data: 'concepto',
                        name: 'concepto'
                    },
                    {
                        data: 'referencia',
                        name: 'referencia',
                        render: function(data) {
                            if (!data) return '';
                            return `<span style="display:block; max-width:150px; word-wrap:break-word; white-space:normal;">${data}</span>`;
                        }
                    },
                    {
                        data: 'tipo_movto',
                        name: 'tipo',
                        class: 'text-center'
                    },
                    {
                        data: 'usuarioautoriza',
                        name: 'usuarioautoriza'
                    },
                    {
                        data: 'estatus',
                        name: 'cancelado',
                        class: 'text-center'
                    },
                    {
                        data: 'importe_formateado',
                        name: 'importe',
                        class: 'text-end'
                    }

                ],
                order: [
                    [1, 'desc']
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();

                    var total = api.column('importe:name', {
                            search: 'applied'
                        })
                        .data()
                        .reduce(function(a, b) {
                            var valor = parseFloat(
                                $('<div>').html(b).text().replace(/[^0-9.-]/g, '')
                            ) || 0;
                            return a + valor;
                        }, 0);

                    var totalFormateado = '$' + total.toLocaleString('es-MX', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    $('#totalImporte').html('<strong>' + totalFormateado + '</strong>');
                }
            });

            // ── Botón filtrar ────────────────────────────────────────────
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
