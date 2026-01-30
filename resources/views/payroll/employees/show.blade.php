@extends('layouts.master')

@section('title', 'Detalle del Empleado')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-white d-flex justify-content-between align-items-center"
                        style="background:{{ !empty($restaurants->color_secondary) ? $restaurants->color_secondary : '#6c757d' }};">
                        <h5 class="mb-0"
                            style="color:{{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#fff' }};">
                            <i class="fas fa-user"></i> Información del Empleado
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('business.restaurants.payroll.index', 
                                ['business' => $business->slug, 'restaurants' => $restaurants->slug]) }}" 
                                class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Información Personal -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-id-card"></i> Información Personal</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">Nombre(s)</label>
                                                <p class="fw-bold mb-0">{{ $employee->first_name }}</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">Apellido Paterno</label>
                                                <p class="fw-bold mb-0">{{ $employee->last_name }}</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">Apellido Materno</label>
                                                <p class="fw-bold mb-0">{{ $employee->sur_name }}</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">Nombre Completo</label>
                                                <p class="fw-bold mb-0">
                                                    {{ $employee->first_name }} {{ $employee->last_name }} {{ $employee->sur_name }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted fs-5">Correo Electrónico</label>
                                                <p class="mb-0">
                                                    @if($employee->email)
                                                        <i class="fas fa-envelope text-primary"></i> 
                                                        <a href="mailto:{{ $employee->email }}">{{ $employee->email }}</a>
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted fs-5">Teléfono</label>
                                                <p class="mb-0">
                                                    @if($employee->phone)
                                                        <i class="fas fa-phone text-success"></i> 
                                                        <a href="tel:{{ $employee->phone }}">{{ $employee->phone }}</a>
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="text-muted fs-5">Género</label>
                                                <p class="mb-0">
                                                    @if($employee->gender)
                                                        @if($employee->gender == 'male')
                                                            <i class="fas fa-mars text-primary"></i> Masculino
                                                        @elseif($employee->gender == 'female')
                                                            <i class="fas fa-venus text-danger"></i> Femenino
                                                        @else
                                                            <i class="fas fa-genderless text-secondary"></i> Otro
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No especificado</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted fs-5">Fecha de Nacimiento</label>
                                                <p class="mb-0">
                                                    @if($employee->birth_date)
                                                        <i class="fas fa-birthday-cake text-warning"></i> 
                                                        {{ \Carbon\Carbon::parse($employee->birth_date)->format('d/m/Y') }}
                                                        <span class="badge bg-primary ms-3">
                                                            {{ \Carbon\Carbon::parse($employee->birth_date)->age }} años
                                                        </span>
                                                    @else
                                                        <span class="text-muted">No registrada</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted fs-5">Lugar de Nacimiento</label>
                                                <p class="mb-0">
                                                    @if($employee->birth_place)
                                                        <i class="fas fa-map-marker-alt text-info"></i> {{ $employee->birth_place }}
                                                    @else
                                                        <span class="text-muted">No registrado</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información Laboral -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-building"></i> Información Laboral</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Restaurante</label>
                                            <p class="fw-bold mb-0">{{ $restaurants->name }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Puesto</label>
                                            <p class="fw-bold mb-0">
                                                @if($employee->position)
                                                    {{ $employee->position->name }}
                                                @else
                                                    <span class="text-muted">No asignado</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Tipo de Contrato</label>
                                            <p class="mb-0">
                                                @if($employee->employment_type == 'fixed')
                                                    <span class="badge bg-primary">Fijo</span>
                                                @elseif($employee->employment_type == 'temporal')
                                                    <span class="badge bg-primary">Temporal</span>
                                                @elseif($employee->employment_type == 'part-time')
                                                    <span class="badge bg-primary">Tiempo Parcial</span>
                                                @elseif($employee->employment_type == 'contractor')
                                                    <span class="badge bg-secondary">Contratista</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Estatus</label>
                                            <p class="mb-0">
                                                @if($employee->trashed())
                                                    <span class="badge bg-danger">Suspendido</span>
                                                @elseif($employee->status == 'active')
                                                    <span class="badge bg-success">Activo</span>
                                                @elseif($employee->status == 'inactive')
                                                    <span class="badge bg-secondary">Inactivo</span>
                                                @elseif($employee->status == 'terminated')
                                                    <span class="badge bg-dark">Terminado</span>
                                                @elseif($employee->status == 'on_leave')
                                                    <span class="badge bg-warning">En Permiso</span>
                                                @else
                                                    <span class="badge bg-light text-dark">{{ ucfirst($employee->status) }}</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fechas -->
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-calendar-alt"></i> Fechas Importantes</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Fecha de Contratación</label>
                                            <p class="mb-0">
                                                @if($employee->hire_date)
                                                    <i class="fas fa-calendar-check text-success"></i> 
                                                    {{ \Carbon\Carbon::parse($employee->hire_date)->format('d/m/Y') }}
                                                    <span class="badge bg-info ms-2">
                                                        Hace {{ \Carbon\Carbon::parse($employee->hire_date)->diffForHumans() }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">No registrada</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Antigüedad</label>
                                            <p class="mb-0">
                                                @if($employee->hire_date)
                                                    @php
                                                        $hireDate = \Carbon\Carbon::parse($employee->hire_date);
                                                        $now = \Carbon\Carbon::now();
                                                        $diff = $hireDate->diff($now);
                                                    @endphp
                                                    <i class="fas fa-briefcase text-primary"></i> 
                                                    {{ $diff->y }} años, 
                                                    {{ $diff->m }} meses, 
                                                    {{ $diff->d }} días
                                                @else
                                                    <span class="text-muted">No calculable</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Fecha de Terminación</label>
                                            <p class="mb-0">
                                                @if($employee->termination_date)
                                                    <i class="fas fa-calendar-times text-danger"></i> 
                                                    {{ \Carbon\Carbon::parse($employee->termination_date)->format('d/m/Y') }}
                                                @else
                                                    <span class="text-muted">No aplica</span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dirección -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-map-marker-alt"></i> Dirección</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="text-muted fs-5">Domicilio</label>
                                                <p class="mb-0">{{ $employee->address ?? 'No registrado' }}</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">Ciudad</label>
                                                <p class="mb-0">{{ $employee->city ?? 'No registrada' }}</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">Estado</label>
                                                <p class="mb-0">{{ $employee->state ?? 'No registrado' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">Código Postal</label>
                                                <p class="mb-0">{{ $employee->postal_code ?? 'No registrado' }}</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="text-muted fs-5">País</label>
                                                <p class="mb-0">{{ $employee->country ?? 'No registrado' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Datos Fiscales y Bancarios -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-file-invoice-dollar"></i> Datos Fiscales</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Número IMSS</label>
                                            <p class="mb-0 font-monospace">{{ $employee->imss_number ?? 'No registrado' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">RFC</label>
                                            <p class="mb-0 font-monospace">{{ $employee->rfc ?? 'No registrado' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">CURP</label>
                                            <p class="mb-0 font-monospace">{{ $employee->curp ?? 'No registrado' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card border h-100">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-university"></i> Datos Bancarios</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Banco</label>
                                            <p class="mb-0">{{ $employee->bank_name ?? 'No registrado' }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">Número de Cuenta</label>
                                            <p class="mb-0 font-monospace">
                                                @if($employee->bank_account)
                                                    ****{{ substr($employee->bank_account, -4) }}
                                                @else
                                                    No registrada
                                                @endif
                                            </p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-muted fs-5">CLABE Interbancaria</label>
                                            <p class="mb-0 font-monospace">{{ $employee->bank_clabe ?? 'No registrada' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notas -->
                        @if($employee->notes)
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0"><i class="fas fa-sticky-note"></i> Notas Adicionales</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $employee->notes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Información del Sistema -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card border bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-plus"></i> Creado: 
                                                    {{ $employee->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-edit"></i> Última actualización: 
                                                    {{ $employee->updated_at->format('d/m/Y H:i') }}
                                                </small>
                                            </div>
                                            <div class="col-md-4">
                                                <small class="text-muted">
                                                    <i class="fas fa-fingerprint"></i> ID: #{{ $employee->id }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <!-- <a href="{{ route('business.restaurants.payroll.index', 
                                    ['business' => $business->slug, 'restaurants' => $restaurants->slug]) }}" 
                                    class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver a la Lista
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection