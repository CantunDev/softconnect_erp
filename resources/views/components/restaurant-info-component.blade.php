
<div class="row">
    <div class="col-xxl-8 col-xl-12 col-lg-12">
        <div class="card shadow-sm" style="border: 2px solid {{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc' }};
                    color: {{ !empty($restaurants->color_accent) ? $restaurants->color_accent : '#000' }};">
            <div class="card-body border-bottom" style="background-color: rgba({{ hex2rgb($restaurants->color_primary ?? '#0d6efd') }}, 0.05);">
                <div class="d-flex flex-column flex-md-row align-items-center">
                    <div class="mb-4 me-3 position-relative">
                        <img src="{{ $restaurants->restaurant_file ?? 'https://avatar.oxro.io/avatar.svg?name=' . urlencode(Auth::user()->restaurants->first()->name) }}"
                        alt="{{ $restaurants->name }} Logo"
                        class="avatar-lg rounded-circle border-3 restaurant-avatar"
                         style="border-style:solid; object-fit:cover; border-color:{{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc' ,0 }}">
                    </div>
                    <div class="text-center text-md-start">
                        <h3 class="mb-2" style="color: {{ $restaurants->color_secondary ?? '#0d6efd' }};">{{ $restaurants->name }}</h3>
                        <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                            <span class="badge py-2 px-3 rounded-pill fw-medium"
                                  style="background-color: rgba({{ hex2rgb($restaurants->color_primary ?? '#0d6efd') }}, 0.1); color: {{ $restaurants->color_primary ?? '#0d6efd' }};">
                                <i class="bi bi-building me-1"></i>{{ $restaurants->business->name }}
                            </span>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary py-2 px-3 rounded-pill fw-medium text-uppercase">
                                <i class="bi bi-calendar me-1"></i>{{ $monthName }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Contenido principal (se mantiene igual) -->
            {{-- <div class="card-body border-bottom">
                <!-- Tu contenido aquí -->
            </div> --}}
            
            <!-- Footer opcional con colores -->
            {{-- <div class="card-footer bg-transparent d-flex justify-content-end py-3 border-top-0">
                <button class="btn btn-sm me-2" 
                        style="background-color: {{ $restaurant->color_primary ?? '#0d6efd' }}; color: {{ $restaurant->color_accent ?? '#ffffff' }}">
                    <i class="bi bi-printer me-1"></i> Imprimir
                </button>
                <button class="btn btn-sm btn-outline-custom" 
                        style="border-color: {{ $restaurant->color_primary ?? '#0d6efd' }}; color: {{ $restaurant->color_primary ?? '#0d6efd' }}">
                    <i class="bi bi-share me-1"></i> Compartir
                </button>
            </div> --}}
        </div>
    </div>
</div>