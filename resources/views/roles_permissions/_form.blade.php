{{--
    _form.blade.php — Stepper reutilizable para Crear / Editar Roles
    Variables esperadas del controlador:
        $role        → Role con ->permissions, ->users (cada user con ->businesses y ->restaurants cargados) | null
        $permisos_cat→ colección de categorías únicas con ->category
        $permisos    → colección de permisos con ->id, ->category, ->name
        $users       → colección de TODOS los usuarios con relaciones:
                           ->businesses (cada business: id, name, logo)
                           ->restaurants (cada restaurant: id, name, logo, businesses[])
        $route       → route() del form action
        $method      → 'POST' | 'PUT'
        $btnText     → 'Registrar Rol' | 'Guardar Cambios'
        $isEdit      → bool

    Relaciones en User.php:
        public function businesses()   { return $this->belongsToMany(Business::class,   'users_business'); }
        public function restaurants()  { return $this->belongsToMany(Restaurant::class, 'users_restaurants'); }

    Relaciones en Restaurant.php:
        public function businesses()   { return $this->belongsToMany(Business::class, 'business_restaurants'); }
--}}

{{-- ══════════════════════════════════════════════════════════════
     ESTILOS DEL STEPPER
══════════════════════════════════════════════════════════════ --}}
<style>
:root {
    --sp-primary      : #4361ee;
    --sp-primary-light: #eef0fd;
    --sp-success      : #2ec4b6;
    --sp-warning      : #f4a261;
    --sp-danger       : #e63946;
    --sp-border       : #dee2e6;
    --sp-text         : #1a1a2e;
    --sp-muted        : #6c757d;
    --sp-radius       : 10px;
    --sp-shadow       : 0 2px 12px rgba(67,97,238,.10);
    --sp-trans        : .2s ease;
}

/* ── Stepper nav ───────────────────────────────────────────────── */
.rp-stepper {
    display: flex;
    align-items: flex-start;
    gap: 0;
    margin-bottom: 2rem;
    position: relative;
}
.rp-stepper::before {
    content: '';
    position: absolute;
    top: 20px;
    left: calc(16.66% + 20px);
    right: calc(16.66% + 20px);
    height: 2px;
    background: var(--sp-border);
    z-index: 0;
}
.rp-step {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: .45rem;
    cursor: pointer;
    position: relative;
    z-index: 1;
}
.rp-step-circle {
    width: 40px; height: 40px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .9rem;
    font-weight: 700;
    background: #fff;
    border: 2px solid var(--sp-border);
    color: var(--sp-muted);
    transition: all var(--sp-trans);
    position: relative;
    z-index: 2;
}
.rp-step-label {
    font-size: .75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: var(--sp-muted);
    text-align: center;
    transition: color var(--sp-trans);
}
.rp-step-sublabel {
    font-size: .68rem;
    color: var(--sp-muted);
    text-align: center;
    opacity: .7;
}
/* Activo */
.rp-step.active .rp-step-circle {
    background: var(--sp-primary);
    border-color: var(--sp-primary);
    color: #fff;
    box-shadow: 0 0 0 4px rgba(67,97,238,.15);
}
.rp-step.active .rp-step-label { color: var(--sp-primary); }
/* Completado */
.rp-step.done .rp-step-circle {
    background: var(--sp-success);
    border-color: var(--sp-success);
    color: #fff;
}
.rp-step.done .rp-step-label { color: var(--sp-success); }
/* Línea de progreso */
.rp-stepper-line {
    position: absolute;
    top: 20px;
    left: calc(16.66% + 20px);
    height: 2px;
    background: var(--sp-success);
    z-index: 1;
    width: 0;
    transition: width .4s ease;
}

/* ── Paneles de pasos ──────────────────────────────────────────── */
.rp-step-panel { display: none; }
.rp-step-panel.active {
    display: block;
    animation: rpPanelIn .2s ease;
}
@keyframes rpPanelIn {
    from { opacity:0; transform: translateY(6px); }
    to   { opacity:1; transform: translateY(0); }
}

/* ── PASO 1: Nombre ────────────────────────────────────────────── */
.rp-name-wrapper { max-width: 460px; }
.rp-name-wrapper .form-label {
    font-weight: 600;
    font-size: .85rem;
    letter-spacing: .04em;
    text-transform: uppercase;
    color: var(--sp-text);
}
.rp-name-wrapper .form-control {
    border-radius: var(--sp-radius);
    border: 1.5px solid var(--sp-border);
    padding: .6rem 1rem;
    font-size: 1rem;
    transition: border-color var(--sp-trans), box-shadow var(--sp-trans);
}
.rp-name-wrapper .form-control:focus {
    border-color: var(--sp-primary);
    box-shadow: 0 0 0 3px rgba(67,97,238,.14);
}

