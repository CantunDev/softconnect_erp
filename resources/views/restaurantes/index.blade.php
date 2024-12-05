@extends('layouts.master')
@section('content')
        <div class="page-content">
            <div class="container-fluid">
            <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Restaurantes</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lista</a></li>
                                    <li class="breadcrumb-item active">Restaurantes</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 card-title flex-grow-1">Lista de Restaurantes</h5>
                                    <div class="flex-shrink-0">
                                        <a href="{{route('restaurants.create')}}" class="btn btn-primary">Nuevo</a>
                                        {{-- <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a> --}}
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="card-body border-bottom">
                                <div class="row g-3">
                                    <div class="col-xxl-4 col-lg-6">
                                        <input type="search" class="form-control" id="searchTableList" placeholder="Search for ...">
                                    </div>
                                    <div class="col-xxl-2 col-lg-6">
                                        <select class="form-select" id="idStatus" aria-label="Default select example">
                                            <option value="all">Status</option>
                                            <option value="Active">Active</option>
                                            <option value="New">New</option>
                                            <option value="Close">Close</option>
                                        </select>
                                    </div>
                                    <div class="col-xxl-2 col-lg-4">
                                        <select class="form-select" id="idType" aria-label="Default select example">
                                            <option value="all">Select Type</option>
                                            <option value="Full Time">Full Time</option>
                                            <option value="Part Time">Part Time</option>
                                        </select>
                                    </div>
                                    <div class="col-xxl-2 col-lg-4">
                                        <div id="datepicker1">
                                            <input type="text" class="form-control" placeholder="Select date" data-date-format="dd M, yyyy" data-date-container='#datepicker1' data-date-autoclose="true" data-provide="datepicker">
                                        </div><!-- input-group -->
                                    </div>
                                    <div class="col-xxl-2 col-lg-4">
                                        <button type="button" class="btn btn-soft-secondary w-100" onclick="filterData();"><i class="mdi mdi-filter-outline align-middle"></i> Filter</button>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table_restaurants" class="table table-wrapper text-wrapper text-center align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Empresa</th>
                                                <th scope="col">Restaurante</th>
                                                <th scope="col" class=" text-wrapper">Descripcion</th>
                                                <th scope="col" class="">Usuarios</th>
                                                <th scope="col" class="">Vpn Ip</th>
                                                <th scope="col" class="">Estatus</th>
                                                <th scope="col" class=""></th>
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
    $(document).ready(function(){
        $('#table_restaurants').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: '{!! route('restaurants.index') !!}',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'business', name: 'business', orderable: false, searchable: false},
                {data: 'name', name: 'name', orderable: false, searchable: false},
                {data: 'description', name: 'description', orderable: false, searchable: false},
                {data: 'assigned', name: 'assigned', orderable: false, searchable: false},
                {data: 'ip', name: 'ip', orderable: false, searchable: false},
                {data: 'status', name: 'status', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
        });
    });
</script>
<script>
    function btnDelete(id) {
        Swal.fire({
            title: "Desea eliminar?",
            text: "Por favor asegúrese y luego confirme!",
            icon: 'warning',
            showCancelButton: !0,
            confirmButtonText: "¡Sí, borrar!",
            cancelButtonText: "¡No, cancelar!",
            reverseButtons: !0
        }).then(function (e) {
            if (e.value === true) {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ url('restaurants') }}/" + id, ,
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
                            $('#table_restaurants').DataTable().ajax.reload();
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