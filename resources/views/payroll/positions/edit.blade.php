@extends('layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-white d-flex justify-content-between align-items-center"
                    style="background:{{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#007bff' }};">
                    <h5 class="mb-0"
                        style="color:{{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#fff' }};">
                        <i class="fas fa-briefcase"></i> Editar Puesto Laboral
                    </h5>
                    <a href="{{ route('business.restaurants.payroll.index', ['business' => $business->slug, 'restaurants' => $restaurants->slug]) }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Volver a Puestos
                    </a>
                </div>

                <div class="card-body">
                    <form id="positionForm" method="POST" 
                    action="{{ route('business.restaurants.positions.update', 
                    ['business' => $business->slug,
                     'restaurants' => $restaurants->slug,
                     'position' => $position->id])
                    }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Información Básica del Puesto -->
                            <div class="col-md-8 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-info-circle"></i> Información del Puesto</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Restaurante -->
                                        <div class="mb-3">
                                            <label for="restaurant_id" class="form-label">
                                                Restaurante <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $restaurants->name }}"
                                                readonly
                                                placeholder="{{ $restaurants->name }}">
                                            <input type="hidden" name="restaurant_id" value="{{ $restaurants->id }}">
                                            @error('restaurant_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">El nombre del puesto debe ser único por restaurante</small>
                                        </div>

                                        <!-- Nombre del Puesto -->
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                Nombre del Puesto <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                id="name" name="name" required maxlength="100"
                                                value="{{ old('name', $position->name) }}"
                                                placeholder="Ej. Chef Principal, Mesero, Recepcionista">
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Descripción -->
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Descripción</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                id="description" name="description" rows="4"
                                                placeholder="Describe las responsabilidades y funciones del puesto...">{{ old('description', $position->description) }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted">Campo opcional</small>
                                        </div>

                                        <!-- Estado -->
                                        <div class="mb-3">
                                            <label for="status" class="form-label">
                                                Estado <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-control @error('status') is-invalid @enderror"
                                                id="status" name="status" required onchange="updateStatusPanel()">
                                                <option value="active" {{ old('status', $position->status) == 'active' ? 'selected' : '' }}>Activo</option>
                                                <option value="inactive" {{ old('status', $position->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Panel de Estado -->
                            <div class="col-md-4 mb-4">
                                <div class="card bg-light">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0"><i class="fas fa-circle text-success"></i> Estado del Puesto</h6>
                                    </div>
                                    <div class="card-body">
                                        @if(old('status', $position->status) == 'active')
                                            <div class="alert alert-success mb-2" id="statusAlert">
                                                <i class="fas fa-check-circle"></i> <strong>Activo</strong>
                                            </div>
                                            <p class="text-muted small mb-0" id="statusMessage">Los nuevos empleados pueden ser asignados a este puesto</p>
                                        @else
                                            <div class="alert alert-danger mb-2" id="statusAlert">
                                                <i class="fas fa-times-circle"></i> <strong>Inactivo</strong>
                                            </div>
                                            <p class="text-muted small mb-0" id="statusMessage">No se pueden asignar empleados a este puesto</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Salarial -->
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-dollar-sign"></i> Información Salarial</h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Tipo de Salario -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="salary_type" class="form-label">
                                                    Tipo de Salario <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control @error('salary_type') is-invalid @enderror"
                                                    id="salary_type" name="salary_type" required onchange="updateSalaryInfo()">
                                                    <option value="">Selecciona una opcion</option>
                                                    <option value="fixed" {{ old('salary_type', $position->salary_type) == 'fixed' ? 'selected' : '' }}>Fijo</option>
                                                    <option value="hourly" {{ old('salary_type', $position->salary_type) == 'hourly' ? 'selected' : '' }}>Por Hora</option>
                                                    <option value="daily" {{ old('salary_type', $position->salary_type) == 'daily' ? 'selected' : '' }}>Por Día</option>
                                                </select>
                                                @error('salary_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Salario Base -->
                                            <div class="col-md-6 mb-3">
                                                <label for="base_salary" class="form-label">
                                                    Salario Base <span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="fas fa-peso-sign"></i></span>
                                                    <input type="number" class="form-control @error('base_salary') is-invalid @enderror"
                                                        id="base_salary" name="base_salary" value="{{ old('base_salary', $position->base_salary) }}"
                                                        step="0.01" min="0" required placeholder="0.00">
                                                </div>
                                                @error('base_salary')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <!-- Horas por Día -->
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="hours_per_day" class="form-label">Horas por Día</label>
                                                <input type="number" class="form-control @error('hours_per_day') is-invalid @enderror"
                                                    id="hours_per_day" name="hours_per_day" value="{{ old('hours_per_day', $position->hours_per_day) }}"
                                                    min="1" max="24" placeholder="8">
                                                @error('hours_per_day')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Aplica para salarios por hora o por día</small>
                                            </div>
                                        </div>

                                        <!-- Información de Salario -->
                                        <div class="alert alert-info mt-4">
                                            <strong><i class="fas fa-info-circle"></i> Información del Cálculo de Salario:</strong>
                                            <p class="mb-0 mt-2" id="salaryExplanation">
                                                @php
                                                    $explanations = [
                                                        'fixed' => 'Para un puesto con <strong>Salario Fijo</strong>, el empleado recibirá un pago constante independientemente de las horas trabajadas.',
                                                        'hourly' => 'Para un puesto con <strong>Salario por Hora</strong>, el pago se calcula multiplicando la tarifa horaria por las horas trabajadas.',
                                                        'daily' => 'Para un puesto con <strong>Salario por Día</strong>, el pago se calcula multiplicando la tarifa diaria por los días trabajados.'
                                                    ];
                                                    $currentType = old('salary_type', $position->salary_type);
                                                @endphp
                                                {!! $explanations[$currentType] ?? 'Seleccione un tipo de salario para ver la explicación.' !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('business.restaurants.payroll.index', 
                                        ['business' => $business->slug, 'restaurants' => $restaurants->slug]) }}"
                                        class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Puesto
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
@endsection

@push('js')
<script>
    function updateSalaryInfo() {
        const salaryType = document.getElementById('salary_type').value;
        const explanationElement = document.getElementById('salaryExplanation');
        const explanations = {
            'fixed': 'Para un puesto con <strong>Salario Fijo</strong>, el empleado recibirá un pago constante independientemente de las horas trabajadas.',
            'hourly': 'Para un puesto con <strong>Salario por Hora</strong>, el pago se calcula multiplicando la tarifa horaria por las horas trabajadas.',
            'daily': 'Para un puesto con <strong>Salario por Día</strong>, el pago se calcula multiplicando la tarifa diaria por los días trabajados.'
        };
        
        if (explanations[salaryType]) {
            explanationElement.innerHTML = explanations[salaryType];
        } else {
            explanationElement.innerHTML = 'Seleccione un tipo de salario para ver la explicación.';
        }
    }

    function updateStatusPanel() {
        const status = document.getElementById('status').value;
        const statusAlert = document.getElementById('statusAlert');
        const statusMessage = document.getElementById('statusMessage');

        if (status === 'active') {
            statusAlert.innerHTML = '<i class="fas fa-check-circle"></i> <strong>Activo</strong>';
            statusAlert.className = 'alert alert-success mb-2';
            statusMessage.textContent = 'Los nuevos empleados pueden ser asignados a este puesto';
        } else {
            statusAlert.innerHTML = '<i class="fas fa-times-circle"></i> <strong>Inactivo</strong>';
            statusAlert.className = 'alert alert-danger mb-2';
            statusMessage.textContent = 'No se pueden asignar empleados a este puesto';
        }
    }

    $(document).ready(function() {
        updateSalaryInfo();

        $('#positionForm').on('submit', function(e) {
            const positionName = $('#name').val();
            const restaurantName = "{{ $restaurants->name }}";

            if (positionName.trim() === '') {
                alert('Por favor ingrese el nombre del puesto');
                e.preventDefault();
                return;
            }

            if (!confirm(`¿Está seguro de actualizar el puesto "${positionName}" en ${restaurantName}?`)) {
                e.preventDefault();
                return;
            }
        });
    });
</script>
@endpush