@extends('layouts.master')
@section('title')
    Roles & Permisos |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
        Roles & Permisos
        @endslot
        @slot('bcPrevText')
        Roles & Permisos
        @endslot
        @slot('bcPrevLink')
            {{ route('roles_permissions.index') }}
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="bx bx-plus font-size-15"></i> Nuev Rol
                </a>
            </div>
            <div class="table-responsive">
                <table id="table_roles" class="table table-wrapper text-wrapper  dt-responsive nowrap w-100 align-middle table-nowrap table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre Rol</th>
                            <th scope="col">Usuarios</th>
                            <th scope="col">Permisos</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="bx bx-plus font-size-15"></i> Nuevo permiso
                </a>
            </div>
            <div class="table-responsive">
                <table id="table_permissions" class="table table-wrapper text-wrapper  dt-responsive nowrap w-100 align-middle table-nowrap table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Permisos</th>
                            <th scope="col">Modelos</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    $(document).ready(function(){
        $('#table_roles').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: '{!! route('roles.get') !!}',
            },
            language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name', orderable: false, searchable: false},
                {data: 'users', name: 'users', orderable: false, searchable: false},
                {data: 'permissions', name: 'permissions', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('#table_permissions').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: '{!! route('permissions.get') !!}',
            },
            language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'category', name: 'category', orderable: false, searchable: false},
                {data: 'permissions', name: 'permissions', orderable: false, searchable: false},
                {data: 'models', name: 'models', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    });
</script>
@endsection
