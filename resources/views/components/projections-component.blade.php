<div class="row">
    <div class="col-sm-4">
        <div class="card" style="border: 2px solid #ccc">
            <div class="card-body">
                <p class="text-muted mb-4"><i class="mdi mdi-finance h2 text-warning align-middle mb-0 me-3"></i>
                    Proyectado </p>

                <div class="row">
                    <div class="col-6">
                        <div>
                            <h5 class="price"> {{ $totalProjectedSales }} </h5>
                            {{-- <p class="text-muted text-truncate mb-0">+ 0.0012 ( 0.2 % ) <i class="mdi mdi-arrow-up ms-1 text-success"></i></p> --}}
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <div id="area-sparkline-chart-1" data-colors='["--bs-warning"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card" style="border: 2px solid #ccc">
            <div class="card-body">
                <p class="text-muted mb-4"><i class="mdi mdi-account-group h2 text-info align-middle mb-0 me-3"></i>
                    Clientes </p>

                <div class="row">
                    <div class="col-6">
                        <div>
                            <h5 class="">{{ $totalTax }}</h5>
                            {{-- <p class="text-muted text-truncate mb-0">- 4.102 ( 0.1 % ) <i class="mdi mdi-arrow-down ms-1 text-danger"></i></p> --}}
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <div id="area-sparkline-chart-2" data-colors='["--bs-primary"]' class="apex-charts">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="card" style="border: 2px solid #ccc">
            <div class="card-body">
                <p class="text-muted mb-4"><i
                        class="mdi mdi-account-cash h2 text-success align-middle mb-0 me-3"></i>
                    Cheque Promedio </p>

                <div class="row">
                    <div class="col-6">
                        <div>
                            <h5 class="price">{{ $averageCheck }}</h5>
                            {{-- <p class="text-muted text-truncate mb-0">+ 1.792 ( 0.1 % ) <iclass="mdi mdi-arrow-up ms-1 text-success"></i></p> --}}
                        </div>
                    </div>
                    <div class="col-6">
                        <div>
                            <div id="area-sparkline-chart-3" data-colors='["--bs-info"]' class="apex-charts"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
