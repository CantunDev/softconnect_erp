<div class="row">
    @foreach ($restaurants as $index => $restaurant)
        @php
            $restaurantKey = 'venta' . $restaurant->id;
            $restaurantData = $results[$restaurantKey] ?? null;
            $hasData = isset($restaurantData) && is_array($restaurantData);
            
            // Valores por defecto
            $defaultValues = [
                'color_primary' => '#ccc',
                'color_accent' => '#000',
                'data' => [
                    'totalTemp' => 0,
                    'totalclientesTemp' => 0,
                    'chequePromedioTemp' => 0,
                    'total' => 0,
                    'nopersonas' => 0,
                    'chequePromedio' => 0
                ],
                'projection' => [
                    'sales_goal' => 0,
                    'clients_goal' => 0,
                    'avg_check_goal' => 0
                ],
                'metrics' => [
                    'sales' => [
                        'daily_goal' => 0,
                        'goal_to_date' => 0,
                        'percentage' => 0,
                        'reach' => 0,
                        'deficit' => 0,
                        'daily_average' => 0,
                        'monthly_projection' => 0,
                        'projection_diff' => 0
                    ],
                    'clients' => [
                        'daily_goal' => 0,
                        'goal_to_date' => 0,
                        'percentage' => 0,
                        'reach' => 0
                    ],
                    'checks' => [
                        'deficit' => 0
                    ]
                ]
            ];
            
            // Fusionar con datos reales si existen
            $displayData = $hasData ? array_merge($defaultValues, $restaurantData) : $defaultValues;
            
            // Asegurar que los sub-arrays existan
            $displayData['data'] = array_merge($defaultValues['data'], $displayData['data'] ?? []);
            $displayData['projection'] = array_merge($defaultValues['projection'], $displayData['projection'] ?? []);
            $displayData['metrics'] = array_merge($defaultValues['metrics'], $displayData['metrics'] ?? []);
        @endphp
        
        <div class="col-xl-{{ $colSize }}">
            <div class="card" style="border: 2px solid {{ $displayData['color_primary'] }}; color: {{ $displayData['color_accent'] }};">
                <div class="card-body">
                    <h4 class="card-title mb-4">Proyectado Ventas {{ $restaurant->name }}</h4>
                    
                    <!-- Sección de Ventas -->
                    <div class="accordion accordion-flush" id="accordionFlush{{ $index }}">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button style="background-color: {{ $displayData['color_primary'] }}; color: {{ $displayData['color_accent'] }}" 
                                    class="accordion-button fw-medium" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseSales{{ $index }}" 
                                    aria-expanded="true" aria-controls="flush-collapseSales{{ $index }}">
                                    <i class="bx bx-restaurant font-size-12 align-middle me-1"></i>
                                    Ventas
                                </button>
                            </h2>
                            <div id="flush-collapseSales{{ $index }}" class="accordion-collapse collapse show" 
                                aria-labelledby="flush-headingSales{{ $index }}" 
                                data-bs-parent="#accordionFlush{{ $index }}">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active">
                                        <!-- Meta de venta mensual -->
                                        <h5 class="font-size-12 mb-2">Meta de venta</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['projection']['sales_goal'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Meta de venta al día -->
                                        <h5 class="font-size-12 mb-2">Meta de venta al día</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['metrics']['sales']['goal_to_date'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Venta real al día -->
                                        <h5 class="font-size-12 mb-2">Venta real al día</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['data']['totalTemp'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Alcance al día (%) -->
                                        <h5 class="font-size-12 mb-2">Alcance al día</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 percentage">
                                                {{ $displayData['metrics']['sales']['percentage'] }}%
                                            </h5>
                                        </div>
                                        
                                        <!-- Diferencia ($) -->
                                        <h5 class="font-size-12 mb-2">DIF/PROY ($)</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 {{ $displayData['metrics']['sales']['reach'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                ${{ number_format($displayData['metrics']['sales']['reach'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Déficit total -->
                                        <h5 class="font-size-12 mb-2">DÉFICIT TOTAL</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 {{ $displayData['metrics']['sales']['deficit'] <= 0 ? 'text-success' : 'text-danger' }}">
                                                ${{ number_format($displayData['metrics']['sales']['deficit'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Meta diaria -->
                                        <h5 class="font-size-12 mb-2">META VTA DIARIA</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['metrics']['sales']['daily_goal'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Promedio diario -->
                                        <h5 class="font-size-12 mb-2">PROM VTA DIARIA</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['metrics']['sales']['daily_average'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Proyección al cierre -->
                                        <h5 class="font-size-12 mb-2">PROY AL CIERRE</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['metrics']['sales']['monthly_projection'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Diferencia proyectada -->
                                        <h5 class="font-size-12 mb-2">DIFERENCIA(+/-)</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 {{ $displayData['metrics']['sales']['projection_diff'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                ${{ number_format($displayData['metrics']['sales']['projection_diff'], 2) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sección de Clientes -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button style="background-color: {{ $displayData['color_primary'] }}; color: {{ $displayData['color_accent'] }}" 
                                    class="accordion-button fw-medium" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseClients{{ $index }}" 
                                    aria-expanded="false" aria-controls="flush-collapseClients{{ $index }}">
                                    <i class="bx bx-body font-size-12 align-middle me-1"></i>
                                    Clientes
                                </button>
                            </h2>
                            <div id="flush-collapseClients{{ $index }}" class="accordion-collapse collapse show" 
                                aria-labelledby="flush-headingClients{{ $index }}" 
                                data-bs-parent="#accordionFlush{{ $index }}">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active">
                                        <!-- Meta de clientes mensual -->
                                        <h5 class="font-size-12 mb-2">Meta de clientes</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{ number_format($displayData['projection']['clients_goal']) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Meta de clientes al día -->
                                        <h5 class="font-size-12 mb-2">Meta de clientes al día</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{ number_format($displayData['metrics']['clients']['goal_to_date']) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Clientes reales al día -->
                                        <h5 class="font-size-12 mb-2">Clientes al día real</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{ number_format($displayData['data']['totalclientesTemp']) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Alcance al día (%) -->
                                        <h5 class="font-size-12 mb-2">Alcance al día</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 percentage">
                                                {{ $displayData['metrics']['clients']['percentage'] }}%
                                            </h5>
                                        </div>
                                        
                                        <!-- Diferencia en clientes -->
                                        <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 {{ $displayData['metrics']['clients']['reach'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                {{ number_format($displayData['metrics']['clients']['reach']) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Sección de Cheques -->
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button style="background-color: {{ $displayData['color_primary'] }}; color: {{ $displayData['color_accent'] }}" 
                                    class="accordion-button fw-medium" type="button" 
                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseChecks{{ $index }}" 
                                    aria-expanded="false" aria-controls="flush-collapseChecks{{ $index }}">
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
                                        <h5 class="font-size-12 mb-2">Meta cheque prom</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['projection']['avg_check_goal'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Cheque promedio actual -->
                                        <h5 class="font-size-12 mb-2">Cheque prom actual</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                ${{ number_format($displayData['data']['chequePromedioTemp'], 2) }}
                                            </h5>
                                        </div>
                                        
                                        <!-- Déficit -->
                                        <h5 class="font-size-12 mb-2">DÉFICIT</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 {{ $displayData['metrics']['checks']['deficit'] <= 0 ? 'text-success' : 'text-danger' }}">
                                                ${{ number_format($displayData['metrics']['checks']['deficit'], 2) }}
                                            </h5>
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