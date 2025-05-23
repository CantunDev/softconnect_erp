@extends('layouts.master')
@section('content')
    <x-restaurant-info-component :restaurants="$restaurants" />
    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}
    <form
        action="{{ route('business.restaurants.providers.store', [
            'business' => $business->slug ?? '',
            'restaurants' => $restaurants->slug ?? '',
        ]) }}"
        id="form_providers" method="post">
        @csrf
        @method('POST')
        <div class="row">
            <div class="col-xl-12 col-sm-9">
                <div class="card" style="border: 2px solid #ccc;">
                    <div class="card-body">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-shipping" role="tabpanel"
                                aria-labelledby="v-pills-shipping-tab">
                                <div>
                                    <h4 class="card-title">Informacion del proveedor</h4>
                                    <div class="form-group row mb-4">
                                        <label for="nombre" class="col-md-2 col-form-label"> Nombre</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="nombre" name="nombre"
                                                placeholder="Proveedor" value="{{ old('nombre') }}">
                                            @error('nombre')
                                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="razonsocial" class="col-md-2 col-form-label"> Razon social</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="razonsocial" name="razonsocial"
                                                placeholder="Proveedor SA de CV" value="{{ old('razonsocial') }}">
                                            @error('razonsocial')
                                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="rfc" class="col-md-2 col-form-label"> RFC</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="rfc" name="rfc"
                                                placeholder="PRV12345445">
                                            @error('rfc')
                                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="direccion" class="col-md-2 col-form-label">Direccion</label>
                                        <div class="col-md-10">
                                            <textarea class="form-control" id="direccion" name="direccion" rows="3" placeholder="Calle 20 Entre 30 "></textarea>
                                            @error('direccion')
                                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="codigopostal" class="col-md-2 col-form-label"> Codigo Postal</label>
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" id="codigopostal" name="codigopostal"
                                                placeholder="89874" value="{{ old('codigopostal') }}">
                                            @error('codigopostal')
                                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="email" class="col-md-2 col-form-label">Correo electronico</label>
                                        <div class="col-md-10">
                                            <input type="email" class="form-control" id="email" name="email"
                                                placeholder="proveedor@proveedor" value="{{ old('email') }}">
                                            @error('email')
                                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4">
                                        <label for="telefono" class="col-md-2 col-form-label">Teléfono</label>
                                        <div class="col-md-10 position-relative">
                                            <span class="phone-flag-mx"></span>
                                            <input type="text" class="form-control phone pl-5" id="telefono"
                                                name="telefono" placeholder="938 123 3234">
                                            @error('telefono')
                                                <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-sm-9">
                <div class="card" style="border: 2px solid #ccc;">
                    <div class="card-body">
                        <div class="tab-pane" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                            <div>
                                <h4 class="card-title">Informacion extra</h4>
                                <div class="form-group row mb-4">
                                    <div class="col-lg-2 mr-2 ml-4">
                                        <div class="form-group mb-0">
                                            <label for="credito">Dias credito</label>
                                            <input type="text" class="form-control text-center" id="credito"
                                                name="credito" placeholder="0" value="{{ old('credito')}} ">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 mr-2 ml-4">
                                        <div class="form-group mb-0">
                                            <label for="idtipoproveedor">Tipo de proveedor</label>
                                            <select class="form-control select2" title="idtipoproveedor"
                                                id="idtipoproveedor" name="idtipoproveedor">
                                                <option value="0">Selecciona una opcion</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group mb-0">
                                            <label for="idcuentacontable">Cuenta contable</label>
                                            <select class="form-control select2" title="idcuentacontable"
                                                id="idcuentacontable" name="idcuentacontable">
                                                <option value="0">Selecciona una opcion</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-sm-9">
                <div class="card" style="border: 2px solid #ccc;">
                    <div class="card-body">
                        <div class="tab-pane" id="v-pills-payment" role="tabpanel"
                            aria-labelledby="v-pills-payment-tab">
                            <div>
                                <h4 class="card-title">Informacion de cuenta</h4>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group mb-0">
                                            <label for="nombrebanco">Banco</label>
                                            <select class="form-control select2" title="nombrebanco" name="nombrebanco">
                                                <option value="0">Selecciona una opcion</option>
                                                <option value="AL">Alabama</option>
                                                <option value="AK">Alaska</option>
                                                <option value="AZ">Arizona</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-0">
                                            <label for="cuentaclave">Cuenta Clave</label>
                                            <input type="text" class="form-control" id="cuentaclave"
                                                name="cuentaclave" placeholder="0000 0000 000000000000 0">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group mb-0">
                                            <label for="nocuenta">Numero de cuenta</label>
                                            <input type="text" class="form-control" id="nocuenta" name="nocuenta"
                                                placeholder="998348438">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-between">
                                <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Cancelar</a>
                                <button type="submit" class="btn btn-success">Registrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @section('js')
        <script>
        $(document).ready(function() {
                $("input[name='credito']").TouchSpin({
                // verticalbuttons: true,
                min: 0,
                max: 30,
                step: 1,
                decimals: 0,
                boostat: 1,
                maxboostedstep: 1,
                verticalupclass: 'bi bi-chevron-up',
                verticaldownclass: 'bi bi-chevron-down',
            });
        });
    </script>
    @endsection
@endsection
