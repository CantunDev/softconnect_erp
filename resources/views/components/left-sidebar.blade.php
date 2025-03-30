@props(['business', 'restaurantsWithBusiness', 'restaurantsWithoutBusiness'])
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                @role('Super-Admin')
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="bx bx-cog"></i>
                            <span key="t-projects">Configuraciones</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            @can('read_business')
                                <li>
                                    <a href="{{ route('business.index') }}" key="t-p-grid">
                                        <i class="bx bx-building-house"></i>
                                        <span>Empresas</span>
                                    </a>
                                </li>
                            @endcan
                            @can('read_restaurants')
                                <li>
                                    <a href="{{ route('restaurants.index') }}" key="t-p-list">
                                        <i class="bx bx-restaurant "></i>
                                        <span>Restaurantes</span>
                                    </a>
                                </li>
                            @endcan
                            @can('read_users')
                                <li>
                                    <a href="{{ route('users.index') }}" key="t-p-overview">
                                        <i class="bx bx-user"></i>
                                        <span>Usuarios</span>
                                    </a>
                                </li>
                            @endcan
                            @can('read_roles')
                                <li>
                                    <a href="{{ route('roles_permissions.index') }}" key="t-create-new">
                                        <i class="bx bx-shield"></i>
                                        <span>Roles/Permisos</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endrole
                <!-- Sección para Super Admin (todos los restaurantes) -->
                @if (Auth::user()->hasRole('Super-Admin'))
                    <li class="menu-title" key="t-menu">Todos</li>
                    @foreach ($business as $i => $bs)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-circle"></i>
                                <span key="t-{{ $bs->id }}">{{ $bs->name }}</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-hive"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.projections.index', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-line-chart"></i>
                                        <span>Proyecciones</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-grid-vertical"></i>
                                        <span>Semanal</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dashboard', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-stats"></i>
                                        <span>Anual</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('users.index') }}" key="r-a-{{ $bs->id }}">
                                        <i class="bx bx-git-compare"></i>
                                        <span>Comparativo</span>
                                    </a>
                                </li> --}}

                                @if ($bs->restaurants->isNotEmpty())
                                    @foreach ($bs->restaurants as $j => $rest)
                                        <li>
                                            <a href="javascript: void(0);" key="t-{{ $rest->id }}"
                                                class="has-arrow waves-effect">
                                                <i class="bx bx-dish"></i>
                                                <span>{{ $rest->name }}</span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a
                                                        href="{{ route('business.restaurants.home.index', ['business' => $bs->slug, 'restaurants' => $rest->slug]) }}">
                                                        <i class="mdi mdi-room-service"></i>
                                                        <span key="t-chat">Inicio</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-a-{{ $bs->id }}">
                                                        <i class="bx bx-calculator"></i>
                                                        <span>Caja</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-s-{{ $bs->id }}">
                                                        <i class="bx bx-grid-vertical"></i>
                                                        <span>Semanal</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-a-{{ $bs->id }}">
                                                        <i class="bx bx-stats"></i>
                                                        <span>Anual</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-a-{{ $bs->id }}">
                                                        <i class="bx bx-stats"></i>
                                                        <span>Punto Equilibrio</span>
                                                    </a>
                                                </li>
                                                @can('read_providers')
                                                    <li>
                                                        <a
                                                            href="{{ route('business.restaurants.providers.index', ['business' => $bs->slug, 'restaurants' => $rest->slug]) }}">
                                                            <i class="bx bx-cart"></i>
                                                            <span key="t-chat">Proveedores</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('read_invoices')
                                                    <li>
                                                        <a href="{{ route('business.restaurants.invoices.index', ['business' => $bs->id, 'restaurants' => $rest->slug]) }}"
                                                            class="waves-effect">
                                                            <i class="bx bx-receipt"></i>
                                                            <span key="t-chat">Facturas</span>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                                            <i class="bx bx-money"></i>
                                                            <span key="t-projects">Operaciones</span>
                                                        </a>
                                                        <ul class="sub-menu" aria-expanded="false">
                                                            <li>
                                                                <a href="{{ route('business.restaurants.payment_method.index', ['business' => $bs->slug, 'restaurants' => $rest->slug]) }}"
                                                                    key="t-p-grid">
                                                                    <span key="t-chat">Metodos de pago</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('business.restaurants.expenses_categories.index', ['business' => $bs->slug, 'restaurants' =>  $rest->slug]) }}"
                                                                    key="t-p-list">
                                                                    <span key="t-chat">Tipo gastos</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('business.restaurants.expenses.index', ['business' => $bs->slug, 'restaurants' => $rest->slug]) }}"
                                                                    key="t-p-overview">
                                                                    <span key="t-chat">Gastos</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                        </li>
                    @endforeach
                    <li class="menu-title" key="t-menu">Restaurantes</li>
                    @foreach ($restaurantsWithoutBusiness as $i => $rest)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-dish"></i>
                                <span key="t-projects">{{ $rest->name }}</span>
                            </a>
                            <ul>
                                <li>
                                    <a
                                        href="{{ route('business.restaurants.home.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}">
                                        <i class="mdi mdi-room-service"></i>
                                        <span key="t-chat">Inicio</span>
                                    </a>
                                </li>
                                @can('read_providers')
                                    <li>
                                        <a
                                            href="{{ route('business.restaurants.providers.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}">
                                            <i class="bx bx-cart"></i>
                                            <span key="t-chat">Proveedores</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('read_invoices')
                                    <li>
                                        <a href="{{ route('business.restaurants.invoices.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}"
                                            class="waves-effect">
                                            <i class="bx bx-receipt"></i>
                                            <span key="t-chat">Facturas</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <i class="bx bx-money"></i>
                                            <span key="t-projects">Operaciones</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="{{ route('business.restaurants.payment_method.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}"
                                                    key="t-p-grid">Metodo de pagos</a>
                                            </li>
                                            <li><a href="{{ route('business.restaurants.expenses_categories.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}"
                                                    key="t-p-list">Tipo de
                                                    gastos</a></li>
                                            <li>
                                                <a href="{{ route('business.restaurants.expenses.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}"
                                                    key="t-p-overview">
                                                    Gastos
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endforeach
                @endif
                <!-- Sección de Empresas y sus Restaurantes (solo para usuarios normales) -->
                @if (!Auth::user()->hasRole('Super-Admin') && $business->isNotEmpty())
                    <li class="menu-title" key="t-menu">Empresas</li>
                    @foreach ($business as $i => $bs)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-circle"></i>
                                <span key="t-{{ $bs->id }}">{{ $bs->name }}</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-hive"></i>
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.projections.index', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-line-chart"></i>
                                        <span>Proyecciones</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-grid-vertical"></i>
                                        <span>Semanal</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-stats"></i>
                                        <span>Anual</span>
                                    </a>
                                </li>
                                {{-- <li>
                                    <a href="{{ route('users.index') }}" key="r-a-{{ $bs->id }}">
                                        <i class="bx bx-git-compare"></i>
                                        <span>Comparativo</span>
                                    </a>
                                </li> --}}

                                @if ($restaurantsWithBusiness->isNotEmpty())
                                    @foreach ($restaurantsWithBusiness as $j => $rest)
                                        <li>
                                            <a href="javascript: void(0);" key="t-{{ $rest->id }}"
                                                class="has-arrow waves-effect">
                                                <i class="bx bx-dish"></i>
                                                <span>{{ $rest->name }}</span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a
                                                        href="{{ route('business.restaurants.home.index', ['business' => $bs->slug, 'restaurants' => $rest->slug]) }}">
                                                        <i class="mdi mdi-room-service"></i>
                                                        <span key="t-chat">Inicio</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('business.restaurants.projections.index', ['business' => $bs->slug, 'restaurants' => $rest->slug]) }}">
                                                        <i class="bx bx-line-chart"></i>
                                                        <span>Proyecciones</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-a-{{ $bs->id }}">
                                                        <i class="bx bx-calculator"></i>
                                                        <span>Caja</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-s-{{ $bs->id }}">
                                                        <i class="bx bx-grid-vertical"></i>
                                                        <span>Semanal</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-a-{{ $bs->id }}">
                                                        <i class="bx bx-stats"></i>
                                                        <span>Anual</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('users.index') }}"
                                                        key="r-a-{{ $bs->id }}">
                                                        <i class="bx bx-stats"></i>
                                                        <span>Punto Equilibrio</span>
                                                    </a>
                                                </li>
                                                @can('read_providers')
                                                    <li>
                                                        <a
                                                            href="{{ route('business.providers.index', ['business' => $rest->id]) }}">
                                                            <i class="bx bx-cart"></i>
                                                            <span key="t-chat">Proveedores</span>
                                                        </a>
                                                    </li>
                                                @endcan
                                                @can('read_invoices')
                                                    <li>
                                                        <a href="{{ route('business.invoices.index', ['business' => $rest->id]) }}"
                                                            class="waves-effect">
                                                            <i class="bx bx-receipt"></i>
                                                            <span key="t-chat">Facturas</span>
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                                            <i class="bx bx-money"></i>
                                                            <span key="t-projects">Operaciones</span>
                                                        </a>
                                                        <ul class="sub-menu" aria-expanded="false">
                                                            <li>
                                                                <a href="{{ route('business.payment_method.index', ['business' => $rest->id]) }}"
                                                                    key="t-p-grid">
                                                                    <span key="t-chat">Metodos de pago</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('business.expenses_categories.index', ['business' => $rest->id]) }}"
                                                                    key="t-p-list">
                                                                    <span key="t-chat">Tipo gastos</span>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('business.expenses.index', ['business' => $rest->id]) }}"
                                                                    key="t-p-overview">
                                                                    <span key="t-chat">Gastos</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @endcan
                                            </ul>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>

                        </li>
                    @endforeach
                    <li class="menu-title" key="t-menu">Restaurantes</li>
                    @foreach ($restaurantsWithoutBusiness as $i => $rest)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-dish"></i>
                                <span key="t-projects">{{ $rest->name }}</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('business.restaurants.dashboard', ['business' => $bs->slug,'restaurants' => $rest->slug ]) }}">
                                        <i class="mdi mdi-room-service"></i>
                                        <span key="t-chat">Inicio</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('business.dashboard', ['business' => $bs->slug]) }}">
                                        <i class="bx bx-line-chart"></i>
                                        <span>Proyecciones</span>
                                    </a>
                                </li>
                                @can('read_providers')
                                    <li>
                                        <a href="{{ route('business.providers.index', ['business' => $rest->id]) }}">
                                            <i class="bx bx-cart"></i>
                                            <span key="t-chat">Proveedores</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('read_invoices')
                                    <li>
                                        <a href="{{ route('business.invoices.index', ['business' => $rest->id]) }}"
                                            class="waves-effect">
                                            <i class="bx bx-receipt"></i>
                                            <span key="t-chat">Facturas</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <i class="bx bx-money"></i>
                                            <span key="t-projects">Operaciones</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="{{ route('business.payment_method.index', ['business' => $rest->id]) }}"
                                                    key="t-p-grid">Metodo de pagos</a>
                                            </li>
                                            <li><a href="{{ route('business.expenses_categories.index', ['business' => $rest->id]) }}"
                                                    key="t-p-list">Tipo de
                                                    gastos</a></li>
                                            <li><a href="{{ route('business.expenses.index', ['business' => $rest->id]) }}"
                                                    key="t-p-overview">Gastos</a></li>
                                        </ul>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endforeach
                @endif
                <!-- Sección de Restaurantes sin Empresa (para usuarios normales) -->
                @if (!Auth::user()->hasRole('Super-Admin') && $restaurantsWithoutBusiness->isNotEmpty())
                    <li class="menu-title" key="t-menu">Restaurantes</li>
                    @foreach ($restaurantsWithoutBusiness as $i => $rest)
                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bx bx-dish"></i>
                                <span key="t-projects">{{ $rest->name }}</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="{{ route('business.restaurants.dashboard', ['business' => 'rest', 'restaurants' => $rest->slug]) }}">
                                        <i class="mdi mdi-room-service"></i>
                                        <span key="t-chat">Inicio</span>
                                    </a>
                                </li>
                                <li>
                                        <a href="{{ route('business.restaurants.projections.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}">
                                        <i class="bx bx-line-chart"></i>
                                        <span>Proyecciones</span>
                                    </a>
                                </li>
                                    <li>
                                        <a
                                            href="{{ route('business.restaurants.providers.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}">
                                            <i class="bx bx-cart"></i>
                                            <span key="t-chat">Proveedores</span>
                                        </a>
                                    </li>
                                @can('read_invoices')
                                    <li>
                                        <a
                                            href="{{ route('business.restaurants.invoices.index', ['business' => 'rest', 'restaurants' => $rest->slug]) }}">
                                            class="waves-effect">
                                            <i class="bx bx-receipt"></i>
                                            <span key="t-chat">Facturas</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                                            <i class="bx bx-money"></i>
                                            <span key="t-projects">Operaciones</span>
                                        </a>
                                        <ul class="sub-menu" aria-expanded="false">
                                            <li><a href="{{ route('business.payment_method.index', ['business' => $rest->id]) }}"
                                                    key="t-p-grid">Metodo de pagos</a>
                                            </li>
                                            <li><a href="{{ route('business.expenses_categories.index', ['business' => $rest->id]) }}"
                                                    key="t-p-list">Tipo de
                                                    gastos</a></li>
                                            <li><a href="{{ route('business.expenses.index', ['business' => $rest->id]) }}"
                                                    key="t-p-overview">Gastos</a></li>
                                        </ul>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endforeach
                @endif
                <!-- Mensaje si no hay asignaciones (solo para usuarios normales) -->
                @if (!Auth::user()->hasRole('Super-Admin') && $business->isEmpty() && $restaurantsWithoutBusiness->isEmpty())
                    <li class="menu-title" key="t-menu">Sin asignacion</li>
                @endif
                <li class="text-center mb-2" style="bottom: 0; width: 100%;">
                    <a href="{{ route('logout') }}" class="waves-effect text-danger"
                        onclick="event.preventDefault(); 
                        document.getElementById('logout-form').submit();">
                        <i class="bx bx-log-out-circle text-danger"></i>
                        <span key="t-dashboard">Cerrar Sesion</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                        @method('POST')
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
