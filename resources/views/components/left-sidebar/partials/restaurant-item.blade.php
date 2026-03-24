@props(['businessSlug', 'restaurant'])

<li>
    <a href="javascript: void(0);" class="has-arrow waves-effect">
        <i class="bx bx-dish"></i>
        <span>{{ $restaurant->name }}</span>
    </a>
    <ul>
        <li>
            <a
                href="{{ route('business.restaurants.home.index', ['business' => $businessSlug, 'restaurants' => $restaurant->slug]) }}">
                <i class="mdi mdi-room-service"></i>
                <span>Inicio</span>
            </a>
        </li>
        <li>
            <a
                href="{{ route('business.restaurants.cash_movements.index', ['business' => $businessSlug, 'restaurants' => $restaurant->slug]) }}">
                <i class="bx bx-calendar"></i>
                <span>Movts Caja</span>
            </a>
        </li>
        @can('read_projections')
            <li>
                <a
                    href="{{ route('business.restaurants.projections.index', ['business' => $businessSlug, 'restaurants' => $restaurant->slug]) }}">
                    <i class="bx bx-line-chart"></i>
                    <span>Proyecciones</span>
                </a>
            </li>
        @endcan
        @can('read_weekly_projections')
            <li>
                <a href="#">
                    <i class="bx bx-grid-vertical"></i>
                    <span>Semanal</span>
                </a>
            </li>
        @endcan
        @can('read_annual_projections')
            <li>
                <a href="#">
                    <i class="bx bx-stats"></i>
                    <span>Anual</span>
                </a>
            </li>
        @endcan
        @can('read_break_even_point')
            <li>
                <a href="#">
                    <i class="bx bx-stats"></i>
                    <span>Punto Equilibrio</span>
                </a>
            </li>
        @endcan
        @can('read_providers')
            <li>
                <a
                    href="{{ route('business.restaurants.providers.index', ['business' => $businessSlug, 'restaurants' => $restaurant->slug]) }}">
                    <i class="bx bx-cart"></i>
                    <span>Proveedores</span>
                </a>
            </li>
        @endcan

        @can('read_invoices')
            <li>
                <a href="{{ route('business.restaurants.invoices.index', ['business' => $businessSlug, 'restaurants' => $restaurant->slug]) }}"
                    class="waves-effect">
                    <i class="bx bx-receipt"></i>
                    <span>Facturas</span>
                </a>
            </li>
            <x-left-sidebar.partials.operations-menu :business="$businessSlug" :restaurant="$restaurant->slug" />
        @endcan
    </ul>
</li>
