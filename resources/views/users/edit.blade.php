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
            {{ route('users.index') }}
        @endslot
        @slot('bcActiveText')
            Actualizar usuario
        @endslot
    @endcomponent
    @include('users._form',
        [
            'user' => $user,
            'method' => 'PUT',
            'btnText' => 'Actualizar',
            'action' => route('users.update', $user->id),
            'labelText' => 'Actualizar Usuario'     
        ])
@endsection

