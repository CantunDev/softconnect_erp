@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Nueva usuario
        @endslot
        @slot('bcPrevText')
            Usuario
        @endslot
        @slot('bcPrevLink')
            {{ route('users.index') }}
        @endslot
        @slot('bcActiveText')
            Nueva usuario
        @endslot
    @endcomponent
    @include('users._form',
    [
        'user' => new App\Models\User,
        'method' => 'POST',
        'btnText' => 'Guardar',
        'action' => route('users.store'),
        'labelText' => 'Crear Nuevo Usuario'     
    ])
@endsection

