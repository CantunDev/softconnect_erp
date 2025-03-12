@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Proveedores
        @endslot
        @slot('bcPrevText')
            Proveedores
        @endslot
        @slot('bcPrevLink')
            {{ route('business.providers.index', ['business' => request()->route('business')]) }} 
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent

@endsection