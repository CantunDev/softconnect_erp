<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card"
            {{-- style="border: 2px solid #ccc"  --}}
            >
            <div class="card-body">
                <!-- Skeleton Placeholder -->
                <div class="skeleton" id="skeleton-total">
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
                <div class="real-content" id="real-content-total" style="display: none;">
                    <!-- Div para errores (oculto inicialmente) -->
                    <!-- Div para datos (oculto inicialmente) -->
                    <div id="data-content-total" style="display: none;">
                        <div class="accordion accordion-flush" id="accordionFlush-1">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button fw-medium" type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse-1" aria-expanded="true"
                                        aria-controls="flush-collapse-1
                                        {{-- " style=" background-color: #ccc; color: black" --}}
                                        >
                                        <i class="bx bx-food-menu font-size-12 align-middle me-1"></i>
                                        Venta General de Ventas
                                        
                                    </button>
                                    <div>
                                        <span class="badge badge-{{ $totals['turnoStatus'] == 'Cerrado' ? 'success' : ($totals['turnoStatus'] == 'Abierto' ? 'warning' : 'info') }}">
                                            {{ $totals['turnoStatus'] }} - {{ $totals['fechaTurno'] }}
                                        </span>
                                        <small class="text-muted ml-2">{{ $totals['restaurantesIncluidos'] }} restaurantes</small>
                                    </div>
                                </h2>
                            </div>
                            <div id="flush-collapse-total" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingThree"
                                data-bs-parent="#accordionFlush-1">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="cheques-tab-1"
                                        role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($totals['totalTemp'], 2) }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta Gral</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta Cobrada</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Clientes</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Descuentos</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Cheque Promedio</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Alimentos</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
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
        </div>
    </div>
</div>