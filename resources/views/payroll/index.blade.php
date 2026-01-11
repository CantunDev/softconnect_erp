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
                        <a class="nav-link" data-bs-toggle="tab" href="#payroll_periods" role="tab">
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
                        <a class="nav-link" data-bs-toggle="tab" href="#positions" role="tab">
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
                                                <th scope="col" class="px-4 py-3">Nombre</th>
                                                <th scope="col" class="px-4 py-3">Contacto</th>
                                                <th scope="col" class="px-4 py-3">Direccion</th>
                                                <th scope="col" class="px-4 py-3">Fecha Contratacion</th>
                                                <th scope="col" class="px-4 py-3">Estatus</th>
                                                <th scope="col" class="px-4 py-3">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($employees as $employe)
                                                <tr>
                                                    <td> {{ $employe->id }} </td>
                                                    <td> {{ $employe->full_name }} </td>
                                                    <td> {{ $employe->email }} </td>
                                                    <td> {{ $employe->address }} </td>
                                                    <td> {{ $employe->hire_date }} </td>
                                                    <td> {{ $employe->status }} </td>
                                                    <td> {{ $employe->id }} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <!-- end table -->
                                </div>
                                <!-- end table responsive -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="payroll_periods" role="tabpanel">
                        <div>
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">
                                        {{-- Lista de proveedores  --}}
                                    </h5>
                                    {{-- @can('create_providers') --}}
                                    <div class="flex-shrink-0">
                                        <div class="flex-shrink-0">
                                            <a href="{{ route('business.restaurants.payroll_periods.create', ['business' => request()->route('business'), 'restaurants' => request()->route('restaurants')]) }}"
                                                class="btn btn-sm btn-success">
                                                <i class="mdi mdi-plus me-1"></i>
                                                Nuevo
                                            </a>
                                        </div>
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
                                                <th scope="col" class="px-4 py-3">#</th>
                                                <th scope="col" class="px-4 py-3">Fecha inicio</th>
                                                <th scope="col" class="px-4 py-3">Fecha termino</th>
                                                <th scope="col" class="px-4 py-3">Periodo</th>
                                                <th scope="col" class="px-4 py-3">Estatus</th>
                                                <th scope="col" class="px-4 py-3">Notas</th>
                                                <th scope="col" class="px-4 py-3">Opciones</th>
                                            </tr>
                                        </thead>
                                         @foreach ($payroll_periods as $payroll_period)
                                                <tr>
                                                    <td> {{ $payroll_period->id }} </td>
                                                    <td> {{ $payroll_period->start_date }} </td>
                                                    <td> {{ $payroll_period->end_date }} </td>
                                                    <td> {{ $payroll_period->period_number }} </td>
                                                    <td> {{ $payroll_period->status }} </td>
                                                    <td> {{ $payroll_period->notes }} </td>
                                                    <td> 
                                                        <a class="btn btn-success btn-sm" href="{{ route('business.restaurants.attendance.create', ['business'=>$business, 'restaurants' => $restaurants ]) }}">
                                                            <i class="mdi mdi-account-multiple-plus me-1"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                    </table>
                                    <!-- end table -->
                                </div>
                                <!-- end table responsive -->
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="positions" role="tabpanel">
                        <div>
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">
                                        {{-- Lista de proveedores  --}}
                                    </h5>
                                    {{-- @can('create_providers') --}}
                                    <div class="flex-shrink-0">
                                        <a href="{{ route('business.restaurants.positions.create', ['business' => request()->route('business'), 'restaurants' => request()->route('restaurants')]) }}"
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
                                    <table id="table_typeproviders"
                                        class="table table-sm align-middle dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Puesto</th>
                                                <th scope="col">Descripcion</th>
                                                <th scope="col">Salario Base</th>
                                                <th scope="col">Tipo</th>
                                                <th scope="col">Horas</th>
                                                <th scope="col">Estatus</th>
                                                <th scope="col" class="px-4 py-3">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($positions as $position)
                                                <tr>
                                                    <td> {{ $position->id }} </td>
                                                    <td> {{ $position->name }} </td>
                                                    <td> {{ $position->description }} </td>
                                                    <td> {{ $position->base_salary }} </td>
                                                    <td> {{ $position->salary_type }} </td>
                                                    <td> {{ $position->hours_per_day }} </td>
                                                    <td> {{ $position->status }} </td>
                                                    <td> {{ $position->id }} </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
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
