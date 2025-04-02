<div class="row mt-2">
    <div class="col-xl-12">
        <div class="card" style="border: 2px solid #ccc">
            <div class="card-body">
                {{-- <div class="skeleton" id="skeleton-1">
                    <div class="skeleton-line" style="width: 50%; height: 20px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                    <div class="skeleton-line" style="width: 100%; height: 15px;"></div>
                </div> --}}
                <h4 class="card-title mb-4">Total Ventas Corazon Contento</h4>
                <div class="accordion accordion-flush" id="accordionFlush">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button
                                {{-- style="background-color: {{ Auth::user()->business->first()->color_primary ?? '' }}; color: {{ Auth::user()->business->first()->color_accent ?? '' }}" --}}
                                class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseC"
                                aria-expanded="true" aria-controls="flush-collapseC">
                                <span>
                                    <i class="bx bx-restaurant font-size-12 align-middle me-1"></i>
                                    Ventas
                                </span>
                            </button>
                        </h2>
                    </div>
                    <div id="flush-collapseC" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                        <div class="accordion-body text-muted">
                            <div class="tab-pane active" id="vta-tab" role="tabpanel">
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price"> 
                                    </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Meta de venta</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        {{-- meta / dias del mes * dias analizados --}}
                                    </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Meta de venta al </h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        {{-- {{$totalGeneral}} --}}
                                    </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Venta real al dia</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 percentage">
                                        {{-- venta real al dia / meta clientes a la fecha * 100 --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Alcance al dia</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">

                                        {{-- Venta real al dia - meta de venta a la fecha --}}
                                        0
                                    </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">DIF/PROY</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 percentage">

                                        {{-- alcance - 100  --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">DEFICIT</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        {{-- meta / dias del mes --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">META VTA DIARIA</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        {{-- vta_real / dias transcurridos --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">PROM VTA DIARIA</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        {{-- promedio venta * dias del mes   --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">PROY AL CIERRE</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">

                                        {{-- proyectado - meta  --}}
                                        0 </h5>
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
                                {{-- style="background-color: {{ Auth::user()->business->first()->color_primary ?? '' }}; color: {{ Auth::user()->business->first()->color_accent ?? '' }}" --}}
                                class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseC" aria-expanded="true"
                                aria-controls="flush-collapseC">
                                <i class="bx bx-body font-size-12 align-middle me-1"></i>
                                Clientes
                        </h2>
                    </div>
                    <div id="flush-collapseC" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                        <div class="accordion-body text-muted">
                            <div class="tab-pane active" id="vta-tab" role="tabpanel">
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12">
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Meta de clientes</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12">
                                        {{-- meta_clientes / dias del mes * dias transcurridos --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Meta de clientes al dia </h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 ">
                                        {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                    </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Clientes al dia real</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 percentage">
                                        {{-- venta real al dia / meta clientes a la fecha * 100 --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Alcance al dia</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12">

                                        {{-- meta_clientes - clientes al dia  --}}
                                        0 </h5>
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
                                {{-- style="background-color: {{ Auth::user()->business->first()->color_primary ?? '' }}; color: {{ Auth::user()->business->first()->color_accent ?? '' }}" --}}
                                class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseC" aria-expanded="true"
                                aria-controls="flush-collapseC">
                                <i class="bx bx-spreadsheet font-size-12 align-middle me-1"></i>
                                Cheques
                        </h2>
                    </div>
                    <div id="flush-collapseC" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlush">
                        <div class="accordion-body text-muted">
                            <div class="tab-pane active" id="cheques-tab" role="tabpanel">
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Meta cheque prom</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                        
                                    </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">Cheque prom actual</h5>
                                <div class="float-end ms-2">
                                    <h5 class="font-size-12 price">
                                        {{-- metacheques - promedio cheque actual --}}
                                        0 </h5>
                                </div>
                                <h5 class="font-size-12 mb-2">DEFICIT</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>