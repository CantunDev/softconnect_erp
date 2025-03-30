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
        action="{{ route('business.restaurants.projections.update', ['business' => $restaurants->business->slug, 'restaurants' => $restaurants->slug, 'projection' => $restaurants->id]) }}"
        method="post">
        @csrf
        @method('PUT')
        <input type="hidden" value="{{ $year }}" class="" name="year">
        <input type="hidden" value="{{ $restaurants->id }}" class="" name="restaurant_id">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="card-title mb-0">Actualizar Proyecciones Mensuales para
                                <span>{{ $restaurants->name }}</span>
                                {{ $year }}
                            </h1>
                            <button onclick="clearProjections()" type="button"
                                class="btn btn-secondary waves-effect btn-label waves-light">
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
                                                    <input type="text"
                                                        value="{{ $projectionsByMonth[$monthNumber] ? $projectionsByMonth[$monthNumber]->projected_sales : 0 }}"
                                                        class="clear" name="projected_sales[]"
                                                        {{ !Auth::user()->hasRole('Super-Admin') && $currentMonth > $monthNumber ? 'readonly' : '' }}>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 90px;">
                                                    <input type="text"
                                                        value="{{ $projectionsByMonth[$monthNumber] ? $projectionsByMonth[$monthNumber]->projected_costs : 0 }}"
                                                        class="clear" name="projected_costs[]"
                                                        {{ $currentMonth > $monthNumber ? 'readonly' : '' }}>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 90px;">
                                                    <input type="text"
                                                        value="{{ $projectionsByMonth[$monthNumber] ? $projectionsByMonth[$monthNumber]->projected_profit : 0 }}"
                                                        class="clear" name="projected_profit[]"
                                                        {{ $currentMonth > $monthNumber ? 'readonly' : '' }}>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 60px;">
                                                    <input type="text"
                                                        value="{{ $projectionsByMonth[$monthNumber] ? $projectionsByMonth[$monthNumber]->projected_tax : 0 }}"
                                                        class="clear" name="projected_tax[]"
                                                        {{ $currentMonth > $monthNumber ? 'readonly' : '' }}>
                                                </div>
                                            </td>
                                            <td></td>
                                            <td style="align-items: center;">
                                                <div class="me-1" style="width: 60px;">
                                                    <input type="text"
                                                        value="{{ $projectionsByMonth[$monthNumber] ? $projectionsByMonth[$monthNumber]->projected_check : 0 }}"
                                                        class="clear" name="projected_check[]"
                                                        {{ $currentMonth > $monthNumber ? 'readonly' : '' }}>
                                                </div>
                                            </td>
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
                                    <button type="submit" class="btn btn-warning">
                                        <i class="mdi mdi-skip-next me-1"></i> Actualizar Proyecciones </button>
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
    // Selector de inputs (mejorado para eficiencia)
    $("input[name^='projected_']").each(function() {
        const $input = $(this);
        
        // Verificar si el campo es readonly (bloqueado por tu condición Blade)
        if ($input.prop('readonly')) {
            // Bloquear completamente (estilo + evitar TouchSpin)
            $input.TouchSpin({
                verticalbuttons: true,
                min: 0,
                max: 0,
                maxboostedstep: 10,
                verticalupclass: 'bi dash',
                verticaldownclass: 'bi dash'
            });
        } else {
            // Inicializar TouchSpin SOLO en campos editables
            $input.TouchSpin({
                verticalbuttons: true,
                min: 0,
                max: 100000000,
                step: 1,
                decimals: 0,
                boostat: 5,
                maxboostedstep: 10,
            });
        }
    });
}); 
    </script>
    <script>
        function clearProjections() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción reseteará todas las proyecciones a 0 y no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, borrar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Limpiar solo campos editables (no readonly)
                    document.querySelectorAll('.clear').forEach(input => {
                        if (!input.readOnly) input.value = "0";
                    });

                    // Notificación de éxito
                    Swal.fire(
                        '¡Borrado!',
                        'Las proyecciones fueron reseteadas a 0.',
                        'success'
                    );
                }
            });
        }
    </script>
@endsection
