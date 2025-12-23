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
          <i class="bx bx-plus font-size-15"></i> Nueva empresa de prueba
        </a>
      </div>
      <div class="table-responsive">
        {{-- <table class="table project-list-table table-nowrap align-middle table-hover" id="datatable"> --}}
          <table id="table_business" class="table table-wrapper text-wrapper  dt-responsive nowrap w-100 align-middle table-nowrap table-hover">
          <thead class="table-light">
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">Usuarios</th>
              <th scope="col">Restaurantes</th>
              <th scope="col">Estatus</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function(){
        $('#table_business').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: '{!! route('business.index') !!}',
            },
            language: {
                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'business', name: 'business', orderable: false, searchable: false},
                {data: 'users', name: 'users', orderable: false, searchable: false},
                {data: 'restaurants', name: 'restaurants', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    });
</script>
<script>
  function btnSuspend(id) {
      Swal.fire({
          title: "Desea suspender?",
          text: "Por favor asegúrese y luego confirme!",
          icon: 'warning',
          showCancelButton: !0,
          confirmButtonText: "¡Sí, suspender!",
          cancelButtonText: "¡No, cancelar!",
          reverseButtons: !0
      }).then(function (e) {
          if (e.value === true) {
              $.ajax({
                  type: 'PUT',
                  url: "{{ url('suspend/business') }}/" + id, 
                  data: {
                      id: id,
                      _token: '{!! csrf_token() !!}'
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      console.log(response);
                      if (response.success === true) {
                          Swal.fire({
                              title: "Hecho!",
                              text: response.message,
                              icon: "success",
                              confirmButtonText: "Hecho!",
                          });
                          $('#table_business').DataTable().ajax.reload();
                      } else {
                          Swal.fire({
                              title: "Error!",
                              text: response.message,
                              icon: "error",
                              confirmButtonText: "Cancelar!",
                          });
                      }
                  }
              });
          } else {
              e.dismiss;
          }
      }, function (dismiss) {
          return false;
      })
  }
</script>
<script>
  function btnRestore(id) {
      Swal.fire({
          title: "Desea Restaurar?",
          text: "Esta accion restaurara la empresa",
          icon: 'warning',
          showCancelButton: !0,
          confirmButtonText: "¡Sí, restaurar!",
          cancelButtonText: "¡No, cancelar!",
          reverseButtons: !0
      }).then(function (e) {
          if (e.value === true) {
              $.ajax({
                  type: 'PUT',
                  url: "{{ url('restore/business') }}/" + id, 
                  data: {
                      id: id,
                      _token: '{!! csrf_token() !!}'
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      console.log(response);
                      if (response.success === true) {
                          Swal.fire({
                              title: "Hecho!",
                              text: response.message,
                              icon: "success",
                              confirmButtonText: "Hecho!",
                          });
                          $('#table_business').DataTable().ajax.reload();
                      } else {
                          Swal.fire({
                              title: "Error!",
                              text: response.message,
                              icon: "error",
                              confirmButtonText: "Cancelar!",
                          });
                      }
                  }
              });
          } else {
              e.dismiss;
          }
      }, function (dismiss) {
          return false;
      })
  }
</script>
<script>
  function btnDelete(id) {
      Swal.fire({
          title: "Desea eliminar?",
          text: "Por favor asegúrese y luego confirme esta opcion sera irreversible !",
          icon: 'warning',
          showCancelButton: !0,
          confirmButtonText: "¡Sí, eliminar!",
          cancelButtonText: "¡No, cancelar!",
          reverseButtons: !0
      }).then(function (e) {
          if (e.value === true) {
              $.ajax({
                  type: 'DELETE',
                  url: "{{ url('business') }}/" + id, 
                  data: {
                      id: id,
                      _token: '{!! csrf_token() !!}'
                  },
                  dataType: 'JSON',
                  success: function (response) {
                      console.log(response);
                      if (response.success === true) {
                          Swal.fire({
                              title: "Hecho!",
                              text: response.message,
                              icon: "success",
                              confirmButtonText: "Hecho!",
                          });
                          $('#table_business').DataTable().ajax.reload();
                      } else {
                          Swal.fire({
                              title: "Error!",
                              text: response.message,
                              icon: "error",
                              confirmButtonText: "Cancelar!",
                          });
                      }
                  }
              });
          } else {
              e.dismiss;
          }
      }, function (dismiss) {
          return false;
      })
  }
</script>
@endsection
