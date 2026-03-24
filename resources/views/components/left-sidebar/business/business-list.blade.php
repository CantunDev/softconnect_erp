@props(['business', 'restaurants'])

@if ($business->isNotEmpty())
    <li class="menu-title">Empresas</li>

    @foreach ($business as $bs)
        <li>
            <a href="javascript: void(0);" class="has-arrow waves-effect">
                <i class="bx bx-circle"></i>
                <span>{{ $bs->name }}</span>
            </a>
            <ul>
                <li>
                    <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                        <i class="bx bx-hive"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('read_projections')
                    <li>
                        <a href="{{ route('business.projections.index', ['business' => $bs->slug]) }}">
                            <i class="bx bx-line-chart"></i>
                            <span>Proyecciones</span>
                        </a>
                    </li>
                @endcan
                @can('read_weekly_projections')
                    <li>
                        <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                            <i class="bx bx-grid-vertical"></i>
                            <span>Semanal</span>
                        </a>
                    </li>
                @endcan
                @can('read_annual_projections')
                    <li>
                        <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                            <i class="bx bx-stats"></i>
                            <span>Anual</span>
                        </a>
                    </li>
                @endcan

                @foreach ($restaurants as $rest)
                    <x-left-sidebar.partials.restaurant-item :businessSlug="$bs->slug" :restaurant="$rest" />
                @endforeach
            </ul>
        </li>
    @endforeach
@endif
