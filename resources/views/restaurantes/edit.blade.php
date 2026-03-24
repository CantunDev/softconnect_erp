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
            {{ route('config.restaurants.index') }}
        @endslot
        @slot('bcActiveText')
            Editar Restaurante
        @endslot
    @endcomponent

    @include('restaurantes._form', [
        'restaurant' => $restaurant,
        'method' => 'PUT',
        'btnText' => 'Actualizar',
        'action' => route('config.restaurants.update', $restaurant->id),
        'labelText' => 'Actualizar Restaurante',
    ])
@endsection

@section('css')
    <style>
        #map {
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .checker-fields {
            transition: all 0.3s ease;
        }
    </style>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.0/color-thief.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Incluir Google Maps API con tu API key --}}
    <div id="map" style="height: 500px; width: 100%;"></div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
        // 1. Obtener valores iniciales de los inputs de Laravel
        let latInput = document.getElementById('latitude');
        let lngInput = document.getElementById('longitude');

        let initialLat = parseFloat(latInput.value) || 19.4326;
        let initialLng = parseFloat(lngInput.value) || -99.1332;

        // 2. Inicializar Mapa
        const map = L.map('map').setView([initialLat, initialLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        // 3. Marcador
        const marker = L.marker([initialLat, initialLng], {
        draggable: true
        }).addTo(map);

        // 4. Configurar el Buscador (Geocoder)
        const geocoderControl = L.Control.geocoder({
        defaultMarkGeocode: false,
        placeholder: "Buscar dirección...",
        errorMessage: "No se encontró la ubicación"
        })
        .on('markgeocode', function(e) {
        const latlng = e.geocode.center;
        map.setView(latlng, 17);
        marker.setLatLng(latlng);
        fillForm(e.geocode);
        })
        .addTo(map);

        // 5. Función para llenar el formulario
        function fillForm(data) {
        console.log("Datos recibidos:", data); // Para depuración
        const addr = data.properties.address || {};

        // Coordenadas
        latInput.value = data.center.lat.toFixed(6);
        lngInput.value = data.center.lng.toFixed(6);

        // Campos de dirección (usamos OR para capturar distintos nombres que devuelve la API)
        document.getElementById('address').value = (addr.road || addr.pedestrian || addr.suburb || '') +
        ' ' + (addr.house_number || '');
        document.getElementById('city').value = addr.city || addr.town || addr.village || addr
        .municipality || '';
        document.getElementById('state').value = addr.state || '';
        document.getElementById('postal_code').value = addr.postcode || '';
        document.getElementById('country').value = addr.country || 'México';
        }

        // 6. Función Reverse Geocoding (cuando mueves el marcador)
        const geocoderService = L.Control.Geocoder.nominatim();

        function updateByCoords(latlng) {
        geocoderService.reverse(latlng, map.options.crs.scale(map.getZoom()), function(results) {
        if (results && results.length > 0) {
        fillForm(results[0]);
        }
        });
        }

        // Eventos de movimiento
        marker.on('dragend', function() {
        updateByCoords(marker.getLatLng());
        });

        map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        updateByCoords(e.latlng);
        });

        // Botón "Mi ubicación actual"
        const btnLocation = document.getElementById('getCurrentLocation');
        if (btnLocation) {
        btnLocation.addEventListener('click', function() {
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
        const coords = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
        };
        map.setView(coords, 17);
        marker.setLatLng(coords);
        updateByCoords(coords);
        });
        }
        });
        }
        });
        </script>
        <script>
            // Configuración de ColorThief
            const colorThief = new ColorThief();
            const rgbToHex = (r, g, b) => '#' + [r, g, b].map(x => {
                const hex = x.toString(16);
                return hex.length === 1 ? '0' + hex : hex;
            }).join('');

            // Previsualización de imagen y extracción de colores
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
                                if (palette[0]) document.getElementById('color_primary').value = rgbToHex(...palette[
                                    0]);
                                if (palette[1]) document.getElementById('color_secondary').value = rgbToHex(...palette[
                                    1]);
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

            // Quitar imagen
            document.getElementById('removeImage')?.addEventListener('click', function() {
                document.getElementById('inputLogo').value = "";
                imgPreview.src = originalImageSrc;
                const options = document.querySelector('.image-options');
                if (options) options.classList.add('d-none');
            });

            // ============================================
            // FUNCIONALIDAD DEL MAPA
            // ============================================
            let map;
            let marker;
            let geocoder;
            let autocomplete;

            // Coordenadas por defecto (centro de México)
            const defaultLat = {{ old('latitude', 19.432608) }};
            const defaultLng = {{ old('longitude', -99.133209) }};

            function initMap() {
                geocoder = new google.maps.Geocoder();

                const mapOptions = {
                    center: {
                        lat: defaultLat,
                        lng: defaultLng
                    },
                    zoom: 15,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    mapTypeControl: true,
                    streetViewControl: true,
                    fullscreenControl: true
                };

                map = new google.maps.Map(document.getElementById('map'), mapOptions);

                // Si hay coordenadas guardadas, colocar marcador
                if (defaultLat && defaultLng && defaultLat != 0 && defaultLng != 0) {
                    placeMarker({
                        lat: defaultLat,
                        lng: defaultLng
                    });
                }

                // Evento click en el mapa
                map.addListener('click', function(event) {
                    placeMarker(event.latLng);
                    getAddressFromCoords(event.latLng);
                });

                // Autocompletado de direcciones
                const input = document.getElementById('address_search');
                autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);

                autocomplete.addListener('place_changed', function() {
                    const place = autocomplete.getPlace();
                    if (!place.geometry) return;

                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }

                    placeMarker(place.geometry.location);
                    fillAddressFields(place);
                });
            }

            // Colocar marcador
            function placeMarker(location) {
                if (marker) {
                    marker.setMap(null);
                }

                marker = new google.maps.Marker({
                    position: location,
                    map: map,
                    draggable: true,
                    animation: google.maps.Animation.DROP
                });

                // Actualizar coordenadas
                $('#latitude').val(location.lat());
                $('#longitude').val(location.lng());

                // Evento al arrastrar el marcador
                marker.addListener('dragend', function() {
                    const position = marker.getPosition();
                    $('#latitude').val(position.lat());
                    $('#longitude').val(position.lng());
                    getAddressFromCoords(position);
                });
            }

            // Obtener dirección a partir de coordenadas
            function getAddressFromCoords(location) {
                geocoder.geocode({
                    location: location
                }, function(results, status) {
                    if (status === 'OK' && results[0]) {
                        fillAddressFields(results[0]);
                    }
                });
            }

            // Llenar campos de dirección
            function fillAddressFields(place) {
                let address = place.formatted_address || place.name || '';
                let city = '';
                let state = '';
                let country = '';
                let postalCode = '';

                // Extraer componentes de la dirección
                if (place.address_components) {
                    for (const component of place.address_components) {
                        if (component.types.includes('locality')) {
                            city = component.long_name;
                        }
                        if (component.types.includes('administrative_area_level_1')) {
                            state = component.long_name;
                        }
                        if (component.types.includes('country')) {
                            country = component.long_name;
                        }
                        if (component.types.includes('postal_code')) {
                            postalCode = component.long_name;
                        }
                    }
                }

                $('#address').val(address);
                $('#city').val(city);
                $('#state').val(state);
                $('#country').val(country);
                $('#postal_code').val(postalCode);
                $('#address_search').val(address);
            }

            // ============================================
            // FUNCIONALIDAD DEL CHECKBOX DEL CHECADOR
            // ============================================
            $('#timeclock_active').change(function() {
                if (this.checked) {
                    $('#checkerFields').slideDown();
                } else {
                    $('#checkerFields').slideUp();
                }
            });

            // ============================================
            // EVENTOS DE BOTONES
            // ============================================

            // Buscar dirección manualmente
            $('#searchAddress').click(function() {
                const address = $('#address_search').val();
                if (address) {
                    geocoder.geocode({
                        address: address
                    }, function(results, status) {
                        if (status === 'OK' && results[0]) {
                            map.setCenter(results[0].geometry.location);
                            map.setZoom(17);
                            placeMarker(results[0].geometry.location);
                            fillAddressFields(results[0]);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se encontró la dirección'
                            });
                        }
                    });
                }
            });

            // Obtener ubicación actual
            document.getElementById('getCurrentLocation')?.addEventListener('click', function() {
                if (navigator.geolocation) {
                    Swal.fire({
                        title: 'Obteniendo ubicación...',
                        text: 'Por favor espera mientras obtenemos tu ubicación',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            const location = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude
                            };

                            map.setCenter(location);
                            map.setZoom(17);
                            placeMarker(location);
                            getAddressFromCoords(location);

                            Swal.close();
                        },
                        function(error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo obtener tu ubicación: ' + error.message
                            });
                        }
                    );
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Tu navegador no soporta geolocalización'
                    });
                }
            });

            // Resetear mapa
            $('#resetMap').click(function() {
                map.setCenter({
                    lat: defaultLat,
                    lng: defaultLng
                });
                map.setZoom(15);
                if (marker) {
                    marker.setMap(null);
                    marker = null;
                }
                $('#latitude').val('');
                $('#longitude').val('');
            });

            // Mostrar/ocultar contraseña del reloj checador
            document.getElementById('togglePassword')?.addEventListener('click', function() {
                const passwordInput = document.getElementById('timeclock_password');
                const icon = this.querySelector('i');

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('mdi-eye');
                    icon.classList.add('mdi-eye-off');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('mdi-eye-off');
                    icon.classList.add('mdi-eye');
                }
            });

            // Validación del formulario
            $('#restaurantForm').submit(function(e) {
                const hasChecker = $('#timeclock_active').is(':checked');

                if (hasChecker) {
                    const checkerIp = $('#timeclock_host').val();

                    if (!checkerIp) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Por favor, ingresa la IP del checador'
                        });
                        return false;
                    }

                    // Validar formato de IP
                    const ipPattern =
                        /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;
                    if (!ipPattern.test(checkerIp)) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Por favor, ingresa una IP válida'
                        });
                        return false;
                    }
                }
            });

            // Inicializar mapa cuando la página esté lista
            $(document).ready(function() {
                initMap();
            });

            // Validación de errores
            @if ($errors->any())
                let htmlErrors = '<ul style="text-align:left;">';
                @foreach ($errors->all() as $error)
                    htmlErrors += '<li>{{ $error }}</li>';
                @endforeach
                htmlErrors += '</ul>';
                Swal.fire({
                    icon: 'error',
                    title: '¡Ups! Hay errores en el formulario',
                    html: htmlErrors,
                    confirmButtonColor: '#556ee6'
                });
            @endif

            // Mensajes de éxito
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#556ee6',
                    timer: 3000
                });
            @endif
        </script>
    @endsection
