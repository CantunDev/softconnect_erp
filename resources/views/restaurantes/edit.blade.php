@extends('layouts.master')

@section('title')
    Actualizar Restaurante
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('title')
            Actualizar Restaurante
        @endslot
        @slot('bcPrevText')
            Restaurante
        @endslot
        @slot('bcPrevLink')
            {{ route('restaurants.index') }}
        @endslot
        @slot('bcActiveText')
            Editar Restaurante
        @endslot
    @endcomponent

    <form action="{{ route('restaurants.update', $restaurant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-sm-6 col-lg-3">
                                <label for="inputName" class="form-label">Nombre</label>
                                <input name="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="inputName" value="{{ old('name', $restaurant->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-4 col-lg-3">
                                <label for="color_primary" class="form-label">Color primario</label>
                                <input name="color_primary" type="color"
                                    class="form-control @error('color_primary') is-invalid @enderror" id="color_primary"
                                    value="{{ old('color_primary', $restaurant->color_primary) }}">
                                @error('color_primary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-4 col-lg-3">
                                <label for="color_secondary" class="form-label">Color secundario</label>
                                <input name="color_secondary" type="color"
                                    class="form-control @error('color_secondary') is-invalid @enderror" id="color_secondary"
                                    value="{{ old('color_secondary', $restaurant->color_secondary) }}">
                                @error('color_secondary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6 col-lg-3">
                                <label for="color_accent" class="form-label">Color de Acento</label>
                                <input name="color_accent" type="color"
                                    class="form-control @error('color_accent') is-invalid @enderror" id="color_accent"
                                    value="{{ old('color_accent', $restaurant->color_accent) }}">
                                @error('color_accent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-8 col-lg-8">
                                <label for="inputDescription" class="form-label">Descripcion</label>
                                <input name="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" id="inputDescription"
                                    value="{{ old('description', $restaurant->description) }}">
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6 col-md-3 col-lg-4">
                                <label for="inputIp" class="form-label">Vpn Ip</label>
                                <input name="ip" type="text"
                                    class="form-control text-uppercase @error('ip') is-invalid @enderror" id="inputIp"
                                    value="{{ old('ip', $restaurant->ip) }}">
                                @error('ip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6 col-md-4">
                                <label for="inputDatabase" class="form-label">Base de Datos</label>
                                <input type="text" name="database" id="inputDatabase"
                                    class="form-control @error('database') is-invalid @enderror"
                                    value="{{ old('database', $restaurant->database) }}">
                                @error('database')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Logo del restaurante</h4>
                        <div class="image-upload-container text-center mb-4">
                            <div class="image-preview-wrapper">
                            @php
                                $filename = $restaurant->restaurant_file;
                                $filename = ltrim($filename, '/');
                                $fullPath = public_path($filename);
                                $fileExists = file_exists($fullPath);
                            @endphp

                            @if ($filename && $fileExists)
                                <img id="imagePreview"
                                    src="{{ asset($filename) }}"
                                    alt="Imagen del Restaurante" class="img-thumbnail mb-3"
                                    style="max-width: 100%; max-height: 200px;">
                            @else
                                <img id="imagePreview" 
                                    src="https://via.placeholder.com/300x150?text=Subir+Imagen"
                                    alt="Previsualización" class="img-thumbnail mb-3"
                                    style="max-width: 100%; max-height: 200px;">
                            @endif
                        </div>

                            <div class="mb-3">
                                <label for="inputLogo" class="form-label">Cambiar imagen</label>
                                <input type="file" name="restaurant_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                                    class="form-control @error('restaurant_file') is-invalid @enderror">
                                @error('restaurant_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="image-options d-none">
                                <button type="button" class="btn btn-outline-danger btn-sm w-100" id="removeImage">
                                    <i class="mdi mdi-refresh me-1"></i> Restaurar original
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-warning"> 
                        <i class="mdi mdi-content-save-edit-outline me-1"></i> Actualizar Restaurante
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('restaurants.index') }}">
                        <i class="mdi mdi-close-circle-outline me-1"></i> Cancelar
                    </a>
                </div>
            </div> 
            {{-- Fin Col-lg-4 --}}
        </div> 
        {{-- Fin Row Principal --}}
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
                        // Extraer colores automáticamente al subir una imagen nueva
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
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if ($errors->any())
            let htmlErrors = '<ul>';
            @foreach ($errors->all() as $error)
                htmlErrors += '<li style="text-align:left;">{{ $error }}</li>';
            @endforeach
            htmlErrors += '</ul>';

            Swal.fire({
                icon: 'error',
                title: '¡Ups! Hay errores',
                html: htmlErrors,
                confirmButtonColor: '#556ee6'
            });
        @endif

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: '{{ session("success") }}',
                confirmButtonColor: '#556ee6',
                timer: 3000
            });
        @endif
    </script>
@endsection