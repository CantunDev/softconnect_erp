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
                        <a class="nav-link active" data-bs-toggle="tab" href="#employees" role="tab">
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
                    <div class="tab-pane active" id="employees" role="tabpanel">
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
                                    <table id="table_employees"
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
                                        Puestos
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
                                    <table id="table_positions"
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
                                                <th scope="col">Opciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
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
@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
            $('#table_positions').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ajax: {
                    url: '{!! route('business.restaurants.positions.index', ['business' => $business->slug, 'restaurants' => $restaurants->slug]) !!}',
                },

                language: {
                    "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
                },

                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                    
                    {data: 'position', name: 'name', orderable: false, searchable: false},
                    {data: 'description', name: 'description', orderable: false, searchable: false},
                    {data: 'salary_format', name: 'base_salary', orderable: false, searchable: false},
                    {data: 'salary_type', name: 'salary_type', orderable: false, searchable: false},
                    {data: 'hours_per_day', name: 'hours_per_day', orderable: false, searchable: false},
                    {data: 'status', name: 'status', orderable: false, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
            });
    });
</script>
<script>
    function btnSuspendPosition(id) {
        Swal.fire({
            title: "¿Desea suspender?",
            text: "Por favor asegúrese y luego confirme!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "¡Sí, suspender!",
            cancelButtonText: "Cancelar",
        }).then(function (e) {
            if (e.value === true) {
                let url = "{{ route('business.restaurants.positions.suspend', ['business' => $business->slug, 'restaurants' => $restaurants->slug, 'position' => ':id']) }}";
                url = url.replace(':id', id);
    // ¿}
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        _token: '{!! csrf_token() !!}'
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response);
                        if (response.success === true) {
                            Swal.fire({
                                title: "Hecho!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "Hecho!",
                            });
                            $('#table_positions').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                confirmButtonText: "Cancelar!",
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                        Swal.fire({
                            title: "Error!",
                            text: "Ocurrió un error al suspender",
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }

    function btnRestorePosition(id) {
        Swal.fire({
            title: "¿Desea Restaurar?",
            text: "Esta acción restaurará el puesto",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "¡Sí, restaurar!",
            cancelButtonText: "Cancelar",
        }).then(function (e) {
            if (e.value === true) {
                let url = "{{ route('business.restaurants.positions.restore', ['business' => $business->slug, 'restaurants' => $restaurants->slug, 'position' => ':id']) }}";
                url = url.replace(':id', id);
                
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: {
                        _token: '{!! csrf_token() !!}'
                    },
                    dataType: 'JSON',
                    success: function (response) {
                        console.log(response);
                        if (response.success === true) {
                            Swal.fire({
                                title: "Hecho!",
                                text: response.message,
                                icon: "success",
                                confirmButtonText: "Hecho!",
                            });
                            $('#table_positions').DataTable().ajax.reload();
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                confirmButtonText: "Cancelar!",
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                        Swal.fire({
                            title: "Error!",
                            text: "Ocurrió un error al restaurar",
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }

    function btnDeletePosition(id) {
        Swal.fire({
            title: "¿Desea eliminar permanentemente?",
            text: "Por favor asegúrese y luego confirme, esta opción es irreversible!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "¡Sí, eliminar!",
            cancelButtonText: "¡No, cancelar!",
            confirmButtonColor: '#d33'
        }).then(function (e) {
            if (e.value === true) {
                let url = "{{ route('business.restaurants.positions.destroy', ['business' => $business->slug, 'restaurants' => $restaurants->slug, 'position' => ':id']) }}";
                url = url.replace(':id', id);
                
                 $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Eliminado", response.message, "success");
                            $('#table_positions').DataTable().ajax.reload();
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    }
                });
            } else {
                e.dismiss;
            }
        }, function (dismiss) {
            return false;
        })
    }
</script>

<script>
    $(document).ready(function() {
        $('#table_employees').DataTable({
            processing: true,
            serverSide: true,
            paging: true,

            ajax: {
                url: '{!! route('business.restaurants.employees.index', ['business' => $business->slug, 'restaurants' => $restaurants->slug]) !!}',
            },
            language: {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json"
            },

            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'full_name', name: 'first_name'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'hire_date', name: 'hire_date'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
        });
    });

    function btnSuspendEmployee(id) {
        Swal.fire({
            title: "¿Desea suspender empleado?",
            text: "El empleado no aparecerá en nóminas activas.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Sí, suspender",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('business.restaurants.employees.suspend', ['business' => $business->slug, 'restaurants' => $restaurants->slug, 'employee' => ':id']) }}";
                url = url.replace(':id', id);
                
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Suspendido", response.message, "success");
                            $('#table_employees').DataTable().ajax.reload();
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    },
                    error: function() {
                        Swal.fire("Error", "Error al procesar la solicitud", "error");
                    }
                });
            }
        });
    }

    function btnRestoreEmployee(id) {
        Swal.fire({
            title: "¿Restaurar empleado?",
            text: "El empleado volverá a estar activo.",
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: "Sí, restaurar"
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('business.restaurants.employees.restore', ['business' => $business->slug, 'restaurants' => $restaurants->slug, 'employee' => ':id']) }}";
                url = url.replace(':id', id);
                
                $.ajax({
                    type: 'PUT',
                    url: url,
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Restaurado", response.message, "success");
                            $('#table_employees').DataTable().ajax.reload();
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    }
                });
            }
        });
    }

    function btnDeleteEmployee(id) {
        Swal.fire({
            title: "¿Eliminar permanentemente?",
            text: "Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar"
        }).then((result) => {
            if (result.isConfirmed) {
                let url = "{{ route('business.restaurants.employees.destroy', ['business' => $business->slug, 'restaurants' => $restaurants->slug, 'employee' => ':id']) }}";
                url = url.replace(':id', id);
                
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Eliminado", response.message, "success");
                            $('#table_employees').DataTable().ajax.reload();
                        } else {
                            Swal.fire("Error", response.message, "error");
                        }
                    }
                });
            }
        });
    }
</script>
@endsection