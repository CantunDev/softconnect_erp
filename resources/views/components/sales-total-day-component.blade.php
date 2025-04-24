<div class="row mt-2">
    <div class="col-xl-12">
        <div class="card" style="border: 2px solid #ccc">
            <div class="card-body">
                {{-- <div class="skeleton" id="skeleton-1">
                    <div class="skeleton-line" style="width: 50%; height: 20px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                </div> --}}
                {{-- <h4 class="card-title mb-4">Total Ventas Corazon Contento</h4> --}}
                <div class="accordion accordion-flush" id="accordionFlushSalesTotalDay">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse-total-day"
                                aria-expanded="true" aria-controls="flush-collapse-total-day">
                                <div class="d-flex align-items-center me-2">
                                    <i class="bx bx-restaurant font-size-16 me-4"></i>
                                    <h4 class="card-title mb-0">Resumen General </h4>
                                </div>
                                <div>
                                    <span
                                        class="badge bg-{{ $totals['turnoStatus'] == 'Cerrado' ? 'warning' : ($totals['turnoStatus'] == 'Abierto' ? 'success' : 'info') }}">
                                        {{ $totals['fechaTurno'] }}
                                    </span>
                                    <span class="badge bg-primary ms-2">
                                        {{ $totals['restaurantesIncluidos'] }} Restaurantes
                                    </span>
                                </div>
                            </button>
                        </h2>
                        <div id="flush-collapse-total-day" class="accordion-collapse collapse show"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushSalesTotalDay">
                            <div class="accordion-body p-1">
                                <div class="row rounded g-0" style="border: 2px solid var(--bs-border-color);">
                                    <div class="col-12">
                                        <div class="card card-h-100 border-0">
                                            <!-- Skeleton Loading -->
                                            <div class="skeleton" id="skeleton-total">
                                                <div class="skeleton-header"></div>
                                                <div class="skeleton-body">
                                                    <div class="skeleton-line"
                                                        style="width: 70%; height: 25px; margin-bottom: 20px;"></div>
                                                    <div class="row g-0">
                                                        <div class="col-6">
                                                            <div class="skeleton-line"
                                                                style="width: 90%; height: 15px; margin-bottom: 10px;">
                                                            </div>
                                                            <div class="skeleton-line"
                                                                style="width: 70%; height: 20px;"></div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="skeleton-line"
                                                                style="width: 90%; height: 15px; margin-bottom: 10px;">
                                                            </div>
                                                            <div class="skeleton-line"
                                                                style="width: 70%; height: 20px;"></div>
                                                        </div>
                                                    </div>
                                                    <div class="skeleton-divider"></div>
                                                    <div class="row g-0 mt-3">
                                                        @for ($i = 0; $i < 4; $i++)
                                                            <div class="col-6 col-md-3">
                                                                <div class="skeleton-line"
                                                                    style="width: 80%; height: 12px; margin-bottom: 5px;">
                                                                </div>
                                                                <div class="skeleton-line"
                                                                    style="width: 60%; height: 15px;"></div>
                                                            </div>
                                                        @endfor
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Contenido Real -->
                                            <div class="real-content" id="real-content-total" style="display: none;">
                                                <div class="card-body" id="data-content-total">
                                                    <!-- Main Metrics -->
                                                    <div class="row g-0 mb-4">
                                                        <div class="col-md-6 pe-2">
                                                            <div class="metric-card">
                                                                <h6>Venta Total</h6>
                                                                <h3 class="text-primary">
                                                                    ${{ number_format($totals['totalTemp'], 2) }}</h3>
                                                                <div class="progress mt-2" style="height: 6px;">
                                                                    <div class="progress-bar bg-primary"
                                                                        role="progressbar"
                                                                        style="width: {{ $totals['totalTemp'] > 0 ? 100 : 0 }}%"
                                                                        aria-valuenow="{{ $totals['totalTemp'] }}"
                                                                        aria-valuemin="0"
                                                                        aria-valuemax="{{ $totals['totalTemp'] * 1.2 }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 ps-2">
                                                            <div class="metric-card">
                                                                <h6>Venta Cobrada</h6>
                                                                <h3 class="text-success">
                                                                    ${{ number_format($totals['totalPaidTemp'], 2) }}
                                                                </h3>
                                                                <div class="progress mt-2" style="height: 6px;">
                                                                    <div class="progress-bar bg-success"
                                                                        role="progressbar"
                                                                        style="width: {{ $totals['totalTemp'] > 0 ? round(($totals['totalPaidTemp'] / $totals['totalTemp']) * 100) : 0 }}%"
                                                                        aria-valuenow="{{ $totals['totalPaidTemp'] }}"
                                                                        aria-valuemin="0"
                                                                        aria-valuemax="{{ $totals['totalTemp'] }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Secondary Metrics -->
                                                    <div class="row g-0">
                                                        <div class="col-12 col-md-3 col-sm-6 pe-2 mb-3">
                                                            <div class="metric-card-sm">
                                                                <h6 class="mb-3">Detalle de Clientes</h6>
                                                                <div class="row g-0">
                                                                    <!-- Clientes Atendidos -->
                                                                    <div class="col-4 text-center border-end">
                                                                        <div class="text-muted small">Atendidos</div>
                                                                        <h4 class="mb-0">
                                                                            {{ $totals['noclientesTemp'] }}</h4>
                                                                        <div class="text-success small mt-1">
                                                                            <i class="bx bx-user-check"></i>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Clientes en Piso -->
                                                                    <div class="col-4 text-center border-end">
                                                                        <div class="text-muted small">En Piso</div>
                                                                        <h4 class="mb-0">
                                                                            {{ $totals['nopersonasTemp'] }}</h4>
                                                                        <div class="text-warning small mt-1">
                                                                            <i class="bx bx-user"></i>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Clientes Totales -->
                                                                    <div class="col-4 text-center">
                                                                        <div class="text-muted small">Totales</div>
                                                                        <h4 class="mb-0">
                                                                            {{ $totals['totalclientesTemp'] }}</h4>
                                                                        <div class="text-primary small mt-1">
                                                                            <i class="bx bx-group"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3 col-sm-6 pe-2 mb-3">
                                                            <div class="metric-card-sm">
                                                                <h6>Ticket Promedio</h6>
                                                                <h4>${{ number_format($totals['chequePromedioTemp'], 2) }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3 col-sm-6 ps-2 pe-2 mb-3">
                                                            <div class="metric-card-sm">
                                                                <h6>Alimentos</h6>
                                                                <h4>${{ number_format($totals['alimentosTemp'], 2) }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 col-md-3 col-sm-6 ps-2 mb-3">
                                                            <div class="metric-card-sm">
                                                                <h6>Bebidas</h6>
                                                                <h4>${{ number_format($totals['bebidasTemp'], 2) }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Additional Info -->
                                                    <div
                                                        class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                                        <small class="text-info">
                                                            <i class="bx bx-time-five me-1"></i> Actualizado:
                                                            {{ now()->format('H:i:s') }}
                                                        </small>
                                                        <div>
                                                            <small class="text-info me-2">
                                                                Descuentos:
                                                                ${{ number_format($totals['descuentosTemp'], 2) }}
                                                            </small>
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
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Simular carga de datos
        setTimeout(function() {
            document.getElementById('skeleton-total').style.display = 'none';
            document.getElementById('real-content-total').style.display = 'block';
        }, 800);
    });
</script>