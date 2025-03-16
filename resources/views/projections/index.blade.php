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
            {{ route('business.providers.index', ['business' => request()->route('business')]) }} 
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Lista de proveedores </h5>
                @can('create_providers')
                    <div class="flex-shrink-0">
                        <a href="{{ route('business.providers.create',['business' => request()->route('business')]) }}" class="btn btn-primary">Nuevo</a>
                    </div>
                @endcan
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_projections" class="table align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                    <thead>
                        <tr>
                            <th scope="col" colspan="7">Grupo Restaurantero Corazon</th>
                        </tr>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Restaurante</th>
                            <th scope="col">Año</th>
                            <th scope="col" class="px-4 py-3">Proyeccion</th>
                            <th scope="col" class="px-4 py-3">Clientes</th>
                            <th scope="col" class="px-4 py-3">Costo</th>
                            <th scope="col" class="px-4 py-3"></th>
                        </tr>
                    </thead>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
    </div>
@endsection

@section('js')
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
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'DT_RowIndex',
                                    name: 'DT_RowIndex',
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
