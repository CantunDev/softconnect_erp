<style>
    :root {
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --border-color: #e5e7eb;
        --bg-card: #ffffff;
        --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        --bg-subtle: #f9fafb;
    }

    @media (prefers-color-scheme: dark) {
        :root {
            --text-primary: #e5e7eb;
            --text-secondary: #9ca3af;
            --border-color: #374151;
            --bg-card: #1f2937;
            --card-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            --bg-subtle: #111827;
        }
    }

    body {
        background-color: var(--bg-subtle);
    }

    .form-control {
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        background-color: var(--bg-card);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .form-control:focus {
        border-color: #000;
        color: var(--text-primary);
        background-color: var(--bg-card);
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        color: var(--text-primary);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .card {
        border: 1px solid var(--border-color);
        background-color: var(--bg-card);
        color: var(--text-primary);
        border-radius: 0.75rem;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        transition: all 0.2s ease;
    }

    .card:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    }

    .card-body {
        color: var(--text-primary);
        padding: 1.75rem;
    }

    .card-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        font-size: 1rem;
    }

    .invalid-feedback {
        display: block;
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-color: #ef4444 !important;
    }

    .is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1) !important;
        border-color: #ef4444 !important;
    }

    .is-valid {
        border-color: #10b981 !important;
    }

    .selectpicker {
        max-height: 38px !important;
        overflow: hidden !important;
        border-radius: 0.5rem !important;
    }

    .bootstrap-select>.dropdown-toggle {
        max-height: 38px !important;
        overflow: hidden !important;
        border: 1px solid var(--border-color) !important;
        background-color: var(--bg-card) !important;
        color: var(--text-primary) !important;
        border-radius: 0.5rem !important;
        transition: all 0.2s ease !important;
    }

    .bootstrap-select>.dropdown-toggle:focus {
        border-color: #000 !important;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05) !important;
    }

    .bootstrap-select .dropdown-menu {
        background-color: var(--bg-card);
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 0.5rem;
        margin-top: 0.25rem;
    }

    .bootstrap-select .dropdown-menu>.active>a,
    .bootstrap-select .dropdown-menu>li>a:hover {
        background-color: rgba(0, 0, 0, 0.08);
        color: var(--text-primary);
    }

    .btn {
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-primary {
        background-color: #000;
        border-color: #000;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #1a1a1a;
        border-color: #1a1a1a;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-secondary {
        color: var(--text-primary);
        border-color: var(--border-color);
    }

    .btn-outline-secondary:hover {
        color: var(--text-primary);
        background-color: rgba(0, 0, 0, 0.05);
        border-color: #000;
    }

    .table {
        color: var(--text-primary);
        margin-bottom: 0;
    }

    .table thead th {
        border-color: var(--border-color);
        color: var(--text-primary);
        background-color: var(--bg-subtle);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table tbody td {
        border-color: var(--border-color);
        word-break: break-word;
        max-width: 200px;
        padding: 0.75rem 0.5rem;
    }

    .table tbody tr {
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.03);
    }

    /* Avatar Preview */
    .avatar-preview {
        position: relative;
        width: 200px;
        height: 200px;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        cursor: pointer;
        overflow: hidden;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }

    .avatar-preview:hover {
        border-color: #0d6efd;
        background-color: rgba(13, 110, 253, 0.05);
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        transition: transform 0.2s ease;
    }

    .avatar-preview:hover img {
        transform: scale(1.02);
    }

    .avatar-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        padding: 1rem;
    }

    .avatar-placeholder svg {
        width: 48px;
        height: 48px;
        color: #6c757d;
        margin-bottom: 0.5rem;
    }

    #inputLogo {
        cursor: pointer;
    }

    /* Espaciado */
    .row.g-3 {
        gap: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .table {
            font-size: 13px;
        }

        .table tbody td {
            max-width: 150px;
            padding: 0.5rem 0.25rem;
        }

        .avatar-preview {
            width: 180px;
            height: 180px;
        }

        .card-body {
            padding: 1.25rem;
        }
    }

    @media (max-width: 480px) {
        .table {
            font-size: 11px;
        }

        .table tbody td {
            max-width: 120px;
            padding: 0.25rem 0.15rem;
        }

        .avatar-preview {
            width: 150px;
            height: 150px;
        }

        .card-body {
            padding: 1rem;
        }
    }

    /* Loading spinner */
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }

    /* Dark mode adjustments */
    @media (prefers-color-scheme: dark) {
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }

        .avatar-preview {
            background-color: var(--bg-subtle);
            border-color: var(--border-color);
        }

        .avatar-preview:hover {
            border-color: #3b82f6;
        }

        .btn-outline-secondary:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
    }
