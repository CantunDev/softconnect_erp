@extends('layouts.master')
@section('title')
  Categorias |
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Categoria gastos
    @endslot
    @slot('bcPrevText')
    Categoria gastos
    @endslot
    @slot('bcPrevLink')
      {{ route('expenses_categories.index') }}
    @endslot
    @slot('bcActiveText')
      Listado
    @endslot
  @endcomponent
    <div class="card">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Categoria de gastos</h5>
                <div class="flex-shrink-0">
                    <a href="{{route('expenses_categories.create')}}" class="btn btn-primary">Nuevo</a>
                    {{-- <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a> --}}
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title">Striped rows</h4> --}}
                    {{-- <p class="card-title-desc">Use <code>.table-striped</code> to add zebra-striping to any table row within
                        the <code>&lt;tbody&gt;</code>.</p> --}}

                    <div class="table-responsive">
                        <table id="table_expenses" class="table table-striped mb-0">

                            <thead>
                                <tr>
                                    <th>Categorias</th>
                                    <th>Subcategorias</th>
                                    <th>Sub-subcategorias</th>
                                    <th>Sub-subcategorias</th>
                                </tr>
                            </thead>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function(){
        $('#table_expenses').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: '{!! route('expenses_categories.index') !!}',
            },
            columns: [
                {data: 'Idtipogasto', name: 'Idtipogasto', orderable: false, searchable: false},
                {data: 'descripcion', name: 'descripcion', orderable: false, searchable: false},
                {data: 'subtipo', name: 'subtipo', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
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