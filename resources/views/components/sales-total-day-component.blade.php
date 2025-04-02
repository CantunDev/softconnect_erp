<div class="row rounded" style=" border: 2px solid #ccc; --bs-gutter-x: 0;">
    <div class="col-12">
        <div class="card card-h-100">
            <!-- Skeleton Loading -->
            <div class="skeleton" id="skeleton-total">
                <div class="skeleton-header"></div>
                <div class="skeleton-body">
                    <div class="skeleton-line" style="width: 70%; height: 25px; margin-bottom: 20px;"></div>
                    <div class="row">
                        <div class="col-6">
                            <div class="skeleton-line" style="width: 90%; height: 15px; margin-bottom: 10px;"></div>
                            <div class="skeleton-line" style="width: 70%; height: 20px;"></div>
                        </div>
                        <div class="col-6">
                            <div class="skeleton-line" style="width: 90%; height: 15px; margin-bottom: 10px;"></div>
                            <div class="skeleton-line" style="width: 70%; height: 20px;"></div>
                        </div>
                    </div>
                    <div class="skeleton-divider"></div>
                    <div class="row mt-3">
                        @for($i = 0; $i < 4; $i++)
                        <div class="col-6 col-md-3">
                            <div class="skeleton-line" style="width: 80%; height: 12px; margin-bottom: 5px;"></div>
                            <div class="skeleton-line" style="width: 60%; height: 15px;"></div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Contenido Real -->
            <div class="real-content" id="real-content-total" style="display: none;">
                {{-- @if(count($errors) > 0)
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach($errors as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @else --}}
                <div class="card-body" id="data-content-total">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">
                            <i class="bx bx-restaurant me-2"></i>Resumen General
                        </h4>
                        <div>
                            <span class="badge bg-{{ $totals['turnoStatus'] == 'Cerrado' ? 'warning' : ($totals['turnoStatus'] == 'Abierto' ? 'success' : 'info') }}">
                                {{ $totals['turnoStatus'] }} - {{ $totals['fechaTurno'] }}
                            </span>
                            <span class="badge bg-primary ms-2">
                                {{ $totals['restaurantesIncluidos'] }} Restaurantes
                            </span>
                        </div>
                    </div>

                    <!-- Main Metrics -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="metric-card">
                                <h6>Venta Total</h6>
                                <h3 class="text-primary">${{ number_format($totals['totalTemp'], 2) }}</h3>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-primary" role="progressbar" 
                                         style="width: {{ $totals['totalTemp'] > 0 ? 100 : 0 }}%" 
                                         aria-valuenow="{{ $totals['totalTemp'] }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $totals['totalTemp'] * 1.2 }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="metric-card">
                                <h6>Venta Cobrada</h6>
                                <h3 class="text-success">${{ number_format($totals['totalPaidTemp'], 2) }}</h3>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $totals['totalTemp'] > 0 ? round(($totals['totalPaidTemp']/$totals['totalTemp'])*100) : 0 }}%" 
                                         aria-valuenow="{{ $totals['totalPaidTemp'] }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="{{ $totals['totalTemp'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Metrics -->
                    <div class="row">
                        <div class="col-12 col-md-3 mb-3">
                            <div class="metric-card-sm">
                                <h6 class="mb-3">Detalle de Clientes</h6>
                                <div class="row">
                                    <!-- Clientes Atendidos -->
                                    <div class="col-4 text-center border-end">
                                        <div class="text-muted small">Atendidos</div>
                                        <h4 class="mb-0">{{ $totals['noclientesTemp'] }}</h4>
                                        <div class="text-success small mt-1">
                                            <i class="bx bx-user-check"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Clientes en Piso -->
                                    <div class="col-4 text-center border-end">
                                        <div class="text-muted small">En Piso</div>
                                        <h4 class="mb-0">{{ $totals['nopersonasTemp'] }}</h4>
                                        <div class="text-warning small mt-1">
                                            <i class="bx bx-user"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Clientes Totales -->
                                    <div class="col-4 text-center">
                                        <div class="text-muted small">Totales</div>
                                        <h4 class="mb-0">{{ $totals['totalclientesTemp'] }}</h4>
                                        <div class="text-primary small mt-1">
                                            <i class="bx bx-group"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="metric-card-sm">
                                <h6>Ticket Promedio</h6>
                                <h4>${{ number_format($totals['chequePromedioTemp'], 2) }}</h4>
                                {{-- <div class="text-primary mt-3">
                                    <i class="bx bx-group"></i>
                                </div> --}}
                            </div>
                            
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="metric-card-sm">
                                <h6>Alimentos</h6>
                                <h4>${{ number_format($totals['alimentosTemp'], 2) }}</h4>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="metric-card-sm">
                                <h6>Bebidas</h6>
                                <h4>${{ number_format($totals['bebidasTemp'], 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <small class="text-info">
                            <i class="bx bx-time-five me-1"></i> Actualizado: {{ now()->format('H:i:s') }}
                        </small>
                        <div>
                            <small class="text-info me-2">
                                Descuentos: ${{ number_format($totals['descuentosTemp'], 2) }}
                            </small>
                        </div>
                    </div>
                </div>
                {{-- @endif --}}
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

<style>
.card-h-100 {
    min-height: 100%;
}
.skeleton {
    padding: 1.5rem;
}
.skeleton-header {
    height: 25px;
    width: 50%;
    margin-bottom: 1.5rem;
    background: #f0f0f0;
    border-radius: 4px;
}
.skeleton-body {
    padding: 0 0.5rem;
}
.skeleton-divider {
    height: 1px;
    background: #f0f0f0;
    margin: 1.5rem 0;
}
.skeleton-line {
    background: #f0f0f0;
    border-radius: 4px;
    animation: shimmer 1.5s infinite linear;
    background-size: 200% 100%;
}
.metric-card {
    background: #f9f9f9;
    padding: 1rem;
    border-radius: 8px;
    height: 100%;
}
.metric-card-sm {
    padding: 0.75rem;
    border-radius: 6px;
    background: #f9f9f9;
    height: 100%;
}
.metric-card h6, .metric-card-sm h6 {
    font-size: 0.75rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}
.metric-card h3, .metric-card-sm h4 {
    font-weight: 600;
    margin-bottom: 0.25rem;
}
@keyframes shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>