</style>

@if ($errors->any())
    <div class="alert alert-danger mb-3" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form id="create_users" class="row g-3" action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method($method)

            <div class="col-sm-4 col-lg-4">
                <label for="inputName" class="form-label">Nombre</label>
                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    id="inputName" placeholder="Nombre" value="{{ old('name', $user->name ?? '') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-4 col-lg-4">
                <label for="inputLastname" class="form-label">A. Paterno</label>
                <input name="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror"
                    id="inputLastname" placeholder="Apellido paterno" value="{{ old('lastname', $user->lastname ?? '') }}">
                @error('lastname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-4 col-lg-3">
                <label for="inputSurname" class="form-label">A. Materno</label>
                <input name="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                    id="inputSurname" placeholder="Apellido materno" value="{{ old('surname', $user->surname ?? '') }}">
                @error('surname')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6 col-md-3 col-lg-3">
                <label for="inputPhone" class="form-label">Teléfono</label>
                <input name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                    id="inputPhone" minlength="10" maxlength="10" placeholder="Ej: 9380000000"
                    value="{{ old('phone', $user->phone ?? '') }}">
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6 col-lg-4">
                <label for="inputEmail" class="form-label">Correo electrónico</label>
                <input type="email" name="email" id="inputEmail"
                    class="form-control text-lowercase @error('email') is-invalid @enderror"
                    placeholder="mail@mail.com" value="{{ old('email', $user->email ?? '') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Fotografía de Perfil</h4>

        <div class="row g-3">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label for="inputLogo" class="form-label">Imagen <span class="fw-normal text-muted">(opcional)</span></label>
                <input type="file" name="user_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                    class="form-control @error('user_file') is-invalid @enderror" onchange="previewImage(event)">
                
                @if(isset($user) && $user->user_file)
                    <small class="text-muted d-block mt-1">
                        <i class="fas fa-image me-1"></i> Imagen actual: {{ basename($user->user_file) }}
                    </small>
                @endif
                
                @error('user_file')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6">
                <label class="form-label">Previsualización</label>
                <div class="avatar-preview" id="avatarPreview">
                    <div class="avatar-placeholder" id="avatarPlaceholder" style="{{ isset($user) && $user->user_file ? 'display: none;' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Haz clic para seleccionar imagen</span>
                        <span style="font-size: 0.75rem; opacity: 0.7;">JPG, PNG</span>
                    </div>
                    
                    @if(isset($user) && $user->user_file)
                        <img src="{{ Storage::url($user->user_file) }}" alt="Perfil" id="currentImage">
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title mb-4">Selecciona una empresa</h4>

        <div class="row g-3">
            <div class="col-sm-6 col-md-6 col-lg-6">
                <label for="business_id" class="form-label">Selecciona una opción</label>
                <select class="form-control selectpicker" id="business_id" name="business_id[]" multiple data-live-search="true" data-actions-box="true" data-selected-text-format="count">
                    <option value=""
                        {{ in_array("", $selectedBusinessIds ?? []) ? 'selected' : '' }}>
                        Sin empresa / Solo restaurantes
                    </option>
                    @foreach ($business as $bs)
                        <option value="{{ $bs->id }}"
                            {{ in_array($bs->id, $selectedBusinessIds ?? []) ? 'selected' : '' }}>
                            {{ $bs->business_name }}
                        </option>
                    @endforeach
                </select>
                @error('business_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6">
                <h4 class="card-title mb-4 d-flex align-items-center">
                    Selecciona tu restaurante
                    <span class="selected-counter ms-2 badge bg-secondary" style="display: {{ isset($selectedRestaurantIds) && count($selectedRestaurantIds) > 0 ? 'inline-block' : 'none' }};">
                        {{ isset($selectedRestaurantIds) ? count($selectedRestaurantIds) : 0 }} seleccionados
                    </span>
                </h4>
                <div class="table-responsive">
                    <table class="table table-nowrap align-middle mb-0" id="restaurants-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>Restaurante</th>
                            </tr>
                        </thead>
                        <tbody id="restaurants-body">
                            @if(isset($selectedRestaurantIds) && count($selectedRestaurantIds) > 0)
                                <tr>
                                    <td colspan="2" class="text-center text-muted">
                                        <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                            <span class="visually-hidden">Cargando...</span>
                                        </div>
                                        Cargando restaurantes disponibles...
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="2" class="text-center text-muted py-4">
                                        <i class="fas fa-building me-2"></i>
                                        Seleccione una empresa para ver los restaurantes.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-12 mt-4 d-flex gap-2">
                <button type="submit" form="create_users" class="btn btn-primary">{{ $btnText }}</button>
                <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
</form>

@section('js')
<script>
/* ============================================
   IMAGE PREVIEW
============================================ */
let currentImageUrl = '{{ isset($user) && $user->user_file ? Storage::url($user->user_file) : null }}';

function previewImage(event) {
    const preview = document.getElementById('avatarPreview');
    const placeholder = document.getElementById('avatarPlaceholder');
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (placeholder) placeholder.style.display = 'none';

            const currentImg = document.getElementById('currentImage');
            if (currentImg) currentImg.remove();

            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Preview';
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    } else {
        restoreImage();
    }
}

function restoreImage() {
    const preview = document.getElementById('avatarPreview');
    const placeholder = document.getElementById('avatarPlaceholder');

    preview.innerHTML = '';
    if (placeholder) preview.appendChild(placeholder);

    if (currentImageUrl) {
        const img = document.createElement('img');
        img.src = currentImageUrl;
        img.alt = 'Perfil';
        img.id = 'currentImage';
        preview.appendChild(img);
        if (placeholder) placeholder.style.display = 'none';
    } else {
        if (placeholder) placeholder.style.display = 'flex';
    }
}

/* ============================================
   VALIDATION RULES
============================================ */
const rules = {
    name: { minLength: 3, onlyLetters: true, label: 'El nombre', regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/ },
    lastname: { minLength: 3, onlyLetters: true, label: 'El apellido paterno', regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/ },
    surname: { minLength: 3, onlyLetters: true, label: 'El apellido materno', regex: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/ },
    phone: { digits: 10, label: 'El teléfono', regex: /^\d+$/ },
    email: { isEmail: true, label: 'El correo', regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/ },
};

function validate(fieldName, value) {
    const rule = rules[fieldName];
    if (!rule) return null;

    if (!value || value.trim() === '') {
        return fieldName === 'email' ? null : `${rule.label} es requerido`;
    }

    if (rule.onlyLetters && !rule.regex.test(value)) return `${rule.label} solo puede contener letras`;
    if (rule.minLength && value.trim().length < rule.minLength) return `${rule.label} debe tener al menos ${rule.minLength} caracteres`;

    if (rule.digits) {
        if (!rule.regex.test(value)) return `${rule.label} solo puede contener números`;
        if (value.length !== rule.digits) return `${rule.label} debe tener exactamente ${rule.digits} dígitos`;
    }

    if (rule.isEmail && !rule.regex.test(value)) return `${rule.label} no tiene un formato válido`;

    return null;
}

function showError(input, message) {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');

    let feedback = input.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('div');
        feedback.classList.add('invalid-feedback');
        input.insertAdjacentElement('afterend', feedback);
    }
    feedback.textContent = message;
}

