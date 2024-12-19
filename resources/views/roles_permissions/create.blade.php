@extends('layouts.master')
@section('title')
    Roles & Permisos |
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Roles
        @endslot
        @slot('bcPrevText')
            Nuevo Role
        @endslot
        @slot('bcPrevLink')
            {{ route('roles_permissions.index') }}
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-start mb-3">
                <h3 class="text-uppercase">Registrar nuevo Role<span class="text-primary"> </span></h3>
                <hr>
            </div>
            <div class="table-responsive">
                <form action="{{ route('roles_permissions.store') }}" method="POST" class="form-group">
                    @csrf
                    @method('POST')
                    <div class="col-sm-6 col-lg-4">
                        <label for="inputName" class="form-label">Nombre</label>
                        <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="inputName" placeholder="Nombre" value="{{ old('name') }}">
                        <input name="guard_name" type="hidden" class="form-control @error('name') is-invalid @enderror" id="inputName" value="web" value="{{ old('guard_name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <table class="table table-sm table-bordered mb-0 mt-4">
                        <thead class="thead-dark">
                            <tr>
                                <th style="text-align: center"></th>
                                <th style="text-align: center">Crear</th>
                                <th style="text-align: center">Leer</th>
                                <th style="text-align: center">Actualizar</th>
                                <th style="text-align: center">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos_cat as $i => $per_cat)
                                <tr style="text-align: center">
                                    <td>{{ $per_cat->category }}</td>
                                    @foreach ($permisos as $j => $per)
                                        @if ($per->category === $per_cat->category)
                                            <td style="text-align: center">
                                                <div class="checkbox checkbox-blue mb-2">
                                                    <input type="checkbox" id="chk{{ $per->id }}" name="permission[]"
                                                        value="{{ $per->id }}">
                                                    <label for="chk{{ $per->id }}"></label>
                                                </div>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-success waves-effect waves-light">
                            Registrar<span class="btn-label-right"></span>
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger waves-effect waves-light">
                            Cancelar<span class="btn-label-right"></span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('js')
@endsection
