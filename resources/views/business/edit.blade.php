@extends('layouts.master')
@section('title')
    Actualizar Empresa |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Editar Empresa
        @endslot
        @slot('bcPrevText')
            Empresas
        @endslot
        @slot('bcPrevLink')
            {{ route('business.index') }}
        @endslot
        @slot('bcActiveText')
            Editar empresa
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Información Básica</h4>
                    <form id="business_edit" class="row g-3" action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="col-sm-6 col-lg-6">
                            <label for="inputName" class="form-label">Nombre corto</label>
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                id="inputName" placeholder="Ej: Empresa Demo" value="{{ old('name', $business->name) }}">
                            <input type="hidden" id="business_id" value="{{ old('id', $business->id) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-lg-6">
                            <label for="inputBusinessName" class="form-label">Nombre oficial</label>
                            <input name="business_name" type="text"
                                class="form-control @error('business_name') is-invalid @enderror" id="inputBusinessName"
                                placeholder="Ej: Empresa Demo SA de CV"
                                value="{{ old('business_name', $business->business_name) }}">
                            @error('business_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12">
                            <h5 class="font-size-14 mb-3">Esquema de colores</h5>
                            <div class="row g-3">
                                <div class="col-sm-4 col-lg-4">
                                    <label for="color_primary" class="form-label">Color primario</label>
                                    <div class="input-group colorpicker-component">
                                        <input name="color_primary" type="text" class="form-control color-input @error('color_primary') is-invalid @enderror" 
                                            id="color_primary" value="{{ old('color_primary', $business->color_primary ? $business->color_primary : '#3b7ddd') }}">
                                        <span class="input-group-text color-picker"><i class="mdi mdi-eyedropper"></i></span>
                                        @error('color_primary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="color-preview mt-2" style="background-color: {{ $business->color_primary ? $business->color_primary : '#3b7ddd' }}; height: 30px; border-radius: 4px;"></div>
                                </div>
                                
                                <div class="col-sm-4 col-lg-4">
                                    <label for="color_secondary" class="form-label">Color secundario</label>
                                    <div class="input-group colorpicker-component">
                                        <input name="color_secondary" type="text" class="form-control color-input @error('color_secondary') is-invalid @enderror" 
                                            id="color_secondary" value="{{ old('color_secondary', $business->color_secondary ? $business->color_secondary : '#6c757d') }}">
                                        <span class="input-group-text color-picker"><i class="mdi mdi-eyedropper"></i></span>
                                        @error('color_secondary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="color-preview mt-2" style="background-color: {{ $business->color_secondary ? $business->color_secondary : '#6c757d' }}; height: 30px; border-radius: 4px;"></div>
                                </div>
                                
                                <div class="col-sm-4 col-lg-4">
                                    <label for="color_accent" class="form-label">Color de acento</label>
                                    <div class="input-group colorpicker-component">
                                        <input name="color_accent" type="text" class="form-control color-input @error('color_accent') is-invalid @enderror" 
                                            id="color_accent" value="{{ old('color_accent', $business->color_accent ? $business->color_accent : '#1cbb8c') }}">
                                        <span class="input-group-text color-picker"><i class="mdi mdi-eyedropper"></i></span>
                                        @error('color_accent')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="color-preview mt-2" style="background-color: {{ $business->color_accent ? $business->color_accent : '#1cbb8c' }}; height: 30px; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-3 col-lg-2">
                            <label for="inputRfc" class="form-label">RFC</label>
                            <input name="rfc" type="text"
                                class="form-control text-uppercase @error('rfc') is-invalid @enderror" id="inputRfc" minlength="12"
                                maxlength="13" value="{{ old('rfc', $business->rfc) }}">
                            @error('rfc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-8 col-md-6 col-lg-4">
                            <label for="inputAddress" class="form-label">Dirección</label>
                            <input name="business_address" type="text"
                                class="form-control @error('business_address') is-invalid @enderror" id="inputAddress"
                                placeholder="Ej: Calle A entre B y C"
                                value="{{ old('business_address', $business->business_address) }}">
                            @error('business_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-md-3 col-lg-3">
                            <label for="inputPhone" class="form-label">Teléfono</label>
                            <input name="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror"
                                id="inputPhone" minlength="10" maxlength="15" placeholder="Ej: 9380000000"
                                value="{{ old('telephone', $business->telephone) }}">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <label for="inputEmail" class="form-label">Correo electrónico</label>
                            <input type="email" name="email" id="inputEmail"
                                class="form-control text-lowercase @error('email') is-invalid @enderror"
                                placeholder="softconnect_erp@mail.com" value="{{ old('email', $business->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-lg-4">
                            <label for="inputWeb" class="form-label">Sitio web <span
                                    class="fw-normal text-muted">(opcional)</span></label>
                            <input name="web" type="url" class="form-control @error('web') is-invalid @enderror"
                                id="inputWeb" placeholder="Ej: www.sitioweb.com" value="{{ old('web', $business->web) }}">
                            @error('web')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-md-4 col-lg-4">
                            <label for="inputBusinessLine" class="form-label">Línea de negocio</label>
                            <input type="text" name="business_line" id="inputBusinessLine"
                                class="form-control @error('business_line') is-invalid @enderror" placeholder="Ej: Restaurantes"
                                value="{{ old('business_line', $business->business_line) }}">
                            @error('business_line')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-4 col-lg-3">
                            <label for="inputCountry" class="form-label">País</label>
                            <input type="text" name="country" id="inputCountry"
                                class="form-control @error('country') is-invalid @enderror"
                                value="{{ old('country', $business->country) }}">
                            @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-4 col-lg-3">
                            <label for="inputState" class="form-label">Estado</label>
                            <input type="text" name="state" id="inputState"
                                class="form-control @error('state') is-invalid @enderror"
                                value="{{ old('state', $business->state) }}">
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-4 col-lg-3">
                            <label for="inputCity" class="form-label">Ciudad</label>
                            <input type="text" name="city" id="inputCity"
                                class="form-control @error('city') is-invalid @enderror"
                                value="{{ old('city', $business->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <label for="inputRegime" class="form-label">Régimen <span
                                    class="fw-normal text-muted">(opcional)</span></label>
                            <input type="text" name="regime" id="inputRegime"
                                class="form-control @error('regime') is-invalid @enderror"
                                value="{{ old('regime', $business->regime) }}">
                            @error('regime')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 col-md-4">
                            <label for="inputRegimensat" class="form-label">Régimen SAT <span
                                    class="fw-normal text-muted">(opcional)</span></label>
                            <input type="text" name="idregiment_sat" id="inputRegimensat"
                                class="form-control @error('idregiment_sat') is-invalid @enderror"
                                value="{{ old('idregiment_sat', $business->idregiment_sat) }}">
                            @error('idregiment_sat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Asignar Restaurantes</h4>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle mb-0" id="restaurants-table">
                            <thead>
                                <tr>
                                    <th style="width: 20px;"></th>
                                    <th>Restaurante</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="restaurants-body">
                                @foreach ($restaurants as $restaurant)
                                    <tr>
                                        <td>
                                            <div class="form-check font-size-16">
                                                <input type="checkbox" name="restaurant_ids[]" value="{{$restaurant->id}}" 
                                                    id="restaurantCheck{{$restaurant->id}}" 
                                                    {{ $business->business_restaurants->pluck('id')->contains($restaurant->id) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="restaurantCheck{{$restaurant->id}}"></label>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-group-item me-2">
                                                    <a href="javascript: void(0);" class="d-inline-block">
                                                        <img src="https://avatar.oxro.io/avatar.svg?name={{$restaurant->name}}"&caps=3&bold=true alt="" class="rounded-circle avatar-xs">
                                                    </a>
                                                </div>
                                                <h5 class="text-truncate font-size-14 m-0 ms-2"><a href="#" class="text-dark">{{$restaurant->name}}</a></h5>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $restaurant->status ? 'success' : 'danger' }}-subtle text-{{ $restaurant->status ? 'success' : 'danger' }} font-size-12">
                                                {{ $restaurant->status ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Logo de la Empresa</h4>
                    
                    <div class="image-upload-container text-center mb-4">
                        <div class="image-preview-wrapper">
                            @if($business->business_file && file_exists(public_path('assets/images/companies/' . $business->business_file)))
                                <img id="imagePreview" src="{{ asset('assets/images/companies/' . $business->business_file) }}" 
                                    alt="Logo actual" class="img-thumbnail mb-3" style="max-width: 100%; max-height: 200px;">
                            @else
                                <img id="imagePreview" src="https://via.placeholder.com/300x150?text=Subir+Logo" 
                                    alt="Previsualización" class="img-thumbnail mb-3" style="max-width: 100%; max-height: 200px;">
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="inputLogo" class="form-label">Seleccionar imagen</label>
                            <input type="file" name="business_file" accept=".jpg,.jpeg,.png,.webp" id="inputLogo"
                                class="form-control @error('business_file') is-invalid @enderror">
                            @error('business_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="image-options @if(!$business->business_file || !file_exists(public_path('assets/images/companies/' . $business->business_file))) d-none @endif">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-danger btn-sm w-100" id="removeImage">
                                        <i class="mdi mdi-delete-outline me-1"></i> Eliminar
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button type="button" class="btn btn-outline-primary btn-sm w-100" id="rotateImage">
                                        <i class="mdi mdi-rotate-right me-1"></i> Rotar
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <label for="imageQuality" class="form-label">Calidad de compresión: <span id="qualityValue">80</span>%</label>
                                <input type="range" class="form-range" id="imageQuality" min="10" max="100" value="80">
                            </div>
                            
                            <div class="mt-2">
                                <label for="imageSize" class="form-label">Tamaño máximo: <span id="sizeValue">500</span> KB</label>
                                <input type="range" class="form-range" id="imageSize" min="100" max="1000" value="500">
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning">
                            <i class="mdi mdi-content-save-outline me-1"></i> Actualizar Empresa
                        </button>
                        <a class="btn btn-outline-secondary" href="{{ route('business.index') }}">
                            <i class="mdi mdi-close-circle-outline me-1"></i> Cancelar
                        </a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
<!-- Bootstrap Color Picker CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/css/bootstrap-colorpicker.min.css">
<style>
    .colorpicker.dropdown-menu {
        z-index: 9999 !important;
    }
    .colorpicker-component .input-group-text {
        cursor: pointer;
    }
    .colorpicker-component .input-group-text i {
        pointer-events: none;
    }
    .color-preview {
        border: 1px solid #dee2e6;
    }
</style>
@endsection

@section('js')
<!-- jQuery (necesario para Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Bootstrap Color Picker JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.4.0/js/bootstrap-colorpicker.min.js"></script>

<!-- Image Compressor -->
<script src="https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.0/dist/browser-image-compression.min.js"></script>

<script>
    $(document).ready(function() {
        // Inicializar el selector de color
        $('.colorpicker-component').colorpicker({
            format: 'hex',
            colorSelectors: {
                'primary': '#3b7ddd',
                'secondary': '#6c757d',
                'success': '#1cbb8c',
                'info': '#17a2b8',
                'warning': '#fcb92c',
                'danger': '#dc3545',
                'dark': '#343a40',
                'light': '#f8f9fa'
            }
        }).on('changeColor', function(e) {
            // Actualizar vista previa de color cuando cambia
            const color = e.color.toString('hex');
            $(this).closest('.col-sm-4').find('.color-preview').css('background-color', color);
        });
        
        // Vista previa de imagen
        $('#inputLogo').change(function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    $('#imagePreview').attr('src', event.target.result);
                    $('.image-options').removeClass('d-none');
                }
                reader.readAsDataURL(file);
            }
        });
        
        // Eliminar imagen
        $('#removeImage').click(function() {
            $('#imagePreview').attr('src', 'https://via.placeholder.com/300x150?text=Subir+Logo');
            $('#inputLogo').val('');
            $('.image-options').addClass('d-none');
        });
        
        // Rotar imagen
        let rotation = 0;
        $('#rotateImage').click(function() {
            rotation += 90;
            if (rotation >= 360) rotation = 0;
            $('#imagePreview').css('transform', `rotate(${rotation}deg)`);
        });
        
        // Mostrar valores de calidad y tamaño
        $('#imageQuality').on('input', function() {
            $('#qualityValue').text($(this).val());
        });
        
        $('#imageSize').on('input', function() {
            $('#sizeValue').text($(this).val());
        });
        
        // Comprimir imagen antes de enviar el formulario
        $('#business_edit').submit(function(e) {
            const fileInput = $('#inputLogo')[0];
            if (fileInput.files && fileInput.files.length > 0) {
                e.preventDefault();
                
                const quality = parseInt($('#imageQuality').val()) / 100;
                const maxSizeMB = parseInt($('#imageSize').val()) / 1000;
                
                const options = {
                    maxSizeMB: maxSizeMB,
                    maxWidthOrHeight: 800,
                    useWebWorker: true,
                    fileType: 'image/jpeg',
                    initialQuality: quality
                };
                
                imageCompression(fileInput.files[0], options)
                    .then(compressedFile => {
                        // Crear un nuevo DataTransfer y agregar el archivo comprimido
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(compressedFile);
                        
                        // Reemplazar el archivo original con el comprimido
                        fileInput.files = dataTransfer.files;
                        
                        // Enviar el formulario
                        e.target.submit();
                    })
                    .catch(error => {
                        console.error('Error al comprimir la imagen:', error);
                        e.target.submit();
                    });
            }
        });
    });
</script>
@endsection