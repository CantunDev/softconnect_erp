<div class="col-xl-12">
    <div class="card" style="border: 2px solid #ccc">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm mt-2">
                <div class="card-body py-2">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="fw-semibold text-muted small">Período:</span>
                            <select id="sel-month" class="form-select form-select-sm w-auto">
                                @php $currentMonth = now()->month; @endphp

                                @foreach ($months as $key => $m)
                                    <option value="{{ $key }}" {{ $key == $currentMonth ? 'selected' : '' }}>
                                        {{ ucfirst($m) }}
                                    </option>
                                @endforeach
                            </select>
                            <select id="sel-year" class="form-select form-select-sm w-auto">
                                @foreach (range(now()->year - 2, now()->year) as $y)
                                    <option value="{{ $y }}" {{ $y == now()->year ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="text-muted small">ó</span>
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light">
                                    <i class="bx bx-calendar"></i>
                                </span>
                                <input type="text" id="start-date" class="form-control" placeholder="Desde"
                                    style="width:120px;" autocomplete="off">
                            </div>
                            <div class="input-group input-group-sm w-auto">
                                <span class="input-group-text bg-light">
                                    <i class="bx bx-calendar"></i>
                                </span>
                                <input type="text" id="end-date" class="form-control" placeholder="Hasta"
                                    style="width:120px;" autocomplete="off">
                            </div>
                            <button id="btn-filter" class="btn btn-sm btn-primary">
                                <i class="bx bx-filter-alt me-1"></i>Filtrar
                            </button>
                            <button id="btn-clear-range" class="btn btn-sm btn-outline-secondary d-none">
                                <i class="bx bx-x me-1"></i>Limpiar
                            </button>
                            <span id="loading-indicator" class="spinner-border spinner-border-sm text-primary d-none"
                                role="status">
                            </span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button id="btn-export-excel" class="btn btn-sm btn-outline-success">
                                <i class="bx bx-file me-1"></i>Excel
                            </button>
                            <button id="btn-export-pdf" class="btn btn-sm btn-outline-danger">
                                <i class="bx bxs-file-pdf me-1"></i>PDF
                                <span class="spinner-border spinner-border-sm d-none" id="pdf-spinner"
                                    role="status"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
