<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-xl-4 mx-auto">
                        <div>
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="https://avatar.oxro.io/avatar.svg?name={{ Auth::user()->fullname }}"
                                        alt=""
                                        class="avatar-md rounded-circle img-thumbnail d-block mx-auto mb-2">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <div class="text-muted">
                                        <p class="mb-2">Bienvenido</p>
                                        <h5 class="mb-1">{{ Auth::user()->fullname }}</h5>
                                        <p class="mb-0">{{ Auth::user()->roles->pluck('name')[0] ?? '' }}</p>
                                    </div>
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
                                        <span
                                            class="mt-2 mb-2">{{ Auth::user()->business->pluck('business_name')[0] ?? '' }}</span>
                                    @endif
                                    @if (Auth::user()->business->isEmpty() && Auth::user()->restaurants->count())
                                        <img src="{{ Auth::user()->restaurants->first()->restaurant_file ?? 'https://avatar.oxro.io/avatar.svg?name=' . urlencode(Auth::user()->restaurants->first()->name) }}"
                                            alt="" class="avatar-md rounded-circle d-block mx-auto mb-2">
                                        <span
                                            class="mt-2 mb-2">{{ Auth::user()->restaurants->pluck('name')[0] ?? '' }}</span>
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
