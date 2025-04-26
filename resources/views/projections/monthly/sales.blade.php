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
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body border-bottom">
                        {{-- <div class="float-end dropdown ms-2">
                            <a class="text-muted" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
    
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div> --}}
    
                        <div>
                            <div class="mb-4 me-3">
                                {{-- <i class="mdi mdi-account-circle text-primary h1"></i> --}}
                            </div>
    
                            <div>
                                <h3 class="">{{ $restaurants->name }}</h3>
                                <p class="text-muted mb-1">{{ $business->name }}</p>
                                <p class="text-muted mb-0 text-uppercase">{{ $monthName }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body border-bottom">
                        <div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div>
                                        <p class="text-muted mb-2">
                                            <i class="text-success mdi mdi-cash-usd h5"></i>
                                            Ventas proyectadas
                                        </p>
                                        <h5 class="price"> {{ $projection->projected_sales }} </h5>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div>
                                        <p class="text-muted mb-2">
                                            <i class="text-warning mdi mdi-storefront h5"></i>
                                            Costos proyectados
                                        </p>
                                        <h5 class="price"> {{ $projection->projected_costs }} </h5>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div>
                                        <p class="text-muted mb-2">
                                            <i class="text-info mdi mdi-account-group h5"></i>
                                            Clientes proyectados
                                        </p>
                                        <h5> {{ $projection->projected_tax }} </h5>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    {{-- <div class="text-sm-end mt-4 mt-sm-0"> --}}
                                    <div>
                                        <p class="text-muted mb-2">
                                            <i class="text-danger mdi mdi-account-cash h5"></i>
                                            Ticket proyectado
                                        </p>
                                        <h5 class="price"> {{ $projection->projected_tax }} </h5>
                                        {{-- <h5>+  <span class="badge bg-success ms-1 align-bottom">+ 1.3 %</span></h5> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    </div>
    
                </div>
            </div>
        </div>
    <form
        action="{{ route('business.restaurants.projections.month.sales.update', [
            'business' => $restaurants->business->slug, 
            'restaurants' => $restaurants->slug,
            'month' => $monthName,
            ]) }}"
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
                            <h1 class="card-title mb-0">Registrar Proyecciones de {{$monthName}} para
                                <span>{{ $restaurants->name }}</span>
                                {{ $year }}
                            </h1>
                        
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
                                        <th colspan="2">Venta Real</th>
                                        <th colspan="2">Clientes</th>
                                        <th colspan="2">Ticket Promedio</th>
                                        {{-- <th colspan="2">#</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                     {{-- @dd($sales) --}}
                                    @foreach ($days as $i => $dayInfo)
                                    <input type="hidden" value="{{ $dayInfo['full_date'] }}" name="date[]">
                                    <input type="hidden" value="{{ $projection }}" name="projection_id">
                                    
                                    <tr class="product">
                                        <td>
                                            <div style="width: 80px;">
                                                <p class="mb-0">
                                                    <span class="fw-medium text-uppercase">
                                                        {{ $dayInfo['short_name'] }}
                                                    </span>
                                                </p>
                                            </div>
                                        </td>
                                        <td></td>
                                        <td style="align-items: center;">
                                            <div style="width: 90px;">
                                                <span>{{ $projections_monthly[$i]->projected_day_sales ?? 0 }}</span>
                                            </div>
                                        </td>
                                        <td style="align-items: center;">
                                            <div style="width: 90px;">
                                                <input class="form-control" type="text" name="actual_day_sales[]"
                                                       value="{{ $ventas = $sales[$i-1]['total_sales'] ?? 0 }}"> 
                                            </div>
                                        </td>
                                        <td style="align-items: center;">
                                         
                                        </td>
                                        <td>
                                            <div style="width: 90px;">
                                                <input class="form-control" type="text" name="actual_day_tax[]"
                                                       value="{{ $clientes = $sales[$i-1]['total_personas'] ?? 0 }}"> 
                                            </div>
                                        </td>
                                        <td></td>
                                        <td>
                                            @php
                                                // Inicializar variables para el día actual
                                                
                                                // Calcular ticket promedio (evitando división por cero)
                                                $ticket = ($ventas > 0 && $clientes > 0) 
                                                    ? round($ventas / $clientes, 2) 
                                                    : 0;
                                            @endphp
                                            <div style="width: 90px;">
                                                <input class="form-control" type="text" name="actual_day_check[]"
                                                   value="{{ $ticket }}"> 
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
                                    <button type="submit" class="btn btn-success">
                                        <i class="mdi mdi-skip-next me-1"></i> Registrar Ventas </button>
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
  
</script>
@endsection
