@props(['restaurants'])

@if ($restaurants->isNotEmpty())
    <li class="menu-title">Restaurantes</li>

    @foreach ($restaurants as $rest)
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-dish"></i>
                <span>{{ $rest->name }}</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="bx bx-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('read_monthly_projections')
                    <li>
                        <a href="{{ route('restaurante.home.index', $rest->slug) }}">
                            <i class="bx bx-calendar"></i>
                            <span>Mensual</span>
                        </a>
                    </li>
                @endcan
                <li>
                    <a href="{{ route('restaurante.cash_movements.index', $rest->slug) }}">
                        <i class="bx bx-calendar"></i>
                        <span>Movts Caja</span>
                    </a>
                </li>
                @can('read_weekly_projections')
                    <li>
                        <a href="{{ route('restaurante.home.index', $rest->slug) }}">
                            <i class="bx bx-calendar"></i>
                            <span>Mensual</span>
                        </a>
                    </li>
                @endcan
                @can('read_annual_projections')
                    <li>
                        <a href="{{ route('restaurante.home.index', $rest->slug) }}">
                            <i class="bx bx-calendar"></i>
                            <span>Mensual</span>
                        </a>
                    </li>
                @endcan

                @can('read_providers')
                    <li>
                        <a href="{{ route('restaurants.providers.index', ['restaurants' => $rest->slug]) }}">
                            <i class="bx bx-cart"></i>
                            <span>Proveedores</span>
                        </a>
                    </li>
                @endcan

                @can('read_invoices')
                    <li>
                        <a href="{{ route('restaurants.invoices.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}"
                            class="waves-effect">
                            <i class="bx bx-receipt"></i>
                            <span>Facturas</span>
                        </a>
                    </li>
                    <x-left-sidebar.partials.operations-menu business="rest" :restaurant="$rest->slug" />
                @endcan
            </ul>
        </li>
    @endforeach
@endif
