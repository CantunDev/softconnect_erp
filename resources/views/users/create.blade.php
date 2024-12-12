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

  <div class="card">
    <div class="card-body">
      <form class="row g-3" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="col-sm-6 col-lg-4">
          <label for="inputName" class="form-label">Nombre</label>
          <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="inputName"
            placeholder="Nombre" value="{{ old('name') }}">
          @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-lg-4">
          <label for="inputBusinessName" class="form-label">A. Paterno</label>
          <input name="business_name" type="text" class="form-control @error('business_name') is-invalid @enderror"
            id="inputBusinessName" placeholder="Apellido" value="{{ old('business_name') }}">
          @error('business_name')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="col-sm-6 col-lg-4">
          <label for="inputRfc" class="form-label">A. Materno</label>
          <input name="rfc" type="text" class="form-control @error('rfc') is-invalid @enderror"
            id="inputRfc" placeholder="Apellido" value="{{ old('rfc') }}">
          @error('rfc')
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

        <div class="col-lg-4">
          <label for="inputLogo" class="form-label">Imagen <span class="fw-normal text-muted">(opcional)</span></label>
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
  
  <div class="card">
      <div class="card-body">
        <h4 class="card-title mb-4">Seleccina tu empresa</h4>
        <form class="row g-3" action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('POST')
      
          <div class="col-sm-6 col-md-3 col-lg-6">
            <select class="form-control" name="business_id" id="business_id">
              <option disabled selected>Selecciona una opcion</option>
              @foreach ($business as $bs)
                <option value="{{$bs->id}}">{{$bs->business_name}}</option>  
              @endforeach
            </select>
              @error('business_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
          </div>    
          <div class="col-sm-6 col-md-3 col-lg-6">
              <h4 class="card-title mb-4">Selecciona tu restaurante</h4>
              <div class="table-responsive">
                  <table class="table table-nowrap align-middle mb-0">
                      <tbody>
                          <tr>
                              <td style="width: 40px;">
                                  <div class="form-check font-size-16">
                                      <input class="form-check-input" type="checkbox" id="upcomingtaskCheck01">
                                      <label class="form-check-label" for="upcomingtaskCheck01"></label>
                                  </div>
                              </td>     
                              <td>
                                  <div class="avatar-group">
                                      <div class="avatar-group-item">
                                          <a href="javascript: void(0);" class="d-inline-block">
                                              <img src="{{ URL::asset('/assets/images/users/avatar-4.jpg') }}" alt="" class="rounded-circle avatar-xs">
                                          </a>
                                      </div>
                                  </div>
                              </td>
                              <td>
                                <h5 class="text-truncate font-size-14 m-0"><a href="#" class="text-dark">Create a
                                        Skote Dashboard UI</a></h5>
                              </td>
                              <td>
                                  <div class="text-center">
                                      <span
                                          class="badge rounded-pill badge-soft-secondary font-size-11">Waiting</span>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>    
          <div class="col-12 mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Registrar</button>
            <a class="btn btn-outline-secondary" href="{{ route('business.index') }}">Cancelar</a>
          </div>
        </form>
    </div>
  </div>

@endsection