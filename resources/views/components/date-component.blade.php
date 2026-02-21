<div class="row">

    <div class="col-xl-12">

        <div class="card" style="border: 2px solid #ccc">
            <div class="card-body">
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

                                <img src="{{ Auth::user()->avatar_url }}"
                                    alt="" class="avatar-md rounded-circle img-thumbnail d-block mx-auto mb-2">
                                <div class="text-muted">
                                    <h5 id="greeting-text" class="mb-1">{{ Auth::user()->fullname }}</h5>
                                    <p class="mb-0">{{ Auth::user()->roles->pluck('name')[0] ?? '' }}</p>
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
                                    @if (Auth::user()->business->count())
                                        <img src="{{ Auth::user()->business->first()->business_file ?? 'https://avatar.oxro.io/avatar.svg?name=' . urlencode(Auth::user()->business->first()->business_name) }}"
                                            alt="" class="avatar-md rounded-circle d-block mx-auto mb-2">
                                        <h5 class="mt-2 mb-2">
                                            {{ Auth::user()->business->pluck('business_name')[0] ?? '' }}</h5>
                                    @endif
                                    @if (Auth::user()->business->isEmpty() && Auth::user()->restaurants->count())
                                        <img src="{{ Auth::user()->restaurants->first()->restaurant_file ?? 'https://avatar.oxro.io/avatar.svg?name=' . urlencode(Auth::user()->restaurants->first()->name) }}"
                                            alt="" class="avatar-md rounded-circle d-block mx-auto mb-2">
                                        <h5 class="mt-2 mb-2">{{ Auth::user()->restaurants->pluck('name')[0] ?? '' }}
                                        </h5>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const greetingElement = document.getElementById('greeting-text');
        const hour = new Date().getHours();
        let timeClass = '';
        let greeting = '';

        if (hour >= 5 && hour < 12) {
            // Mañana (5am - 11:59am)
            timeClass = 'morning-bg';
            greeting = 'Buenos días';
        } else if (hour >= 12 && hour < 18) {
            // Día (12pm - 5:59pm)
            timeClass = 'day-bg';
            greeting = 'Buenas tardes';
        } else if (hour >= 18 && hour < 21) {
            // Tarde (6pm - 8:59pm)
            timeClass = 'evening-bg';
            greeting = 'Buenas tardes';
        } else {
            // Noche (9pm - 4:59am)
            timeClass = 'night-bg';
            greeting = 'Buenas noches';
        }

        // Aplicar clases
        // timeElement.classList.add(timeClass);
        greetingElement.textContent = greeting + ', ' + greetingElement.textContent;
    });
</script>