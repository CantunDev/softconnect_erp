@extends('layouts.master')
@section('title')
    Roles & Permisos |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
        Roles & Permisos
        @endslot
        @slot('bcPrevText')
        Roles & Permisos
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
            <h3 class="text-uppercase">Actualizar permisos para el rol de <span class="text-primary"> {{$roles->name}} </span></h3>
            <hr>
            
          </div>
          <div class="table-responsive">
            <form action="{{route('roles_permissions.update', $roles->id)}}" method="POST" class="form-group">
                @csrf
                @method('PUT')
                <table class="table table-sm table-bordered mb-0">
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
                                    <td>{{$per_cat->category}}</td>
                                    @foreach ($permisos as $j => $per)
                                        @if($per->category === $per_cat->category)
                                            <td style="text-align: center">
                                                <div class="checkbox checkbox-blue mb-2">
                                                    <input type="checkbox" id="chk{{ $per->id }}" name="permission[]"
                                                        value="{{ $per->id }}" {{ $roles->permissions->pluck('id')->contains($per->id) ? 'checked' : '' }}>
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
                        Actualizar<span class="btn-label-right"></span>
                    </button>
                    <a  href="{{ url()->previous() }}" class="btn btn-danger waves-effect waves-light">
                        Cancelar<span class="btn-label-right"></span>
                    </a>
                </div>
            </form>
        </div> <!-- end table-responsive-->
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
          <div class="card-box">
         

          </div> <!-- end card-box -->
      </div> <!-- end col -->
  </div>
</div>
@endsection
@section('js')

@endsection
