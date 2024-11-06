<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Proveedores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <section class="bg-gray-50 dark:bg-gray-900 py-3 sm:py-5">
            <div class="px-4 mx-auto max-w-screen-2xl lg:px-12">
                <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                    <div class="flex flex-col px-4 py-3 space-y-3 lg:flex-row lg:items-center lg:justify-between lg:space-y-0 lg:space-x-4">
                        <div class="flex items-center flex-1 space-x-4">
                            
                        </div>
                        <div class="flex flex-col flex-shrink-0 space-y-3 md:flex-row md:items-center lg:justify-end md:space-y-0 md:space-x-3">
                            {{-- <a href="{{route('providers.create')}}" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 dark:bg-slate-600 dark:hover:bg-slate-700 focus:outline-none dark:focus:ring-slate-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Nuevo proveedor
                            </a> --}}
                           
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table id="table_cheques" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="p-4">#</th>
                                    <th scope="col" class="p-4">Fecha</th>
                                    <th scope="col" class="px-4 py-3">Folio</th>
                                    <th scope="col" class="px-4 py-3">Personas</th>
                                    <th scope="col" class="px-4 py-3">Subtotal</th>
                                    <th scope="col" class="px-4 py-3">Propina</th>
                                    <th scope="col" class="px-4 py-3">Total</th>
                                    <th scope="col" class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                   
                </div>
            </div>
          </section>
    </div>
    <script>
            $(document).ready(function(){
                $('#table_cheques').DataTable({
                    processing: true,
                    serverSide: true,
                    paging: true,
                    ajax: {
                        url: '{!! route('cheques.index') !!}',
                    },
                    columns: [
                        {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                        {data: 'fecha', name: 'fecha', orderable: false, searchable: false},
                        {data: 'sfolio', name: 'sfolio', orderable: false, searchable: false},
                        {data: 'nopersonas', name: 'nopersonas', orderable: false, searchable: false},
                        {data: 'subtotal', name: 'subtotal', orderable: false, searchable: false},
                        {data: 'propina', name: 'propina', orderable: false, searchable: false},
                        {data: 'total', name: 'total', orderable: false, searchable: false}
                    ],
                });
            });
        </script>
    </script>
</x-app-layout>