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
                        <div id="error-content-{{ $index }}" class="alert alert-danger" style="display: none;">
                            <ul class="mb-0">
                                @if (isset($errors[$index]))
                                    <li>{{ $errors[$index] }}</li>
                                @endif
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
                                            data-bs-target="#flush-collapse-{{ $index }}" aria-expanded="true"
                                            aria-controls="flush-collapse-{{ $index }}">
                                            <i class="bx bx-food-menu font-size-12 align-middle me-1"></i>
                                            Venta Al Dia
                                        </button>
                                    </h2>
                                </div>
                                <div id="flush-collapse-{{ $index }}" class="accordion-collapse collapse show"
                                    aria-labelledby="flush-headingThree"
                                    data-bs-parent="#accordionFlush-{{ $index }}">
                                    <div class="accordion-body text-muted">
                                        <div class="tab-pane active" id="cheques-tab-{{ $index }}"
                                            role="tabpanel">
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
                                                    <span class="text-danger">{{ $results['venta' . $restaurant->id]['tempChequeData']['nopersonasTemp'] }} </span> |
                                                    <span class="text-success">{{ $results['venta' . $restaurant->id]['tempChequeData']['noclientesTemp'] }} </span> =
                                                    <span class="text-primary">{{ $clientes = $results['venta' . $restaurant->id]['tempChequeData']['totalclientesTemp'] }} </span>

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
                                                    @if (isset($results['venta' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    
                                                    <span class="price">{{ $ta = $results['venta' . $restaurant->id]['tempChequeData']['alimentosTemp'] }}</span>
                                                    <span class="percentage"> {{ round(($ta * 100 )/$gral, 1) }}</span>

                                                    @else
                                                        {{-- Valor por defecto si no hay datos --}}
                                                        {{ $ta = 0 }}
                                                    @endif
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Alimentos</h5>
                                            <div class="float-end ms-2">
                                                <h5 class="font-size-12">
                                                    @if (isset($results['venta' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    
                                                    <span class="price">{{ $tb = $results['venta' . $restaurant->id]['tempChequeData']['bebidasTemp'] }}</span>
                                                    <span class="percentage"> {{ round(($tb * 100 )/$gral, 1) }}</span>

                                                    @else
                                                        {{-- Valor por defecto si no hay datos --}}
                                                        {{ $tb = 0 }}
                                                    @endif
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Bebidas</h5>
                                            <div class="float-end ms-2">
                                                @if (isset($results['venta' . $restaurant->id]))
                                                    <span class="me-1 badge rounded-circle p-1 {{ $results['venta' . $restaurant->id]['turno'] == 'Abierto' ? 'bg-success' : 'bg-warning' }}">
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