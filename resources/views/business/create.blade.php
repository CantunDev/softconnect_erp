@extends('layouts.master')
@section('title')
  Nueva Empresa |
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Nueva Empresa
    @endslot
    @slot('bcPrevText')
      Empresas
    @endslot
    @slot('bcPrevLink')
      {{ route('business.index') }}
    @endslot
    @slot('bcActiveText')
      Nueva empresa
    @endslot
  @endcomponent

  <div class="card">
    <div class="card-body">
      <form class="row g-3" action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="col-sm-6 col-lg-6">
          <label for="inputName" class="form-label">Nombre corto</label>
          <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="inputName"
            placeholder="Ej: Empresa Demo" value="{{ old('name') }}">
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-lg-6">
          <label for="inputBusinessName" class="form-label">Nombre oficial</label>
          <input name="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror"
            id="inputBusinessName" placeholder="Ej: Empresa Demo SA de CV" value="{{ old('business_name') }}">
          @error('business_name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-6 col-lg-2">
          <label for="color_primary" class="form-label">Color primario</label>
          <input name="color_primary" type="color" class="form-control @error('name') is-invalid @enderror" id="color_primary"
            placeholder="" value="{{ old('name') }}">
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-6 col-lg-2">
          <label for="color_secondary" class="form-label">Color secundario</label>
          <input name="color_secondary" type="color" class="form-control @error('name') is-invalid @enderror" id="color_secondary"
            placeholder="" value="{{ old('name') }}">
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-6 col-lg-2">
          <label for="color_accent" class="form-label">Color de Acento</label>
          <input name="color_accent" type="color" class="form-control @error('name') is-invalid @enderror" id="color_accent"
            placeholder="" value="{{ old('name') }}">
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="col-sm-4 col-md-3 col-lg-2">
          <label for="inputRfc" class="form-label">RFC</label>
          <input name="rfc" type="text" class="form-control text-uppercase @error('rfc') is-invalid @enderror"
            id="inputRfc" minlength="12" maxlength="13" value="{{ old('rfc') }}">
          @error('rfc')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-8 col-md-6 col-lg-3">
          <label for="inputAddress" class="form-label">Dirección</label>
          <input name="business_address" type="text"
            class="form-control @error('business_address') is-invalid @enderror" id="inputAddress"
            placeholder="Ej: Calle A entre B y C" value="{{ old('business_address') }}">
          @error('business_address')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-md-3 col-lg-2">
          <label for="inputPhone" class="form-label">Teléfono</label>
          <input name="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror"
            id="inputPhone" minlength="10" maxlength="15" placeholder="Ej: 9380000000" value="{{ old('telephone') }}">
          @error('telephone')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-lg-4">
          <label for="inputEmail" class="form-label">Correo electrónico</label>
          <input type="email" name="email" id="inputEmail"
            class="form-control text-lowercase @error('email') is-invalid @enderror"
            placeholder="softconnect_erp@mail.com" value="{{ old('email') }}">
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-lg-3">
          <label for="inputWeb" class="form-label">Sitio web <span class="fw-normal text-muted">(opcional)</span></label>
          <input name="web" type="url" class="form-control @error('web') is-invalid @enderror" id="inputWeb"
            placeholder="Ej: www.sitioweb.com" value="{{ old('web') }}">
          @error('web')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-md-4 col-lg-3">
          <label for="inputBusinessLine" class="form-label">Línea de negocio</label>
          <input type="text" name="business_line" id="inputBusinessLine"
            class="form-control @error('business_line') is-invalid @enderror" placeholder="Ej: Restaurantes"
            value="{{ old('business_line') }}">
          @error('business_line')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-4 col-lg-3">
          <label for="inputCountry" class="form-label">País</label>
          <input type="text" name="country" id="inputCountry"
            class="form-control @error('country') is-invalid @enderror" value="{{ old('country', 'México') }}">
          @error('country')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-4 col-lg-3">
          <label for="inputState" class="form-label">Estado</label>
          <input type="text" name="state" id="inputState"
            class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}">
          @error('state')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-4 col-lg-3">
          <label for="inputCity" class="form-label">Ciudad</label>
          <input type="text" name="city" id="inputCity"
            class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
          @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-md-4">
          <label for="inputRegime" class="form-label">Régimen <span
              class="fw-normal text-muted">(opcional)</span></label>
          <input type="text" name="regime" id="inputRegime"
            class="form-control @error('regime') is-invalid @enderror" value="{{ old('regime') }}">
          @error('regime')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-md-4">
          <label for="inputRegimensat" class="form-label">Régimen SAT <span
              class="fw-normal text-muted">(opcional)</span></label>
          <input type="text" name="idregiment_sat" id="inputRegimensat"
            class="form-control @error('idregiment_sat') is-invalid @enderror" value="{{ old('idregiment_sat') }}">
          @error('idregiment_sat')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-lg-4">
          <label for="inputLogo" class="form-label">Logo <span class="fw-normal text-muted">(opcional)</span></label>
          <input type="file" name="business_file" accept=".jpg,.jpeg,.png" id="inputLogo"
            class="form-control @error('business_file') is-invalid @enderror">
          @error('business_file')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-12 mt-4 d-flex gap-2">
          <button type="submit" class="btn btn-primary">Registrar</button>
          <a class="btn btn-outline-secondary" href="{{ route('business.index') }}">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
@endsection
