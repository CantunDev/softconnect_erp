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
                                        <h5 class="percentage">{{ $rangeMonth }}</h5>
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
    @php
    $count = count($restaurants);
    if ($count == 1) {
        $colSize = 12; // Si hay un solo restaurante, ocupa toda la fila
    } elseif ($count == 2) {
        $colSize = 6; // Si hay dos, se dividen en mitades
    } elseif ($count == 4) {
        $colSize = 3; // Si hay dos, se dividen en mitades
    }else {
        $colSize = 4; // Si hay tres o más, se dividen en tercios (máximo 3 columnas)
    }
@endphp
    <div class="row">
        @foreach ($restaurants as $i => $restaurant)
            {{-- <div class="restaurant-card" style="background-color: {{ $restaurants[$i]->color_primary }}; color: {{ $restaurants[$i]->color_secondary }}">
            <h1>{{ $restaurants[$i]->name }}</h1>
            <button style="background-color: {{ $restaurants[$i]->color_accent }}">Ver más</button> --}}
            {{-- </div> --}}
            <div class="col-xl-{{$colSize}}">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="card-title mb-4 fixed-text ">{{$restaurants[$i]->name}} </h4> --}}
                        <div class="accordion accordion-flush" id="accordionFlush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                        class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                        aria-controls="flush-collapse{{ $restaurants[$i]->id }}">
                                        <i class="bx bx-food-menu font-size-12 align-middle me-1"
                                        style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                        Venta Al Dia {{ $restaurants[$i]->name }}
                                </h2>
                            </div>
                            <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="cheques-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['totalTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta Gral</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['totalPaidTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta Cobrada</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['nopersonasTemp'] }}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Clientes</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{-- $  {{$resultsTemp['venta'.$restaurants[$i]->id]['chequePromedio']}} --}}

                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['descuentosTemp'] }}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Descuentos</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['chequePromedioTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Cheque Promedio</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['alimentosTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Alimentos</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['bebidasTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Bebidas</h5>
                                        <div class="float-end ms-2">
                                            <span class="me-1 badge rounded-circle p-1 {{ $resultsTemp['venta' . $restaurants[$i]->id]['turno'] == 'Abierto' ? 'bg-success' : 'bg-warning' }}">
                                                <span class="visually-hidden">status</span>
                                            </span>
                                            {{ $resultsTemp['venta' . $restaurants[$i]->id]['turno'] }}


                                        </div>
                                        <h5 class="font-size-12 mb-2">Turno </h5>
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
            <div class="col-xl-{{$colSize}}">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">{{ $restaurants[$i]->name }}</h4>
                        <div class="accordion accordion-flush" id="accordionFlush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                        class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                        aria-controls="flush-collapse{{ $restaurants[$i]->id }}">
                                        <i class="bx bx-restaurant font-size-12 align-middle me-1"
                                            style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                        Ventas {{ $restaurants[$i]->name }}
                                </h2>
                            </div>
                            <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="vta-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de venta mesual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de venta mesual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de venta dia {{ $daysPass }}</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $results['venta' . $restaurants[$i]->id]['total'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta real al dia</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 percentage">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Alcance al dia</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 percentage">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">DEFICIT</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">META VTA DIARIA</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">PROM.. VTA DIARIA REAL</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">PROYECTADO AL CIERRE</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
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
                                    <button
                                        style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                        class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                        aria-controls="flush-collapse{{ $restaurants[$i]->id }}">
                                        <i class="bx bx-body font-size-12 align-middle me-1"
                                            style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                        Clientes {{ $restaurants[$i]->name }}
                                </h2>
                            </div>
                            <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
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
                                        <h5 class="font-size-12 mb-2">Meta de clientes al dia {{ $daysPass }}</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 ">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $results['venta' . $restaurants[$i]->id]['nopersonas'] }}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Clientes al dia real</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 percentage">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
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
                                    <button
                                        style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                        class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                        aria-controls="flush-collapse{{ $restaurants[$i]->id }}">
                                        <i class="bx bx-spreadsheet font-size-12 align-middle me-1"
                                            style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                        Cheques {{ $restaurants[$i]->name }}
                                </h2>
                            </div>
                            <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="cheques-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de cheque promedio</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $results['venta' . $restaurants[$i]->id]['chequePromedio'] }}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Cheque promedio actual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                0
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
    <script>
        // Selecciona el elemento h5 con la clase "price"
        const priceElements = document.querySelectorAll('.price');

        // Usa AutoNumeric para formatear el número
        priceElements.forEach(element => {
            const rawValue = parseFloat(element.textContent); // Obtén el valor del texto de la etiqueta
            if (!isNaN(rawValue)) {
                new AutoNumeric(element, {
                    currencySymbol: '$',
                    decimalPlaces: 2,
                    digitGroupSeparator: ',',
                    currencySymbolPlacement: 'p', // "p" coloca el símbolo antes del número
                    decimalCharacter: '.',
                    unformatOnSubmit: true, // Elimina el formato al enviar el formulario
                }).set(rawValue); // Establece el valor formateado en el elemento
            }
        });
    </script>
    <script>
        // Selecciona el elemento h5 con la clase "percentage"
        const percentageElements = document.querySelectorAll('.percentage');

        // Usa AutoNumeric para formatear como porcentaje
        percentageElements.forEach(element => {
            const rawValue = parseFloat(element.textContent); // Obtén el valor del texto de la etiqueta
            if (!isNaN(rawValue)) {
                new AutoNumeric(element, {
                    currencySymbol: '%', // El símbolo es el de porcentaje
                    decimalPlaces: 2, // Establece dos decimales
                    //   digitGrkoupSeparator: ',', // Si lo necesitas, puedes agregar separador de miles
                    percentage: true, // Activa la opción de porcentaje
                    scaleDecimalPlaces: 2, // Controla la cantidad de decimales
                    unformatOnSubmit: true, // Elimina el formato al enviar el formulario
                    decimalCharacter: '.', // Caracter decimal
                    currencySymbolPlacement: 's' // El símbolo del porcentaje va al final
                }).set(rawValue * 1); // Multiplica por 100 para obtener el valor en porcentaje
            }
        });
    </script>
@endsection
