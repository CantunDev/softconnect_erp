<div class="row">
    <div class="col-md-12 col-xl-12">
        <div class="card">
            <div class="card-body">
                <!-- Skeleton Placeholder -->
                <div class="skeleton" id="skeleton-total">
                    <div class="skeleton-line" style="width: 50%; height: 20px; margin-bottom: 15px;"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="skeleton-line" style="width: 80%; height: 15px; margin-bottom: 10px;"></div>
                            <div class="skeleton-line" style="width: 60%; height: 12px;"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="skeleton-line" style="width: 80%; height: 15px; margin-bottom: 10px;"></div>
                            <div class="skeleton-line" style="width: 60%; height: 12px;"></div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="skeleton-line" style="width: 100%; height: 12px; margin-bottom: 8px;"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="skeleton-line" style="width: 100%; height: 12px; margin-bottom: 8px;"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="skeleton-line" style="width: 100%; height: 12px; margin-bottom: 8px;"></div>
                        </div>
                        <div class="col-md-3">
                            <div class="skeleton-line" style="width: 100%; height: 12px; margin-bottom: 8px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Contenido real (oculto inicialmente) -->
                <div class="real-content" id="real-content-total" style="display: none;">
                    @if(count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div id="data-content-total">
                            <div class="accordion accordion-flush" id="accordionFlush-1">
                                <div class="accordion-item">
                                    <h2 class="accordion-header d-flex justify-content-between align-items-center">
                                        <button class="accordion-button fw-medium collapsed" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#flush-collapse-total" 
                                            aria-expanded="false"
                                            aria-controls="flush-collapse-total">
                                            <i class="bx bx-food-menu font-size-12 align-middle me-1"></i>
                                            <span>Venta General del Día</span>
                                        </button>
                                        <div class="d-flex align-items-center ms-2">
                                            <span class="badge bg-{{ $totals['turnoStatus'] == 'Cerrado' ? 'success' : ($totals['turnoStatus'] == 'Abierto' ? 'warning' : 'info') }} me-2">
                                                {{ $totals['turnoStatus'] }} - {{ $totals['fechaTurno'] }}
                                            </span>
                                            <small class="text-muted">{{ $totals['restaurantesIncluidos'] }} restaurantes</small>
                                        </div>
                                    </h2>
                                    
                                    <div id="flush-collapse-total" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-heading-total"
                                        data-bs-parent="#accordionFlush-1">
                                        <div class="accordion-body text-muted pt-0">
                                            <div class="tab-pane active" id="cheques-tab-1"
                                                role="tabpanel">
                                                <!-- Fila 1: Totales principales -->
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <h5 class="font-size-12 mb-0">Venta General</h5>
                                                            <h5 class="font-size-12 mb-0 price">${{ number_format($totals['totalTemp'], 2) }}</h5>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="font-size-12 mb-0">Venta Cobrada</h5>
                                                            <h5 class="font-size-12 mb-0 price">${{ number_format($totals['totalPaidTemp'], 2) }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <h5 class="font-size-12 mb-0">Clientes Atendidos</h5>
                                                            <h5 class="font-size-12 mb-0">{{ $totals['totalclientesTemp'] }}</h5>
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="font-size-12 mb-0">Ticket Promedio</h5>
                                                            <h5 class="font-size-12 mb-0">${{ number_format($totals['chequePromedioTemp'], 2) }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Fila 2: Detalles adicionales -->
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="font-size-12 mb-0">Descuentos</h5>
                                                            <h5 class="font-size-12 mb-0">${{ number_format($totals['descuentosTemp'], 2) }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="font-size-12 mb-0">Alimentos</h5>
                                                            <h5 class="font-size-12 mb-0">${{ number_format($totals['alimentosTemp'], 2) }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="font-size-12 mb-0">Bebidas</h5>
                                                            <h5 class="font-size-12 mb-0">${{ number_format($totals['bebidasTemp'], 2) }}</h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <h5 class="font-size-12 mb-0">Personas</h5>
                                                            <h5 class="font-size-12 mb-0">{{ $totals['noclientesTemp'] }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar el skeleton loading -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simular carga de datos (en producción, esto sería manejado por Livewire o AJAX)
    setTimeout(function() {
        document.getElementById('skeleton-total').style.display = 'none';
        document.getElementById('real-content-total').style.display = 'block';
        document.getElementById('data-content-total').style.display = 'block';
    }, 1000);
});
</script>

<style>
.skeleton {
    padding: 1rem;
}
.skeleton-line {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
    border-radius: 4px;
}
@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
.price {
    color: #405189;
    font-weight: 600;
}
</style>