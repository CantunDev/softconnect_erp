<li>
    <a href="javascript: void(0);" class="has-arrow waves-effect">
        <i class="bx bx-cog"></i>
        <span>Configuraciones</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        @can('read_users')
            <li>
                <a href="{{ route('config.users.index') }}">
                    <i class="bx bx-user"></i>
                    <span>Usuarios</span>
                </a>
            </li>
        @endcan

        @can('read_roles')
            <li>
                <a href="{{ route('config.roles_permissions.index') }}">
                    <i class="bx bx-shield"></i>
                    <span>Roles / Permisos</span>
                </a>
            </li>
        @endcan

        @can('read_business')
            <li>
                <a href="{{ route('config.business.index') }}">
                    <i class="bx bx-building-house"></i>
                    <span>Empresas</span>
                </a>
            </li>
        @endcan

        @can('read_restaurants')
            <li>
                <a href="{{ route('config.restaurants.index') }}">
                    <i class="bx bx-restaurant"></i>
                    <span>Restaurantes</span>
                </a>
            </li>
        @endcan
    </ul>
</li>
