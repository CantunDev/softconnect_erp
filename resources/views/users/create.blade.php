@extends('layouts.master')
@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Nueva usuario
        @endslot
        @slot('bcPrevText')
            Usuario
        @endslot
        @slot('bcPrevLink')
            {{ route('users.index') }}
        @endslot
        @slot('bcActiveText')
            Nueva usuario
        @endslot
    @endcomponent

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

        /* Mejora general */
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

        /* Select no se agranda */
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

        .bootstrap-select.show>.dropdown-toggle {
            max-height: 38px !important;
            overflow: hidden !important;
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

        .bootstrap-select .dropdown-menu>li>a {
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

        @media (prefers-color-scheme: dark) {
            .btn-outline-secondary:hover {
                background-color: rgba(255, 255, 255, 0.05);
            }
        }

        .table {
            color: var(--text-primary);
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

        @media (prefers-color-scheme: dark) {
            .table tbody tr:hover {
                background-color: rgba(255, 255, 255, 0.03);
            }
        }

        /* Avatar Preview Mejorado */
        .avatar-preview {
            width: 100%;
            min-height: 220px;
            border: 2px dashed var(--border-color);
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-subtle);
            overflow: hidden;
            margin-top: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .avatar-preview:hover {
            border-color: #000;
            background-color: rgba(0, 0, 0, 0.02);
        }

        @media (prefers-color-scheme: dark) {
            .avatar-preview:hover {
                background-color: rgba(255, 255, 255, 0.02);
            }
        }

        .avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .avatar-preview:hover img {
            transform: scale(1.02);
        }

        .avatar-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
            color: var(--text-secondary);
            font-size: 0.875rem;
            text-align: center;
            padding: 2rem;
        }

        .avatar-placeholder svg {
            width: 48px;
            height: 48px;
            stroke: var(--border-color);
            opacity: 0.5;
        }

        #inputLogo {
            cursor: pointer;
        }

        /* Espaciado mejorado */
        .row.g-3 {
            gap: 1.5rem;
        }

        /* Responsivo para tablas */
        @media (max-width: 768px) {
            .table {
                font-size: 13px;
            }

            .table thead th,
            .table tbody td {
                padding: 0.5rem 0.25rem;
            }

            .table tbody td {
                max-width: 150px;
            }

            .avatar-preview {
                min-height: 160px;
            }

            .card-body {
                padding: 1.25rem;
            }
        }

        @media (max-width: 480px) {
            .table {
                font-size: 11px;
            }

            .table thead th,
            .table tbody td {
                padding: 0.25rem 0.15rem;
            }

            .table tbody td {
                max-width: 120px;
            }

            .avatar-preview {
                min-height: 140px;
            }

            .card-body {
                padding: 1rem;
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
            <form id="create_users" class="row g-3" action="{{ route('users.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="col-sm-6 col-lg-4">
                    <label for="inputName" class="form-label">Nombre</label>
                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        id="inputName" placeholder="Nombre" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-4">
                    <label for="inputLastname" class="form-label">A. Paterno</label>
                    <input name="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror"
                        id="inputLastname" placeholder="Apellido" value="{{ old('lastname') }}">
                    @error('lastname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-4">
                    <label for="inputSurname" class="form-label">A. Materno</label>
                    <input name="surname" type="text" class="form-control @error('surname') is-invalid @enderror"
                        id="inputSurname" placeholder="Apellido" value="{{ old('surname') }}">
                    @error('surname')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-3 col-lg-2">
                    <label for="inputPhone" class="form-label">Teléfono</label>
                    <input name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                        id="inputPhone" minlength="10" maxlength="15" placeholder="Ej: 9380000000"
                        value="{{ old('phone') }}">
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-lg-4">
                    <label for="inputEmail" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" id="inputEmail"
                        class="form-control text-lowercase @error('email') is-invalid @enderror"
                        placeholder="softconnect_erp@mail.com" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4">Fotografía de Perfil</h4>

            <div class="row g-3">
                <div class="col-sm-6 col-md-6 col-lg-6">
                    <label for="inputLogo" class="form-label">Imagen <span
                            class="fw-normal text-muted">(opcional)</span></label>
                    <input type="file" name="user_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                        class="form-control @error('user_file') is-invalid @enderror" onchange="previewImage(event)">
                    @error('user_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6">
                    <label class="form-label">Previsualización</label>
                    <div class="avatar-preview" id="avatarPreview" onclick="document.getElementById('inputLogo').click()">
                        <div class="avatar-placeholder">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Haz clic para seleccionar imagen</span>
                            <span style="font-size: 0.75rem; opacity: 0.7;">JPG, PNG</span>
                        </div>
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
                    <select class="form-control selectpicker" id="business_id" name="business_id" multiple>
                        <option value="">Selecciona una opción</option>
                        <option value="sin_empresa">Sin empresa / Solo restaurantes</option>
                        @foreach ($business as $bs)
                            <option value="{{ $bs->id }}">{{ $bs->business_name }}</option>
                        @endforeach
                    </select>
                    @error('business_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-6 col-md-6 col-lg-6">
                    <h4 class="card-title mb-4">Selecciona tu restaurante</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0" id="restaurants-table">
                            <thead>
                                <tr>
                                    <th style="width: 40px;"></th>
                                    <th>Restaurante</th>
                                </tr>
                            </thead>
                            <tbody id="restaurants-body">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="col-12 mt-4 d-flex gap-2">
                    <button type="submit" form="create_users" class="btn btn-primary">Registrar</button>
                    <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Cancelar</a>
                </div>
            </div>
        </div>
    </div>
    </form>

    <script>
        // Avatar Preview
        function previewImage(event) {
            const preview = document.getElementById('avatarPreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                };
                reader.readAsDataURL(file);
            }
        }

        // Hacer el preview clickeable
        document.getElementById('avatarPreview').addEventListener('click', function() {
            document.getElementById('inputLogo').click();
        });
    </script>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            if ($.fn.selectpicker) {
                $('.selectpicker').selectpicker();
            } else {
                console.error("Bootstrap Select no está cargado.");
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#business_id').on('change', function() {
                var businessIds = $(this).val(); // Obtener los IDs seleccionados
                $('#restaurants-body').empty(); // Limpiar la tabla antes de agregar nuevos datos

                if (businessIds && businessIds.length > 0) {
                    // Enviar los IDs seleccionados al servidor
                    $.ajax({
                        url: "{{ route('restaurants.get') }}", // Ruta para obtener los restaurantes
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            business_ids: businessIds // Enviar los IDs como un array
                        },
                        success: function(data) {
                            // Aplanar el array en caso de que venga anidado
                            var flatData = data.flat().filter(function(item) {
                                return item !== null && item !== undefined;
                            });

                            if (flatData.length > 0) {
                                $.each(flatData, function(index, restaurant) {
                                    var imageUrl = restaurant?.restaurant_file ?
                                        `${restaurant.restaurant_file}` :
                                        `https://avatar.oxro.io/avatar.svg?name=${encodeURIComponent(restaurant.name || 'Restaurante')}&caps=3&bold=true`;

                                    var row = `
                            <tr>
                                <td style="width: 40px;">
                                    <div class="form-check font-size-16">
                                        <input type="checkbox" name="restaurant_ids[]" value="${restaurant.id}" id="restaurantCheck${restaurant.id}">
                                        <label class="form-check-label" for="restaurantCheck${restaurant.id}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-group-item me-2">
                                            <a href="javascript: void(0);" class="d-inline-block">
                                                <img src="${imageUrl}" alt="" class="rounded-circle avatar-xs">
                                            </a>
                                        </div>
                                        <h5 class="text-truncate font-size-14 m-0 ms-2">
                                            <a href="#" class="text-dark">${restaurant.name}</a>
                                        </h5>
                                    </div>
                                </td>
                            </tr>`;
                                    $('#restaurants-body').append(row);
                                });
                            } else {
                                $('#restaurants-body').append(
                                    '<tr><td colspan="4" class="text-center">No se encontraron restaurantes.</td></tr>'
                                );
                            }
                        },
                        error: function() {
                            alert('Error al cargar los restaurantes.');
                        }
                    });
                } else {
                    $('#restaurants-body').append(
                        '<tr><td colspan="4" class="text-center">Seleccione al menos un negocio.</td></tr>'
                    );
                }
            });
        });
    </script>

    <script>
        $('#create_users').on('submit', function(e) {
            e.preventDefault();
            var seleccionados = [];
            $('input[name="restaurant_ids[]"]:checked').each(function() {
                seleccionados.push($(this).val());
            });
            // console.log('Seleccionados:', seleccionados);
            // if (seleccionados.length === 0) {
            //     alert('Debe seleccionar al menos un restaurante.');
            //     return; 
            // }
            $('#restaurant_ids_field').remove();
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'restaurant_ids')
                .attr('id', 'restaurant_ids_field')
                .val(seleccionados.join(','))
                .appendTo('#create_users');
            this.submit();
        });
    </script>
@endsection