/* ── PASO 2: Permisos ──────────────────────────────────────────── */
.rp-toolbar {
    display: flex; align-items: center;
    justify-content: space-between;
    flex-wrap: wrap; gap: .75rem;
    margin-bottom: 1rem;
}
.rp-search-box {
    position: relative; flex:1;
    min-width: 200px; max-width: 320px;
}
.rp-search-box .bx {
    position: absolute; left: .85rem; top:50%;
    transform: translateY(-50%);
    color: var(--sp-muted); font-size:1rem; pointer-events:none;
}
.rp-search-box input {
    padding-left: 2.25rem;
    border-radius: 50px;
    border: 1.5px solid var(--sp-border);
    font-size: .875rem;
    transition: border-color var(--sp-trans), box-shadow var(--sp-trans);
}
.rp-search-box input:focus {
    border-color: var(--sp-primary);
    box-shadow: 0 0 0 3px rgba(67,97,238,.12);
}
.rp-counter-badge {
    font-size: .8rem; font-weight: 600;
    background: var(--sp-primary-light); color: var(--sp-primary);
    border: 1.5px solid #c7cef8;
    border-radius: 50px; padding: .3rem .85rem;
    white-space: nowrap;
    transition: background var(--sp-trans), color var(--sp-trans);
}
.rp-counter-badge.has-perms { background:#e8faf8; color:var(--sp-success); border-color:#a8e8e3; }
.rp-btn-select-all {
    font-size: .8rem; padding: .3rem .9rem;
    border-radius: 50px;
    border: 1.5px solid var(--sp-primary);
    color: var(--sp-primary); background: transparent;
    cursor: pointer;
    transition: all var(--sp-trans); white-space: nowrap;
}
.rp-btn-select-all:hover, .rp-btn-select-all.all-selected {
    background: var(--sp-primary); color: #fff;
}
.rp-table-wrapper {
    border: 1.5px solid var(--sp-border);
    border-radius: var(--sp-radius);
    overflow: hidden;
    box-shadow: var(--sp-shadow);
    max-height: 480px;
    overflow-y: auto;
}
.rp-permissions-table { margin-bottom:0; table-layout:fixed; }
.rp-permissions-table thead th {
    background: #f8f9ff;
    font-size: .75rem; font-weight:700;
    text-transform: uppercase; letter-spacing:.06em;
    color: var(--sp-muted);
    padding: .75rem 1rem;
    border-bottom: 2px solid var(--sp-border);
    vertical-align: middle;
    position: sticky; top: 0; z-index: 2;
}
.rp-permissions-table thead th:first-child { width:30%; text-align:left; color: var(--sp-text); }
.rp-permissions-table thead th:not(:first-child) { text-align:center; width:17.5%; }
.rp-col-header { display:flex; flex-direction:column; align-items:center; gap:.3rem; }
.rp-col-toggle {
    font-size:.68rem; padding:.15rem .55rem;
    border-radius:50px; border:1px solid currentColor;
    background:transparent; cursor:pointer; line-height:1.4;
    opacity:.75; transition: opacity var(--sp-trans), background var(--sp-trans);
    color: var(--sp-muted);
}
.rp-col-toggle:hover { opacity:1; background: var(--sp-border); }
.rp-permissions-table tbody tr { transition: background var(--sp-trans); }
.rp-permissions-table tbody tr:hover { background:#f7f8ff; }
.rp-permissions-table tbody tr.rp-hidden { display:none; }
.rp-permissions-table tbody td { padding:.6rem 1rem; vertical-align:middle; border-color:var(--sp-border); }
.rp-permissions-table tbody td:first-child { font-weight:500; font-size:.875rem; color:var(--sp-text); }
.rp-permissions-table tbody td:not(:first-child) { text-align:center; }
.rp-no-results { display:none; text-align:center; color:var(--sp-muted); padding:2rem; font-size:.9rem; }
.rp-no-results.visible { display:table-row; }
.rp-check-wrap { display:inline-flex; align-items:center; justify-content:center; }
.rp-check-wrap input[type="checkbox"] {
    width:1.15rem; height:1.15rem;
    accent-color: var(--sp-primary);
    cursor:pointer;
}
.rp-row-toggle {
    font-size:.7rem; padding:.18rem .55rem;
    border-radius:50px; border:1px solid var(--sp-border);
    background:transparent; cursor:pointer; color:var(--sp-muted);
    transition: all var(--sp-trans); margin-left:.5rem;
}
.rp-row-toggle:hover { background:var(--sp-primary-light); color:var(--sp-primary); border-color:#c7cef8; }
.rp-row-toggle.full { background:var(--sp-primary-light); color:var(--sp-primary); border-color:#c7cef8; }

/* ── PASO 3: Usuarios ──────────────────────────────────────────── */
.rp-users-layout {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.25rem;
}
@media (max-width: 768px) {
    .rp-users-layout { grid-template-columns: 1fr; }
}
.rp-users-panel {
    border: 1.5px solid var(--sp-border);
    border-radius: var(--sp-radius);
    overflow: hidden;
    box-shadow: var(--sp-shadow);
    display: flex;
    flex-direction: column;
    max-height: 560px;
}
.rp-users-panel-header {
    background: #f8f9ff;
    padding: .65rem 1rem;
    border-bottom: 1.5px solid var(--sp-border);
    display: flex; align-items: center; justify-content: space-between;
    gap: .5rem; flex-wrap: wrap;
}
.rp-users-panel-header h6 {
    font-size: .78rem; font-weight:700;
    text-transform:uppercase; letter-spacing:.06em;
    color: var(--sp-text); margin:0;
}
.rp-users-panel-toolbar {
    display: flex; align-items: center; gap: .5rem;
    flex-wrap: wrap; width: 100%;
    padding: .5rem 1rem;
    border-bottom: 1px solid var(--sp-border);
    background: #fff;
}
.rp-users-panel-search {
    position: relative; flex:1; min-width:120px;
}
.rp-users-panel-search .bx {
    position:absolute; left:.65rem; top:50%;
    transform:translateY(-50%); color:var(--sp-muted); pointer-events:none;
    font-size: .85rem;
}
.rp-users-panel-search input {
    padding-left:1.9rem; border-radius:50px;
    border:1.5px solid var(--sp-border);
    font-size:.78rem; width:100%; padding-top:.3rem; padding-bottom:.3rem;
    transition: border-color var(--sp-trans), box-shadow var(--sp-trans);
}
.rp-users-panel-search input:focus {
    outline:none;
    border-color: var(--sp-primary);
    box-shadow: 0 0 0 2px rgba(67,97,238,.1);
}
/* Filtros de tipo */
.rp-filter-tabs {
    display:flex; gap:.3rem; flex-wrap:wrap;
}
.rp-filter-tab {
    font-size:.68rem; font-weight:600;
    padding:.2rem .6rem; border-radius:50px;
    border:1.5px solid var(--sp-border);
    background:transparent; cursor:pointer;
    color:var(--sp-muted);
    transition: all var(--sp-trans);
    white-space:nowrap;
}
.rp-filter-tab:hover { border-color:var(--sp-primary); color:var(--sp-primary); }
.rp-filter-tab.active { background:var(--sp-primary); border-color:var(--sp-primary); color:#fff; }
.rp-filter-tab.business.active { background:#4361ee; border-color:#4361ee; }
.rp-filter-tab.restaurant.active { background:#2ec4b6; border-color:#2ec4b6; }

.rp-users-list {
    overflow-y: auto;
    flex: 1;
    padding: .5rem;
    display: flex;
    flex-direction: column;
    gap: .4rem;
}

/* ── Tarjeta de usuario (panel izquierdo) ──────────────────────── */
.rp-user-card {
    border-radius: 8px;
    border: 1.5px solid var(--sp-border);
    background: #fff;
    cursor: pointer;
    transition: border-color var(--sp-trans), background var(--sp-trans),
                box-shadow var(--sp-trans);
    user-select: none;
    overflow: hidden;
}
.rp-user-card:hover { border-color: var(--sp-primary); box-shadow: 0 2px 8px rgba(67,97,238,.1); }
.rp-user-card.selected { border-color: var(--sp-success); background: #f0fdf9; }

/* Fila principal de la card */
.rp-user-card-main {
    display: flex; align-items: center; gap: .75rem;
    padding: .6rem .75rem;
}
.rp-user-card .rp-avatar {
    width: 38px; height: 38px;
    border-radius: 50%;
    border: 2px solid var(--sp-border);
    flex-shrink: 0;
    background: #eef0fd;
    display: flex; align-items:center; justify-content:center;
    font-size: .85rem; font-weight:700;
    color: var(--sp-primary);
    overflow: hidden;
}
.rp-user-card .rp-avatar img { width:100%; height:100%; object-fit:cover; }
.rp-user-card .rp-user-info { flex:1; min-width:0; }
.rp-user-card .rp-user-name {
    font-size: .83rem; font-weight:600; color: var(--sp-text);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.rp-user-card .rp-user-email {
    font-size: .72rem; color: var(--sp-muted);
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis;
}
.rp-user-card .rp-check-indicator {
    width: 22px; height: 22px; border-radius: 50%;
    border: 2px solid var(--sp-border);
    display:flex; align-items:center; justify-content:center;
    flex-shrink:0; transition: all var(--sp-trans);
    font-size: .75rem; color: transparent;
}
.rp-user-card.selected .rp-check-indicator {
    background: var(--sp-success); border-color: var(--sp-success); color: #fff;
}

/* Botón expandir + panel de detalle business/restaurants */
.rp-user-card-expand-btn {
    width:100%; padding:.28rem .75rem;
    background: #f8f9ff;
    border:none; border-top:1px solid var(--sp-border);
    font-size:.69rem; color:var(--sp-muted); font-weight:600;
    text-align:left; cursor:pointer;
    display:flex; align-items:center; gap:.3rem;
    transition: background var(--sp-trans), color var(--sp-trans);
}
.rp-user-card-expand-btn:hover { background:var(--sp-primary-light); color:var(--sp-primary); }
.rp-user-card-expand-btn .bx { transition:transform var(--sp-trans); }
.rp-user-card-expand-btn.open .bx-chevron-down { transform:rotate(180deg); }

.rp-user-detail {
    display:none; padding:.6rem .75rem;
    border-top:1px solid var(--sp-border);
    background:#fafbff;
    animation: rpDetailIn .15s ease;
}
.rp-user-detail.open { display:block; }
@keyframes rpDetailIn {
    from { opacity:0; transform:translateY(-4px); }
    to   { opacity:1; transform:translateY(0); }
}
.rp-detail-section { margin-bottom:.6rem; }
.rp-detail-section:last-child { margin-bottom:0; }
.rp-detail-label {
    font-size:.65rem; font-weight:700; text-transform:uppercase;
    letter-spacing:.06em; color:var(--sp-muted);
    margin-bottom:.3rem;
    display:flex; align-items:center; gap:.3rem;
}
.rp-detail-items { display:flex; flex-wrap:wrap; gap:.35rem; }

/* Chip de business/restaurant */
.rp-entity-chip {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.25rem .6rem; border-radius:6px;
    font-size:.7rem; font-weight:500;
    border:1.5px solid transparent;
    max-width:100%;
}
.rp-entity-chip img {
    width:16px; height:16px; border-radius:3px;
    object-fit:cover; flex-shrink:0;
}
.rp-entity-chip span { white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:120px; }
.rp-entity-chip.business   { background:#eef0fd; color:#4361ee; border-color:#c7cef8; }
.rp-entity-chip.restaurant { background:#e8faf8; color:#1a7a5e; border-color:#a8e8e3; }
.rp-entity-chip.standalone { background:#fff8e6; color:#8a6000; border-color:#f5d87a; }

/* ── Panel derecho: asignados ──────────────────────────────────── */
.rp-assigned-empty {
    display:flex; flex-direction:column;
    align-items:center; justify-content:center;
    flex:1; color:var(--sp-muted);
    padding: 2rem; text-align:center; gap: .5rem;
}
.rp-assigned-empty i { font-size:2.5rem; opacity:.3; }
.rp-assigned-badge {
    background: var(--sp-primary); color:#fff;
    font-size: .7rem; font-weight:700;
    padding:.15rem .5rem; border-radius:50px;
    min-width:20px; text-align:center;
}
/* Card en panel asignados */
.rp-user-card-assigned {
    display:flex; align-items:flex-start; gap:.65rem;
    padding:.55rem .65rem;
    border-radius:8px; border:1.5px solid #b2e8d4;
    background:#f0fdf9;
}
.rp-user-card-assigned .rp-avatar-sm {
    width:32px; height:32px; border-radius:50%;
    background:#eef0fd; color:var(--sp-primary);
    display:flex; align-items:center; justify-content:center;
    font-size:.75rem; font-weight:700; flex-shrink:0;
    overflow:hidden;
}
.rp-user-card-assigned .rp-avatar-sm img { width:100%; height:100%; object-fit:cover; }
.rp-user-card-assigned .rp-user-info { flex:1; min-width:0; }
.rp-user-card-assigned .rp-user-name { font-size:.82rem; font-weight:600; color:var(--sp-text); }
.rp-user-card-assigned .rp-user-email { font-size:.7rem; color:var(--sp-muted); }
.rp-user-card-assigned .rp-chips-mini { display:flex; flex-wrap:wrap; gap:.25rem; margin-top:.25rem; }
.rp-user-card-assigned .btn-remove {
    margin-left:auto; flex-shrink:0;
    width:22px; height:22px; border-radius:50%; border:none;
    background:rgba(230,57,70,.1); color: var(--sp-danger);
    display:flex; align-items:center; justify-content:center;
    cursor:pointer; font-size:.75rem;
    transition: background var(--sp-trans); padding:0;
}
.rp-user-card-assigned .btn-remove:hover { background: var(--sp-danger); color:#fff; }
.rp-user-hidden { display:none !important; }

/* ── Botones de navegación ─────────────────────────────────────── */
.rp-nav-buttons {
    display:flex; align-items:center; justify-content:space-between;
    gap:.75rem; padding-top:1.25rem;
    border-top:1.5px solid var(--sp-border);
    margin-top:1.5rem;
}
.rp-nav-buttons .btn {
    padding:.55rem 1.6rem; border-radius:var(--sp-radius);
    font-weight:600; font-size:.875rem; letter-spacing:.02em;
    transition: all var(--sp-trans);
}
.rp-nav-buttons .btn-primary:hover {
    box-shadow:0 4px 14px rgba(67,97,238,.35);
    transform:translateY(-1px);
}
.rp-nav-buttons .btn-success:hover {
    box-shadow:0 4px 14px rgba(46,196,182,.35);
    transform:translateY(-1px);
}

/* Progress bar under stepper */
.rp-progress-bar-wrap {
    height:3px; background:var(--sp-border);
    border-radius:3px; margin-bottom:1.75rem; overflow:hidden;
}
.rp-progress-bar-fill {
    height:100%; background: linear-gradient(90deg, var(--sp-primary), var(--sp-success));
    border-radius:3px;
    transition: width .4s ease;
}
</style>

{{-- ══════════════════════════════════════════════════════════════
     FORM
══════════════════════════════════════════════════════════════ --}}
<form action="{{ $route }}" method="POST" id="rpStepForm">
    @csrf
    @method($method)
    <input type="hidden" name="guard_name" value="web">

    {{-- ── Stepper nav ───────────────────────────────────────── --}}
    <div class="rp-stepper" id="rpStepper">
        <div class="rp-step active" data-step="1" onclick="goToStep(1)">
            <div class="rp-step-circle" id="stepCircle1">1</div>
            <span class="rp-step-label">Datos</span>
            <span class="rp-step-sublabel">Nombre del rol</span>
        </div>
        <div class="rp-step" data-step="2" onclick="goToStep(2)">
            <div class="rp-step-circle" id="stepCircle2">2</div>
            <span class="rp-step-label">Permisos</span>
            <span class="rp-step-sublabel">Accesos del rol</span>
        </div>
        <div class="rp-step" data-step="3" onclick="goToStep(3)">
            <div class="rp-step-circle" id="stepCircle3">3</div>
            <span class="rp-step-label">Usuarios</span>
            <span class="rp-step-sublabel">Asignar miembros</span>
        </div>
        <div class="rp-stepper-line" id="rpStepperLine"></div>
    </div>

    {{-- Barra de progreso --}}
    <div class="rp-progress-bar-wrap">
        <div class="rp-progress-bar-fill" id="rpProgressBar" style="width:33.33%"></div>
    </div>

    {{-- ══════════════════════════════
         PASO 1 — Nombre del rol
    ══════════════════════════════ --}}
    <div class="rp-step-panel active" id="panel1">
        <div class="rp-name-wrapper">
            <label for="inputRoleName" class="form-label">
                <i class="bx bx-shield-quarter me-1 text-primary"></i> Nombre del Rol
            </label>
            <input
                name="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="inputRoleName"
                placeholder="Ej: Administrador, Supervisor, Cajero…"
                value="{{ old('name', $role->name ?? '') }}"
                autocomplete="off"
                required
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text mt-2">
                <i class="bx bx-info-circle me-1"></i>
                El nombre identifica el rol en todo el sistema. Usa un nombre claro y descriptivo.
            </div>
        </div>

        {{-- Resumen visual (solo en edit) --}}
        @if($isEdit)
        <div class="mt-4 p-3 rounded-3 border" style="background:#f8f9ff;max-width:460px">
            <div class="d-flex gap-3 flex-wrap">
                <div class="text-center px-3">
                    <div class="fw-bold fs-4 text-primary">{{ $role->permissions()->count() }}</div>
                    <small class="text-muted">Permisos</small>
                </div>
                <div class="vr"></div>
                <div class="text-center px-3">
                    <div class="fw-bold fs-4 text-success">{{ $role->users()->count() }}</div>
                    <small class="text-muted">Usuarios</small>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ══════════════════════════════
         PASO 2 — Permisos
    ══════════════════════════════ --}}
    <div class="rp-step-panel" id="panel2">
        <div class="rp-toolbar">
            <div class="rp-search-box">
                <i class="bx bx-search"></i>
                <input type="text" id="rpSearchCat"
                       class="form-control form-control-sm"
                       placeholder="Buscar módulo…" autocomplete="off">
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="rp-counter-badge" id="rpCounter">
                    <i class="bx bx-check-circle me-1"></i>
                    <span id="rpCountNum">0</span> seleccionado(s)
                </span>
                <button type="button" class="rp-btn-select-all" id="rpSelectAll">
                    <i class="bx bx-select-multiple me-1"></i> Seleccionar todo
                </button>
            </div>
        </div>

        <div class="rp-table-wrapper">
            <table class="table table-sm rp-permissions-table" id="rpTable">
                <thead>
                    <tr>
                        <th>Módulo / Categoría</th>
                        @foreach(['create'=>'Crear','read'=>'Leer','update'=>'Actualizar','delete'=>'Eliminar'] as $ck=>$cl)
                        <th>
                            <div class="rp-col-header">
                                {{ $cl }}
                                <button type="button" class="rp-col-toggle"
                                        data-col="{{ $ck }}">todos</button>
                            </div>
                        </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($permisos_cat as $per_cat)
                        @php
                            $catPerms = $permisos->where('category', $per_cat->category)->values();
                            $colMap   = ['create'=>null,'read'=>null,'update'=>null,'delete'=>null];
                            foreach ($catPerms as $p) {
                                $n = strtolower($p->name);
                                if      (str_contains($n,'create')||str_contains($n,'store'))  $colMap['create'] = $p;
                                elseif  (str_contains($n,'read')||str_contains($n,'show')||str_contains($n,'index')||str_contains($n,'list')) $colMap['read']   = $p;
                                elseif  (str_contains($n,'update')||str_contains($n,'edit'))   $colMap['update'] = $p;
                                elseif  (str_contains($n,'delete')||str_contains($n,'destroy'))$colMap['delete'] = $p;
                            }
                            if (collect($colMap)->filter()->count() === 0) {
                                $keys = array_keys($colMap);
                                foreach ($catPerms as $idx => $p) {
                                    if (isset($keys[$idx])) $colMap[$keys[$idx]] = $p;
                                }
                            }
                            $rolePermIds = isset($role) ? $role->permissions->pluck('id')->toArray() : [];
                        @endphp
                        <tr data-category="{{ strtolower($per_cat->category) }}">
                            <td>
                                <div class="d-flex align-items-center">
                                    <span>{{ $per_cat->category }}</span>
                                    <button type="button" class="rp-row-toggle"
                                            data-row="{{ $per_cat->category }}">todo</button>
                                </div>
                            </td>
                            @foreach(['create','read','update','delete'] as $col)
                            <td>
                                @if($colMap[$col])
                                    <div class="rp-check-wrap">
                                        <input type="checkbox" name="permission[]"
                                               id="chk{{ $colMap[$col]->id }}"
                                               value="{{ $colMap[$col]->id }}"
                                               data-col="{{ $col }}"
                                               data-row="{{ $per_cat->category }}"
                                               @checked(in_array($colMap[$col]->id, $rolePermIds))>
                                    </div>
                                @else
                                    <span class="text-muted opacity-25">—</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                    @endforeach
                    <tr class="rp-no-results" id="rpNoResults">
                        <td colspan="5">
                            <i class="bx bx-search-alt-2 me-1"></i>
                            Sin resultados para "<span id="rpNoResultsQuery"></span>"
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    {{-- ══════════════════════════════
         PASO 3 — Usuarios
    ══════════════════════════════ --}}
    <div class="rp-step-panel" id="panel3">

        {{-- Inputs hidden: usuarios seleccionados --}}
        <div id="rpUserInputs"></div>

        <div class="rp-users-layout">

            {{-- ── Panel izquierdo: disponibles ─────────────────── --}}
            <div class="rp-users-panel">
                <div class="rp-users-panel-header">
                    <h6><i class="bx bx-group me-1"></i> Usuarios disponibles</h6>
                </div>

                {{-- Barra de búsqueda + filtros --}}
                <div class="rp-users-panel-toolbar">
                    <div class="rp-users-panel-search">
                        <i class="bx bx-search"></i>
                        <input type="text" id="rpUserSearch"
                               placeholder="Buscar por nombre, email, empresa…"
                               autocomplete="off">
                    </div>
                    <div class="rp-filter-tabs">
                        <button type="button" class="rp-filter-tab active" data-filter="all">Todos</button>
                        <button type="button" class="rp-filter-tab business"   data-filter="business">
                            <i class="bx bx-buildings me-1"></i>Empresas
                        </button>
                        <button type="button" class="rp-filter-tab restaurant" data-filter="restaurant">
                            <i class="bx bx-restaurant me-1"></i>Restaurantes
                        </button>
                    </div>
                </div>

                <div class="rp-users-list" id="rpUsersList">
                    @foreach($users as $u)
                        @php
                            // Proteger relaciones nullables con collect()
                            $u_bizList  = collect($u->businesses  ?? []);
                            $u_restList = collect($u->restaurants ?? []);

                            $assigned  = isset($role) && $role->users->contains($u->id);
                            $initials  = collect(explode(' ', $u->name))->take(2)
                                            ->map(function($w) { return strtoupper($w[0]); })->join('');
                            $avatarSrc = $u->avatar ?? $u->profile_photo_path ?? null;

                            // Agrupar restaurantes: con empresa y sin empresa
                            $restsWithBiz = $u_restList->filter(function($r) {
                                return collect($r->businesses ?? [])->isNotEmpty();
                            });
                            $restsAlone = $u_restList->filter(function($r) {
                                return collect($r->businesses ?? [])->isEmpty();
                            });

                            // Para búsqueda: texto plano de todo
                            $searchText = strtolower(
                                $u->name . ' ' . $u->email . ' ' .
                                $u_bizList->pluck('name')->join(' ') . ' ' .
                                $u_restList->pluck('name')->join(' ')
                            );

                            // Flags para filtros
                            $hasBusiness   = $u_bizList->isNotEmpty();
                            $hasRestaurant = $u_restList->isNotEmpty();
                            $filterAttr    = collect([
                                $hasBusiness   ? 'business'   : null,
                                $hasRestaurant ? 'restaurant' : null,
                            ])->filter()->join(' ');

                            // Conteo para el botón expandir
                            $detailCount = $u_bizList->count() + $u_restList->count();
                        @endphp
                        <div class="rp-user-card {{ $assigned ? 'selected' : '' }}"
                             id="userCard{{ $u->id }}"
                             data-user-id="{{ $u->id }}"
                             data-search="{{ $searchText }}"
                             data-filter="{{ $filterAttr ?: 'none' }}">

                            {{-- Fila principal: click para seleccionar --}}
                            <div class="rp-user-card-main" onclick="toggleUser({{ $u->id }})">
                                <div class="rp-avatar">
                                    @if($avatarSrc)
                                        <img src="{{ $avatarSrc }}" alt="{{ $u->name }}">
                                    @else
                                        {{ $initials }}
                                    @endif
                                </div>
                                <div class="rp-user-info">
                                    <div class="rp-user-name">{{ $u->name }}</div>
                                    <div class="rp-user-email">{{ $u->email }}</div>

                                    {{-- Chips resumen (máx 2 visibles) --}}
                                    <div class="d-flex flex-wrap gap-1 mt-1">
                                        @foreach($u_bizList->take(2) as $biz)
                                            <span class="rp-entity-chip business">
                                                @if($biz->logo)
                                                    <img src="{{ $biz->logo }}" alt="">
                                                @else
                                                    <i class="bx bx-buildings" style="font-size:.75rem"></i>
                                                @endif
                                                <span>{{ $biz->name }}</span>
                                            </span>
                                        @endforeach
                                        @foreach($u_restList->take(2) as $rest)
                                            @php $restBiz = collect($rest->businesses ?? []); @endphp
                                            <span class="rp-entity-chip {{ $restBiz->isNotEmpty() ? 'restaurant' : 'standalone' }}">
                                                @if($rest->logo)
                                                    <img src="{{ $rest->logo }}" alt="">
                                                @else
                                                    <i class="bx bx-restaurant" style="font-size:.75rem"></i>
                                                @endif
                                                <span>{{ $rest->name }}</span>
                                            </span>
                                        @endforeach
                                        @if($detailCount > 4)
                                            <span class="rp-entity-chip" style="background:#f0f0f0;color:#666;border-color:#ddd">
                                                +{{ $detailCount - 4 }} más
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="rp-check-indicator">
                                    <i class="bx bx-check"></i>
                                </div>
                            </div>

                            {{-- Botón expandir detalles (solo si tiene business o restaurants) --}}
                            @if($detailCount > 0)
                                <button type="button"
                                        class="rp-user-card-expand-btn"
                                        onclick="toggleDetail({{ $u->id }}, this)">
                                    <i class="bx bx-chevron-down"></i>
                                    Ver detalle ({{ $u_bizList->count() }} empresa(s) · {{ $u_restList->count() }} restaurante(s))
                                </button>

                                <div class="rp-user-detail" id="detail{{ $u->id }}">

                                    {{-- Empresas --}}
                                    @if($u_bizList->isNotEmpty())
                                        <div class="rp-detail-section">
                                            <div class="rp-detail-label">
                                                <i class="bx bx-buildings text-primary"></i> Empresas
                                            </div>
                                            <div class="rp-detail-items">
                                                @foreach($u_bizList as $biz)
                                                    <span class="rp-entity-chip business">
                                                        @if($biz->logo)
                                                            <img src="{{ $biz->logo }}" alt="{{ $biz->name }}">
                                                        @else
                                                            <i class="bx bx-buildings" style="font-size:.75rem"></i>
                                                        @endif
                                                        <span>{{ $biz->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Restaurantes vinculados a empresa --}}
                                    @if($restsWithBiz->isNotEmpty())
                                        <div class="rp-detail-section">
                                            <div class="rp-detail-label">
                                                <i class="bx bx-restaurant text-success"></i>
                                                Restaurantes <small class="fw-normal">(con empresa)</small>
                                            </div>
                                            <div class="rp-detail-items">
                                                @foreach($restsWithBiz as $rest)
                                                    @php $restBizNames = collect($rest->businesses ?? [])->pluck('name')->join(', '); @endphp
                                                    <span class="rp-entity-chip restaurant" title="{{ $restBizNames }}">
                                                        @if($rest->logo)
                                                            <img src="{{ $rest->logo }}" alt="{{ $rest->name }}">
                                                        @else
                                                            <i class="bx bx-restaurant" style="font-size:.75rem"></i>
                                                        @endif
                                                        <span>{{ $rest->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Restaurantes independientes --}}
                                    @if($restsAlone->isNotEmpty())
                                        <div class="rp-detail-section">
                                            <div class="rp-detail-label">
                                                <i class="bx bx-restaurant" style="color:#8a6000"></i>
                                                Restaurantes <small class="fw-normal">(independientes)</small>
                                            </div>
                                            <div class="rp-detail-items">
                                                @foreach($restsAlone as $rest)
                                                    <span class="rp-entity-chip standalone">
                                                        @if($rest->logo)
                                                            <img src="{{ $rest->logo }}" alt="{{ $rest->name }}">
                                                        @else
                                                            <i class="bx bx-restaurant" style="font-size:.75rem"></i>
                                                        @endif
                                                        <span>{{ $rest->name }}</span>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>{{-- /.rp-user-detail --}}
                            @endif

                        </div>{{-- /.rp-user-card --}}
                    @endforeach
                </div>
            </div>

            {{-- ── Panel derecho: asignados ──────────────────────── --}}
            <div class="rp-users-panel">
                <div class="rp-users-panel-header">
                    <h6>
                        <i class="bx bx-shield-check me-1 text-success"></i>
                        Asignados al rol
                    </h6>
                    <span class="rp-assigned-badge" id="rpAssignedCount">0</span>
                </div>
                <div class="rp-users-list" id="rpAssignedList">
                    <div class="rp-assigned-empty" id="rpAssignedEmpty">
                        <i class="bx bx-user-plus"></i>
                        <span>Selecciona usuarios del panel izquierdo</span>
                    </div>
                </div>
            </div>

        </div>{{-- /.rp-users-layout --}}
    </div>

    {{-- ── Botones de navegación ──────────────────────────────── --}}
    <div class="rp-nav-buttons">
        <div>
            <button type="button" class="btn btn-light d-none" id="btnPrev" onclick="prevStep()">
                <i class="bx bx-chevron-left me-1"></i> Anterior
            </button>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                <i class="bx bx-x me-1"></i> Cancelar
            </a>
            <button type="button" class="btn btn-primary" id="btnNext" onclick="nextStep()">
                Siguiente <i class="bx bx-chevron-right ms-1"></i>
            </button>
            <button type="submit" class="btn btn-success d-none" id="btnSubmit">
                <i class="bx {{ $isEdit ? 'bx-save' : 'bx-plus-circle' }} me-1"></i>
                {{ $btnText }}
            </button>
        </div>
    </div>

</form>

{{-- ══════════════════════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════════════════════ --}}
<script>
(function () {
    'use strict';

    // ── Estado global ──────────────────────────────────────────
    let currentStep  = 1;
    const totalSteps = 3;

    // Map de usuarios asignados: id → { id, name, email, initials, avatarSrc, businesses[], restaurants[] }
    const assignedUsers = new Map();

    // Pre-poblar usuarios asignados en modo edición
    @if($isEdit)
        @foreach($role->users as $u)
            @php
                $u_initials   = collect(explode(' ', $u->name))->take(2)
                                    ->map(function($w) { return strtoupper($w[0]); })->join('');
                $u_avatarSrc  = $u->avatar ?? $u->profile_photo_path ?? null;
                $u_businesses = collect($u->businesses ?? [])->map(function($b) {
                    return ['name' => $b->name, 'logo' => $b->logo];
                })->values()->toArray();
                $u_restaurants = collect($u->restaurants ?? [])->map(function($r) {
                    return [
                        'name'       => $r->name,
                        'logo'       => $r->logo,
                        'standalone' => collect($r->businesses ?? [])->isEmpty(),
                    ];
                })->values()->toArray();
            @endphp
            assignedUsers.set({{ $u->id }}, {
                id         : {{ $u->id }},
                name       : @json($u->name),
                email      : @json($u->email),
                initials   : @json($u_initials),
                avatarSrc  : @json($u_avatarSrc),
                businesses : @json($u_businesses),
                restaurants: @json($u_restaurants),
            });
        @endforeach
    @endif

    // ── Stepper: ir a paso ─────────────────────────────────────
    window.goToStep = function(target) {
        // Solo permite ir a pasos ya visitados o completados
        if (target < currentStep) { navigateTo(target); return; }
        if (target === currentStep) return;
        // Validar paso actual antes de avanzar
        if (!validateStep(currentStep)) return;
        navigateTo(target);
    };

    function navigateTo(step) {
        // Ocultar panel actual, marcar como done
        document.getElementById(`panel${currentStep}`).classList.remove('active');
        document.querySelector(`.rp-step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.rp-step[data-step="${currentStep}"]`).classList.add('done');
        document.getElementById(`stepCircle${currentStep}`).innerHTML = '<i class="bx bx-check"></i>';

        // Si retrocede, quitar done del paso destino
        if (step < currentStep) {
            for (let s = step; s <= currentStep; s++) {
                document.querySelector(`.rp-step[data-step="${s}"]`).classList.remove('done');
                document.getElementById(`stepCircle${s}`).textContent = s;
            }
        }

        currentStep = step;

        document.getElementById(`panel${step}`).classList.add('active');
        document.querySelector(`.rp-step[data-step="${step}"]`).classList.remove('done');
        document.querySelector(`.rp-step[data-step="${step}"]`).classList.add('active');
        document.getElementById(`stepCircle${step}`).textContent = step;

        // Botones
        document.getElementById('btnPrev').classList.toggle('d-none', step === 1);
        document.getElementById('btnNext').classList.toggle('d-none', step === totalSteps);
        document.getElementById('btnSubmit').classList.toggle('d-none', step !== totalSteps);

        // Progreso
        const pct = (step / totalSteps) * 100;
        document.getElementById('rpProgressBar').style.width = pct + '%';

        // Línea del stepper
        const lineWidths = { 1: '0%', 2: '50%', 3: '100%' };
        document.getElementById('rpStepperLine').style.width = lineWidths[step] ?? '0%';

        // Si llega al paso 3, renderizar panel de usuarios
        if (step === 3) renderAssignedPanel();
    }

    window.nextStep = function() {
        if (currentStep >= totalSteps) return;
        if (!validateStep(currentStep)) return;
        navigateTo(currentStep + 1);
    };

    window.prevStep = function() {
        if (currentStep <= 1) return;
        navigateTo(currentStep - 1);
    };

    // ── Validaciones por paso ──────────────────────────────────
    function validateStep(step) {
        if (step === 1) {
            const name = document.getElementById('inputRoleName').value.trim();
            if (!name) {
                document.getElementById('inputRoleName').classList.add('is-invalid');
                document.getElementById('inputRoleName').focus();
                return false;
            }
            document.getElementById('inputRoleName').classList.remove('is-invalid');
        }
        return true;
    }

    document.getElementById('inputRoleName').addEventListener('input', function () {
        if (this.value.trim()) this.classList.remove('is-invalid');
    });

    // ══════════════════════════════════════════════════════════
    //  PASO 2 — Permisos
    // ══════════════════════════════════════════════════════════
    const form = document.getElementById('rpStepForm');

    function updateCounter() {
        const count = form.querySelectorAll('input[name="permission[]"]:checked').length;
        document.getElementById('rpCountNum').textContent = count;
        document.getElementById('rpCounter').classList.toggle('has-perms', count > 0);
    }
    form.addEventListener('change', e => {
        if (e.target.name === 'permission[]') updateCounter();
    });
    updateCounter();

    // Búsqueda categorías
    document.getElementById('rpSearchCat').addEventListener('input', function () {
        const q = this.value.trim().toLowerCase();
        let visible = 0;
        document.querySelectorAll('#rpTable tbody tr[data-category]').forEach(row => {
            const show = !q || row.dataset.category.includes(q);
            row.classList.toggle('rp-hidden', !show);
            if (show) visible++;
        });
        const nr = document.getElementById('rpNoResults');
        nr.classList.toggle('visible', visible === 0 && q !== '');
        document.getElementById('rpNoResultsQuery').textContent = q;
    });

    // Seleccionar todo global
    document.getElementById('rpSelectAll').addEventListener('click', function () {
        const boxes     = form.querySelectorAll('input[name="permission[]"]');
        const allChecked = [...boxes].every(c => c.checked);
        boxes.forEach(c => c.checked = !allChecked);
        this.classList.toggle('all-selected', !allChecked);
        this.innerHTML = !allChecked
            ? '<i class="bx bx-x-circle me-1"></i> Deseleccionar todo'
            : '<i class="bx bx-select-multiple me-1"></i> Seleccionar todo';
        updateCounter();
    });

    // Seleccionar columna
    document.querySelectorAll('.rp-col-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const col   = this.dataset.col;
            const boxes = form.querySelectorAll(`input[data-col="${col}"]`);
            const all   = [...boxes].every(c => c.checked);
            boxes.forEach(c => c.checked = !all);
            updateCounter();
        });
    });

    // Seleccionar fila
    document.querySelectorAll('.rp-row-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            const row   = this.dataset.row;
            const boxes = form.querySelectorAll(`input[data-row="${row}"]`);
            const all   = [...boxes].every(c => c.checked);
            boxes.forEach(c => c.checked = !all);
            this.classList.toggle('full', !all);
            this.textContent = !all ? 'quitar' : 'todo';
            updateCounter();
        });
    });

    // ══════════════════════════════════════════════════════════
    //  PASO 3 — Usuarios
    // ══════════════════════════════════════════════════════════

    // Mapa con TODOS los usuarios disponibles (pre-poblado desde Blade)
    const allUsersData = new Map();
    @foreach($users as $u)
        @php
            $u_initials_all    = collect(explode(' ', $u->name))->take(2)
                                    ->map(function($w) { return strtoupper($w[0]); })->join('');
            $u_avatar_all      = $u->avatar ?? $u->profile_photo_path ?? null;
            $u_businesses_all  = collect($u->businesses ?? [])->map(function($b) {
                return ['name' => $b->name, 'logo' => $b->logo];
            })->values()->toArray();
            $u_restaurants_all = collect($u->restaurants ?? [])->map(function($r) {
                return [
                    'name'       => $r->name,
                    'logo'       => $r->logo,
                    'standalone' => collect($r->businesses ?? [])->isEmpty(),
                ];
            })->values()->toArray();
        @endphp
        allUsersData.set({{ $u->id }}, {
            id         : {{ $u->id }},
            name       : @json($u->name),
            email      : @json($u->email),
            initials   : @json($u_initials_all),
            avatarSrc  : @json($u_avatar_all),
            businesses : @json($u_businesses_all),
            restaurants: @json($u_restaurants_all),
        });
    @endforeach

    // ── Expandir detalle de business/restaurants ───────────────
    window.toggleDetail = function(userId, btn) {
        const detail = document.getElementById(`detail${userId}`);
        const isOpen = detail.classList.toggle('open');
        btn.classList.toggle('open', isOpen);
    };

    // ── Toggle selección de usuario ────────────────────────────
    window.toggleUser = function(userId) {
        const card = document.getElementById(`userCard${userId}`);

        if (assignedUsers.has(userId)) {
            assignedUsers.delete(userId);
            card.classList.remove('selected');
        } else {
            // Tomamos los datos del mapa pre-cargado, no del DOM
            const data = allUsersData.get(userId);
            if (data) assignedUsers.set(userId, data);
            card.classList.add('selected');
        }

        renderAssignedPanel();
        syncHiddenInputs();
    };

    // ── Quitar desde panel derecho ─────────────────────────────
    window.removeUser = function(userId) {
        assignedUsers.delete(userId);
        const card = document.getElementById(`userCard${userId}`);
        if (card) card.classList.remove('selected');
        renderAssignedPanel();
        syncHiddenInputs();
    };

    // ── Renderizar panel derecho (asignados) ───────────────────
    function renderAssignedPanel() {
        const list       = document.getElementById('rpAssignedList');
        const empty      = document.getElementById('rpAssignedEmpty');
        const countBadge = document.getElementById('rpAssignedCount');

        countBadge.textContent = assignedUsers.size;

        if (assignedUsers.size === 0) {
            list.innerHTML = '';
            list.appendChild(empty);
            empty.style.display = 'flex';
            return;
        }

        empty.style.display = 'none';
        list.innerHTML = '';

        assignedUsers.forEach(u => {
            const avatarHtml = u.avatarSrc
                ? `<img src="${u.avatarSrc}" alt="${u.name}">`
                : u.initials || u.name.split(' ').slice(0,2).map(w=>w[0]?.toUpperCase()).join('');

            // Chips de business
            const bizChips = (u.businesses ?? []).map(b => `
                <span class="rp-entity-chip business" style="font-size:.62rem;padding:.15rem .4rem">
                    ${b.logo ? `<img src="${b.logo}" alt="" style="width:12px;height:12px">` : '<i class="bx bx-buildings" style="font-size:.65rem"></i>'}
                    <span>${b.name}</span>
                </span>`).join('');

            // Chips de restaurantes
            const restChips = (u.restaurants ?? []).map(r => `
                <span class="rp-entity-chip ${r.standalone ? 'standalone' : 'restaurant'}" style="font-size:.62rem;padding:.15rem .4rem">
                    ${r.logo ? `<img src="${r.logo}" alt="" style="width:12px;height:12px">` : '<i class="bx bx-restaurant" style="font-size:.65rem"></i>'}
                    <span>${r.name}</span>
                </span>`).join('');

            list.insertAdjacentHTML('beforeend', `
                <div class="rp-user-card-assigned" id="assigned${u.id}">
                    <div class="rp-avatar-sm">${avatarHtml}</div>
                    <div class="rp-user-info">
                        <div class="rp-user-name">${u.name}</div>
                        <div class="rp-user-email">${u.email}</div>
                        ${bizChips || restChips ? `<div class="rp-chips-mini">${bizChips}${restChips}</div>` : ''}
                    </div>
                    <button type="button" class="btn-remove" onclick="removeUser(${u.id})" title="Quitar del rol">
                        <i class="bx bx-x"></i>
                    </button>
                </div>
            `);
        });
    }

    // ── Sincronizar inputs hidden con los usuarios seleccionados
    function syncHiddenInputs() {
        const container = document.getElementById('rpUserInputs');
        container.innerHTML = '';
        assignedUsers.forEach(u => {
            const inp = document.createElement('input');
            inp.type  = 'hidden';
            inp.name  = 'users[]';
            inp.value = u.id;
            container.appendChild(inp);
        });
    }

    // ── Búsqueda en panel izquierdo ────────────────────────────
    document.getElementById('rpUserSearch').addEventListener('input', function () {
        applyFilters();
    });

    // ── Filtros por tipo ───────────────────────────────────────
    let activeFilter = 'all';
    document.querySelectorAll('.rp-filter-tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.rp-filter-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.dataset.filter;
            applyFilters();
        });
    });

    function applyFilters() {
        const q = document.getElementById('rpUserSearch').value.trim().toLowerCase();
        document.querySelectorAll('#rpUsersList .rp-user-card').forEach(card => {
            const matchSearch = !q || card.dataset.search.includes(q);
            const matchFilter = activeFilter === 'all' || card.dataset.filter.includes(activeFilter);
            card.classList.toggle('rp-user-hidden', !(matchSearch && matchFilter));
        });
    }

    // ── Init ───────────────────────────────────────────────────
    renderAssignedPanel();
    syncHiddenInputs();
    // Marcar visualmente los ya asignados (edit)
    assignedUsers.forEach((_, id) => {
        const card = document.getElementById(`userCard${id}`);
        if (card) card.classList.add('selected');
    });

})();
</script>