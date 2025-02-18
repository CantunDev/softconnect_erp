@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Proveedores
        @endslot
        @slot('bcPrevText')
            Proveedores
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
                <table id="table_providers" class="table align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Proveedore</th>
                            <th scope="col" class="px-4 py-3">Categoria</th>
                            <th scope="col" class="px-4 py-3">Compras</th>
                            <th scope="col" class="px-4 py-3">Promedio</th>
                            <th scope="col" class="px-4 py-3">Credito</th>
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
                url: '{!! route('business.providers.index', ['business' => request()->route('business')]) !!}',
                type: 'GET',
                success: function(response) {
                    if (response.data) {
                        $('#table_providers').DataTable({
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
                                    data: 'idtipoproveedor',
                                    name: 'idtipoproveedor ',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'purchases',
                                    name: 'purchases',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'average',
                                    name: 'average',
                                    orderable: false,
                                    searchable: false,
                                    render: function(data) {
                                        return '$' + data
                                    }
                                },
                                {
                                    data: 'credito',
                                    name: 'credito',
                                    orderable: false,
                                    searchable: false
                                },
                                {
                                    data: 'action',
                                    name: 'action',
                                    orderable: false,
                                    searchable: false
                                }
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
