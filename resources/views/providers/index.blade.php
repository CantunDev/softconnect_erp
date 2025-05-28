@extends('layouts.master')
@section('content')
<style>
    /* Establece un ancho máximo para la columna y añade puntos suspensivos */
.table td {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 200px; /* Ajusta este valor según tus necesidades */
}
</style>
<x-restaurant-info-component :restaurants="$restaurants"/>

<div class="col-xl-12">
    <div class="card" style="border: 2px solid {{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc' }};">
        <div class="card-body">
            <!-- Nav tabs -->
            <ul class="nav nav-pills nav-justified" role="tablist">
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link active" data-bs-toggle="tab" href="#providers" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">Proveedores</span> 
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Tipo proveedores</span> 
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab">
                        <span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
                        <span class="d-none d-sm-block">Otros</span>   
                    </a>
                </li>
                <li class="nav-item waves-effect waves-light">
                    <a class="nav-link" data-bs-toggle="tab" href="#settings-1" role="tab">
                        <span class="d-block d-sm-none"><i class="fas fa-cog"></i></span>
                        <span class="d-none d-sm-block">Otros</span>    
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="providers" role="tabpanel">
                    <div>
                        <div class="card-body border-bottom">
                            <div class="d-flex align-items-center">
                                <h5 class="mb-0 card-title flex-grow-1">
                                    {{-- Lista de proveedores  --}}
                                </h5>
                                {{-- @can('create_providers') --}}
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('business.restaurants.providers.create',['business' => request()->route('business'), 'restaurants' => request()->route('restaurants')]) }}" class="btn btn-sm btn-success">
                                            <i class="mdi mdi-plus me-1"></i>
                                            Nuevo
                                        </a>
                                    </div>
                                {{-- @endcan --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_providers" class="table align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col" class="px-4 py-3">Compras</th>
                                            <th scope="col" class="px-4 py-3">Promedio</th>
                                            <th scope="col" class="px-4 py-3">Credito</th>
                                            <th scope="col" class="px-4 py-3">Estatus</th>
                                            <th scope="col" class="px-4 py-3">Opciones</th>
                                        </tr>
                                    </thead>
                                </table>
                                <!-- end table -->
                            </div>
                            <!-- end table responsive -->
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="profile-1" role="tabpanel">
                    <p class="mb-0">
                        Food truck fixie locavore, accusamus mcsweeney's marfa nulla
                        single-origin coffee squid. Exercitation +1 labore velit, blog
                        sartorial PBR leggings next level wes anderson artisan four loko
                        farm-to-table craft beer twee. Qui photo booth letterpress,
                        commodo enim craft beer mlkshk aliquip jean shorts ullamco ad
                        vinyl cillum PBR. Homo nostrud organic, assumenda labore
                        aesthetic magna 8-bit.
                    </p>
                </div>
                <div class="tab-pane" id="messages-1" role="tabpanel">
                    <p class="mb-0">
                        Etsy mixtape wayfarers, ethical wes anderson tofu before they
                        sold out mcsweeney's organic lomo retro fanny pack lo-fi
                        farm-to-table readymade. Messenger bag gentrify pitchfork
                        tattooed craft beer, iphone skateboard locavore carles etsy
                        salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                        Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh
                        mi whatever gluten-free.
                    </p>
                </div>
                <div class="tab-pane" id="settings-1" role="tabpanel">
                    <p class="mb-0">
                        Trust fund seitan letterpress, keytar raw denim keffiyeh etsy
                        art party before they sold out master cleanse gluten-free squid
                        scenester freegan cosby sweater. Fanny pack portland seitan DIY,
                        art party locavore wolf cliche high life echo park Austin. Cred
                        vinyl keffiyeh DIY salvia PBR, banh mi before they sold out
                        farm-to-table.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

    <div class="card">
        
    </div>
@endsection

@section('js')
    {{-- <script>
     $(document).ready(function() {
    $('#table_providers').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('business.providers.index', ['business' => request()->route('business'), 'restaurants' => request()->route('restaurants')]) !!}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'purchases', name: 'purchases', searchable: false },
            { data: 'average', name: 'average', searchable: false },
            { data: 'credito', name: 'credito' },
            { data: 'status', name: 'status', searchable: false },
            { data: 'actions', name: 'actions', orderable: false, searchable: false },

        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        }
    });
});
    </script> --}}
    <script>
        $(document).ready(function() {
            $.ajax({
                url: '{!! route('business.restaurants.providers.index', ['business' => request()->route('business'), 'restaurants' => request()->route('restaurants')]) !!}',
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
                                    name: 'nombre',
                                    orderable: true,
                                    searchable: false,
                                },
                                {
                                    data: 'purchases',
                                    name: 'purchases',
                                    orderable: false,
                                    searchable: false,
                                    className:'text-center'
                                },
                                {
                                    data: 'average',
                                    name: 'average',
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-center',
                                    render: function(data) {
                                        return '$' + data
                                    }
                                },
                                {
                                    data: 'credito',
                                    name: 'credito',
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-center'
                                },
                                {
                                    data: 'status',
                                    name: 'status',
                                    orderable: false,
                                    searchable: false,
                                    className: 'text-center'
                                },
                                {
                                    data: 'actions',
                                    name: 'actions',
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
