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
            {{-- {{ route('business.providers.index', ['business' => request()->rote('business')]) }} --}}
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent
    {{-- style="border: 2px solid {{ !empty($restaurant->color_primary) ? $restaurant->color_primary : '#ccc' }}; --}}
    {{-- color: {{ !empty($restaurant->color_accent) ? $restaurant->color_accent : '#000' }};" --}}
    <style>
        .bootstrap-touchspin .input-group-btn-vertical .btn {
            background-color: {{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#ccc' }};
            border-color: {{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#ccc' }};
            color: {{ !empty($restaurants->color_accent) ? $restaurants->color_accent : '#000' }};
        }

        .bootstrap-touchspin .input-group-btn-vertical .btn:hover {
            background-color: {{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#ccc' }};
            border-color: {{ !empty($restaurants->color_primary) ? $restaurants->color_secondary : '#ccc' }};
        }

        .bootstrap-touchspin .form-control {
            border-color: {{ !empty($restaurants->color_primary) ? $restaurants->color_secondary : '#ccc' }};
            color: {{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#ccc' }};
        }
    </style>
    <form
        action="{{ route('business.restaurants.projections.store', ['business' => $restaurants->business->slug, 'restaurants' => $restaurants->slug]) }}"
        method="post">
        @csrf
        @method('POST')
        <input type="hidden" value="{{ $year }}" class="" name="year">
        <input type="hidden" value="{{ $restaurants->id }}" class="" name="restaurant_id">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title mb-0">Registrar Proyecciones Mensuales para
                                <span>{{ $restaurants->name }}</span>
                                {{ $year }}
                            </h1>
                            <button onclick="clearProyections()" type="button" class="btn btn-secondary waves-effect btn-label waves-light">
                                <i class="mdi mdi-trash-can-outline label-icon"></i> Borrar Metas
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table id="table_projections"
                                class="table table-sm table-wrapper text-wrapper  dt-responsive nowrap w-100 align-middle table-nowrap table-hover">
                                <thead
                                    style="
                                    background-color: {{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc' }};
                                    color: {{ !empty($restaurants->color_accent) ? $restaurants->color_accent : '#000' }}; ">
                                    <tr>
                                        <th>Mes</th>
                                        <th colspan="2">Proyectado</th>
                                        <th colspan="2">Costo</th>
                                        <th colspan="2">Ganancia</th>
                                        <th colspan="2">Clientes</th>
                                        <th colspan="2">Cheque</th>
                                        {{-- <th colspan="2">#</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($months as $monthNumber => $monthName)
                                        <input type="hidden" value="{{ $monthNumber }}" class="price_cl" name="month[]">
                                        <tr class="product">
                                            <td>
                                                <p class="mb-0"><span
                                                        class="fw-medium text-uppercase">{{ $monthName }}</span></p>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="" style="width: 90px;">
                                                    <input type="text" value="0" class="price_cl"
                                                        name="projected_sales[]"
                                                        {{-- {{ $currentMonth > $monthNumber ? 'readonly' : '' }} --}}
                                                        >
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 90px;">
                                                    <input type="text" value="0" class=""
                                                        name="projected_costs[]"
                                                        {{-- {{ $currentMonth > $monthNumber ? 'readonly' : '' }} --}}
                                                        >
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 90px;">
                                                    <input type="text" value="0" class=""
                                                        name="projected_profit[]"
                                                        {{-- {{ $currentMonth > $monthNumber ? 'readonly' : '' }} --}}
                                                        >
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 60px;">
                                                    <input type="text" value="0" class=""
                                                        name="projected_tax[]"
                                                        {{-- {{ $currentMonth > $monthNumber ? 'readonly' : '' }} --}}
                                                        >
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 60px;">
                                                    <input type="text" value="0" class=""
                                                        name="projected_check[]"
                                                        {{-- {{ $currentMonth > $monthNumber ? 'readonly' : '' }} --}}
                                                        >
                                                </div>
                                            </td>
                                            {{-- <td style="align-items: center;">
                                        <div class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove">
                                            <a href="#removeItemModal" data-bs-toggle="modal" class="action-icon text-danger"> <i class="mdi mdi-trash-can font-size-18"></i></a>
                                        </div>
                                    </td> --}}
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4">
                            <div class="col-sm-6">
                                <a href="ecommerce-products.html" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Volver </a>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    <button type="submit" class="btn btn-success">
                                        <i class="mdi mdi-skip-next me-1"></i> Registrar Proyecciones </button>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row-->
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            // Inicializar TouchSpin y Cleave.js para cada input
            $("input[name='projected_sales[]'], input[name='projected_costs[]'], input[name='projected_profit[]'], input[name='projected_tax[]'], input[name='projected_check[]']")
                .each(function() {
                    // Inicializar TouchSpin
                    $(this).TouchSpin({
                        verticalbuttons: true,
                        min: 0,
                        max: 100000000,
                        step: 1,
                        decimals: 0,
                        boostat: 5,
                        maxboostedstep: 10,
                        verticalupclass: 'bi bi-chevron-up',
                        verticaldownclass: 'bi bi-chevron-down',
                    });
                });
        });
    </script>
    <script>
        function clearProyections(){
            alert('Limpiar Proyecciones?');
        }
    </script>
@endsection
