<!-- ============================================
     LAYOUT PRINCIPAL - layouts/app.blade.php
     ============================================ -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistema de Nómina</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-6 overflow-y-auto">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">Nómina</h1>
                <p class="text-gray-400 text-sm">Control de Empleados</p>
            </div>

            <nav class="space-y-4">
                {{-- <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <span class="text-lg">📊 Dashboard</span>
                </a>
                <a href="{{ route('employees.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <span class="text-lg">👥 Empleados</span>
                </a>
                <a href="{{ route('payroll.periods.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <span class="text-lg">📋 Períodos de Nómina</span>
                </a>
                <a href="{{ route('attendance.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <span class="text-lg">✓ Asistencia</span>
                </a>
                <a href="{{ route('payroll.reports') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <span class="text-lg">📊 Reportes</span>
                </a>
                <a href="{{ route('positions.index') }}" class="block px-4 py-2 rounded hover:bg-gray-700">
                    <span class="text-lg">🏢 Puestos</span> --}}
                {{-- </a> --}}
            </nav>
        </div>

        <!-- Contenido Principal -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow p-6 flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">@yield('header')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-gray-600">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-800">Cerrar Sesión</button>
                    </form>
                </div>
            </header>

            <!-- Mensajes Flash -->
            @if ($message = Session::get('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mx-6 mt-4">
                    {{ $message }}
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mx-6 mt-4">
                    {{ $message }}
                </div>
            @endif

            <!-- Contenido -->
            <main class="flex-1 overflow-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

<!-- ============================================
     DASHBOARD - resources/views/dashboard.blade.php
     ============================================ -->

@extends('layouts.master')

@section('title', 'Dashboard')
@section('header', 'Dashboard - Resumen de Nómina')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <!-- Card: Total Empleados -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total Empleados</p>
                <p class="text-3xl font-bold text-gray-800 mt-2"> 0</p>
            </div>
            <span class="text-3xl">👥</span>
        </div>
        <p class="text-green-600 text-sm mt-2">0 activos</p>
    </div>

    <!-- Card: Nóminas Este Período -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-medium">Período Actual</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">0 </p>
            </div>
            <span class="text-3xl">📅</span>
        </div>
        <p class="text-gray-600 text-sm mt-2">0 - 0</p>
    </div>

    <!-- Card: Total a Pagar -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-medium">Total a Pagar</p>
                <p class="text-2xl font-bold text-green-600 mt-2">${{ number_format(0, 2) }}</p>
            </div>
            <span class="text-3xl">💰</span>
        </div>
    </div>

    <!-- Card: Restaurantes -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-gray-600 text-sm font-medium">Restaurantes</p>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ 0    }}</p>
            </div>
            <span class="text-3xl">🏢</span>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Gráfico: Empleados por Restaurante -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Empleados por Restaurante</h3>
        <canvas id="employeesByRestaurant"></canvas>
    </div>

    <!-- Gráfico: Empleados por Puesto -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Empleados por Puesto</h3>
        <canvas id="employeesByPosition"></canvas>
    </div>

    <!-- Gráfico: Evolución de Nóminas -->
    <div class="bg-white rounded-lg shadow p-6 lg:col-span-2">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Tendencia de Nóminas (Últimos 6 Períodos)</h3>
        <canvas id="payrollTrend"></canvas>
    </div>
</div>

<script>
    // Gráfico: Empleados por Restaurante
    const restaurantCtx = document.getElementById('employeesByRestaurant').getContext('2d');
    new Chart(restaurantCtx, {
        type: 'doughnut',
        data: {
            labels: @json(0),
            datasets: [{
                data: @json(0),
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
            }]
        }
    });

    // Gráfico: Empleados por Puesto
    const positionCtx = document.getElementById('employeesByPosition').getContext('2d');
    new Chart(positionCtx, {
        type: 'bar',
        data: {
            labels: @json(0),
            datasets: [{
                label: 'Cantidad',
                data: @json(0),
                backgroundColor: '#36A2EB'
            }]
        }
    });

    // Gráfico: Evolución de Nóminas
    const payrollCtx = document.getElementById('payrollTrend').getContext('2d');
    new Chart(payrollCtx, {
        type: 'line',
        data: {
            labels: @json(0),
            datasets: [{
                label: 'Total Nómina',
                data: @json(0),
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    });
</script>
@endsection

<!-- ============================================
     LISTADO DE EMPLEADOS - resources/views/employees/index.blade.php
     ============================================ -->

@extends('layouts.master')

@section('title', 'Empleados')
@section('header', 'Gestión de Empleados')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-xl font-bold text-gray-800">Lista de Empleados</h3>
    </div>
    <a href="" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + Nuevo Empleado
    </a>
</div>

<!-- Filtros -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form method="GET" action="" class="flex gap-4">
        <div class="flex-1">
            <input type="text" name="search" placeholder="Buscar por nombre..." 
                   value="{{ request('search') }}" 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>
        <select name="restaurant_id" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Todos los Restaurantes</option>
            @foreach($restaurants as $restaurant)
                {{-- <option value="{{ $restaurant->id }}" {{ request('restaurant_id') == $restaurant->id ? 'selected' : '' }}>
                    {{ $restaurant->name }}
                </option> --}}
            @endforeach
        </select>
        <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
            <option value="">Todos los Estatus</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Activo</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactivo</option>
            <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendido</option>
        </select>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Filtrar
        </button>
    </form>
</div>

<!-- Tabla de Empleados -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nombre</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Restaurante</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Puesto</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Entrada</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Estatus</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Acciones</th>
            </tr>
        </thead>
        <tbody>
            {{-- @forelse($employees as $employee)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4 text-gray-800">
                        <div>
                            <p class="font-semibold">{{ $employee->full_name }}</p>
                            <p class="text-sm text-gray-600">{{ $employee->email }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-700">{{ $employee->restaurant->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $employee->position->name }}</td>
                    <td class="px-6 py-4 text-gray-700">{{ $employee->hire_date->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{-- {{ $employee->status === 'active' ? 'bg-green-100 text-green-800' :  --}}
                               {{-- $employee->status === 'inactive' ? 'bg-gray-100 text-gray-800' : --}}
                               {{-- 'bg-red-100 text-red-800' }}"> --}}
                            {{-- {{ ucfirst($employee->status) }} --}}
                        {{-- </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('employees.show', $employee) }}" class="text-blue-600 hover:text-blue-800 text-sm mr-3">Ver</a>
                        <a href="{{ route('employees.edit', $employee) }}" class="text-green-600 hover:text-green-800 text-sm">Editar</a>
                    </td> --}}
                {{-- </tr> --}}
            {{-- @empty --}} --}}
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-600">
                        No hay empleados registrados
                    </td>
                </tr>
            {{-- @endforelse --}}
        </tbody>
    </table>
</div>

<!-- Paginación -->
<div class="mt-6">
    {{-- {{ $employees->links('pagination::tailwind') }} --}}
</div>
@endsection

<!-- ============================================
     CREAR/EDITAR EMPLEADO - resources/views/employees/form.blade.php
     ============================================ -->

@extends('layouts.master')

@section('title', isset($employee) ? 'Editar Empleado' : 'Nuevo Empleado')
@section('header', isset($employee) ? 'Editar Empleado: ' . $employee->full_name : 'Nuevo Empleado')

@section('content')
<form  
      method="POST" class="bg-white rounded-lg shadow p-8 max-w-4xl">
    @csrf
    @if(isset($employee))
        @method('PUT')
    @endif

    <!-- Información Personal -->
    <fieldset class="mb-8">
        <legend class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Información Personal</legend>
        
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nombre</label>
                <input type="text" name="first_name" required 
                       value="{{ $employee->first_name ?? old('first_name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('first_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Apellido</label>
                <input type="text" name="last_name" required 
                       value="{{ $employee->last_name ?? old('last_name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('last_name')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input type="email" name="email" 
                       value="{{ $employee->email ?? old('email') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('email')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Teléfono</label>
                <input type="tel" name="phone" 
                       value="{{ $employee->phone ?? old('phone') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </fieldset>

    <!-- Información Laboral -->
    <fieldset class="mb-8">
        <legend class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Información Laboral</legend>
        
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Restaurante</label>
                <select name="restaurant_id" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar Restaurante</option>
                    {{-- @foreach($restaurants as $restaurant)
                        <option value="{{ $restaurant->id }}" 
                                {{ ($employee->restaurant_id ?? old('restaurant_id')) == $restaurant->id ? 'selected' : '' }}>
                            {{ $restaurant->name }}
                        </option>
                    @endforeach --}}
                </select>
                @error('restaurant_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Puesto</label>
                <select name="position_id" required 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Seleccionar Puesto</option>
                    {{-- @foreach($positions as $position)
                        <option value="{{ $position->id }}" 
                                {{ ($employee->position_id ?? old('position_id')) == $position->id ? 'selected' : '' }}>
                            {{ $position->name }}
                        </option>
                    @endforeach --}}
                </select>
                @error('position_id')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Entrada</label>
                <input type="date" name="hire_date" required 
                       value=""
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('hire_date')<span class="text-red-600 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Contrato</label>
                <select name="employment_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="fixed" {{ ($employee->employment_type ?? old('employment_type')) === 'fixed' ? 'selected' : '' }}>Fijo</option>
                    <option value="temporal" {{ ($employee->employment_type ?? old('employment_type')) === 'temporal' ? 'selected' : '' }}>Temporal</option>
                    <option value="part-time" {{ ($employee->employment_type ?? old('employment_type')) === 'part-time' ? 'selected' : '' }}>Tiempo Parcial</option>
                    <option value="contractor" {{ ($employee->employment_type ?? old('employment_type')) === 'contractor' ? 'selected' : '' }}>Contratista</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Estatus</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="active" {{ ($employee->status ?? old('status')) === 'active' ? 'selected' : '' }}>Activo</option>
                    <option value="inactive" {{ ($employee->status ?? old('status')) === 'inactive' ? 'selected' : '' }}>Inactivo</option>
                    <option value="suspended" {{ ($employee->status ?? old('status')) === 'suspended' ? 'selected' : '' }}>Suspendido</option>
                    <option value="terminated" {{ ($employee->status ?? old('status')) === 'terminated' ? 'selected' : '' }}>Terminado</option>
                </select>
            </div>
        </div>
    </fieldset>

    <!-- Información Fiscal -->
    <fieldset class="mb-8">
        <legend class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Información Fiscal y Bancaria</legend>
        
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Número IMSS</label>
                <input type="text" name="imss_number" 
                       value="{{ $employee->imss_number ?? old('imss_number') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">RFC</label>
                <input type="text" name="rfc" 
                       value="{{ $employee->rfc ?? old('rfc') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Banco</label>
                <input type="text" name="bank_name" 
                       value="{{ $employee->bank_name ?? old('bank_name') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Número de Cuenta</label>
                <input type="text" name="bank_account" 
                       value="{{ $employee->bank_account ?? old('bank_account') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">CLABE Interbancaria</label>
                <input type="text" name="bank_clabe" 
                       value="{{ $employee->bank_clabe ?? old('bank_clabe') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
        </div>
    </fieldset>

    <!-- Botones -->
    <div class="flex gap-4">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            {{ isset($employee) ? 'Actualizar' : 'Guardar' }}
        </button>
        <a href="" class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
            Cancelar
        </a>
    </div>
</form>
@endsection

<!-- ============================================
     PERÍODOS DE NÓMINA - resources/views/payroll/periods/index.blade.php
     ============================================ -->

@extends('layouts.master')

@section('title', 'Períodos de Nómina')
@section('header', 'Gestión de Períodos de Nómina')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h3 class="text-xl font-bold text-gray-800">Períodos de Nómina</h3>
    <a href="" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + Nuevo Período
    </a>
</div>

<div class="grid grid-cols-1 gap-6">
    
</div>

@endsection

<!-- ============================================
     DETALLE DE PERÍODO - resources/views/payroll/periods/show.blade.php
     ============================================ -->

@extends('layouts.master')

@section('title', 'Período de Nómina')
{{-- @section('header', 'Detalle del Período ' . $period->period_number . ' / ' . $period->year) --}}

@section('content')
<div class="mb-6">
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-4 gap-4">
            <div>
                <p class="text-sm text-gray-600">Restaurante</p>
                <p class="text-lg font-bold text-gray-800"></p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Período</p>
                {{-- <p class="text-lg font-bold text-gray-800">{{ $period->start_date->format('d/m/Y') }} - {{ $period->end_date->format('d/m/Y') }}</p> --}}
            </div>
            <div>
                <p class="text-sm text-gray-600">Estado</p>
                <span class="px-3 py-1 rounded-full text-sm font-semibold">

                    {{-- {{ $period->status === 'draft' ? 'bg-yellow-100 text-yellow-800' :
                       $period->status === 'approved' ? 'bg-blue-100 text-blue-800' :
                       $period->status === 'paid' ? 'bg-green-100 text-green-800' :
                       'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($period->status) }} --}}
                </span>
            </div>
        </div>
    </div>

    <!-- Tabla de Nómina -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Empleado</th>
                    <th class="px-6 py-3 text-left font-semibold text-gray-800">Días</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-800">Ingresos</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-800">Descuentos</th>
                    <th class="px-6 py-3 text-right font-semibold text-gray-800">Neto</th>
                    <th class="px-6 py-3 text-center font-semibold text-gray-800">Acciones</th>
                </tr>
            </thead>
            <tbody>
            
            </tbody>
            <tfoot class="bg-gray-50 border-t font-bold">
                <tr>
                    <td colspan="2" class="px-6 py-4 text-right">TOTALES:</td>
                    <td class="px-6 py-4 text-right text-green-600">
                        {{-- ${{ number_format($period->summaries->sum('total_income'), 2) }} --}}
                    </td>
                    <td class="px-6 py-4 text-right text-red-600">
                        {{-- ${{ number_format($period->summaries->sum('total_deductions'), 2) }} --}}
                    </td>
                    <td class="px-6 py-4 text-right text-blue-600">
                        {{-- ${{ number_format($period->summaries->sum('net_payment'), 2) }} --}}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

<!-- ============================================
     REPORTES - resources/views/payroll/reports.blade.php
     ============================================ -->

@extends('layouts.master')

@section('title', 'Reportes de Nómina')
@section('header', 'Reportes y Análisis de Nómina')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Filtros -->
    <div class="lg:col-span-3 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Filtros</h3>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Restaurante</label>
                <select name="restaurant_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Todos</option>
                    {{-- @foreach($restaurants as $r)
                        <option value="{{ $r->id }}" {{ request('restaurant_id') == $r->id ? 'selected' : '' }}>
                            {{ $r->name }}
                        </option>
                    @endforeach --}}
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Desde</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Hasta</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Generar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Métricas Clave -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-600 text-sm font-semibold">Total Pagado</p>
        <p class="text-3xl font-bold text-green-600 mt-2">$0</p>
        <p class="text-gray-600 text-xs mt-2">En 0 período(s)</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-600 text-sm font-semibold">Promedio por Período</p>
        <p class="text-3xl font-bold text-blue-600 mt-2">$0</p>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <p class="text-gray-600 text-sm font-semibold">Mayor Nómina</p>
        <p class="text-3xl font-bold text-purple-600 mt-2">$0</p>
    </div>
</div>

<!-- Gráficos -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Nóminas por Período</h3>
        <canvas id="payrollByPeriod"></canvas>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Distribución: Ingresos vs Descuentos</h3>
        <canvas id="incomeVsDeductions"></canvas>
    </div>
</div>

<!-- Tabla de Detalle -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100 border-b">
            <tr>
                <th class="px-6 py-3 text-left font-semibold text-gray-800">Período</th>
                <th class="px-6 py-3 text-left font-semibold text-gray-800">Restaurante</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-800">Empleados</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-800">Ingresos</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-800">Descuentos</th>
                <th class="px-6 py-3 text-right font-semibold text-gray-800">Neto</th>
            </tr>
        </thead>
        <tbody>
            
        </tbody>
    </table>
</div>

<script>
    // Gráfico: Nóminas por Período
    const periodCtx = document.getElementById('payrollByPeriod').getContext('2d');
    new Chart(periodCtx, {
        type: 'bar',
        data: {
            labels: 0,
            datasets: [{
                label: 'Nómina Total',
                data: 0,
                backgroundColor: '#3B82F6'
            }]
        }
    });

    // Gráfico: Ingresos vs Descuentos
    const incomeCtx = document.getElementById('incomeVsDeductions').getContext('2d');
    new Chart(incomeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Ingresos', 'Descuentos'],
            datasets: [{
                data: [0, 0],
                backgroundColor: ['#10B981', '#EF4444']
            }]
        }
    });
</script>
@endsection
