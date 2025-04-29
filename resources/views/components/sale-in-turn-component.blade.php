    @if (count($errors) > 0)
        <div class="alert alert-danger mb-4" id="error-alert">
            <ul class="mb-0">
                @foreach ($errors as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        @foreach ($restaurants as $index => $restaurant)
            <div class="col-md-6 col-xl-{{ $colSize }}">
                <div class="card"
                    style="border: 2px solid {{ !empty($restaurant->color_primary) ? $restaurant->color_primary : '#ccc' }};
                    color: {{ !empty($restaurant->color_accent) ? $restaurant->color_accent : '#000' }};">
                    <div class="card-body">
                        <!-- Skeleton Placeholder -->
                        <div class="skeleton" id="skeleton-{{ $index }}">
                            <div class="skeleton-line" style="width: 50%; height: 20px;"></div>
                            <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                            <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                            <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                            <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                            <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                            <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                            <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                        </div>

                        <!-- Contenido real (oculto inicialmente) -->
                        <div class="real-content" id="real-content-{{ $index }}" style="display: none;">
                            <!-- Div para errores (oculto inicialmente) -->
                            <div id="error-content-{{ $index }}" class="alert alert-danger"
                                style="display: none;">
                                <ul class="mb-0">
                                    {{-- @if (isset($errors[$index]))
                                        <li>{{ $errors[$index] }}</li>
                                    @endif  --}}
                                </ul>
                            </div>

                            <!-- Div para datos (oculto inicialmente) -->
                            <div id="data-content-{{ $index }}" style="display: none;">
                                <div class="accordion accordion-flush" id="accordionFlush-{{ $index }}">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button fw-medium" type="button"
                                                style="background-color: {{ $restaurant->color_primary ?? '' }}; color: {{ $restaurant->color_accent ?? '' }}"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapse-{{ $index }}"
                                                aria-expanded="true"
                                                aria-controls="flush-collapse-{{ $index }}">
                                                <i class="bx bx-food-menu font-size-12 align-middle me-1"></i>
                                                Venta Al Dia {{ $restaurant->name }}
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="flush-collapse-{{ $index }}"
                                        class="accordion-collapse collapse show" aria-labelledby="flush-headingThree"
                                        data-bs-parent="#accordionFlush-{{ $index }}">
                                        <div class="accordion-body text-muted">
                                            <div class="tab-pane active" id="cheques-tab-{{ $index }}"
                                                role="tabpanel">
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12 price text-info">
                                                        {{-- @php
                                                            dump('Current Restaurant ID:', $restaurant->id);
                                                            dump(
                                                                'ProjectionDaily Structure:',
                                                                array_keys($projectionDaily),
                                                            );
                                                            dump(
                                                                'Specific Data:',
                                                                $projectionDaily['daily' . $restaurant->id] ??
                                                                    'No existe esta clave',
                                                            );
                                                        @endphp --}}
                                                        <strong>{{ $projectionDaily['daily' . $restaurant->id]['dailySales']['projected_day_sales'] ?? 0 }}</strong>
                                                    </h5>
                                                </div>

                                                {{-- <span class="">{{ number_format($projection['projected_day_sales'], 2) }}</span> --}}
                                                {{-- <span class="text-success">{{ number_format($projection['actual_day_sales'], 2) }}</span> --}}

                                                <div class="progress" style="height: 15px; border-radius: 10px;">
                                                    @php
                                                        $sales_in_turn = isset($results['venta' . $restaurant->id])
                                                            ? $results['venta' . $restaurant->id]['tempChequeData'][
                                                                'totalTemp'
                                                            ]
                                                            : 0;

                                                        $projected_sales =
                                                            $projectionDaily['daily' . $restaurant->id]['dailySales'][
                                                                'projected_day_sales'
                                                            ] ?? 0;

                                                        $percentage =
                                                            $projected_sales > 0
                                                                ? ($sales_in_turn / $projected_sales) * 100
                                                                : 0;
                                                    @endphp

                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: {{ $percentage }}%; background-color: {{ $percentage > 100 ? '#28a745' : ($percentage > 80 ? 'orange' : ($percentage > 30 ? '#ffc107' : 'red')) }}"
                                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                    </div>

                                                </div>

                                                <h5 class="font-size-12 mb-2"></h5>
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12 price">
                                                        @if (isset($results['venta' . $restaurant->id]))
                                                            {{-- Acceso a los datos --}}
                                                            {{ $gral = $results['venta' . $restaurant->id]['tempChequeData']['totalTemp'] }}
                                                        @else
                                                            {{-- Valor por defecto si no hay datos --}}
                                                            {{ $gral = 0 }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <h5 class="font-size-12 mb-2">Venta Gral</h5>
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12 price">
                                                        @if (isset($results['venta' . $restaurant->id]))
                                                            {{-- Acceso a los datos --}}
                                                            {{ $paid = $results['venta' . $restaurant->id]['tempChequeData']['totalPaidTemp'] }}
                                                        @else
                                                            {{-- Valor por defecto si no hay datos --}}
                                                            {{ $paid = 0 }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <h5 class="font-size-12 mb-2">Venta Cobrada</h5>
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12">
                                                        @if (isset($results['venta' . $restaurant->id]))
                                                            {{-- Acceso a los datos --}}
                                                            <span
                                                                class="text-danger">{{ $results['venta' . $restaurant->id]['tempChequeData']['nopersonasTemp'] }}
                                                            </span> |
                                                            <span
                                                                class="text-success">{{ $results['venta' . $restaurant->id]['tempChequeData']['noclientesTemp'] }}
                                                            </span> =
                                                            <span
                                                                class="text-primary">{{ $clientes = $results['venta' . $restaurant->id]['tempChequeData']['totalclientesTemp'] }}
                                                            </span>
                                                        @else
                                                            {{-- Valor por defecto si no hay datos --}}
                                                            {{ $clientes = 0 }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <h5 class="font-size-12 mb-2">Clientes</h5>
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12 price">
                                                        <!-- Datos dinámicos aquí -->
                                                        @if (isset($results['venta' . $restaurant->id]))
                                                            {{-- Acceso a los datos --}}
                                                            {{ $desc = $results['venta' . $restaurant->id]['tempChequeData']['descuentosTemp'] }}
                                                        @else
                                                            {{-- Valor por defecto si no hay datos --}}
                                                            {{ $desc = 0 }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <h5 class="font-size-12 mb-2">Descuentos</h5>
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12 price">
                                                        <!-- Datos dinámicos aquí -->
                                                        @if (isset($results['venta' . $restaurant->id]))
                                                            {{-- Acceso a los datos --}}
                                                            {{ $chk = $results['venta' . $restaurant->id]['tempChequeData']['chequePromedioTemp'] }}
                                                        @else
                                                            {{-- Valor por defecto si no hay datos --}}
                                                            {{ $chk = 0 }}
                                                        @endif
                                                    </h5>
                                                </div>
                                                <h5 class="font-size-12 mb-2">Cheque Promedio</h5>
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12">
                                                        @php
                                                            $ta = isset($results['venta' . $restaurant->id])
                                                                ? $results['venta' . $restaurant->id]['tempChequeData'][
                                                                    'alimentosTemp'
                                                                ]
                                                                : 0;
                                                            $percentage_ta =
                                                                $gral != 0 ? round(($ta * 100) / $gral, 1) : 0;
                                                        @endphp

                                                        <span class="price">{{ $ta }}</span>
                                                        <span class="percentage">{{ $percentage_ta }}</span>
                                                    </h5>
                                                </div>
                                                <h5 class="font-size-12 mb-2">Alimentos</h5>
                                                <div class="float-end ms-2">
                                                    <h5 class="font-size-12">
                                                        @php
                                                            $tb = isset($results['venta' . $restaurant->id])
                                                                ? $results['venta' . $restaurant->id]['tempChequeData'][
                                                                    'bebidasTemp'
                                                                ]
                                                                : 0;
                                                            $percentage_tb =
                                                                $gral != 0 ? round(($tb * 100) / $gral, 1) : 0;
                                                        @endphp

                                                        <span class="price">{{ $tb }}</span>
                                                        <span class="percentage">{{ $percentage_tb }}</span>
                                                    </h5>
                                                </div>
                                                <h5 class="font-size-12 mb-2">Bebidas</h5>
                                                <div class="float-end ms-2">
                                                    @if (isset($results['venta' . $restaurant->id]))
                                                        <span
                                                            class="me-1 badge rounded-circle p-1 {{ $results['venta' . $restaurant->id]['turno'] == 'Abierto' ? 'bg-success' : 'bg-warning' }}">
                                                            <span class="visually-hidden">status</span>
                                                        </span>
                                                        {{ $results['venta' . $restaurant->id]['turno'] }}
                                                    @endif
                                                </div>
                                                <h5 class="font-size-12 mb-2">Turno </h5>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
