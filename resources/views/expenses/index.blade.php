@extends('layouts.master')
@section('title')
    Gastos |
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Gastos
    @endslot
    @slot('bcPrevText')
      Gastos
    @endslot
    @slot('bcPrevLink')
      {{ route('expenses.index') }}
    @endslot
    @slot('bcActiveText')
      Listado
    @endslot
  @endcomponent
    <div class="card">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Lista de Gastos </h5>
                <div class="flex-shrink-0">
                    <a href="{{route('expenses.create')}}" class="btn btn-primary">Nuevo</a>
                    {{-- <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_restaurants" class="table table-wrapper text-wrapper text-center align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Fecha</th>
                            <th scope="col" class="px-4 py-3">Folio Nota </th>
                            <th scope="col" class="px-4 py-3">Folio Factura</th>
                            <th scope="col" class="px-4 py-3">Proveedor</th>
                            <th scope="col" class="px-4 py-3">Metodo de pago</th>
                            <th scope="col" class="px-4 py-3">Subtotal</th>
                            <th scope="col" class="px-4 py-3">Iva</th>
                            <th scope="col" class="px-4 py-3">Descuento</th>
                            <th scope="col" class="px-4 py-3">Total</th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>          
@endsection
