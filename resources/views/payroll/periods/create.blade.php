@extends('layouts.master')

@section('title', 'Nueva Nómina')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background:{{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#ccc' }};">
                        <h5 class="mb-0"
                            style="color:{{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc' }};">
                            <i class="fas fa-file-invoice-dollar"></i> Crear Nueva Nómina
                        </h5>
                        <a href="" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('business.restaurants.payroll_periods.store', ['business' => $business, 'restaurants' => $restaurants])}}" id="payrollForm">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <!-- Información Básica de la Nómina -->
                                <div class="col-md-8 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información General</h6>
                                        </div>
                                        <div class="card-body">
                                            <!-- Restaurante -->
                                            <div class="mb-3">
                                                <label for="restaurant_id" class="form-label">
                                                    Restaurante <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control select2 @error('restaurant_id') is-invalid @enderror" 
                                                    id="restaurant_id" 
                                                    name="restaurant_id" 
                                                    required>
                                                    <option value="">Seleccione un restaurante</option>
                                                    {{-- @foreach ($businessRestaurants as $restaurant) --}}
                                                    <option value="{{ $restaurants->id }}"
                                                        {{ old('restaurant_id', $restaurants->id) == $restaurants->id ? 'selected' : '' }}>
                                                        {{ $restaurants->name }}
                                                    </option>
                                                </select>
                                                @error('restaurant_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Año y Período -->
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="year" class="form-label">
                                                        Año <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" 
                                                        class="form-control @error('year') is-invalid @enderror"
                                                        id="year" name="year" 
                                                        value="{{ old('year', date('Y')) }}"
                                                        min="2000" 
                                                        max="2100"
                                                        required>
                                                    @error('year')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="period_number" class="form-label">
                                                        Número de Período <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" 
                                                        class="form-control @error('period_number') is-invalid @enderror"
                                                        id="period_number" name="period_number"
                                                        value="{{ old('period_number', 1) }}"
                                                        min="1" 
                                                        max="26"
                                                        placeholder="1-26"
                                                        required>
                                                    @error('period_number')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                    <small class="text-muted">Período de nómina (1-26)</small>
                                                </div>
                                            </div>

                                            <!-- Descripción del período -->
                                            <div class="mb-3">
                                                <label class="form-label">Descripción del Período</label>
                                                <div class="alert alert-info">
                                                    <small id="periodDescription">
                                                        Seleccione el año y período para ver la descripción
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estado de la Nómina -->
                                <div class="col-md-4 mb-4">
                                    <div class="card bg-light">
                                        <div class="card-header bg-secondary text-white">
                                            <h6 class="mb-0"><i class="fas fa-circle"></i> Estado</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="alert alert-secondary mb-2" id="statusAlert">
                                                <i class="fas fa-file-alt"></i> <strong>Borrador</strong>
                                            </div>
                                            <p class="text-muted small mb-0" id="statusMessage">
                                                La nómina se creará en estado de borrador
                                            </p>
                                            <div class="mt-3">
                                                <small class="text-muted">
                                                    <strong>Estados:</strong><br>
                                                    📝 Borrador<br>
                                                    ✓ Aprobada<br>
                                                    ⚙️ Procesada<br>
                                                    💰 Pagada<br>
                                                    ✗ Cancelada
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fechas del Período -->
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Fechas del Período</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="start_date" class="form-label">
                                                        Fecha de Inicio <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date"
                                                        class="form-control @error('start_date') is-invalid @enderror"
                                                        id="start_date" name="start_date"
                                                        value="{{ old('start_date') }}"
                                                        required>
                                                    @error('start_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="end_date" class="form-label">
                                                        Fecha de Fin <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="date"
                                                        class="form-control @error('end_date') is-invalid @enderror"
                                                        id="end_date" name="end_date"
                                                        value="{{ old('end_date') }}"
                                                        required>
                                                    @error('end_date')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="alert alert-light border">
                                                <small id="daysInfo">Seleccione las fechas para ver la duración</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información de Pago -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-money-bill-wave"></i> Información de Pago</h6>
                                        </div>
                                        <div class="card-body">
                                            <!-- Estatus -->
                                            <div class="mb-3">
                                                <label for="status" class="form-label">
                                                    Estado <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status" required onchange="updateStatusPanel()">
                                                    <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>
                                                        Borrador
                                                    </option>
                                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>
                                                        Aprobada
                                                    </option>
                                                    <option value="processed" {{ old('status') == 'processed' ? 'selected' : '' }}>
                                                        Procesada
                                                    </option>
                                                    <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>
                                                        Pagada
                                                    </option>
                                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                                        Cancelada
                                                    </option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Aprobada en -->
                                            <div class="mb-3">
                                                <label for="approved_at" class="form-label">Fecha de Aprobación</label>
                                                <input type="datetime-local"
                                                    class="form-control @error('approved_at') is-invalid @enderror"
                                                    id="approved_at" name="approved_at"
                                                    value="{{ old('approved_at') }}">
                                                @error('approved_at')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Se completa automáticamente al aprobar</small>
                                            </div>

                                            <!-- Pagada en -->
                                            <div class="mb-3">
                                                <label for="paid_at" class="form-label">Fecha de Pago</label>
                                                <input type="datetime-local"
                                                    class="form-control @error('paid_at') is-invalid @enderror"
                                                    id="paid_at" name="paid_at"
                                                    value="{{ old('paid_at') }}">
                                                @error('paid_at')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Se completa automáticamente al pagar</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notas -->
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-sticky-note"></i> Notas y Observaciones</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="notes" class="form-label">Notas</label>
                                                <textarea class="form-control @error('notes') is-invalid @enderror"
                                                    id="notes" name="notes" rows="4"
                                                    placeholder="Escriba cualquier nota o observación importante...">{{ old('notes') }}</textarea>
                                                @error('notes')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumen -->
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-eye"></i> Resumen de la Nómina</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <small class="text-muted">Restaurante</small>
                                                        <h6 id="summaryRestaurant">-</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <small class="text-muted">Período</small>
                                                        <h6 id="summaryPeriod">-</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <small class="text-muted">Duración</small>
                                                        <h6 id="summaryDays">-</h6>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="text-center">
                                                        <small class="text-muted">Estado</small>
                                                        <h6 id="summaryStatus">-</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="" class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Crear Nómina
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            .select2-container .select2-selection--single {
                height: 38px;
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 36px;
            }

            .card {
                border: 1px solid #e0e0e0;
                border-radius: 8px;
            }

            .card-header {
                border-bottom: 1px solid #e0e0e0;
            }

            .form-label {
                font-weight: 500;
                color: #555;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            const payrollStatus = {
                'draft': { label: 'Borrador', icon: '📝', color: 'secondary' },
                'approved': { label: 'Aprobada', icon: '✓', color: 'success' },
                'processed': { label: 'Procesada', icon: '⚙️', color: 'info' },
                'paid': { label: 'Pagada', icon: '💰', color: 'success' },
                'cancelled': { label: 'Cancelada', icon: '✗', color: 'danger' }
            };

            function updateStatusPanel() {
                const status = document.getElementById('status').value;
                const statusAlert = document.getElementById('statusAlert');
                const statusMessage = document.getElementById('statusMessage');

                const statusInfo = payrollStatus[status];
                statusAlert.innerHTML = `<i class="fas fa-circle"></i> <strong>${statusInfo.icon} ${statusInfo.label}</strong>`;
                statusAlert.className = `alert alert-${statusInfo.color} mb-2`;

                const messages = {
                    'draft': 'La nómina se creará en estado de borrador y podrá ser editada',
                    'approved': 'La nómina ha sido aprobada y está lista para procesar',
                    'processed': 'La nómina está siendo procesada',
                    'paid': 'La nómina ha sido pagada a los empleados',
                    'cancelled': 'La nómina ha sido cancelada'
                };
                statusMessage.textContent = messages[status];
                updateSummary();
            }

            function updateDateInfo() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const daysInfo = document.getElementById('daysInfo');

                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const days = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;

                    if (days > 0) {
                        const options = { year: 'numeric', month: 'long', day: 'numeric' };
                        daysInfo.innerHTML = `<strong>Duración:</strong> ${days} días (${start.toLocaleDateString('es-MX', options)} - ${end.toLocaleDateString('es-MX', options)})`;
                    } else {
                        daysInfo.innerHTML = '<strong class="text-danger">Error:</strong> La fecha de fin debe ser posterior a la de inicio';
                    }
                    updateSummary();
                }
            }

            function updateSummary() {
                const restaurantId = document.getElementById('restaurant_id').value;
                const periodNumber = document.getElementById('period_number').value;
                const year = document.getElementById('year').value;
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;
                const status = document.getElementById('status').value;

                // Restaurante
                if (restaurantId) {
                    const selectedText = document.querySelector('#restaurant_id option:selected').text;
                    document.getElementById('summaryRestaurant').textContent = selectedText;
                } else {
                    document.getElementById('summaryRestaurant').textContent = '-';
                }

                // Período
                if (periodNumber && year) {
                    document.getElementById('summaryPeriod').textContent = `Período ${periodNumber}/${year}`;
                } else {
                    document.getElementById('summaryPeriod').textContent = '-';
                }

                // Días
                if (startDate && endDate) {
                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    const days = Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
                    if (days > 0) {
                        document.getElementById('summaryDays').textContent = `${days} días`;
                    } else {
                        document.getElementById('summaryDays').textContent = '-';
                    }
                } else {
                    document.getElementById('summaryDays').textContent = '-';
                }

                // Estado
                if (status) {
                    const statusInfo = payrollStatus[status];
                    document.getElementById('summaryStatus').textContent = `${statusInfo.icon} ${statusInfo.label}`;
                } else {
                    document.getElementById('summaryStatus').textContent = '-';
                }
            }

            $(document).ready(function() {
                // Inicializar Select2
                $('.select2').select2({
                    placeholder: 'Seleccione una opción',
                    allowClear: true
                });

                // Eventos de cambio
                $('#restaurant_id').on('change', updateSummary);
                $('#period_number').on('change', updateSummary);
                $('#year').on('change', updateSummary);
                $('#start_date').on('change', updateDateInfo);
                $('#end_date').on('change', updateDateInfo);

                // Validación de formulario
                $('#payrollForm').on('submit', function(e) {
                    const restaurantId = $('#restaurant_id').val();
                    const periodNumber = $('#period_number').val();
                    const year = $('#year').val();
                    const startDate = $('#start_date').val();
                    const endDate = $('#end_date').val();

                    if (!restaurantId || !periodNumber || !year || !startDate || !endDate) {
                        alert('Por favor complete todos los campos requeridos');
                        e.preventDefault();
                        return false;
                    }

                    const start = new Date(startDate);
                    const end = new Date(endDate);
                    if (end < start) {
                        alert('La fecha de fin debe ser posterior a la fecha de inicio');
                        e.preventDefault();
                        return false;
                    }

                    const periodNum = parseInt(periodNumber);
                    if (periodNum < 1 || periodNum > 26) {
                        alert('El período debe estar entre 1 y 26');
                        e.preventDefault();
                        return false;
                    }

                    if (!confirm('¿Está seguro de crear esta nómina?')) {
                        e.preventDefault();
                        return false;
                    }
                });

                // Inicializar resumen
                updateSummary();
            });
        </script>
    @endpush
@endsection