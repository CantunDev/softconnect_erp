@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Facturas
        @endslot
        @slot('bcPrevText')
            Facturas
        @endslot
        @slot('bcPrevLink')
            {{ route('business.providers.index', ['business' => request()->route('business')]) }}
        @endslot
        @slot('bcActiveText')
            Listado
        @endslot
    @endcomponent
    {{-- @dd(request()->route('business')) --}}

    <div class="card">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Lista de Facturas </h5>
            </div>
        </div>
        <form id="filterForm" method="POST">
            @csrf
            <div class="card-body border-bottom">
                <div class="row g-3">
                    <div class="col-xxl-4 col-lg-6">
                        <input type="search" name="folio" class="form-control" id="searchTableList"
                            placeholder="Buscar folio factura...">
                    </div>
                    <div class="col-xxl-2 col-lg-6">
                        <select class="form-select" name="client" id="idStatus" aria-label="Default select example">
                            <option value="" selected>Selecciona un cliente</option>
                        </select>
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <select class="form-select" name="type" id="idType" aria-label="Default select example">
                            <option value="" selected>Selecciona el tipo</option>
                            <option value="PPD">PPD</option>
                            <option value="PPD">PUE</option>
                        </select>
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <div id="datepicker1">
                            <input type="text" class="form-control selector" placeholder="Seleccionar fecha"
                                name="date">
                        </div>
                    </div>
                    <div class="col-xxl-2 col-lg-4">
                        <button type="submit" class="btn btn-outline-primary w-100" onclick="filterData();"><i
                                class="mdi mdi-filter-outline align-middle"></i> Buscar</button>
                    </div>
                </div>
            </div>
        </form>
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
    </div>
@endsection

@section('js')
    <script>
        $(".selector").flatpickr({
            maxDate: "today",
            mode: "range"

        });
    </script>
    <script>
        function filterData() {

            event.preventDefault(); // Previene el envío normal del formulario
            // Serializa los datos del formulario como una cadena de consulta
            const queryParams = $(this).serialize();
            $.ajax({
                url: '{!! route('business.invoices.index', ['business' => request()->route('business')]) !!}',
                method: 'GET',
                success: function(response) {
                    console.log('Datos enviados correctamente', response);
                    // Actualiza la interfaz o muestra los resultados
                },
                error: function(error) {
                    console.error('Error al enviar los datos', error);
                    // Maneja errores
                }
            });
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#table_invoices').DataTable({
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{!! route('business.invoices.index', ['business' => request()->route('business')]) !!}',
                    type: 'GET',
                    error: function(error) {
                        console.error('Error al cargar los datos:', error);
                        alert('Hubo un problema al cargar los datos. Por favor, inténtelo de nuevo.');
                    }
                },
                columns: [{
                        data: 'sfrtNotaDate',
                        name: 'sfrtNotaDate'
                    },
                    {
                        data: 'fecha',
                        name: 'fecha'
                    },
                    {
                        data: 'sfrtCustomer',
                        name: 'sfrtCustomer'
                    },
                    {
                        data: 'subtotal',
                        name: 'subtotal',
                        render: $.fn.dataTable.render.number(',', '.', 2, '$')
                    },
                    {
                        data: 'impuesto',
                        name: 'impuesto',
                        render: $.fn.dataTable.render.number(',', '.', 2, '$')
                    },
                    {
                        data: 'total',
                        name: 'total',
                        render: $.fn.dataTable.render.number(',', '.', 2, '$')
                    },
                    {
                        data: 'formapago',
                        name: 'formapago'
                    },
                    {
                        data: 'idmetodopago_SAT',
                        name: 'idmetodopago_SAT',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron registros",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "No hay registros disponibles",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    loadingRecords: "Cargando...",
                    processing: "Procesando...",
                    search: "Buscar:",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                },
            });
        });
    </script>
@endsection
