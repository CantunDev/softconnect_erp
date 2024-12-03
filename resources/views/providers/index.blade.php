@extends('layouts.master')
@section('content')
        <div class="page-content">
            <div class="container-fluid">
            <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Proveedores</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Lista</a></li>
                                    <li class="breadcrumb-item active">Proveedores</li>
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
                                    <h5 class="mb-0 card-title flex-grow-1">Lista de proveedores</h5>
                                    <div class="flex-shrink-0">
                                        <a href="#!" class="btn btn-primary">Nuevo</a>
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
                                    <table id="table_invoices" class="table text-center align-middle dt-responsive nowrap w-100 table-check" id="job-list">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Proveedore</th>
                                                <th scope="col" class="px-4 py-3">Categoria</th>
                                                <th scope="col" class="px-4 py-3">Compras</th>
                                                <th scope="col" class="px-4 py-3">Promedio</th>
                                                <th scope="col" class="px-4 py-3">Credito</th>
                                                <th scope="col" class="px-4 py-3"></th>
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
<script>
    $(document).ready(function(){
        $('#table_invoices').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            ajax: {
                url: '{!! route('providers.index') !!}',
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name', name: 'name', orderable: false, searchable: false},
                {data: 'idtipoproveedor', name: 'idtipoproveedor ', orderable: false, searchable: false},
                {data: 'purchases', name: 'purchases', orderable: false, searchable: false},
                {data: 'average', name: 'average', orderable: false, searchable: false,render:function(data){return '$'+data}},
                {data: 'credito', name: 'credito', orderable: false, searchable: false},
                {data: 'action', name: 'action', orderable: false, searchable: false}

                //  {data: 'fecha', name: 'fecha', orderable: false, searchable: false},
                //  {data: 'sfrtFolioInvoice', name: 'sfrtFolioInvoice', orderable: false, searchable: false},
                //  {data: 'sfrtCustomer', name: 'sfrtCustomer', orderable: false, searchable: false},
                //  {data: 'sfrtCustomerEmail', name: 'sfrtCustomerEmail', orderable: false, searchable: false},
                //  {data: 'subtotal', name: 'subtotal', orderable: false, searchable: false, render:function(data){return '$'+data}},
                //  {data: 'impuesto', name: 'impuesto', orderable: false, searchable: false, render:function(data){return '$'+data}},
                //  {data: 'total', name: 'total', orderable: false, searchable: false, render:function(data){return '$'+data}},
                //  {data: 'formapago', name: 'formapago', orderable: false, searchable: false},
                //  {data: 'idmetodopago_SAT', name: 'idmetodopago_SAT', orderable: false, searchable: false},
                //  {data: 'nota', name: 'nota', orderable: false, searchable: false},
                // //  {data: 'nota', name: 'nota', orderable: false, searchable: false}
            ],
        });
    });
</script>
@endsection