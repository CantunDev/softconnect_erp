@extends('layouts.master')
@section('title')
    Actualizar Empresa |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Editar Empresa
        @endslot
        @slot('bcPrevText')
            Empresas
        @endslot
        @slot('bcPrevLink')
            {{ route('business.index') }}
        @endslot
        @slot('bcActiveText')
            Editar empresa
        @endslot
    @endcomponent

    <div class="card">
        <div class="card-body">
          <form id="business_edit" class="row g-3" action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
                <div class="col-sm-6 col-lg-4">
                    <label for="inputName" class="form-label">Nombre corto</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        id="inputName" placeholder="Ej: Empresa Demo" value="{{ old('name', $business->name) }}">
                    <input type="hidden" id="business_id" value="{{ old('id', $business->id) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-6">
                    <label for="inputBusinessName" class="form-label">Nombre oficial</label>
                    <input name="business_name" type="text"
                        class="form-control @error('business_name') is-invalid @enderror" id="inputBusinessName"
                        placeholder="Ej: Empresa Demo SA de CV"
                        value="{{ old('business_name', $business->business_name) }}">
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-4 col-md-3 col-lg-2">
                    <label for="inputRfc" class="form-label">RFC</label>
                    <input name="rfc" type="text"
                        class="form-control text-uppercase @error('rfc') is-invalid @enderror" id="inputRfc" minlength="12"
                        maxlength="13" value="{{ old('rfc', $business->rfc) }}">
                    @error('rfc')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-8 col-md-6 col-lg-3">
                    <label for="inputAddress" class="form-label">Dirección</label>
                    <input name="business_address" type="text"
                        class="form-control @error('business_address') is-invalid @enderror" id="inputAddress"
                        placeholder="Ej: Calle A entre B y C"
                        value="{{ old('business_address', $business->business_address) }}">
                    @error('business_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-3 col-lg-2">
                    <label for="inputPhone" class="form-label">Teléfono</label>
                    <input name="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror"
                        id="inputPhone" minlength="10" maxlength="15" placeholder="Ej: 9380000000"
                        value="{{ old('telephone', $business->telephone) }}">
                    @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-4">
                    <label for="inputEmail" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="inputEmail"
                        class="form-control text-lowercase @error('email') is-invalid @enderror"
                        placeholder="softconnect_erp@mail.com" value="{{ old('email', $business->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-3">
                    <label for="inputWeb" class="form-label">Sitio web <span
                            class="fw-normal text-muted">(opcional)</span></label>
                    <input name="web" type="url" class="form-control @error('web') is-invalid @enderror"
                        id="inputWeb" placeholder="Ej: www.sitioweb.com" value="{{ old('web', $business->web) }}">
                    @error('web')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <label for="inputBusinessLine" class="form-label">Línea de negocio</label>
                    <input type="text" name="business_line" id="inputBusinessLine"
                        class="form-control @error('business_line') is-invalid @enderror" placeholder="Ej: Restaurantes"
                        value="{{ old('business_line', $business->business_line) }}">
                    @error('business_line')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-4 col-lg-3">
                    <label for="inputCountry" class="form-label">País</label>
                    <input type="text" name="country" id="inputCountry"
                        class="form-control @error('country') is-invalid @enderror"
                        value="{{ old('country', $business->country) }}">
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-4 col-lg-3">
                    <label for="inputState" class="form-label">Estado</label>
                    <input type="text" name="state" id="inputState"
                        class="form-control @error('state') is-invalid @enderror"
                        value="{{ old('state', $business->state) }}">
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-4 col-lg-3">
                    <label for="inputCity" class="form-label">Ciudad</label>
                    <input type="text" name="city" id="inputCity"
                        class="form-control @error('city') is-invalid @enderror"
                        value="{{ old('city', $business->city) }}">
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-4">
                    <label for="inputRegime" class="form-label">Régimen <span
                            class="fw-normal text-muted">(opcional)</span></label>
                    <input type="text" name="regime" id="inputRegime"
                        class="form-control @error('regime') is-invalid @enderror"
                        value="{{ old('regime', $business->regime) }}">
                    @error('regime')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-4">
                    <label for="inputRegimensat" class="form-label">Régimen SAT <span
                            class="fw-normal text-muted">(opcional)</span></label>
                    <input type="text" name="idregiment_sat" id="inputRegimensat"
                        class="form-control @error('idregiment_sat') is-invalid @enderror"
                        value="{{ old('idregiment_sat', $business->idregiment_sat) }}">
                    @error('idregiment_sat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-lg-4">
                    <label for="inputLogo" class="form-label">Logo <span
                            class="fw-normal text-muted">(opcional)</span></label>
                    <input type="file" name="business_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                        class="form-control @error('business_file') is-invalid @enderror">
                    @error('business_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div>
    </div>

        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Asignar Restaurantes a la empresa</h4>
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3 col-lg-6">
                        <h4 class="card-title mb-4">Selecciona tu restaurante</h4>
                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle mb-0" id="restaurants-table">
                                <tbody id="restaurants-body">
                                    @foreach ($restaurants as $restaurant)
                                        <tr>
                                            <td style="width: 10px;">
                                                <div class="form-check font-size-16">
                                                    <input type="checkbox" name="restaurant_ids[]" value="{{$restaurant->id}}" id="restaurantCheck{{$restaurant->id}}" {{ $business->business_restaurants->pluck('id')->contains($restaurant->id) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="restaurantCheck{{$restaurant->id}}"></label>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-group-item me-2">
                                                        <a href="javascript: void(0);" class="d-inline-block">
                                                            <img src="https://avatar.oxro.io/avatar.svg?name={{$restaurant->name}}"&caps=3&bold=true alt="" class="rounded-circle avatar-xs">
                                                        </a>
                                                    </div>
                                                    <h5 class="text-truncate font-size-14 m-0 ms-2"><a href="#" class="text-dark">{{$restaurant->name}}</a></h5>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-warning">Actualizar</button>
                        <a class="btn btn-outline-secondary" href="{{ route('business.index') }}">Cancelar</a>
                    </div>
                </div>
                </form>
            </div>
        </div>
@endsection
@section('js')
@endsection
