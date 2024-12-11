@extends('layouts.master')
@section('title')
  Cuentas Contables |
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Cuentas
    @endslot
    @slot('bcPrevText')
      Cuentas
    @endslot
    @slot('bcPrevLink')
      {{ route('restaurants.index') }}
    @endslot
    @slot('bcActiveText')
      Listado
    @endslot
  @endcomponent
    <div class="card">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Lista de pagos contables </h5>
                <div class="flex-shrink-0">
                    <a href="{{route('restaurants.create')}}" class="btn btn-primary">Nuevo</a>
                    {{-- <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a> --}}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_accountings" class="table align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Tipo</th>
                            <th scope="col" class=" text-wrapper">Moneda</th>
                            <th scope="col" class="">Cambio</th>
                            <th scope="col" class="">Estatus</th>
                            <th scope="col" class="">Opciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
          
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        $.ajax({
            url: '{!! route('payment_method.index') !!}',
            type: 'GET',
            success: function (response) {
                if (response.data) { // Asegúrate de que la respuesta tenga datos
                    $('#table_accountings').DataTable({
                        processing: true,
                        serverSide: true,
                        paging: true,
                        data: response.data,
                        columns: [
                            {data: 'idcuentacontable', name: 'idcuentacontable', orderable: false, searchable: false},
                            {data: 'descripcion', name: 'descripcion', orderable: false, searchable: false},
                            {data: 'tipo', name: 'tipo ', orderable: false, searchable: false},
                            {data: 'moneda', name: 'moneda', orderable: false, searchable: false},
                            {data: 'tipodecambio', name: 'tipodecambio', orderable: false, searchable: false},
                            {data: 'status', name: 'status', orderable: false, searchable: false},
                            {data: 'action', name: 'action', orderable: false, searchable: false}
                        ],
                    });
                } else {
                    console.error('No se encontraron datos en la respuesta');
                }
            },
            error: function (error) {
                console.error('Error al cargar los datos:', error);
            }
        });
    });
</script>

<script>
  function btnSuspend(idcuentacontable) {
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
                  url: "{{ url('suspend/payment_method') }}/" + idcuentacontable, 
                  data: {
                    idcuentacontable: idcuentacontable,
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
                          $('#table_accountings').DataTable().ajax.reload();
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
  function btnRestore(idcuentacontable) {
      Swal.fire({
          title: "Desea Restaurar?",
          text: "Esta accion restaurara el restaurente",
          icon: 'warning',
          showCancelButton: !0,
          confirmButtonText: "¡Sí, restaurar!",
          cancelButtonText: "¡No, cancelar!",
          reverseButtons: !0
      }).then(function (e) {
          if (e.value === true) {
              $.ajax({
                  type: 'PUT',
                  url: "{{ url('restore/payment_method') }}/" + idcuentacontable, 
                  data: {
                    idcuentacontable: idcuentacontable,
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
                          $('#table_accountings').DataTable().ajax.reload();
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