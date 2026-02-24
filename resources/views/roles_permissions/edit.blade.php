@extends('layouts.master')

@section('title')
    Editar Rol |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title') Roles & Permisos @endslot
        @slot('bcPrevText') Roles & Permisos @endslot
        @slot('bcPrevLink') {{ route('roles_permissions.index') }} @endslot
        @slot('bcActiveText') Editar: {{ $role->name }} @endslot
    @endcomponent

    <div class="card">
        <div class="card-header py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="avatar-sm bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px">
                    <i class="bx bx-shield-x text-warning font-size-18"></i>
                </div>
                <div>
                    <h5 class="card-title mb-0">Editar Rol</h5>
                    <small class="text-muted">Modifique el nombre o los permisos asignados</small>
                </div>
            </div>
            {{-- Badges informativos --}}
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 rounded-pill px-3 py-2">
                    <i class="bx bx-user me-1"></i>
                    {{ $role->users_count ?? $role->users()->count() }} usuario(s)
                </span>
                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                    <i class="bx bx-key me-1"></i>
                    {{ $role->permissions()->count() }} permiso(s) activos
                </span>
            </div>
        </div>
        <div class="card-body">
            @include('roles_permissions._form', [
                'role'     => $role,
                'route'    => route('roles_permissions.update', $role->id),
                'method'   => 'PUT',
                'btnText'  => 'Guardar Cambios',
                'isEdit'   => true,
            ])
        </div>
    </div>
@endsection