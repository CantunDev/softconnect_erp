<li class="text-center mb-2" style="bottom: 0; width: 100%;">
    <a href="{{ route('logout') }}" class="waves-effect text-danger"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="bx bx-log-out-circle text-danger"></i>
        <span>Cerrar Sesión</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        @method('POST')
    </form>
</li>