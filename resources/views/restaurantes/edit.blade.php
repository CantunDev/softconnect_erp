@extends('layouts.master')
@section('title')
    Actualizar Restaurante
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Actualizar Restaurante
        @endslot
        @slot('bcPrevText')
            Restaurante
        @endslot
        @slot('bcPrevLink')
            {{ route('restaurants.index') }}
        @endslot
        @slot('bcActiveText')
            Editar Restaurante
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-body">
            <form class="row g-3" action="{{ route('restaurants.update', $restaurant->id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-sm-6 col-lg-4">
                    <label for="inputName" class="form-label">Nombre</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        id="inputName" value="{{ $restaurant->name }}" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6 col-lg-2">
                    <label for="color_primary" class="form-label">Color primario</label>
                    <input name="color_primary" type="color" class="form-control @error('name') is-invalid @enderror"
                        id="color_primary"  value="{{ $restaurant->color_primary }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6 col-lg-2">
                    <label for="color_secondary" class="form-label">Color secundario</label>
                    <input name="color_secondary" type="color" class="form-control @error('name') is-invalid @enderror"
                        id="color_secondary" placeholder="" value="{{ $restaurant->color_secondary }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-6 col-lg-2">
                    <label for="color_accent" class="form-label">Color de Acento</label>
                    <input name="color_accent" type="color" class="form-control @error('name') is-invalid @enderror"
                        id="color_accent" placeholder="" value="{{ $restaurant->color_accent }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-sm-8 col-lg-8">
                    <label for="inputBusinessName" class="form-label">Descripcion</label>
                    <input name="description" type="text" class="form-control @error('description') is-invalid @enderror"
                        id="inputDescription" value="{{ $restaurant->description }}" value="{{ old('description') }}">
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-3 col-lg-4">
                    <label for="inputIp" class="form-label">Vpn Ip</label>
                    <input name="ip" type="text" value="{{ $restaurant->ip }}"
                        class="form-control text-uppercase @error('ip') is-invalid @enderror" id="inputIp"
                        value="{{ old('ip') }}">
                    @error('ip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-4">
                    <label for="inputDatabase" class="form-label">Base de Datos</label>
                    <input type="text" name="database" id="inputDatabase"
                        class="form-control @error('database') is-invalid @enderror" value="{{ $restaurant->database }}">
                    @error('database')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4">
                    <label for="inputLogo" class="form-label">Logo Restaurant <span
                            class="fw-normal text-muted">(opcional)</span></label>
                    <input type="file" name="restaurant_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                        class="form-control @error('restaurant_file') is-invalid @enderror">
                    @error('restaurant_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Registrar</button>
                    <a class="btn btn-outline-secondary" href="{{ route('restaurants.index') }}">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
