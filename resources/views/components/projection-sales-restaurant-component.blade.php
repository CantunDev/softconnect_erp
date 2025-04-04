<div class="row">
    @foreach ($restaurants as $index => $restaurant)
        <div class="col-xl-{{ $colSize }}">
            <div class="card"
                style="border: 2px solid {{ $restaurant->color_primary }}; color: {{ $restaurant->color_accent }};">
                <div class="card-body">
                    <h4 class="card-title mb-4">Proyecciones {{ $restaurant->name }}</h4>

                    <!-- Sección de Ventas -->
                    <div class="accordion accordion-flush" id="accordionFlush{{ $index }}">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurant->color_primary }}; color: {{ $restaurant->color_accent }}"
                                    class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseSales{{ $index }}" aria-expanded="true"
                                    aria-controls="flush-collapseSales{{ $index }}">
                                    <i class="bx bx-restaurant font-size-12 align-middle me-1"></i>
                                    Ventas
                                </button>
                            </h2>
                            <div id="flush-collapseSales{{ $index }}" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingSales{{ $index }}"
                                data-bs-parent="#accordionFlush{{ $index }}">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active">
                                        <div class="float-end ms-2">
                                            <!-- Meta de venta mensual -->
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['sales' . $restaurant->id]))
                                                    {{ $gral = $projection['sales' . $restaurant->id]['projected_sales'] }}
                                                @else
                                                    {{ $gral = 0 }}
                                                @endif
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta de venta</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['dailySalesGoal'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif

                                            </h5>
                                        </div>
                                        <!-- Meta de venta al día -->
                                        <h5 class="font-size-12 mb-2">Meta de venta al día {{ $currentDay }}</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                @if (isset($results['venta' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $results['venta' . $restaurant->id]['total'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ $gral = 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Venta real al día -->
                                        <h5 class="font-size-12 mb-2">Venta real al día</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 percentaje">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['salesGoalToDate'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Alcance al día (%) -->
                                        <h5 class="font-size-12 mb-2">Alcance al día</h5>
                                        <div class="float-end ms-2">
                                            @if (isset($projection['goals' . $restaurant->id]))
                                                <h5 class="font-size-12 price"
                                                    style="color: {{ $projection['goals' . $restaurant->id]['diffProyectionGoal'] < 0 ? 'red' : 'green' }};">
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['diffProyectionGoal'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                </h5>
                                            @endif

                                        </div>

                                        <!-- Diferencia ($) -->
                                        <h5 class="font-size-12 mb-2">DIF/PROY ($)</h5>
                                        <div class="float-end ms-2">
                                            @if (isset($projection['goals' . $restaurant->id]))
                                                <h5 class="font-size-12 percentaje"
                                                    style="color: {{ $projection['goals' . $restaurant->id]['salesDeficit'] > 0 ? 'red' : 'green' }};">
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['salesDeficit'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                </h5>
                                            @endif

                                        </div>

                                        <!-- Déficit total -->
                                        <h5 class="font-size-12 mb-2">DÉFICIT TOTAL</h5>
                                        <div class="float-end ms-2">
                                            {{-- <h5 class="font-size-12 {{ $restaurantData['metrics']['sales']['deficit'] <= 0 ? 'text-success' : 'text-danger' }}">
                                                ${{ number_format($restaurantData['metrics']['sales']['deficit'], 2) }}
                                            </h5> --}}
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['goals_daily'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Meta diaria -->
                                        <h5 class="font-size-12 mb-2">META VTA DIARIA</h5>
                                        <div class="float-end ms-2">
                                            {{-- <h5 class="font-size-12 price">
                                                ${{ number_format($restaurantData['metrics']['sales']['daily_goal'], 2) }}
                                            </h5> --}}
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['sales_avg_daily'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Promedio diario -->
                                        <h5 class="font-size-12 mb-2">PROM VTA DIARIA</h5>
                                        <div class="float-end ms-2">
                                            {{-- <h5 class="font-size-12 price">
                                                ${{ number_format($restaurantData['metrics']['sales']['daily_average'], 2) }}
                                            </h5> --}}
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['goals_sales_projected'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Proyección al cierre -->
                                        <h5 class="font-size-12 mb-2">PROY AL CIERRE</h5>
                                        <div class="float-end ms-2">
                                            {{-- <h5 class="font-size-12 price">
                                                ${{ number_format($restaurantData['metrics']['sales']['monthly_projection'], 2) }}
                                            </h5> --}}
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['sales_difference'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Diferencia proyectada -->
                                        <h5 class="font-size-12 mb-2">DIFERENCIA(+/-)</h5>
                                        <div class="float-end ms-2">
                                            {{-- <h5 class="font-size-12 {{ $restaurantData['metrics']['sales']['projection_diff'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                ${{ number_format($restaurantData['metrics']['sales']['projection_diff'], 2) }}
                                            </h5> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección de Clientes -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurant->color_primary }}; color: {{ $restaurant->color_accent }}"
                                    class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseClients{{ $index }}" aria-expanded="false"
                                    aria-controls="flush-collapseClients{{ $index }}">
                                    <i class="bx bx-body font-size-12 align-middle me-1"></i>
                                    Clientes
                                </button>
                            </h2>
                            <div id="flush-collapseClients{{ $index }}" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingClients{{ $index }}"
                                data-bs-parent="#accordionFlush{{ $index }}">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                @if (isset($projection['sales' . $restaurant->id]))
                                                    {{ $projection['sales' . $restaurant->id]['projected_tax'] }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>
                                        <!-- Meta de clientes mensual -->
                                        <h5 class="font-size-12 mb-2">Meta de clientes</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['goals_tax'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Meta de clientes al día -->
                                        <h5 class="font-size-12 mb-2">Meta de clientes al día {{ $currentDay }}</h5>
                                        <div class="float-end ms-2">

                                            @if (isset($results['venta' . $restaurant->id]))
                                                {{-- Acceso a los datos --}}
                                                {{ $results['venta' . $restaurant->id]['nopersonas'] }}
                                            @else
                                                {{-- Valor por defecto si no hay datos --}}
                                                {{ 0 }}
                                            @endif
                                        </div>

                                        <!-- Clientes reales al día -->
                                        <h5 class="font-size-12 mb-2">Clientes al día real</h5>
                                        <div class="float-end ms-2 ">
                                            <h5 class="font-size-12 percentage">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['taxGoalToDate'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>

                                        </div>

                                        <!-- Alcance al día (%) -->
                                        <h5 class="font-size-12 mb-2">Alcance al día</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12"
                                                style="color: {{ $projection['goals' . $restaurant->id]['tax_difference'] < 0 ? 'red' : 'green' }};">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{-- Acceso a los datos --}}
                                                    {{ $projection['goals' . $restaurant->id]['tax_difference'] }}
                                                @else
                                                    {{-- Valor por defecto si no hay datos --}}
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Diferencia en clientes -->
                                        <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                        <div class="float-end ms-2">
                                            {{-- <h5 class="font-size-12 {{ $restaurantData['metrics']['clients']['reach'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                {{ number_format($restaurantData['metrics']['clients']['reach']) }}
                                            </h5> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sección de Cheques -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurant->color_primary }}; color: {{ $restaurant->color_accent }}"
                                    class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapseChecks{{ $index }}" aria-expanded="false"
                                    aria-controls="flush-collapseChecks{{ $index }}">
                                    <i class="bx bx-spreadsheet font-size-12 align-middle me-1"></i>
                                    Cheques
                                </button>
                            </h2>
                            <div id="flush-collapseChecks{{ $index }}" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingChecks{{ $index }}"
                                data-bs-parent="#accordionFlush{{ $index }}">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active">
                                        <!-- Meta cheque promedio -->
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['sales' . $restaurant->id]))
                                                    {{ $projection['sales' . $restaurant->id]['projected_check'] }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Meta cheque prom</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{ $projection['goals' . $restaurant->id]['check_avg_daily'] }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                                {{-- ${{ number_format($restaurantData['projection']['avg_check_goal'], 2) }} --}}
                                            </h5>
                                        </div>

                                        <!-- Cheque promedio actual -->
                                        <h5 class="font-size-12 mb-2">Cheque prom actual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price"
                                                style="color: {{ $projection['goals' . $restaurant->id]['check_defficit'] < 0 ? 'red' : 'green' }};">
                                                @if (isset($projection['goals' . $restaurant->id]))
                                                    {{ $projection['goals' . $restaurant->id]['check_defficit'] }}
                                                @else
                                                    {{ 0 }}
                                                @endif
                                            </h5>
                                        </div>

                                        <!-- Déficit -->
                                        <h5 class="font-size-12 mb-2">DÉFICIT</h5>
                                        <div class="float-end ms-2">
                                            {{-- <h5 class="font-size-12 {{ $restaurantData['metrics']['checks']['deficit'] <= 0 ? 'text-success' : 'text-danger' }}">
                                                ${{ number_format($restaurantData['metrics']['checks']['deficit'], 2) }}
                                            </h5> --}}
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
