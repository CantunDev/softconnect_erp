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
                                     Ventas Alimentos y Bebidas {{ $restaurants->name }}
                                 </span>
                             </button>
                         </h2>
                     </div>
                     <div id="flush-collapseV" class="accordion-collapse collapse show mb-4"
                         aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlush">
                         <div class="row">
                             <div class="table-rep-plugin mt-2 ">
                                 <div class="table-responsive mb-0" data-pattern="priority-columns">
                                     <table id="datatable_ventas_food"
                                         class="table table-sm table-bordered dt-responsive nowrap w-100">
                                         <thead
                                             style="background-color: {{ $restaurants->color_secondary ?? '' }}; color: {{ $restaurants->color_accent ?? '' }}">
                                             <tr>
                                                 <th class="text-center" data-priority="1">Fecha</th>
                                                 <th class="text-center" data-priority="1">Total Alimentos</th>
                                                 <th class="text-center" data-priority="1">Desc Alimentos</th>
                                                 <th class="text-center" data-priority="1">% Alimentos</th>
                                                 <th class="text-center" data-priority="3">Total Bebidas</th>
                                                 <th class="text-center" data-priority="1">Desc Bebidas</th>
                                                 <th class="text-center" data-priority="3">% Bebidas</th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             @forelse ($food_drink_sales as $food_drink_sale)
                                                 <tr>
                                                     <td>{{ $food_drink_sale->dia }}</td>
                                                     <td>{{ $food_drink_sale->total_alimentos }}</td>
                                                     <td>{{ $food_drink_sale->descuento_alimentos }}</td>
                                                     <td>{{ $food_drink_sale->porcentaje_alimentos }}</td>
                                                     <td>{{ $food_drink_sale->total_bebidas }}</td>
                                                     <td>{{ $food_drink_sale->descuento_bebidas }}</td>
                                                     <td>{{ $food_drink_sale->porcentaje_bebidas }}</td>
                                                 </tr>
                                             @empty
                                                 <tr>
                                                     <td colspan="7" class="text-center">
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
                                                 <th id="total_food"></th>
                                                 <th id="total_desc_food"></th>
                                                 <th id="avg_food"></th>
                                                 <th id="total_drinks"></th>
                                                 <th id="total_desc_drinks"></th>
                                                 <th id="avg_drinks"></th>
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
