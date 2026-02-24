@extends('layouts.master')

@section('title')
    Crear Rol |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title') Roles & Permisos @endslot
        @slot('bcPrevText') Roles & Permisos @endslot
        @slot('bcPrevLink') {{ route('roles_permissions.index') }} @endslot
        @slot('bcActiveText') Nuevo Rol @endslot
    @endcomponent

    <div class="card">
        <div class="card-header py-3 d-flex align-items-center gap-2">
            <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:38px;height:38px">
                <i class="bx bx-shield-plus text-primary font-size-18"></i>
            </div>
            <div>
                <h5 class="card-title mb-0">Nuevo Rol</h5>
                <small class="text-muted">Complete los datos y asigne los permisos correspondientes</small>
            </div>
        </div>
        <div class="card-body">
            @include('roles_permissions._form', [
                'role'     => null,
                'route'    => route('roles_permissions.store'),
                'method'   => 'POST',
                'btnText'  => 'Registrar Rol',
                'isEdit'   => false,
            ])
        </div>
    </div>
@endsection