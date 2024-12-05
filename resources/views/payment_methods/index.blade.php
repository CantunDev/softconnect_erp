@extends('layouts.master')
@section('title')
  Cuentas Contables |
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Cuentas
    @endslot
    @slot('bcPrevText')
      Cuentas
    @endslot
    @slot('bcPrevLink')
      {{ route('restaurants.index') }}
    @endslot
    @slot('bcActiveText')
      Listado
    @endslot
  @endcomponent
    <div class="card">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Lista de cuentas contables </h5>
                <div class="flex-shrink-0">
                    <a href="{{route('restaurants.create')}}" class="btn btn-primary">Nuevo</a>
                    {{-- <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_restaurants" class="table table-wrapper text-wrapper text-center align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Tipo</th>
                            <th scope="col" class=" text-wrapper">Moneda</th>
                            <th scope="col" class="">Cambio</th>
                            <th scope="col" class="">Estatus</th>
                            <th scope="col" class=""></th>
                        </tr>
                    </thead>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
        <!-- end card body -->
    </div>
          
@endsection