function showSuccess(input) {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');

    const feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) feedback.textContent = '';
}

/* ============================================
   DOM READY
============================================ */
document.addEventListener('DOMContentLoaded', function() {

    Object.keys(rules).forEach(fieldName => {
        const input = document.querySelector(`[name="${fieldName}"]`);
        if (!input) return;

        input.addEventListener('input', function() {
            const error = validate(fieldName, this.value);
            error ? showError(this, error) : showSuccess(this);
        });

        input.addEventListener('blur', function() {
            const error = validate(fieldName, this.value);
            error ? showError(this, error) : showSuccess(this);
        });
    });

    const preview = document.getElementById('avatarPreview');
    const inputFile = document.getElementById('inputLogo');

    if (preview && inputFile) {
        preview.addEventListener('click', () => inputFile.click());
        inputFile.addEventListener('click', function() { this.value = null; });
    }

    if ($.fn.selectpicker) {
        $('.selectpicker').selectpicker('refresh');
    }
});

/* ============================================
   RESTAURANTS LOADER
============================================ */
$(document).ready(function() {

    let selectedRestaurantIds = @json($selectedRestaurantIds ?? []);
    selectedRestaurantIds = selectedRestaurantIds.map(id => Number(id));

    function updateSelectedCounter() {
        let count = $('input[name="restaurant_ids[]"]:checked').length;
        let $counter = $('.selected-counter');

        if (count > 0) {
            $counter.text(count + ' seleccionados').show();
        } else {
            $counter.hide();
        }
    }

    function renderRestaurants(data) {
        let $tbody = $('#restaurants-body');
        $tbody.empty();

        if (!data.length) {
            $tbody.append('<tr><td colspan="2" class="text-center text-muted py-4">No se encontraron restaurantes.</td></tr>');
            return;
        }

        data.forEach(function(restaurant) {

            let imageUrl = restaurant.restaurant_file
                ? `{{ Storage::url('') }}${restaurant.restaurant_file}`
                : `https://avatar.oxro.io/avatar.svg?name=${encodeURIComponent(restaurant.name)}`;

            let isChecked = selectedRestaurantIds.includes(Number(restaurant.id)) ? 'checked' : '';

            let row = `
                <tr>
                    <td style="width:40px;">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="restaurant_ids[]"
                                   value="${restaurant.id}"
                                   class="form-check-input"
                                   ${isChecked}>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <img src="${imageUrl}" class="rounded-circle me-2" style="width:32px;height:32px;object-fit:cover;">
                            ${restaurant.name}
                        </div>
                    </td>
                </tr>`;
            $('#restaurants-body').append(row);
        });

        updateSelectedCounter();
    }

    function loadRestaurants(businessIds, includeSinEmpresa) {

        $('#restaurants-body').html('<tr><td colspan="2" class="text-center py-4"><div class="spinner-border spinner-border-sm"></div> Cargando...</td></tr>');

        $.ajax({
            url: "{{ route('restaurants.get') }}",
            type: "POST",
            dataType: "json",
            data: {
                business_ids: businessIds,
                include_sin_empresa: includeSinEmpresa,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                let flatData = Array.isArray(data) ? data.flat().filter(Boolean) : [];
                renderRestaurants(flatData);
            },
            error: function() {
                $('#restaurants-body').html('<tr><td colspan="2" class="text-danger text-center py-4">Error al cargar restaurantes</td></tr>');
            }
        });
    }

    $('#business_id').on('change', function() {

        let businessIds = $(this).val();

        if (!Array.isArray(businessIds)) {
            businessIds = businessIds ? [businessIds] : [];
        }

        let includeSinEmpresa = businessIds.includes("");
        let filteredIds = businessIds.filter(id => id !== "");

        loadRestaurants(filteredIds, includeSinEmpresa);
    });

    $(document).on('change', 'input[name="restaurant_ids[]"]', updateSelectedCounter);

    /* ✅ CARGA INICIAL (CREATE + EDIT) */
    let initialBusinessIds = $('#business_id').val();

    if (!Array.isArray(initialBusinessIds)) {
        initialBusinessIds = initialBusinessIds ? [initialBusinessIds] : [];
    }

    let includeSinEmpresaInicial = initialBusinessIds.includes("");
    let filteredInicial = initialBusinessIds.filter(id => id !== "");

    if (includeSinEmpresaInicial || filteredInicial.length > 0) {
        loadRestaurants(filteredInicial, includeSinEmpresaInicial);
    }
});

/* ============================================
   FORM SUBMIT
============================================ */
$('#create_users').on('submit', function(e) {
    e.preventDefault();

    let seleccionados = [];
    $('input[name="restaurant_ids[]"]:checked').each(function() {
        seleccionados.push($(this).val());
    });

    $('#restaurant_ids_field').remove();

    $('<input>')
        .attr('type', 'hidden')
        .attr('name', 'restaurant_ids')
        .attr('id', 'restaurant_ids_field')
        .val(seleccionados.join(','))
        .appendTo(this);

    this.submit();
});
</script>

@endsection