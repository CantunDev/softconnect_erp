@if (count($errors) > 0)
    <!-- Este div se mostrará si hay errores -->
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
                    {{-- @dd($errors[$index]) --}}
                    <!-- Contenido real (oculto inicialmente) -->
                    <div class="real-content" id="real-content-{{ $index }}" style="display: none;">
                        <!-- Div para errores (oculto inicialmente) -->
                        <div id="error-content-{{ $index }}" class="alert alert-danger" style="display: none;">
                            <ul class="mb-0">
                                @if (isset($errors[$index]))
                                    {{-- @foreach ($errors[$index] as $error) --}}
                                    <li>{{ $errors[$index] }}</li>
                                    {{-- @endforeach --}}
                                @endif
                            </ul>
                        </div>

                        <!-- Div para datos (oculto inicialmente) -->
                        <div id="data-content-{{ $index }}" style="display: none;">
                            <div class="accordion accordion-flush" id="accordionFlush-{{ $index }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button fw-medium" type="button"
                                            style="background-color: {{ $restaurant[$index]->color_primary ?? '' }}; color: {{ $restaurant[$index]->color_accent ?? '' }}"
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
                                                    <!-- Datos dinámicos aquí -->
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Venta Gral</h5>
                                            <div class="float-end ms-2">
                                                <h5 class="font-size-12 price">
                                                    <!-- Datos dinámicos aquí -->
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Venta Cobrada</h5>
                                            <div class="float-end ms-2">
                                                <h5 class="font-size-12">
                                                    <!-- Datos dinámicos aquí -->
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Clientes</h5>
                                            <div class="float-end ms-2">
                                                <h5 class="font-size-12 price">
                                                    <!-- Datos dinámicos aquí -->
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Descuentos</h5>
                                            <div class="float-end ms-2">
                                                <h5 class="font-size-12 price">
                                                    <!-- Datos dinámicos aquí -->
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Cheque Promedio</h5>
                                            <div class="float-end ms-2">
                                                <h5 class="font-size-12">
                                                    <!-- Datos dinámicos aquí -->
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Alimentos</h5>
                                            <div class="float-end ms-2">
                                                <h5 class="font-size-12">
                                                    <!-- Datos dinámicos aquí -->
                                                </h5>
                                            </div>
                                            <h5 class="font-size-12 mb-2">Bebidas</h5>
                                            <div class="float-end ms-2">
                                                <!-- Datos dinámicos aquí -->
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
