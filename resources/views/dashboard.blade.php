@extends('layouts.master')
@section('title')
    Dashboard |
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <img src="https://avatar.oxro.io/avatar.svg?name={{ Auth::user()->fullname }}"
                                        alt="" class="avatar-md rounded-circle img-thumbnail">
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
                                    <div class="col">
                                        <img src="{{ Auth::user()->business->first()->business_file ?? 'https://avatar.oxro.io/avatar.svg?name=' . urlencode(Auth::user()->business->first()->business_name) }}"
                                            alt="" class="avatar-md rounded-circle d-block mx-auto">
                                        <span>{{ Auth::user()->business->pluck('business_name')[0] ?? '' }}</span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $count = count($restaurants);
        if ($count == 1) {
            $colSize = 12; // Si hay un solo restaurante, ocupa toda la fila
        } elseif ($count == 2) {
            $colSize = 6; // Si hay dos, se dividen en mitades
        } else {
            $colSize = 4; // Si hay tres o más, se dividen en tercios (máximo 3 columnas)
        }
    @endphp
    <div class="row">
        @foreach ($restaurants as $i => $restaurant)
            {{-- <div class="restaurant-card" style="background-color: {{ $restaurants[$i]->color_primary }}; color: {{ $restaurants[$i]->color_secondary }}">
            <h1>{{ $restaurants[$i]->name }}</h1>
            <button style="background-color: {{ $restaurants[$i]->color_accent }}">Ver más</button> --}}
            {{-- </div> --}}
            <div class="col-xl-{{ $colSize }}">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4 class="card-title mb-4 fixed-text ">{{$restaurants[$i]->name}} </h4> --}}
                        <div class="accordion accordion-flush" id="accordionFlush">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button
                                        style="background-color: {{ $restaurants[$i]->color_primary ?? '' }}; color: {{ $restaurants[$i]->color_accent ?? '' }}"
                                        class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapse{{ $restaurants[$i]->id }}" aria-expanded="true"
                                        aria-controls="flush-collapse{{ $restaurants[$i]->id }}">
                                        <i class="bx bx-food-menu font-size-12 align-middle me-1"
                                            style="color: {{ $restaurant[$i]->color_accent ?? '' }}"></i>
                                        Venta Al Dia {{ $restaurants[$i]->name }}
                                </h2>
                            </div>
                            <div id="flush-collapse{{ $restaurants[$i]->id }}" class="accordion-collapse collapse show"
                                aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlush">
                                <div class="accordion-body text-muted">
                                    <div class="tab-pane active" id="cheques-tab" role="tabpanel">
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['totalTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta Gral</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['totalPaidTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Venta Cobrada</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['nopersonasTemp'] }}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Clientes</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{-- $  {{$resultsTemp['venta'.$restaurants[$i]->id]['chequePromedio']}} --}}

                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['descuentosTemp'] }}

                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Descuentos</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{-- <i class="bx bx-wallet text-primary font-size-12 align-middle me-1"></i> --}}
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['chequePromedioTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Cheque Promedio</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['alimentosTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Alimentos</h5>
                                        <div class="float-end ms-2">
                                            <h5 class="font-size-12 price">
                                                {{ $resultsTemp['venta' . $restaurants[$i]->id]['bebidasTemp'] }}
                                            </h5>
                                        </div>
                                        <h5 class="font-size-12 mb-2">Bebidas</h5>
                                        <div class="float-end ms-2">
                                            <span
                                                class="me-1 badge rounded-circle p-1 {{ $resultsTemp['venta' . $restaurants[$i]->id]['turno'] == 'Abierto' ? 'bg-success' : 'bg-warning' }}">
                                                <span class="visually-hidden">status</span>
                                            </span>
                                            {{ $resultsTemp['venta' . $restaurants[$i]->id]['turno'] }}


                                        </div>
                                        <h5 class="font-size-12 mb-2">Turno </h5>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('components.restaurants_tabs')
    @can('read_business')

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Total Ventas Corazon Contento</h4>
                    <div class="accordion accordion-flush" id="accordionFlush">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button
                                    style="background-color: {{ Auth::user()->business->first()->color_primary ?? '' }}; color: {{ Auth::user()->business->first()->color_accent ?? '' }}"
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
                                    <h5 class="font-size-12 mb-2">Meta de venta al {{ $daysPass }}</h5>
                                    <div class="float-end ms-2">
                                        <h5 class="font-size-12 price">
                                            {{$totalGeneral}}
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
                                    style="background-color: {{ Auth::user()->business->first()->color_primary ?? '' }}; color: {{ Auth::user()->business->first()->color_accent ?? '' }}"
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
                                    <h5 class="font-size-12 mb-2">Meta de clientes al dia {{ $daysPass }}</h5>
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
                                    style="background-color: {{ Auth::user()->business->first()->color_primary ?? '' }}; color: {{ Auth::user()->business->first()->color_accent ?? '' }}"
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
    @endcan
@endsection
@section('js')
    <script>
        function openModal(event, restaurantId, restaurantName) {
            event.stopPropagation(); // Evita que el acordeón se active

            const modalId = "modal-" + restaurantId;
            if (document.getElementById(modalId)) {
                var existingModal = new bootstrap.Modal(document.getElementById(modalId));
                existingModal.show();
                return;
            }

            let modalHTML = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="modalLabel-${restaurantId}" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel-${restaurantId}">Proyeccion para ${restaurantName}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="projectionForm-${restaurantId}" onsubmit="submitForm(event, ${restaurantId})">
                        <div class="mb-3">
                            <label for="projecttion_sales_at-${restaurantId}" class="form-label">Proyeccion de venta</label>
                            <input type="input" class="form-control" id="projected_sales-${restaurantId}" name="projected_sales" required>
                        </div>
                        <div class="mb-3">
                            <label for="projecttion_tax_at-${restaurantId}" class="form-label">Proyeccion de clientes</label>
                            <input type="input" class="form-control" id="projected_tax-${restaurantId}" name="projected_tax" required>
                        </div>
                         <div class="mb-3">
                            <label for="projecttion_checks_at-${restaurantId}" class="form-label">Proyeccion de cheque</label>
                            <input type="input" class="form-control" id="projected_check-${restaurantId}" name="projected_check" required>
                        </div>
                        <input type="hidden" name="restaurant_id" value="${restaurantId}">
                      </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success" form="projectionForm-${restaurantId}">Guardar</button>
                  </div>
                </div>
              </div>
            </div>`;

            document.body.insertAdjacentHTML('beforeend', modalHTML);
            var newModal = new bootstrap.Modal(document.getElementById(modalId));
            newModal.show();
        }

        function submitForm(event, restaurantId) {
            event.preventDefault();

            let form = document.getElementById(`projectionForm-${restaurantId}`);
            let formData = new FormData(form);

            fetch("{{ route('projections.store') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Proyeccion guardada correctamente.");
                        document.getElementById(`modal-${restaurantId}`).remove(); // Cierra el modal
                        refreshData(); // Recargar solo el div
                    } else {
                        alert("Error al guardar la proyeccion.");
                    }
                })
                .catch(error => console.error("Error en la petición:", error));
        }

        function refreshData() {
            location.reload();
        }
    </script>
    <script>
        function openUpdateModal(event, restaurantId, restaurantName) {
            event.stopPropagation(); // Evita que el acordeón se active

            const modalId = "update-modal-" + restaurantId;

            // Si el modal ya existe, solo lo mostramos
            if (document.getElementById(modalId)) {
                var existingModal = new bootstrap.Modal(document.getElementById(modalId));
                existingModal.show();
                return;
            }

            // Estructura del modal
            let modalHTML = `
            <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="modalLabel-${restaurantId}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel-${restaurantId}">Actualizar Proyección para ${restaurantName}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="updateForm-${restaurantId}" onsubmit="updateProjection(event, ${restaurantId})">
                                <div class="mb-3">
                                    <label for="projected_sales-${restaurantId}" class="form-label">Proyección de Ventas</label>
                                    <input type="number" step="0.01" class="form-control" id="projected_sales-${restaurantId}" name="projected_sales" required>
                                </div>
                                <div class="mb-3">
                                    <label for="projected_tax-${restaurantId}" class="form-label">Proyección de Clientes</label>
                                    <input type="number" class="form-control" id="projected_tax-${restaurantId}" name="projected_tax" required>
                                </div>
                                <div class="mb-3">
                                    <label for="projected_check-${restaurantId}" class="form-label">Proyección de Cheque</label>
                                    <input type="number" step="0.01" class="form-control" id="projected_check-${restaurantId}" name="projected_check" required>
                                </div>
                                <input type="hidden" name="restaurant_id" value="${restaurantId}">
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" form="updateForm-${restaurantId}">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>`;

            // Insertar modal en el DOM y mostrarlo
            document.body.insertAdjacentHTML('beforeend', modalHTML);
            var newModal = new bootstrap.Modal(document.getElementById(modalId));
            newModal.show();

            // Llamada AJAX para obtener los datos del restaurante
            fetch(`/projections/${restaurantId}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Llenar los campos con los datos obtenidos
                    document.getElementById(`projected_sales-${restaurantId}`).value = data.projected_sales ?? "";
                    document.getElementById(`projected_tax-${restaurantId}`).value = data.projected_tax ?? "";
                    document.getElementById(`projected_check-${restaurantId}`).value = data.projected_check ?? "";
                })
                .catch(error => console.error("Error al obtener los datos:", error));
        }

        function updateProjection(event, restaurantId) {
            event.preventDefault();

            let form = document.getElementById(`updateForm-${restaurantId}`);
            // let formData = new FormData(form);
            let formData = {
                projected_sales: document.getElementById(`projected_sales-${restaurantId}`).value,
                projected_tax: document.getElementById(`projected_tax-${restaurantId}`).value,
                projected_check: document.getElementById(`projected_check-${restaurantId}`).value,
                _method: "PUT"
            };
            fetch(`/projections/${restaurantId}`, {
                    method: "PUT",
                    body: JSON.stringify(formData),
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Proyección actualizada correctamente.");
                        document.getElementById(`update-modal-${restaurantId}`).remove(); // Cierra el modal
                        refreshData(); // Refrescar datos sin recargar toda la página
                    } else {
                        alert("Error al actualizar la proyección.");
                    }
                })
                .catch(error => console.error("Error en la petición:", error));
        }

        function refreshData() {
            location.reload();
        }
    </script>
@endsection
