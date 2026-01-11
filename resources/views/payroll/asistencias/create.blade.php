@extends('layouts.master')
@section('content')
    <style>
        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header-section h2 {
            margin: 0;
            font-weight: 600;
        }

        .controls-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .grid-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .grid-header {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            padding: 15px;
            font-weight: 600;
            display: grid;
            grid-template-columns: 250px repeat(32, 30px) 80px;
            gap: 2px;
            align-items: center;
        }

        .grid-header-title {
            position: sticky;
            left: 0;
            background: #f8f9fa;
            z-index: 10;
            padding: 10px 15px;
            font-size: 13px;
            text-align: center;
        }

        .grid-header-date {
            background: #f8f9fa;
            padding: 10px 5px;
            font-size: 11px;
            text-align: center;
            writing-mode: vertical-rl;
            transform: rotate(180deg);
            font-weight: 500;
            color: #666;
        }

        .grid-row {
            display: grid;
            grid-template-columns: 250px repeat(32, 30px) 80px;
            gap: 2px;
            padding: 2px;
            background: white;
            border-bottom: 1px solid #e0e0e0;
            align-items: center;
        }

        .grid-row:hover {
            background: #f9f9f9;
        }

        .employee-name {
            position: sticky;
            left: 0;
            background: white;
            z-index: 5;
            padding: 10px 15px;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            border-right: 2px solid #dee2e6;
        }

        .grid-row:hover .employee-name {
            background: #f9f9f9;
        }

        .cell-input {
            width: 100%;
            height: 38px;
            border: 1px solid #e0e0e0;
            padding: 4px;
            font-size: 11px;
            text-align: center;
            cursor: pointer;
            background: white;
            transition: all 0.2s;
        }

        .cell-input:hover {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .cell-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
            background: #f0f4ff;
        }

        /* Colores de estados */
        .present {
            background: #d4edda !important;
            color: #155724;
            font-weight: 600;
        }

        .absent {
            background: #f8d7da !important;
            color: #721c24;
            font-weight: 600;
        }

        .permission {
            background: #fff3cd !important;
            color: #856404;
            font-weight: 600;
        }

        .disability {
            background: #d1ecf1 !important;
            color: #0c5460;
            font-weight: 600;
        }

        .holiday {
            background: #e2e3e5 !important;
            color: #383d41;
            font-weight: 600;
        }

        .double_shift {
            background: #cce5ff !important;
            color: #004085;
            font-weight: 600;
        }

        .delay {
            background: #ffe5cc !important;
            color: #856404;
            font-weight: 600;
        }

        .rest_day {
            background: #f0f0f0 !important;
            color: #6c757d;
            font-weight: 600;
        }

        .actions-column {
            background: white;
            padding: 8px;
            text-align: center;
            border-left: 2px solid #dee2e6;
        }

        .legend {
            display: flex;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
        }

        .legend-box {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .scroll-container {
            overflow-x: auto;
            overflow-y: auto;
            max-height: 600px;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 11px;
        }

        .select-column {
            text-align: center;
        }

        .modal-lg {
            max-width: 600px;
        }

        .dialog-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .dialog-buttons button {
            padding: 8px 16px;
            font-size: 12px;
            flex: 1;
            min-width: 80px;
        }
    </style>
</head>
<body>
    <div class="header-section">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col">
                    <h2><i class="fas fa-calendar-check"></i> Captura de Asistencias</h2>
                </div>
                <div class="col-auto">
                    <button class="btn btn-light btn-sm" onclick="goBack()">
                        <i class="fas fa-arrow-left"></i> Volver
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="controls-section">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Período</label>
                    <select class="form-select form-select-sm" id="periodSelect" onchange="loadEmployees()">
                        <option value="">Seleccione período...</option>
                        <option value="1">Período 1/2024 (01/01 - 15/01)</option>
                        <option value="2">Período 2/2024 (16/01 - 31/01)</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Mes</label>
                    <input type="month" class="form-control form-control-sm" id="monthSelect" value="2024-12" onchange="generateDates()">
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary btn-sm" onclick="generateDates()">
                        <i class="fas fa-sync"></i> Cargar
                    </button>
                    <button class="btn btn-success btn-sm" onclick="saveAttendance()">
                        <i class="fas fa-save"></i> Guardar
                    </button>
                    <button class="btn btn-info btn-sm" onclick="exportGrid()">
                        <i class="fas fa-download"></i> Exportar
                    </button>
                </div>
            </div>

            <div class="legend mt-3">
                <div class="legend-item">
                    <div class="legend-box present"></div> Presente
                </div>
                <div class="legend-item">
                    <div class="legend-box absent"></div> Ausente
                </div>
                <div class="legend-item">
                    <div class="legend-box permission"></div> Permiso
                </div>
                <div class="legend-item">
                    <div class="legend-box disability"></div> Incapacidad
                </div>
                <div class="legend-item">
                    <div class="legend-box holiday"></div> Festivo
                </div>
                <div class="legend-item">
                    <div class="legend-box double_shift"></div> Doble
                </div>
                <div class="legend-item">
                    <div class="legend-box delay"></div> Retardo
                </div>
                <div class="legend-item">
                    <div class="legend-box rest_day"></div> Descanso
                </div>
            </div>
        </div>

        <div class="grid-container">
            <div class="scroll-container">
                <div class="grid-header" id="gridHeader"></div>
                <div id="gridBody"></div>
            </div>
        </div>
    </div>

    <!-- Modal para seleccionar tipo de asistencia -->
    <div class="modal fade" id="typeModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Seleccionar Tipo de Asistencia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="dialog-buttons">
                        <button class="btn btn-success btn-sm" onclick="selectType('present')">✓ Presente</button>
                        <button class="btn btn-danger btn-sm" onclick="selectType('absent')">✗ Ausente</button>
                        <button class="btn btn-warning btn-sm" onclick="selectType('permission')">P Permiso</button>
                        <button class="btn btn-info btn-sm" onclick="selectType('disability')">I Incap.</button>
                        <button class="btn btn-secondary btn-sm" onclick="selectType('holiday')">F Festivo</button>
                        <button class="btn btn-primary btn-sm" onclick="selectType('double_shift')">D Doble</button>
                        <button class="btn btn-warning btn-sm" onclick="selectType('delay')">R Retardo</button>
                        <button class="btn btn-light btn-sm" onclick="selectType('rest_day')">Descanso</button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="selectType('')">Limpiar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let currentCell = null;
        let attendanceData = {};
        let typeShortcuts = {
            'p': 'present',
            'a': 'absent',
            'e': 'permission',
            'i': 'disability',
            'f': 'holiday',
            'd': 'double_shift',
            'r': 'delay',
            'd': 'rest_day'
        };

        const typeLabels = {
            'present': '✓',
            'absent': '✗',
            'permission': 'P',
            'disability': 'I',
            'holiday': 'F',
            'double_shift': 'D',
            'delay': 'R',
            'rest_day': '○'
        };

        // Datos simulados
        const employees = [
            { id: 1, name: 'Rosalia Ish Pítina' },
            { id: 2, name: 'Jose Dolores De la Cruz Chavi' },
            { id: 3, name: 'Salomón Morales Brown' },
            { id: 4, name: 'Imelda Torres Cruz' },
            { id: 5, name: 'Miguel Moreno López' },
            { id: 6, name: 'Tomas Magaña Hernandez' }
        ];

        function generateDates() {
            const month = document.getElementById('monthSelect').value;
            if (!month) return;

            const [year, monthNum] = month.split('-');
            const daysInMonth = new Date(year, monthNum, 0).getDate();
            const dates = [];

            for (let i = 1; i <= daysInMonth; i++) {
                const date = new Date(year, monthNum - 1, i);
                const dayName = ['D', 'L', 'M', 'X', 'J', 'V', 'S'][date.getDay()];
                dates.push({
                    date: `${i}`.padStart(2, '0'),
                    day: dayName,
                    fullDate: date.toISOString().split('T')[0]
                });
            }

            renderGrid(dates);
        }

        function renderGrid(dates) {
            // Header
            const header = document.getElementById('gridHeader');
            let headerHTML = '<div class="grid-header-title">EMPLEADO</div>';
            dates.forEach(d => {
                headerHTML += `<div class="grid-header-date"><strong>${d.day}</strong><br>${d.date}</div>`;
            });
            headerHTML += '<div class="grid-header-title">TOTAL</div>';
            header.innerHTML = headerHTML;

            // Body
            const body = document.getElementById('gridBody');
            let bodyHTML = '';
            employees.forEach(emp => {
                bodyHTML += `<div class="grid-row">
                    <div class="employee-name">${emp.name}</div>`;
                dates.forEach(d => {
                    const key = `${emp.id}_${d.fullDate}`;
                    const value = attendanceData[key] || '';
                    const label = typeLabels[value] || '';
                    bodyHTML += `<input type="text" class="cell-input ${value}" 
                        data-employee="${emp.id}" 
                        data-date="${d.fullDate}" 
                        data-key="${key}"
                        value="${label}"
                        readonly
                        onclick="openTypeModal(this)">`;
                });
                bodyHTML += `<div class="actions-column">
                    <small class="text-muted">0 días</small>
                </div>
                </div>`;
            });
            body.innerHTML = bodyHTML;

            // Agregar listeners
            document.querySelectorAll('.cell-input').forEach(cell => {
                cell.addEventListener('contextmenu', (e) => {
                    e.preventDefault();
                    clearCell(cell);
                });
            });
        }

        function openTypeModal(cell) {
            currentCell = cell;
            const modal = new bootstrap.Modal(document.getElementById('typeModal'));
            modal.show();
        }

        function selectType(type) {
            if (!currentCell) return;

            const key = currentCell.dataset.key;
            attendanceData[key] = type;

            currentCell.value = typeLabels[type] || '';
            currentCell.className = `cell-input ${type}`;

            bootstrap.Modal.getInstance(document.getElementById('typeModal')).hide();
        }

        function clearCell(cell) {
            const key = cell.dataset.key;
            delete attendanceData[key];
            cell.value = '';
            cell.className = 'cell-input';
        }

        function saveAttendance() {
            console.log('Datos a guardar:', attendanceData);
            alert('Asistencias guardadas correctamente!');
        }

        function exportGrid() {
            const period = document.getElementById('periodSelect').value;
            const month = document.getElementById('monthSelect').value;
            if (!month) {
                alert('Seleccione un mes');
                return;
            }

            let csv = 'Empleado,' + Array.from(document.querySelectorAll('.grid-header-date'))
                .map(d => d.textContent.trim()).join(',') + '\n';

            document.querySelectorAll('.grid-row').forEach((row, idx) => {
                const name = row.querySelector('.employee-name').textContent;
                const values = Array.from(row.querySelectorAll('.cell-input'))
                    .map(cell => cell.value || '-').join(',');
                csv += `"${name}",${values}\n`;
            });

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = `asistencia_${month}.csv`;
            link.click();
        }

        function goBack() {
            window.history.back();
        }

        // Inicializar
        generateDates();
    </script>
</body>
</html>
<menu>¡,,,</menu>@endsection