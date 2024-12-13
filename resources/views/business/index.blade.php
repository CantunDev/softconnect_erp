@extends('layouts.master')
@section('title')
  Empresas |
@endsection

@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Empresas
    @endslot
    @slot('bcPrevText')
      Empresas
    @endslot
    @slot('bcPrevLink')
      {{ route('business.index') }}
    @endslot
    @slot('bcActiveText')
      Listado
    @endslot
  @endcomponent

  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('business.create') }}" class="btn btn-success d-flex align-items-center gap-1">
          <i class="bx bx-plus font-size-15"></i> Nueva empresa
        </a>
      </div>
      <div class="table-responsive">
        <table class="table project-list-table table-nowrap align-middle table-hover" id="datatable">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">RFC</th>
              <th scope="col">Linea de negocio</th>
              <th scope="col">Regimen</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($companies as $company)
              <tr>
                <td>
                  <p class="text-muted mb-0">{{ $company->id }}</p>
                </td>
                <td>
                  {{-- <h5 class="font-size-14 mb-0">{{ $company->name }}</h5> --}}
                  <p class="text-muted mb-0">{{ $company->name }}</p>
                </td>
                <td>
                  <p class="text-muted mb-0">{{ $company->rfc }}</p>
                </td>
                <td>
                  <p class="text-muted mb-0">{{ $company->business_line }}</p>
                </td>
                <td>
                  <p class="text-muted mb-0">{{ $company->regime }}</p>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical font-size-18"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                      {{-- <a class="dropdown-item" href="#"><i class="bx bx-show font-size-15"></i> Ver</a> --}}
                      <a class="dropdown-item" href="{{ route('business.edit', $company->id) }}"><i
                          class="bx bx-edit font-size-15"></i> Editar</a>
                      <form method="POST" action="{{ route('business.destroy', $company) }}"
                        data-id="{{ $company->name }}" class="form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"><i class="bx bx-trash font-size-15"></i>
                          Eliminar</button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      $("#datatable").DataTable({
        responsive: true,
        autoWidth: false,
        pagingType: "simple",
        language: {
          lengthMenu: "Mostrar _MENU_ registros / página",
          zeroRecords: "No se encontraron registros coincidentes",
          info: "Mostrando _PAGE_ de _PAGES_ páginas",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(_TOTAL_ registros filtrados)",
          search: "Buscar:",
          paginate: {
            next: "Siguiente",
            previous: "Anterior",
          },
          emptyTable: 'No hay datos disponibles en la tabla',
        },
        order: [
          [0, "desc"]
        ],
      });
      $(".datatable").attr("style", "border-collapse: collapse !important");
    });

    $(document).on('submit', '.form-delete', function(e) {
      e.preventDefault();

      const alertAttribute = $(this).data('id');

      Swal.fire({
        title: '¿Estás seguro?',
        text: 'La empresa ' + alertAttribute + ' se eliminará definitivamente.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      })
    });
  </script>
@endsection
