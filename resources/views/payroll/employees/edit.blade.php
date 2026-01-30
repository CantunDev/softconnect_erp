@extends('layouts.master')

@section('title', 'Editar Empleado')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style=" background:{{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#ccc' }};">
                        <h5 class="mb-0"
                            style=" color:{{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#fff' }};">
                            <i class="fas fa-user-edit"></i> Editar Empleado: {{ $employee->first_name }} {{ $employee->last_name }}
                        </h5>
                        <a href="{{ route('business.restaurants.payroll.index', ['business' => $business->slug, 'restaurants' => $restaurants->slug]) }}" 
                           class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>

                    <div class="card-body">
                        <form method="POST" 
                              action="{{ route('business.restaurants.employees.update', ['business' => $business->slug, 'restaurants' => $restaurants->slug, 'employee' => $employee->id]) }}" 
                              id="employeeForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-building"></i> Información Laboral</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="restaurant_id" class="form-label">
                                                    Restaurante <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control select2" id="restaurant_id" name="restaurant_id" required>
                                                    <option value="{{ $restaurants->id }}" selected>
                                                        {{ $restaurants->name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="position_id" class="form-label">
                                                    Puesto <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control select2 @error('position_id') is-invalid @enderror"
                                                    id="position_id" name="position_id" required>
                                                    <option value="">Seleccione un puesto</option>
                                                    @foreach ($positions as $position)
                                                        <option value="{{ $position->id }}" 
                                                            {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                                            {{ $position->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('position_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="employment_type" class="form-label">
                                                    Tipo de Contrato <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control @error('employment_type') is-invalid @enderror"
                                                    id="employment_type" name="employment_type" required>
                                                    <option value="">Sin seleccionar</option>
                                                    <option value="fixed" {{ old('employment_type', $employee->employment_type) == 'fixed' ? 'selected' : '' }}>Fijo</option>
                                                    <option value="temporal" {{ old('employment_type', $employee->employment_type) == 'temporal' ? 'selected' : '' }}>Temporal</option>
                                                    <option value="part-time" {{ old('employment_type', $employee->employment_type) == 'part-time' ? 'selected' : '' }}>Tiempo parcial</option>
                                                    <option value="contractor" {{ old('employment_type', $employee->employment_type) == 'contractor' ? 'selected' : '' }}>Contratista</option>
                                                </select>
                                                @error('employment_type')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="status" class="form-label">
                                                    Estatus <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                                    <option value="active" {{ old('status', $employee->status) == 'active' ? 'selected' : '' }}>Activo</option>
                                                    <option value="inactive" {{ old('status', $employee->status) == 'inactive' ? 'selected' : '' }}>Inactivo</option>
                                                    <option value="suspended" {{ old('status', $employee->status) == 'suspended' ? 'selected' : '' }}>Suspendido</option>
                                                    <option value="terminated" {{ old('status', $employee->status) == 'terminated' ? 'selected' : '' }}>Terminado</option>
                                                    <option value="on_leave" {{ old('status', $employee->status) == 'on_leave' ? 'selected' : '' }}>En Permiso</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-id-card"></i> Información Personal</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label for="first_name" class="form-label">Nombre(s) <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control text-capitalize @error('first_name') is-invalid @enderror"
                                                        id="first_name" name="first_name"
                                                        value="{{ old('first_name', $employee->first_name) }}"
                                                        oninput="this.value=this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                                        title="Solo se permiten letras y espacios"
                                                        required maxlength="100">
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="last_name" class="form-label">Apellido Paterno <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                        id="last_name" name="last_name" 
                                                        value="{{ old('last_name', $employee->last_name) }}"
                                                        oninput="this.value=this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                                        title="Solo se permiten letras y espacios"
                                                        required maxlength="100">
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4 mb-2">
                                                    <label for="sur_name" class="form-label">Apellido Materno <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control @error('sur_name') is-invalid @enderror"
                                                        id="sur_name" name="sur_name" 
                                                        value="{{ old('sur_name', $employee->sur_name) }}"
                                                        oninput="this.value=this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                                        title="Solo se permiten letras y espacios"
                                                        required maxlength="100">
                                                    @error('sur_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="email" class="form-label">Correo Electrónico</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                        id="email" name="email" value="{{ old('email', $employee->email) }}">
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="phone" class="form-label">Teléfono</label>
                                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror"
                                                        id="phone" name="phone" value="{{ old('phone', $employee->phone) }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                    @error('phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="gender" class="form-label">Género</label>
                                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                                        <option value="">Seleccione</option>
                                                        <option value="male" {{ old('gender', $employee->gender) == 'male' ? 'selected' : '' }}>Masculino</option>
                                                        <option value="female" {{ old('gender', $employee->gender) == 'female' ? 'selected' : '' }}>Femenino</option>
                                                        <option value="other" {{ old('gender', $employee->gender) == 'other' ? 'selected' : '' }}>Otro</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="birth_date" class="form-label">Fecha de Nacimiento</label>
                                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                                        id="birth_date" name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}">
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="birth_place" class="form-label">Lugar de Nacimiento</label>
                                                <input type="text" class="form-control text-capitalize @error('birth_place') is-invalid @enderror"
                                                    id="birth_place" name="birth_place" value="{{ old('birth_place', $employee->birth_place) }}"
                                                    oninput="this.value=this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                                    title="Solo se permiten letras y espacios"
                                                    maxlength="255">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Fechas</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="hire_date" class="form-label">Fecha de Contratación <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control @error('hire_date') is-invalid @enderror"
                                                        id="hire_date" name="hire_date" 
                                                        value="{{ old('hire_date', $employee->hire_date) }}" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="termination_date" class="form-label">Fecha de Terminación</label>
                                                    <input type="date" class="form-control @error('termination_date') is-invalid @enderror"
                                                        id="termination_date" name="termination_date"
                                                        value="{{ old('termination_date', $employee->termination_date) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-map-marker-alt"></i> Dirección</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="address" class="form-label">Domicilio</label>
                                                <input type="text" class="form-control text-capitalize @error('address') is-invalid @enderror"
                                                    id="address" name="address" value="{{ old('address', $employee->address) }}"
                                                    maxlength="255">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="city" class="form-label">Ciudad</label>
                                                    <input type="text" class="form-control text-capitalize @error('city') is-invalid @enderror"
                                                        id="city" name="city" value="{{ old('city', $employee->city) }}"
                                                        oninput="this.value=this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                                        title="Solo se permiten letras y espacios"
                                                        maxlength="100">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="state" class="form-label">Estado</label>
                                                    <input type="text" class="form-control text-capitalize @error('state') is-invalid @enderror"
                                                        id="state" name="state" value="{{ old('state', $employee->state) }}"
                                                        oninput="this.value=this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');"
                                                        title="Solo se permiten letras y espacios"
                                                        maxlength="100">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="postal_code" class="form-label">Código Postal</label>
                                                    <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                                        id="postal_code" name="postal_code" value="{{ old('postal_code', $employee->postal_code) }}"
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                                                        maxlength="5">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="country" class="form-label">País</label>
                                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                                        id="country" name="country" value="{{ old('country', $employee->country) }}" maxlength="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Datos Fiscales</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="imss_number" class="form-label">Número IMSS</label>
                                                    <input type="text" class="form-control @error('imss_number') is-invalid @enderror"
                                                        id="imss_number" name="imss_number"
                                                        value="{{ old('imss_number', $employee->imss_number) }}">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="rfc" class="form-label">RFC</label>
                                                    <input type="text" class="form-control @error('rfc') is-invalid @enderror"
                                                        id="rfc" name="rfc" value="{{ old('rfc', $employee->rfc) }}" 
                                                        oninput="this.value = this.value.toUpperCase()"
                                                        maxlength="13">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="curp" class="form-label">CURP</label>
                                                <input type="text" class="form-control @error('curp') is-invalid @enderror"
                                                    id="curp" name="curp" value="{{ old('curp', $employee->curp) }}" 
                                                    oninput="this.value = this.value.toUpperCase()"
                                                    maxlength="18">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-university"></i> Datos Bancarios</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="bank_name" class="form-label">Nombre del Banco</label>
                                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror"
                                                    id="bank_name" name="bank_name" value="{{ old('bank_name', $employee->bank_name) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="bank_account" class="form-label">Número de Cuenta</label>
                                                <input type="text" class="form-control @error('bank_account') is-invalid @enderror"
                                                    id="bank_account" name="bank_account" value="{{ old('bank_account', $employee->bank_account) }}">
                                            </div>
                                            <div class="mb-3">
                                                <label for="bank_clabe" class="form-label">CLABE Interbancaria</label>
                                                <input type="text" class="form-control @error('bank_clabe') is-invalid @enderror"
                                                    id="bank_clabe" name="bank_clabe" value="{{ old('bank_clabe', $employee->bank_clabe) }}" maxlength="18">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0"><i class="fas fa-sticky-note"></i> Información Adicional</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="notes" class="form-label">Notas</label>
                                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                                    id="notes" name="notes" rows="3">{{ old('notes', $employee->notes) }}</textarea>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                                                    {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Empleado activo
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('business.restaurants.payroll.index', ['business' => $business->slug, 'restaurants' => $restaurants->slug]) }}" 
                                           class="btn btn-secondary">
                                            <i class="fas fa-times"></i> Cancelar
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save"></i> Actualizar Empleado
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
            .select2-container .select2-selection--single { height: 38px; }
            .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 36px; }
            .card { border: 1px solid #e0e0e0; border-radius: 8px; }
            .card-header { border-bottom: 1px solid #e0e0e0; }
            .form-label { font-weight: 500; color: #555; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2({ placeholder: 'Seleccione una opción', allowClear: true });

                const today = new Date().toISOString().split('T')[0];
                $('#hire_date').attr('max', today);
                
                if ($('#hire_date').val()) {
                    $('#termination_date').attr('min', $('#hire_date').val());
                }

                $('#hire_date').on('change', function() {
                    $('#termination_date').attr('min', $(this).val());
                });

                $('#rfc').on('blur', function() {
                    const rfc = $(this).val().trim().toUpperCase();
                    if (rfc && !validateRFC(rfc)) {
                        alert('RFC inválido. Formato: XAXX010101000');
                        $(this).focus();
                    }
                });

                $('#curp').on('blur', function() {
                    const curp = $(this).val().trim().toUpperCase();
                    if (curp && !validateCURP(curp)) {
                        alert('CURP inválido. Debe tener 18 caracteres');
                        $(this).focus();
                    }
                });

                $('#bank_clabe').on('blur', function() {
                    const clabe = $(this).val().trim();
                    if (clabe && clabe.length !== 18) {
                        alert('La CLABE debe tener 18 dígitos');
                    }
                });
                
                $('#imss_number').on('blur', function() {
                    const imss = $(this).val().trim();
                    if (imss && !/^\d{11}$/.test(imss)) {
                        alert('El número IMSS debe tener 11 dígitos');
                    }
                });

                $('#postal_code').on('blur', function() {
                    const postalCode = $(this).val().trim();
                    if (postalCode && !/^\d{4,5}$/.test(postalCode)) {
                        alert('Código postal inválido');
                    }
                });

                function validateRFC(rfc) {
                    const rfcPattern = /^[A-Z&Ñ]{3,4}[0-9]{6}[A-Z0-9]{3}$/;
                    return rfcPattern.test(rfc);
                }

                function validateCURP(curp) {
                    const curpPattern = /^[A-Z]{4}[0-9]{6}[HM]{1}[A-Z]{5}[0-9A-Z]{1}[0-9]$/;
                    return curpPattern.test(curp);
                }

                $('#employeeForm').on('submit', function(e) {
                    const hireDate = $('#hire_date').val();
                    const terminationDate = $('#termination_date').val();
                    
                    if (terminationDate && terminationDate < hireDate) {
                        alert('La fecha de terminación no puede ser anterior a la fecha de contratación');
                        e.preventDefault();
                        return false;
                    }

                    if (!confirm('¿Está seguro de actualizar la información del empleado?')) {
                        e.preventDefault();
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection