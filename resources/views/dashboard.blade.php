@extends('layouts.master')
@section('title')
    Dashboard |
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="https://avatar.oxro.io/avatar.svg?name={{ Auth::user()->fullname }}"
                                        alt="" class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <p class="mb-2">Bienvenido</p>
                                        <h5 class="mb-1">{{ Auth::user()->fullname }}</h5>
                                        <p class="mb-0">{{ Auth::user()->roles->pluck('name')[0] ?? '' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="row text-center">
                                <div class="col-xl-3">
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">INICIO MES</p>
                                        <h5>{{ $startOfMonth }}</h5>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">TERMINO MES</p>
                                        <h5>{{ $endOfMonth }}</h5>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">MES</p>
                                        <h5>{{ $month }} </h5>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">TOTAL DIAS</p>
                                        <h5>{{ $daysInMonth }} </h5>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">DIAS</p>
                                        <h5>{{ $daysPass }} </h5>
                                    </div>
                                    <div class="mt-3">
                                        <p class="text-muted mb-1">% ALCANCE</p>
                                        <h5>{{$rangeMonth}}%</h5>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="col">
                                        <img src="{{ Auth::user()->business->first()->business_file ?? 'https://avatar.oxro.io/avatar.svg?name=' . urlencode(Auth::user()->business->first()->business_name) }}"
                                            alt="" class="avatar-md rounded-circle d-block mx-auto">
                                        <span>{{ Auth::user()->business->pluck('business_name')[0] ?? '' }}</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach ($restaurants as $i => $restaurant)
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{$restaurants[$i]->name}}</h4>
                        <div class="accordion accordion-flush" id="accordionFlush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="true"
                                        aria-controls="flush-collapseThree">
                                        <i class="bx bx-dollar text-primary font-size-12 align-middle me-1"></i>
                                        Venta Al Dia
                                </h2>
                            </div>
                            <div id="flush-collapseThree" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="cheques-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $  {{$results['venta'.$restaurants[$i]->id]['chequePromedio']}}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Clientes</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Cheque Promedio</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Alimentos</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Bebidas</h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        @foreach ($restaurants as $i => $restaurant)
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{$restaurants[$i]->name}}</h4>
                        <div class="accordion accordion-flush" id="accordionFlush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="true"
                                        aria-controls="flush-collapseOne">
                                        <i class="bx bx-restaurant text-primary font-size-12 align-middle me-1"></i>
                                        Ventas
                                </h2>
                            </div>
                            <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="vta-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de venta mesual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de venta mesual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de venta dia 12</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta real al dia</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ {{$results['venta'.$restaurants[$i]->id]['total']}}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Alcance al dia</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">DEFICIT</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">META VTA DIARIA</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">PROM.. VTA DIARIA REAL</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">PROYECTADO AL CIERRE</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">DIFERENCIA(+/-)</h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="accordion accordion-flush" id="accordionFlush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="true"
                                        aria-controls="flush-collapseTwo">
                                        <i class="bx bx-body text-primary font-size-12 align-middle me-1"></i>
                                        Clientes
                                </h2>
                            </div>
                            <div id="flush-collapseTwo" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="vta-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de clientes</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de clientes al dia 12</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Clientes al dia real</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{$results['venta'.$restaurants[$i]->id]['nopersonas']}}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Alcance al dia</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="accordion accordion-flush" id="accordionFlush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="true"
                                        aria-controls="flush-collapseThree">
                                        <i class="bx bx-spreadsheet text-primary font-size-12 align-middle me-1"></i>
                                        Cheques
                                </h2>
                            </div>
                            <div id="flush-collapseThree" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="cheques-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de cheque promedio</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $  {{$results['venta'.$restaurants[$i]->id]['chequePromedio']}}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Cheque promedio actual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                $ 0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">DEFICIT</h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@section('js')
@endsection
