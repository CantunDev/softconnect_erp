@extends('layouts.master')
@section('content')
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
                            <span class="d-none d-sm-block">Empleados</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#typeproviders" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Periodos/Nominas</span>
                        </a>
                    </li>
                     <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#typeproviders" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Asistencias</span>
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#typeproviders" role="tab">
                            <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                            <span class="d-none d-sm-block">Puestos</span>
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
                                        <a href="{{ route('business.restaurants.employees.create', ['business' => request()->route('business'), 'restaurants' => request()->route('restaurants')]) }}"
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
@endsection
