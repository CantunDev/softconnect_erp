@extends('layouts.master')
@section('title')
    Nueva Empresa |
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Nueva Empresa
        @endslot
        @slot('bcPrevText')
            Empresas
        @endslot
        @slot('bcPrevLink')
            {{ route('business.index') }}
        @endslot
        @slot('bcActiveText')
            Nueva empresa
        @endslot
    @endcomponent

<form action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Información del Negocio</h4>
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <h5 class="text-primary mb-3"><i class="mdi mdi-domain me-1"></i> Identidad y Fiscal</h5>
                            </div>

                            <div class="col-md-6">
                                <label for="inputName" class="form-label">Nombre corto (Comercial)</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="inputName" placeholder="Ej: Empresa Demo" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="inputBusinessName" class="form-label">Razón Social (Oficial)</label>
                                <input name="business_name" type="text"
                                    class="form-control @error('business_name') is-invalid @enderror" id="inputBusinessName"
                                    placeholder="Ej: Empresa Demo SA de CV" value="{{ old('business_name') }}">
                                @error('business_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputRfc" class="form-label">RFC</label>
                                <input name="rfc" type="text"
                                    class="form-control text-uppercase @error('rfc') is-invalid @enderror" id="inputRfc"
                                    minlength="12" maxlength="13" value="{{ old('rfc') }}">
                                @error('rfc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputBusinessLine" class="form-label">Giro / Línea de negocio</label>
                                <input type="text" name="business_line" id="inputBusinessLine"
                                    class="form-control @error('business_line') is-invalid @enderror" placeholder="Ej: Restaurantes"
                                    value="{{ old('business_line') }}">
                                @error('business_line')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputRegimensat" class="form-label">Régimen SAT <small
                                        class="text-muted">(Opcional)</small></label>
                                <input type="text" name="idregiment_sat" id="inputRegimensat"
                                    class="form-control @error('idregiment_sat') is-invalid @enderror"
                                    value="{{ old('idregiment_sat') }}">
                                @error('idregiment_sat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <hr class="text-muted">
                                <h5 class="text-primary mb-3"><i class="mdi mdi-map-marker-radius me-1"></i> Ubicación y Contacto</h5>
                            </div>

                            <div class="col-12">
                                <label for="inputAddress" class="form-label">Calle y Número</label>
                                <input name="business_address" type="text"
                                    class="form-control @error('business_address') is-invalid @enderror" id="inputAddress"
                                    placeholder="Ej: Calle Reforma #123, Col. Centro" value="{{ old('business_address') }}">
                                @error('business_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputCountry" class="form-label">País</label>
                                <input type="text" name="country" id="inputCountry"
                                    class="form-control @error('country') is-invalid @enderror" value="{{ old('country', 'México') }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputState" class="form-label">Estado</label>
                                <input type="text" name="state" id="inputState"
                                    class="form-control @error('state') is-invalid @enderror" value="{{ old('state') }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputCity" class="form-label">Ciudad</label>
                                <input type="text" name="city" id="inputCity"
                                    class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputPhone" class="form-label">Teléfono</label>
                                <input name="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror"
                                    id="inputPhone" value="{{ old('telephone') }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputEmail" class="form-label">Correo electrónico</label>
                                <input type="email" name="email" id="inputEmail"
                                    class="form-control text-lowercase @error('email') is-invalid @enderror"
                                    placeholder="correo@ejemplo.com" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="inputWeb" class="form-label">Sitio web <small class="text-muted">(Opcional)</small></label>
                                <input name="web" type="url" class="form-control @error('web') is-invalid @enderror"
                                    id="inputWeb" placeholder="https://" value="{{ old('web') }}">
                                @error('web')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <hr class="text-muted">
                                <h5 class="text-primary mb-3"><i class="mdi mdi-palette me-1"></i> Personalización</h5>
                            </div>

                            <div class="col-md-4">
                                <label for="color_primary" class="form-label">Color primario</label>
                                <div class="input-group colorpicker-component">
                                    <input class="form-control form-control-color w-100" type="color"
                                        value="{{ old('color_primary', '#556ee6') }}" id="color_primary" name="color_primary">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="color_secondary" class="form-label">Color secundario</label>
                                <div class="input-group colorpicker-component">
                                    <input class="form-control form-control-color w-100" type="color"
                                        value="{{ old('color_secondary', '#34c38f') }}" id="color_secondary" name="color_secondary">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="color_accent" class="form-label">Color de acento</label>
                                <div class="input-group colorpicker-component">
                                    <input class="form-control form-control-color w-100" type="color"
                                        value="{{ old('color_accent', '#f1b44c') }}" id="color_accent" name="color_accent">
                                </div>
                            </div>
                        </div> </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Nuevo Logo de la Empresa</h4>
                        <div class="image-upload-container text-center mb-4">
                            <div class="image-preview-wrapper">
                                <img id="imagePreview" src="https://via.placeholder.com/300x150?text=Subir+Logo"
                                    alt="Previsualización" class="img-thumbnail mb-3"
                                    style="max-width: 100%; max-height: 200px;">
                            </div>

                            <div class="mb-3">
                                <label for="inputLogo" class="form-label">Seleccionar imagen</label>
                                <input type="file" name="business_file" accept=".jpg,.jpeg,.png,.webp"
                                    id="inputLogo" class="form-control @error('business_file') is-invalid @enderror">
                                @error('business_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="image-options d-none">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100" id="removeImage">
                                    <i class="mdi mdi-delete-outline me-1"></i> Quitar imagen
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-plus-circle-outline me-1"></i> Crear Empresa
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('business.index') }}">
                        <i class="mdi mdi-close-circle-outline me-1"></i> Cancelar
                    </a>
                </div>
            </div>
        </div> 
    </form>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    
    <script>
        
        const colorThief = new ColorThief();
        const rgbToHex = (r, g, b) => '#' + [r, g, b].map(x => {
            const hex = x.toString(16);
            return hex.length === 1 ? '0' + hex : hex;
        }).join('');

        const imgPreview = document.getElementById('imagePreview');
        const originalImageSrc = imgPreview.src; 

        document.getElementById('inputLogo').onchange = function(evt) {
            const file = evt.target.files[0];

            if (file) {
                const objectUrl = URL.createObjectURL(file);
                imgPreview.src = objectUrl;

                const options = document.querySelector('.image-options');
                if (options) options.classList.remove('d-none');

                imgPreview.onload = function() {
                    try {
                        const palette = colorThief.getPalette(imgPreview, 5);

                        if (palette) {

                            if (palette[0]) document.getElementById('color_primary').value = rgbToHex(...palette[0]);
                            if (palette[1]) document.getElementById('color_secondary').value = rgbToHex(...palette[1]);
                            
                            if (palette[2]) {
                                document.getElementById('color_accent').value = rgbToHex(...palette[2]);
                            } else {
                                document.getElementById('color_accent').value = rgbToHex(...palette[0]);
                            }
                        }
                    } catch (e) {
                        console.log("Error extrayendo colores:", e);
                    }
                };
            }
        };

        document.getElementById('removeImage')?.addEventListener('click', function() {
           
            document.getElementById('inputLogo').value = "";
            imgPreview.src = originalImageSrc;
            
            const options = document.querySelector('.image-options');
            if (options) options.classList.add('d-none');
            
            // document.getElementById('color_primary').value = "#556ee6";
            // document.getElementById('color_secondary').value = "#34c38f";
            // document.getElementById('color_accent').value = "#f1b44c";
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Verificamos si Laravel devolvió errores de validación
    @if ($errors->any())
        let htmlErrors = '<ul>';
        @foreach ($errors->all() as $error)
            htmlErrors += '<li style="text-align:left;">{{ $error }}</li>';
        @endforeach
        htmlErrors += '</ul>';

        Swal.fire({
            icon: 'error',
            title: '¡Ups! Hay errores',
            html: htmlErrors, // Mostramos la lista de errores
            confirmButtonColor: '#556ee6'
        });
    @endif

    // Script para mostrar mensaje de éxito (flash message)
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session("success") }}',
            confirmButtonColor: '#556ee6',
            timer: 3000
        });
    @endif
</script>
@endsection