<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                @role('Super-Admin')
                    <x-left-sidebar.admin.config-menu />
                @endrole

                @if (Auth::user()->hasRole('Super-Admin'))
                    <x-left-sidebar.admin.business-list :business="$business" />
                    <x-left-sidebar.admin.standalone-restaurants :restaurants="$restaurantsWithoutBusiness" />

                @elseif ($business->isNotEmpty())
                    <x-left-sidebar.business.business-list
                        :business="$business"
                        :restaurants="$restaurantsWithBusiness"
                    />
                    @if ($restaurantsWithoutBusiness->isNotEmpty())
                        <x-left-sidebar.restaurant.standalone-list :restaurants="$restaurantsWithoutBusiness" />
                    @endif

                @elseif ($restaurantsWithoutBusiness->isNotEmpty())
                    <x-left-sidebar.restaurant.standalone-list :restaurants="$restaurantsWithoutBusiness" />

                @else
                    <li class="menu-title">Sin asignación</li>
                @endif

                <x-left-sidebar.partials.logout />

            </ul>
        </div>
    </div>
</div>