   @if (count($errors) > 0)
       <div class="alert alert-danger mb-4" id="error-alert">
           <ul class="mb-0">
               @foreach ($errors as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif
   <div class="row">
       <div class="col-lg-12">
           <div class="card" style="border: 2px solid #ccc">
               <div class="card-body">
                   {{-- <h4 class="card-title mb-4">Ventas del mes Restaurante</h4> --}}
                   <div class="accordion accordion-flush" id="accordionFlush">
                       <div class="accordion-item">
                           <h2 class="accordion-header">
                               <button
                                   style="background-color: {{ $restaurants->color_primary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}"
                                   class="accordion-button fw-medium d-flex justify-content-between align-items-center"
                                   type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseV"
                                   aria-expanded="true" aria-controls="flush-collapseV">
                                   <span>
                                       <i class="bx bx-dollar font-size-12 align-middle me-1"></i>
                                       Ventas del mes {{ $restaurants->name }}
                                   </span>
                               </button>
                           </h2>
                       </div>
                       <div id="flush-collapseV" class="accordion-collapse collapse show mb-4"
                           aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                           <div class="row">
                               <div class="table-rep-plugin mt-2 ">
                                   <div class="table-responsive mb-0" data-pattern="priority-columns">
                                       <table id="datatable_ventas"
                                           class="table table-sm table-bordered dt-responsive nowrap w-100">
                                           <thead
                                               style="background-color: {{ $restaurants->color_secondary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}">
                                               <tr>
                                                   <th data-priority="1">Fecha</th>
                                                   <th data-priority="3" class="text-center">Clientes</th>
                                                   <th data-priority="1">Total</th>
                                                   <th data-priority="3">Iva</th>
                                                   <th data-priority="3">Subtotal</th>
                                                   <th data-priority="6">Efectivo</th>
                                                   <th data-priority="6">Propinas</th>
                                                   <th data-priority="6">Tarjeta</th>
                                                   <th data-priority="6">Descuento</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                               @forelse ($cortes as $corte)
                                                   <tr>
                                                       <td class="text-center">
                                                           {{ $corte->dia }}
                                                       </td>
                                                       <td class="text-center"
                                                           data-value="{{ $corte->total_clientes ?? 0 }}">
                                                           {{ $corte->total_clientes ?? 0 }}
                                                       </td>
                                                       <td class="price" data-value="{{ $corte->total_venta ?? 0 }}">
                                                           {{ $corte->total_venta ?? 0 }}
                                                       </td>
                                                       <td class="price" data-value="{{ $corte->total_iva ?? 0 }}">
                                                           {{ $corte->total_iva ?? 0 }}
                                                       </td>
                                                       <td class="price"
                                                           data-value="{{ $corte->total_subtotal ?? 0 }}">
                                                           {{ $corte->total_subtotal ?? 0 }}
                                                       </td>
                                                       <td class="price"
                                                           data-value="{{ $corte->total_efectivo ?? 0 }}">
                                                           {{ $corte->total_efectivo ?? 0 }}
                                                       </td>
                                                       <td class="price"
                                                           data-value="{{ $corte->total_propina ?? 0 }}">
                                                           {{ $corte->total_propina ?? 0 }}
                                                       </td>
                                                       <td class="price"
                                                           data-value="{{ $corte->total_tarjeta ?? 0 }}">
                                                           {{ $corte->total_tarjeta ?? 0 }}
                                                       </td>
                                                       <td class="price"
                                                           data-value="{{ $corte->total_descuento ?? 0 }}">
                                                           {{ $corte->total_descuento ?? 0 }}
                                                       </td>
                                                   </tr>
                                               @empty
                                                   <tr>
                                                       <td colspan="9" class="text-center">
                                                           <div class="alert alert-warning mb-0">No hay ventas en este
                                                               período</div>
                                                       </td>
                                                   </tr>
                                               @endforelse
                                           </tbody>
                                           <tfoot
                                               style="background-color: {{ $restaurants->color_secondary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}">
                                               <tr>
                                                   <th>Total</th>
                                                   <th id="total_clientes"></th>
                                                   <th id="total_venta"></th>
                                                   <th id="total_iva"></th>
                                                   <th id="total_subtotal"></th>
                                                   <th id="total_efectivo"></th>
                                                   <th id="total_propina"></th>
                                                   <th id="total_tarjeta"></th>
                                                   <th id="total_descuento"></th>
                                               </tr>
                                           </tfoot>
                                       </table>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
