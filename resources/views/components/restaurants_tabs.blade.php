<div class="row" id="restaurantTable">
    @foreach ($restaurants as $i => $restaurant)
        @php
            $projection = $restaurants[$i]->projections->first();
            $month = $projection ? $projection->month : null;
            $year = $projection ? $projection->year : null;
        @endphp
        <div class="col-xl-{{ $colSize }}">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $restaurants[$i]->name }}</h4>
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                    class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                    type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                    aria-controls="flush-collapse{{ $restaurants[$i]->id }}">

                                    <span>
                                        <i class="bx bx-restaurant font-size-12 align-middle me-1"
                                            style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                        Ventas {{ $restaurants[$i]->name }}
                                    </span>
                                @can('update_restaurants')
                                    @if (!empty($restaurants[$i]->projections) && $restaurants[$i]->projections->count() > 0)
                                        <!-- Si tiene proyecciones, mostrar el ícono de editar -->
                                        <span class="ms-auto">
                                            <i class="bx bx-pencil font-size-16 align-middle cursor-pointer"
                                                style="color: {{ $restaurants[$i]->color_accent ?? '' }};"
                                                onclick="openUpdateModal(event, {{ $restaurants[$i]->id }}, '{{ $restaurants[$i]->name }}')">
                                            </i>
                                        </span>
                                    @else
                                        <!-- Si no tiene proyecciones, mostrar el ícono de agregar -->
                                        <span class="ms-auto">
                                            <i class="bx bx-plus font-size-16 align-middle cursor-pointer"
                                                style="color: {{ $restaurants[$i]->color_accent ?? '' }};"
                                                onclick="openModal(event, {{ $restaurants[$i]->id }}, '{{ $restaurants[$i]->name }}')">
                                            </i>
                                        </span>
                                    @endif
                                @endcan
                                </button>
                            </h2>
                        </div>
                        <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                            <div class="accordion-body text-muted">
                                <div class="tab-pane active" id="vta-tab" role="tabpanel">
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{$meta = $restaurants[$i]->projections->where('month', $month)->where('year', $year)->first()?->projected_sales ?? 'N/A' }}                                        
                                            </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Meta de venta</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                        {{-- meta / dias del mes * dias analizados --}}
                                            {{ $meta_al_dia = $restaurants[$i]->projections->where('month', $month)->where('year', $year)->first()?->projected_sales / $daysInMonth * $daysPass }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Meta de venta al {{ $daysPass }}</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                            {{ $vta_real = $results['venta' . $restaurants[$i]->id]['total'] }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Venta real al dia</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 percentage">
                                            {{-- venta real al dia / meta clientes a la fecha * 100 --}}
                                            {{ $alcance_vta = $meta_al_dia != 0 ? ($vta_real / $meta_al_dia) * 100 : '0' }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Alcance al dia</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price"
                                            style="color: {{ $vta_real -$meta_al_dia < 0 ? 'red' : 'green' }};">

                                            {{-- Venta real al dia - meta de venta a la fecha --}}
                                            {{ $dif_proy = $vta_real -$meta_al_dia }}

                                        </h5> 
                                    </div>
                                    <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 percentage"
                                        style="color: {{ (100 - $alcance_vta) > 0 ? 'red' : 'green' }};">

                                            {{-- alcance - 100  --}}
                                            {{$def_vta =  100-$alcance_vta }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">DEFICIT</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{-- meta / dias del mes --}}
                                            {{$meta_diaria = (float)$meta / ($daysInMonth + 0)}}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">META VTA DIARIA</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{-- vta_real / dias transcurridos --}}
                                            @php
                                            $promedio_vta_real = $daysPass > 0 ? $vta_real / $daysPass : 0;
                                        @endphp
                                        
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">PROM VTA DIARIA</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{-- promedio venta * dias del mes   --}}
                                            {{ $proyectado_cierre = $promedio_vta_real * ($daysInMonth + 0) }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">PROY AL CIERRE</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price"
                                            style="color: {{ $proyectado_cierre - (float)$meta < 0 ? 'red' : 'green' }};">

                                            {{-- proyectado - meta  --}}
                                            {{ $proyectado_cierre - (float)$meta}}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">DIFERENCIA(+/-)</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                    class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                    aria-controls="flush-collapse{{ $restaurants[$i]->id }}">
                                    <i class="bx bx-body font-size-12 align-middle me-1"
                                        style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                    Clientes {{ $restaurants[$i]->name }}
                            </h2>
                        </div>
                        <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                            <div class="accordion-body text-muted">
                                <div class="tab-pane active" id="vta-tab" role="tabpanel">
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12">
                                            {{ $meta_clientes = $restaurants[$i]->projections->where('month', $month)->where('year', $year)->first()?->projected_tax?? 'N/A' }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Meta de clientes</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12">
                                            {{-- meta_clientes / dias del mes * dias transcurridos --}}
                                            {{ $meta_clientes_al_dia = round (((int)$meta_clientes + 0) / ((int)$daysInMonth + 0) * ((int)$daysPass + 0),2) }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Meta de clientes al dia {{ $daysPass }}</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 ">
                                            {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                            {{ $clientes_total = $results['venta' . $restaurants[$i]->id]['nopersonas'] }}

                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Clientes al dia real</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 percentage">
                                            {{-- venta real al dia / meta clientes a la fecha * 100 --}}
                                            {{ $alcance = $meta_clientes_al_dia != 0 ? ($clientes_total / $meta_clientes_al_dia) * 100 : '0' }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Alcance al dia</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12" style="color: {{ $clientes_total - $meta_clientes_al_dia < 0 ? 'red' : 'green' }};">

                                            {{-- meta_clientes - clientes al dia  --}}
                                            {{$def = $clientes_total - $meta_clientes_al_dia}}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                    class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                    aria-controls="flush-collapse{{ $restaurants[$i]->id }}">
                                    <i class="bx bx-spreadsheet font-size-12 align-middle me-1"
                                        style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                    Cheques {{ $restaurants[$i]->name }}
                            </h2>
                        </div>
                        <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
                            aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlush">
                            <div class="accordion-body text-muted">
                                <div class="tab-pane active" id="cheques-tab" role="tabpanel">
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{ $meta_cheques = $restaurants[$i]->projections->where('month', $month)->where('year', $year)->first()?->projected_check ?? 'N/A' }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Meta cheque prom</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                            {{ $avg_cheq = $results['venta' . $restaurants[$i]->id]['chequePromedio'] }}

                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">Cheque prom actual</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price" 
                                        style="color: {{ ($avg_cheq - (float)$meta_cheques) < 0 ? 'red' : 'green' }};">
                                            {{-- metacheques - promedio cheque actual --}}
                                            {{ $avg_cheq - (float)$meta_cheques }}
                                        </h5>
                                    </div>
                                    <h5 class="font-size-12 mb-2">DEFICIT</h5>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
