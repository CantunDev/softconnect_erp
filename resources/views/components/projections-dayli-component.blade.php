<div class="row">
    <div class="card" style="border: 2px solid #ccc">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Lista de Proyecciones</h5>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="table_projections_dayli"
                    class="table table-sm align-middle dt-responsive nowrap w-100 table-check text-center">
                    <thead>
                        <tr>
                            <th scope="col" class="px-4 py-3">Fecha</th>
                            @foreach ($restaurants as $restaurant)
                                <th colspan="3" scope="col" class="px-4 py-3"
                                    style="color: {{ $restaurantDetails[$restaurant->id]['color_primary'] }}">
                                    {{ $restaurant->name }}
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            <th></th>
                            @foreach ($restaurants as $restaurant)
                                <th>Proyectado / Real</th>
                                <th>Diferencia</th>
                                <th>Cheque Prom.</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $day)
                            <tr>
                                <td>{{ $day['short_name'] }}</td>

                                @foreach ($restaurants as $restaurant)
                                    @php
                                        $projection =
                                            $restaurantDetails[$restaurant->id]['daily_projections'][
                                                $day['full_date']
                                            ] ?? null;
                                        $difference = $projection['difference'] ?? 0;
                                        $avgCheck = $projection['actual_day_check'] ?? 0;
                                    @endphp

                                    <!-- Columna Proyectado/Real -->
                                    <td
                                        style="border-left: 3px solid {{ $restaurantDetails[$restaurant->id]['color_primary'] }}">
                                        @if ($projection)
                                            <div class="d-flex justify-content-between">
                                                <span
                                                    class="">{{ number_format($projection['projected_day_sales'], 2) }}</span>
                                                <span
                                                    class="text-success">{{ number_format($projection['actual_day_sales'], 2) }}</span>
                                            </div>
                                            <div class="progress" style="height: 5px;">
                                                @php
                                                    $percentage = $projection['actual_day_sales']
                                                        ? ($projection['actual_day_sales'] /
                                                                $projection['projected_day_sales']) *
                                                            100
                                                        : 0;
                                                @endphp

                                                <div class="progress-bar" role="progressbar"
                                                    style="width: {{ $percentage }}%; background-color: {{ $percentage > 100 ? '#28a745' : ($percentage > 80 ? 'orange' : ($percentage > 30 ? '#ffc107' : 'red')) }};"
                                                    aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                </div>

                                            </div>
                                        @else
                                            <span class="text-muted">Sin datos</span>
                                        @endif
                                    </td>

                                    <!-- Columna Diferencia -->
                                    <td>
                                        <span class="{{ $difference >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($difference, 2) }}
                                        </span>
                                    </td>

                                    <!-- Columna Cheque Promedio -->
                                    <td>
                                        {{ number_format($avgCheck, 2) }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>

                            <th class="text-end">Total:</th>
                            @foreach ($restaurants as $restaurant)
                                @php
                                    $totalProjected = 0;
                                    $totalActual = 0;
                                    $totalDifference = 0;
                                    $countChecks = 0;
                                    $avgTotalCheck = 0;

                                    // Verificar si hay datos para el restaurante
                                    $hasData = isset($restaurantDetails[$restaurant->id]['daily_projections']);

                                    foreach ($days as $day) {
                                        // Acceso seguro a los datos
                                        $projection = $hasData
                                            ? $restaurantDetails[$restaurant->id]['daily_projections'][
                                                    $day['full_date']
                                                ] ?? null
                                            : null;

                                        if ($projection) {
                                            $totalProjected += $projection['projected_day_sales'] ?? 0;
                                            $totalActual += $projection['actual_day_sales'] ?? 0;
                                            $totalDifference += $projection['difference'] ?? 0;

                                            // Solo sumar si existe el valor
                                            if (isset($projection['actual_day_check'])) {
                                                $avgTotalCheck += $projection['actual_day_check'];
                                                $countChecks++;
                                            }
                                        }
                                    }

                                    // Calcular promedio solo si hay datos
                                    $avgTotalCheck = $countChecks > 0 ? $avgTotalCheck / $countChecks : 0;
                                @endphp
                                <!-- Total Proyectado/Real -->
                                <td>
                                    <div class="d-flex justify-content-between">
                                        <span>{{ number_format($totalProjected, 2) }}</span>-
                                        <span>{{ number_format($totalActual, 2) }}</span>
                                    </div>
                                </td>

                                <!-- Total Diferencia -->
                                <td>
                                    <span class="{{ $totalDifference >= 0 ? 'text-success' : 'text-danger' }}">
                                        {{ number_format($totalDifference, 2) }}
                                    </span>
                                </td>

                                <!-- Promedio Cheque -->
                                <td>
                                    {{-- {{ number_format($avgTotalCheck, 2) }} --}}
                                </td>
                            @endforeach
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-0">Proyecciones diarias del mes</h4>
                <div class="row">
                    @foreach ($restaurants as $restKey => $restaurant)
                        @php
                            $totalProjected = 0;
                            $totalActual = 0;
                            $totalDifference = 0;
                            $countChecks = 0;
                            $avgTotalCheck = 0;
                            $totalTax = 0;
                            $hasData = isset($restaurantDetails[$restaurant->id]['daily_projections']);

                            foreach ($days as $day) {
                                $projection = $hasData
                                    ? $restaurantDetails[$restaurant->id]['daily_projections'][$day['full_date']] ??
                                        null
                                    : null;

                                if ($projection) {
                                    $totalProjected += $projection['projected_day_sales'] ?? 0;
                                    $totalActual += $projection['actual_day_sales'] ?? 0;
                                    $totalDifference += $projection['difference'] ?? 0;
                                    $totalTax += $projection['actual_day_tax'] ?? 0;
                                    // Solo sumar si existe el valor
                                    if (isset($projection['actual_day_check'])) {
                                        $avgTotalCheck += $projection['actual_day_check'];
                                        $countChecks++;
                                    }
                                }
                            }
                            $avgTotalCheck = $countChecks > 0 ? $avgTotalCheck / $countChecks : 0;
                        @endphp


                        <div class="col-xl-{{ $colSize }}">
                            <div class="mt-4">

                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button
                                                style="border: 1.5px solid {{ $restaurant->color_primary }}; color: {{ $restaurant->color_secondary }}; background-color: var(--bs-table-bg)"
                                                class="accordion-button fw-medium" type="button"
                                                data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapse{{ $restKey }}"
                                                aria-expanded="true" aria-controls="flush-collapse{{ $restKey }}">
                                                {{ $restaurant->name }}
                                            </button>
                                        </h2>
                                        <div id="flush-collapse{{ $restKey }}"
                                            class="accordion-collapse collapse show" aria-labelledby="flush-headingOne"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body text-muted">

                                                <div class="card-body border-top">
                                                    <p class="text-muted mb-4">En este mes</p>
                                                    <div class="text-center">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <div>
                                                                    <div class="font-size-24 text-primary mb-2">
                                                                        <i style="color: {{ $restaurant->color_secondary }}"
                                                                            class="mdi mdi-finance"></i>
                                                                    </div>

                                                                    <p class="text-muted mb-2">Proyectado</p>
                                                                    <h5 class="price">{{ $totalProjected }}</h5>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="mt-4 mt-sm-0">
                                                                    <div class="font-size-24 text-primary mb-2">
                                                                        <i style="color: {{ $restaurant->color_secondary }}"
                                                                            class="bx bx-import"></i>
                                                                    </div>

                                                                    <p class="text-muted mb-2">Vta.Real</p>
                                                                    <h5 class="price">{{ $totalActual }}</h5>

                                                                    <div class="mt-3">
                                                                        <a href="javascript: void(0);"
                                                                            style="background-color: {{ $restaurant->color_primary }}; color {{ $restaurant->color_accent }} "
                                                                            class="btn btn-primary btn-sm w-md">Detalles</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-4">
                                                                <div class="mt-4 mt-sm-0">
                                                                    <div class="font-size-24 text-primary mb-2">
                                                                        <i style="color: {{ $restaurant->color_secondary }}"
                                                                            class="mdi mdi-account-group"></i>
                                                                    </div>

                                                                    <p class="text-muted mb-2">Clientes</p>
                                                                    <h5>{{ $totalTax }}</h5>
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
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div> --}}
</div>
</div>
