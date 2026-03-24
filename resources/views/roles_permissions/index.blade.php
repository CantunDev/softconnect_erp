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
            {{ route('config.roles_permissions.index') }}
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent

    {{-- ========== CARD: ROLES ========== --}}
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <div>
                <h5 class="card-title mb-0">
                    <i class="bx bx-shield-quarter me-1 text-primary"></i> Roles
                </h5>
                <small class="text-muted">Gestión de roles del sistema</small>
            </div>
            <a href="{{ route('config.roles_permissions.create') }}" class="btn btn-primary d-flex align-items-center gap-1"
                data-bs-toggle="tooltip" title="Crear nuevo rol">
                <i class="bx bx-plus font-size-15"></i> Nuevo Rol
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_roles"
                    class="table table-wrapper text-wrapper dt-responsive nowrap w-100 align-middle table-nowrap table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50px">#</th>
                            <th scope="col">Nombre Rol</th>
                            <th scope="col">Usuarios</th>
                            <th scope="col">Permisos</th>
                            <th scope="col" style="width: 120px" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ========== CARD: PERMISOS ========== --}}
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between py-3">
            <div>
                <h5 class="card-title mb-0">
                    <i class="bx bx-key me-1 text-success"></i> Permisos
                </h5>
                <small class="text-muted">Permisos disponibles en el sistema</small>
            </div>
            {{-- Descomenta si tienes ruta para crear permisos:
            <a href="{{ route('permissions.create') }}"
               class="btn btn-success d-flex align-items-center gap-1"
               data-bs-toggle="tooltip" title="Crear nuevo permiso">
                <i class="bx bx-plus font-size-15"></i> Nuevo Permiso
            </a>
            --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_permissions"
                    class="table table-wrapper text-wrapper dt-responsive nowrap w-100 align-middle table-nowrap table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" style="width: 50px">#</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Permisos</th>
                            <th scope="col">Modelos</th>
                            <th scope="col" style="width: 120px" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Filled via DataTables AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ── Inicialización de tooltips de Bootstrap ──────────────────────────────
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipEls = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipEls.forEach(el => new bootstrap.Tooltip(el));
        });

        // ── DataTable: Roles ─────────────────────────────────────────────────────
        $(document).ready(function() {
            $('#table_roles').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ajax: {
                    url: '{!! route('config.roles.get') !!}',
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
                    processing: '<div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div> Cargando...',
                },
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
                        data: 'users',
                        name: 'users',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
            });
        });

        // ── DataTable: Permisos ──────────────────────────────────────────────────
        $(document).ready(function() {
            $('#table_permissions').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ajax: {
                    url: '{!! route('config.permissions.get') !!}',
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json',
                    processing: '<div class="spinner-border spinner-border-sm text-success me-2" role="status"></div> Cargando...',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'category',
                        name: 'category',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'permissions',
                        name: 'permissions',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'models',
                        name: 'models',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ],
            });
        });

        // ── Eliminar Rol ─────────────────────────────────────────────────────────
        function btnDelete(id) {
            Swal.fire({
                title: '¿Desea eliminar este rol?',
                text: 'Esta acción es irreversible. Asegúrese antes de confirmar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bx bx-trash"></i> Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true,
            }).then(function(result) {
                if (result.isConfirmed) {
                    // Feedback visual mientras se procesa
                    Swal.fire({
                        title: 'Procesando...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading(),
                    });

                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('config.roles_permissions') }}/" + id,
                        data: {
                            id: id,
                            _token: '{!! csrf_token() !!}',
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            if (response.success === true) {
                                Swal.fire({
                                    title: '¡Eliminado!',
                                    text: response.message,
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar',
                                });
                                $('#table_roles').DataTable().ajax.reload(null, false);
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    confirmButtonText: 'Cerrar',
                                });
                            }
                        },
                        error: function(xhr) {
                            const msg = xhr.responseJSON?.message ?? 'Ocurrió un error inesperado.';
                            Swal.fire({
                                title: 'Error del servidor',
                                text: msg,
                                icon: 'error',
                                confirmButtonText: 'Cerrar',
                            });
                        },
                    });
                }
            });
        }
    </script>
@endsection
