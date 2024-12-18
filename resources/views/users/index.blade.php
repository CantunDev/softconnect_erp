@extends('layouts.master')
@section('title')
    Usuarios |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Usuarios
        @endslot
        @slot('bcPrevText')
            Usuarios
        @endslot
        @slot('bcPrevLink')
            {{ route('users.index') }}
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('users.create') }}" class="btn btn-primary d-flex align-items-center gap-1">
                    <i class="bx bx-plus font-size-15"></i> Nueva usuario
                </a>
            </div>
            <div class="table-responsive">
                <table id="table_users" class="table table-wrapper text-wrapper  dt-responsive nowrap w-100 align-middle table-nowrap table-hover">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Empresas</th>
                            <th scope="col">Restaurantes</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Estatus</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                </table>
                <!-- end table -->
            </div>
            <!-- end table responsive -->
        </div>
        <!-- end card body -->
    </div><!--end card-->
    </div><!--end col-->
    </div><!--end row-->
    </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#table_users').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                ajax: {
                    url: '{!! route('users.index') !!}',
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user',
                        name: 'user',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'business',
                        name: 'business',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'restaurants',
                        name: 'restaurants',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'roles',
                        name: 'roles',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
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
            }).then(function(e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'PUT',
                        url: "{{ url('suspend/users') }}/" + id,
                        data: {
                            id: id,
                            _token: '{!! csrf_token() !!}'
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response);
                            if (response.success === true) {
                                Swal.fire({
                                    title: "Hecho!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonText: "Hecho!",
                                });
                                $('#table_users').DataTable().ajax.reload();
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
            }, function(dismiss) {
                return false;
            })
        }
    </script>
    <script>
        function btnRestore(id) {
            Swal.fire({
                title: "Desea Restaurar?",
                text: "Esta accion restaurara el usuario",
                icon: 'warning',
                showCancelButton: !0,
                confirmButtonText: "¡Sí, restaurar!",
                cancelButtonText: "¡No, cancelar!",
                reverseButtons: !0
            }).then(function(e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'PUT',
                        url: "{{ url('restore/users') }}/" + id,
                        data: {
                            id: id,
                            _token: '{!! csrf_token() !!}'
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response);
                            if (response.success === true) {
                                Swal.fire({
                                    title: "Hecho!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonText: "Hecho!",
                                });
                                $('#table_users').DataTable().ajax.reload();
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
            }, function(dismiss) {
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
            }).then(function(e) {
                if (e.value === true) {
                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('users') }}/" + id,
                        data: {
                            id: id,
                            _token: '{!! csrf_token() !!}'
                        },
                        dataType: 'JSON',
                        success: function(response) {
                            console.log(response);
                            if (response.success === true) {
                                Swal.fire({
                                    title: "Hecho!",
                                    text: response.message,
                                    icon: "success",
                                    confirmButtonText: "Hecho!",
                                });
                                $('#table_users').DataTable().ajax.reload();
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
            }, function(dismiss) {
                return false;
            })
        }
    </script>
@endsection
