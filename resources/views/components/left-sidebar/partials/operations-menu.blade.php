@props(['business', 'restaurant'])

<li>
    <a href="javascript: void(0);" class="has-arrow waves-effect">
        <i class="bx bx-money"></i>
        <span>Operaciones</span>
    </a>
    <ul class="sub-menu" aria-expanded="false">
        <li>
            <a href="{{ route('business.restaurants.payment_method.index', ['business' => $business, 'restaurants' => $restaurant]) }}">
                <span>Métodos de pago</span>
            </a>
        </li>
        <li>
            <a href="{{ route('business.restaurants.expenses_categories.index', ['business' => $business, 'restaurants' => $restaurant]) }}">
                <span>Tipo de gastos</span>
            </a>
        </li>
        <li>
            <a href="{{ route('business.restaurants.expenses.index', ['business' => $business, 'restaurants' => $restaurant]) }}">
                <span>Gastos</span>
            </a>
        </li>
    </ul>
</li>