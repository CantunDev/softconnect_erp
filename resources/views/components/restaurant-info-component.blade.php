@php
    // Función helper para convertir hex a rgb (opcional)
    function hex2rgb($hex)
    {
        $hex = str_replace('#', '', $hex);
        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return "$r, $g, $b";
    }
@endphp
<div class="row">
    <div class="col-xxl-12 col-xl-12 col-lg-12">
        <div class="card shadow-sm"
            style="border: 2px solid {{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc' }};
                    color: {{ !empty($restaurants->color_accent) ? $restaurants->color_accent : '#000' }};">
            <div class="card-body border-bottom"
                style="background-color: rgba({{ hex2rgb($restaurants->color_primary ?? '#0d6efd') }}, 0.05);">
                <div class="row">
                    <div class="col-md-3 col-xl-3">
                        <div class="text-center mt-2 mb-2 position-relative">
                            <div class="position-absolute w-100 h-100" style="top: 0; left: 0; z-index: 0; opacity: 0.3;">
                                <div class="row text-center h-100 align-items-center">
                                    <div class="col-12">
                                        <img src="" alt=""
                                            class="img-fluid" style="max-height: 100px;">
                                    </div>
                                </div>
                            </div>
                            <div class="position-relative" style="z-index: 1;">

                                <img src="https://avatar.oxro.io/avatar.svg?name={{ $restaurants->name }}"
                                    alt=""  class="avatar-lg rounded-circle border-3 restaurant-avatar"
                                    style="border-style:solid; object-fit:cover; border-color:{{ !empty($restaurants->color_primary) ? $restaurants->color_primary : '#ccc', 0 }}">
                                <div class="text-muted">
                                    <h5 id="greeting-text" class="mb-1">{{ $restaurants->name }}</h5>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="col-xl-8">
                        <div class="row text-center">
                            <div class="col-xl-3">
                                <div class="mt-3">
                                    <p class="text-muted mb-1">INICIO MES</p>
                                    <h5>{{ $startOfMonth }}</h5>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted mb-1">TERMINO MES</p>
                                    <h5>{{ $endOfMonth }}</h5>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="mt-3">
                                    <p class="text-muted mb-1">MES</p>
                                    <h5 class="text-uppercase">{{ $month }} </h5>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted mb-1">TOTAL DIAS</p>
                                    <h5>{{ $daysInMonth }} </h5>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="mt-3">
                                    <p class="text-muted mb-1">DIAS</p>
                                    <h5>{{ $daysPass }} </h5>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted mb-1">% ALCANCE</p>
                                    <h5 class="percentage">{{ $rangeMonth }}</h5>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="col mt-2 mb-2">
                                  
                                </div>
                            </div>

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
