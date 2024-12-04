@extends('layouts.master')
@section('content')
        <div class="page-content">
            <div class="container-fluid">
            <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Facturas</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lista</a></li>
                                    <li class="breadcrumb-item active">Facturas</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Lista de facturas</h5>
                                    <div class="flex-shrink-0">
                                        <a href="#!" class="btn btn-primary">Add New Job</a>
                                        <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a>
                                        <div class="dropdown d-inline-block">

                                            <button type="menu" class="btn btn-success" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-dots-vertical"></i></button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body border-bottom">
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
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table_invoices" class="table align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                                        <thead>
                                            <tr>
                                                <th scope="col">Cuenta</th>
                                                <th scope="col">Factura</th>
                                                <th scope="col">Cliente</th>
                                                {{-- <th scope="col">Correo</th> --}}
                                                <th scope="col">Subtotal</th>
                                                <th scope="col">IVA</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Forma Pago</th>
                                                <th scope="col">Tipo</th>
                                                {{-- <th scope="col">Estado</th> --}}
                                                {{-- <th scope="col"></th> --}}
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
            </div> <!-- container-fluid -->
        </div><!-- End Page-content -->

                <!-- Modal -->
        <div class="modal fade" id="jobDelete" tabindex="-1" aria-labelledby="jobDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-body px-4 py-5 text-center">
                        <button type="button" class="btn-close position-absolute end-0 top-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="avatar-sm mb-4 mx-auto">
                            <div class="avatar-title bg-primary text-primary bg-opacity-10 font-size-20 rounded-3">
                                <i class="mdi mdi-trash-can-outline"></i>
                            </div>
                        </div>
                        <p class="text-muted font-size-16 mb-4">Are you sure you want to permanently erase the job.</p>

                        <div class="hstack gap-2 justify-content-center mb-0">
                            <button type="button" class="btn btn-danger">Delete Now</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('js')
<script>
    $(document).ready(function(){
        $('#table_invoices').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: '{!! route('invoices.index') !!}',
            },
            columns: [
                // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false}
                 {data: 'sfrtNotaDate', name: 'sfrtNotaDate', orderable: false, searchable: false},
                //  {data: 'nota', name: 'nota', orderable: false, searchable: false},
                 {data: 'fecha', name: 'fecha', orderable: false, searchable: false},
                //  {data: 'sfrtFolioInvoice', name: 'sfrtFolioInvoice', orderable: false, searchable: false},
                 {data: 'sfrtCustomer', name: 'sfrtCustomer', orderable: false, searchable: false},
                //  {data: 'sfrtCustomerEmail', name: 'sfrtCustomerEmail', orderable: false, searchable: false},
                 {data: 'subtotal', name: 'subtotal', orderable: false, searchable: false, render:function(data){return '$'+data}},
                 {data: 'impuesto', name: 'impuesto', orderable: false, searchable: false, render:function(data){return '$'+data}},
                 {data: 'total', name: 'total', orderable: false, searchable: false, render:function(data){return '$'+data}},
                 {data: 'formapago', name: 'formapago', orderable: false, searchable: false},
                 {data: 'idmetodopago_SAT', name: 'idmetodopago_SAT', orderable: false, searchable: false},
                //  {data: 'nota', name: 'nota', orderable: true, searchable: true},
                //  {data: 'nota', name: 'nota', orderable: false, searchable: false}
            ],
        });
    });
</script>
@endsection