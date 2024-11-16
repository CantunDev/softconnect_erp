<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Registrar gastos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-18 lg:px-6">
                <form id="create_quote" method="POST" action="{{route('expenses.store')}}">
                    @csrf
                    @method('POST')  
                    <div class="grid grid-cols-6 gap-4">
                       
                        <div class="col-span-1 ">
                            <label for="date" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Fecha compra</label>
                            <input type="date" id="date" name="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
                        </div>
                        <div class="col-span-1 ">
                            <label for="folio" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Folio nota</label>
                            <input type="text" id="folio" name="folio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="NOTA:2423" required />
                        </div>
                        
                        <div class="col-span-1">
                            <label for="provider_id" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Proveedor</label>
                            <select id="provider_id" name="provider_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecciona un proveedor </option>
                                    @foreach ($providers as $provider)
                                        <option value="{{$provider->id}}"> {{$provider->name}} </option>
                                        
                                    @endforeach                                                                                     
                            </select>
                        </div>
                        <div class="col-span-1 ">
                            <label for="folio_invoiced" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Folio factura</label>
                            <input type="hidden" id="invoiced" name="invoiced" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="1" required />
                            <input type="text" id="folio_invoiced" name="folio_invoiced" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Folio" required />
                        </div>
                        <div class="col-span-2 ">
                            <label for="payment_method_id" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Metodo de pago</label>
                            <select id="payment_method_id" name="payment_method_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecciona un metodo pago</option>
                                    {{-- @foreach ($companies as $company)
                                        <option value="{{$company->id}}"> {{$company->name}} </option>
                                        
                                    @endforeach --}}
                            </select>
                        </div>

                        <div class="col-start-2 col-span-1 py-8">
                            <label for="subtotal" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Subtotal</label>
                            <input type="text" id="subtotal" name="subtotal" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="50" required />
                        </div>
                        <div class="col-span-1 py-8">
                            <label for="tax" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Iva</label>
                            <input type="text" id="tax" name="tax" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="50" required />
                        </div>
                        <div class="col-span-1 py-8">
                            <label for="discount" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Descuento</label>
                            <input type="text" id="discount" name="discount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="50" required />
                        </div>
                        <div class="col-span-1 py-8">
                            <label for="amount" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Total</label>
                            <input type="number" id="amount" name="amount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="10" required />
                        </div>
                        <div class="col-start-2 col-span-1">
                            <label for="type" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Tipo de gasto</label>
                            <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecciona un tipo</option>
                                    @foreach ($categories as $category)
                                        <option value="{{$category->id}}"> {{$category->name}} </option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-span-1 ">
                            <label for="subtype" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Subtipo</label>
                            <select id="subtype" name="subtype" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecciona un subtipo </option>
                                    {{-- @foreach ($companies as $company)
                                        <option value="{{$company->id}}"> {{$company->name}} </option>
                                        
                                    @endforeach --}}
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label for="sub_subtype" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Sub-subtipo</label>
                            <select id="sub_subtype" name="sub_subtype" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option selected disabled>Selecciona un sub-subtipo </option>
                                    {{-- @foreach ($companies as $company)
                                        <option value="{{$company->id}}"> {{$company->name}} </option>
                                        
                                    @endforeach --}}
                            </select>
                        </div>
                        {{-- <div class="col-end-7 col-span-6 bg-yellow-300">03</div> --}}
                        {{-- <div class="col-start-1 col-end-7 bg-yellow-300">04</div> --}}
                    </div>
                    
                    <div class="grid grid-cols-4 gap-1 mt-2">
                        <div class="col-start-1 col-span-full ">
                            <label for="description" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Comentarios</label>                        
                            <textarea name="description" id="" rows="2"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </textarea>
                        </div>                        
                    </div>

                    <div class="grid grid-cols-2 gap-1 mt-8 items-center text-center">
                        <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gren-600 dark:hover:bg-green-700 focus:outline-none dark:focus:ring-green-800">Guardar</button>
                        <a href="{{URL::previous()}}" type="button" class="ml-4 text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-500 dark:focus:ring-red-700">
                            Cancelar 
                        </a>
                    </div>
                </form>
    
            </div>
        </section>
    </div>

    <script>
    $(document).ready(function () {
        $('#type').on('change', function () {
            var idType = this.value;
            $("#subtype").html('');
            $.ajax({
                url: "{{url('/fetch-subcategories')}}",
                // url: "{{route('fetchsubcategories')}}",
                type: "POST",
                data: {
                    id: idType,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (result) {
                    $('#subtype').html('<option value="">-- Selecciona un subtipo --</option>');
                    $.each(result.subcategories, function (key, value) {
                        $("#subtype").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                    $('#sub_subtype').html('<option value="">-- Selecciona un sub-subtipo --</option>');
                }
            });
        });


        $('#subtype').on('change', function () {
                var idSubcategory = this.value;
            $("#sub_subtype").html('');
            $.ajax({
                url: "{{url('/fetch-subsubcategories')}}",
                type: "POST",
                data: {
                    id: idSubcategory,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#sub_subtype').html('<option value="">-- Selecciona una subsubcategoria --</option>');
                    $.each(res.subsubcategories, function (key, value) {
                        $("#sub_subtype").append('<option value="' + value
                            .id + '">' + value.name + '</option>');
                    });
                }
            });
        });

    });
    </script>
</x-app-layout>