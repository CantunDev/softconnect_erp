@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Proyecciones
        @endslot
        @slot('bcPrevText')
            Proyecciones
        @endslot
        @slot('bcPrevLink')
            {{ route('business.projections.index', ['business' => request()->route('business')]) }}
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent

    <div class="row">
        <div class="card" style="border: 2px solid #ccc">
            <div class="card-body border-bottom">
                <div class="d-flex align-items-center">
                    <h5 class="mb-0 card-title flex-grow-1">Lista de Proyecciones </h5>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="table_projections"
                        class="table table-sm align-middle dt-responsive nowrap w-100 table-check text-center">
                        <thead>
                            <tr>
                                <th scope="col" colspan="7">{{ $business->business_name }}</th>
                            </tr>
                            <tr>
                                <th scope="col" class="px-4 py-3">#</th>
                                <th scope="col" class="px-4 py-3">Restaurante</th>
                                <th scope="col" class="px-4 py-3">Proyecciones</th>
                                <th scope="col" class="px-4 py-3">Ganancia</th>
                                <th scope="col" class="px-4 py-3">Clientes</th>
                                <th scope="col" class="px-4 py-3">Costo Venta</th>
                                <th scope="col" class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        {{-- <tfoot>
                        <tr>
                            <th colspan="2" style="text-align:right">Total:</th>
                            <th id="total-projections">$0.00</th>
                            <th id="total-profit">$0.00</th>
                            <th id="total-tax">$0.00</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot> --}}
                    </table>
                    <!-- end table -->
                </div>
                <!-- end table responsive -->
            </div>
        </div>
    </div>
    <x-date-component></x-date-component>
    <div class="row">
        <div class="col-sm-4">
            <div class="card" style="border: 2px solid #ccc">
                <div class="card-body">
                    <p class="text-muted mb-4"><i class="mdi mdi-finance h2 text-warning align-middle mb-0 me-3"></i>
                        Proyectado </p>

                    <div class="row">
                        <div class="col-6">
                            <div>
                                <h5>$ 9134.39</h5>
                                <p class="text-muted text-truncate mb-0">+ 0.0012 ( 0.2 % ) <i
                                        class="mdi mdi-arrow-up ms-1 text-success"></i></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <div id="area-sparkline-chart-1" data-colors='["--bs-warning"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card" style="border: 2px solid #ccc">
                <div class="card-body">
                    <p class="text-muted mb-4"><i class="mdi mdi-account-group h2 text-info align-middle mb-0 me-3"></i>
                        Clientes </p>

                    <div class="row">
                        <div class="col-6">
                            <div>
                                <h5>$ 245.44</h5>
                                <p class="text-muted text-truncate mb-0">- 4.102 ( 0.1 % ) <i
                                        class="mdi mdi-arrow-down ms-1 text-danger"></i></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <div id="area-sparkline-chart-2" data-colors='["--bs-primary"]' class="apex-charts"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card" style="border: 2px solid #ccc">
                <div class="card-body">
                    <p class="text-muted mb-4"><i class="mdi mdi-account-cash h2 text-success align-middle mb-0 me-3"></i>
                        Cheque Promedio </p>

                    <div class="row">
                        <div class="col-6">
                            <div>
                                <h5>$ 63.61</h5>
                                <p class="text-muted text-truncate mb-0">+ 1.792 ( 0.1 % ) <i
                                        class="mdi mdi-arrow-up ms-1 text-success"></i></p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <div id="area-sparkline-chart-3" data-colors='["--bs-info"]' class="apex-charts"></div>
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
        console.log('Elementos encontrados:', document.querySelectorAll('.price').length);
        document.querySelectorAll('.price').forEach(el => {
            console.log('Contenido:', el.textContent, 'Parsed:', parseFloat(el.textContent));
        });

        function formatPrices() {
            const priceElements = document.querySelectorAll('.price:not(.formatted)');

            priceElements.forEach(element => {
                const rawValue = parseFloat(element.textContent);
                if (!isNaN(rawValue)) {
                    new AutoNumeric(element, {
                        currencySymbol: '$',
                        decimalPlaces: 2,
                        digitGroupSeparator: ',',
                        currencySymbolPlacement: 'p',
                        decimalCharacter: '.',
                        unformatOnSubmit: true,
                    }).set(rawValue);
                    element.classList.add('formatted'); // Marcar como formateado
                }
            });
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', formatPrices);

        // Observar cambios dinámicos en el DOM
        const observer = new MutationObserver(formatPrices);
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{!! route('business.projections.index', ['business' => request()->route('business')]) !!}',
                type: 'GET',
                success: function(response) {
                    if (response.data) {
                        $('#table_projections').DataTable({
                            processing: true,
                            serverSide: true,
                            paging: true,
                            data: response.data,
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'name',
                                    name: 'name',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'projections',
                                    name: 'projections',
                                    orderable: false,
                                    searchable: false,
                                },
                                {
                                    data: 'profit',
                                    name: 'profit',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'tax',
                                    name: 'tax',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'check',
                                    name: 'check',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                },

                            ],
                        });
                    } else {
                        console.error('No se encontraron datos en la respuesta');
                    }
                },
                error: function(error) {
                    console.error('Error al cargar los datos:', error);
                }
            });
        });
    </script>
@endsection
