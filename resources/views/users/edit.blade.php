@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Actualizar usuario
        @endslot
        @slot('bcPrevText')
            Usuario
        @endslot
        @slot('bcPrevLink')
            {{ route('config.users.index') }}
        @endslot
        @slot('bcActiveText')
            Actualizar usuario
        @endslot
    @endcomponent
    @include('users._form', [
        'user' => $user,
        'method' => 'PUT',
        'btnText' => 'Actualizar',
        'action' => route('config.users.update', $user->id),
        'labelText' => 'Actualizar Usuario',
    ])
@endsection
