@extends('layouts.master')
@section('content')
    <style>
        /* Establece un ancho máximo para la columna y añade puntos suspensivos */
        .table td {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
            /* Ajusta este valor según tus necesidades */
        }
    </style>
    <x-restaurant-info-component :restaurants="$restaurants" />
    <div class="col-xl-12">
        <div class="card"
            style="border: 2px solid {{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc' }};">
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
                        <a class="nav-link" data-bs-toggle="tab" href="#typeproviders" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Tipo proveedores</span>
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
                                        <a href="{{ route('business.restaurants.providers.create', ['business' => request()->route('business'), 'restaurants' => request()->route('restaurants')]) }}"
                                            class="btn btn-sm btn-success">
                                            <i class="mdi mdi-plus me-1"></i>
                                            Nuevo
                                        </a>
                                    </div>
                                    {{-- @endcan --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table_providers"
                                        class="table table-sm align-middle dt-responsive nowrap w-100 table-check">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col" class="px-4 py-3">Proveedor</th>
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
                    <div class="tab-pane" id="typeproviders" role="tabpanel">
                        <div>
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">
                                        {{-- Lista de proveedores  --}}
                                    </h5>
                                    {{-- @can('create_providers') --}}
                                    <div class="flex-shrink-0">
                                        <button class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#addProviderTypeModal">
                                            <i class="mdi mdi-plus"></i> Nuevo Tipo
                                        </button>
                                    </div>
                                    {{-- @endcan --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table_typeproviders"
                                        class="table table-sm align-middle dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Clave</th>
                                                <th scope="col">Descripcion</th>
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
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal para agregar tipo de proveedor -->
    <div class="modal fade" id="addProviderTypeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Tipo de Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="providerTypeForm">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Clave</label>
                            <input type="text" class="form-control" name="idtipoproveedor" placeholder="CARNES">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <input type="text" class="form-control" name="descripcion" placeholder="CARNES y PROTEINAS"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            // Objeto para almacenar instancias de DataTables
            const dataTables = {
                providers: null,
                types: null
            };

            // Inicializar la tabla de proveedores (pestaña activa por defecto)
            initDataTable('providers');

            // Evento para inicializar otras tablas al cambiar de pestaña
            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const target = $(e.target).attr('href');

                if (target === '#typeproviders' && !dataTables.types) {
                    initDataTable('types');
                }
            });

            // Función centralizada para inicialización de DataTables
            function initDataTable(tableType) {
                const configs = {
                    providers: {
                        tableId: '#table_providers',
                        ajax: {
                            url: '{!! route('business.restaurants.providers.index', [
                                'business' => request()->route('business'),
                                'restaurants' => request()->route('restaurants'),
                            ]) !!}',
                            type: 'GET'
                        },
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
                                className: 'text-center'
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
                    },
                    types: {
                        tableId: '#table_typeproviders',
                        ajax: {
                            url: '{!! route('business.restaurants.typeproviders.index', [
                                'business' => request()->route('business'),
                                'restaurants' => request()->route('restaurants'),
                            ]) !!}',
                            type: 'GET'
                        },
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                orderable: false,
                                searchable: false
                            },
                            {
                                data: 'idtipoproveedor',
                                name: 'idtipoproveedor'
                            },
                            {
                                data: 'descripcion',
                                name: 'descripcion'
                            },
                            {
                                data: 'actions',
                                name: 'actions',
                                orderable: false
                            }
                        ]
                    }
                };

                // Inicialización condicional
                if (!dataTables[tableType]) {
                    dataTables[tableType] = $(configs[tableType].tableId).DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: configs[tableType].ajax,
                        columns: configs[tableType].columns,
                        language: {
                            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                        }
                    });
                }



            }

            // Manejar envío del formulario
            $('#providerTypeForm').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    url: '{!! route('business.restaurants.typeproviders.store', [
                        'business' => request()->route('business'),
                        'restaurants' => request()->route('restaurants'),
                    ]) !!}',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addProviderTypeModal').modal('hide');
                        $('#table_typeproviders').DataTable().ajax.reload();
                        $('#providerTypeForm')[0].reset();
                    },
                    error: function(xhr) {
                        console.log(xhr.responseJSON.message);
                        // toastr.error(xhr.responseJSON.message || 'Error al guardar');
                    }
                });
            });

        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $.ajax({
                url: '{!! route('business.restaurants.providers.index', [
                    'business' => request()->route('business'),
                    'restaurants' => request()->route('restaurants'),
                ]) !!}',
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
                                    className: 'text-center'
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
    </script> --}}

    <script>
        function btnSuspend(id) {
            Swal.fire({
                title: "Desea suspender el proveedor?",
                text: "Por favor asegúrese y luego confirme !",
                icon: 'warning',
                showCancelButton: !0,
                confirmButtonText: "¡Sí, suspender!",
                cancelButtonText: "¡No, cancelar!",
                reverseButtons: !0
            }).then(function(e) {
                if (e.value === true) {
                    // Formatear el ID para asegurar 2 dígitos
                    var formattedId = id.toString().padStart(2, '0');
                    $.ajax({
                        type: 'PUT',
                        url: '{!! route('business.restaurants.providers.suspend', [
                            'business' => request()->route('business'),
                            'restaurants' => request()->route('restaurants'),
                            'providers' => ':id',
                        ]) !!}'.replace(':id', formattedId),
                        data: {
                            id: id,
                            _token: '{!! csrf_token() !!}'
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response);
                            if (response.success === true) {
                                Swal.fire({
                                    title: "Hecho!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonText: "Hecho!",
                                });
                                $('#table_providers').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.message,
                                    icon: "error",
                                    confirmButtonText: "Cancelar!",
                                });
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function(dismiss) {
                return false;
            })
        }
    </script>
@endsection
