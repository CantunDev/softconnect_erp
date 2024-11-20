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
                            <a href="{{route('expenses_categories.create')}}" class="flex ml-2 items-center justify-center px-4 py-2 text-sm font-medium text-white rounded-lg bg-slate-700 hover:bg-slate-800 focus:ring-4 focus:ring-slate-300 dark:bg-slate-600 dark:hover:bg-slate-700 focus:outline-none dark:focus:ring-slate-800">
                                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                                </svg>
                                Categorias
                            </a>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-dark-50 dark:bg-slate-800">
                                        Categorias
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-orange-50 dark:bg-orange-600">
                                        Subcategorias
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-slate-50 dark:bg-slate-300">
                                        Sub-subcategorias
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses_categories as $i => $categories)
                                <tr>
                                        <td class="flex px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <h2>
                                               {{$i = $i+1}} {{$categories->name}}                                                
                                            </h2>    
                                            {{-- <a href="{{route('providers.edit', $categories->id)}}" type="button" class="px-2 py-1 text-xs font-medium text-center inline-flex items-center text-white bg-yellow-600 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                <svg class="w-4 h-5 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="6" height="6" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z"/>
                                                </svg>                                      
                                            </a>
                                            <form  method="POST" action="{{route('providers.destroy', $categories->id)}} ">
                                                @method('DELETE')
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id" value="{{ $categories->id }}">
                                                <button  type="submit" class="px-2 py-1 ml-1 text-xs font-medium text-center inline-flex items-center text-white bg-gray-600 rounded-lg hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                    <svg class="w-4 h-5 text-white-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                        <path fill-rule="evenodd" d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z" clip-rule="evenodd"/>
                                                    </svg>                                      
                                                </button>
                                            </form> --}}
                                        </td> 
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            
                                                @foreach ($categories->children as $j => $children)
                                                    <li>
                                                      {{$i. ".". $j = $j+1 }} {{$children->name}}
                                                    </li>
                                                @endforeach
                                    
                                        </td> 
                                        <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @foreach ($categories->children as $l => $children)
                                                @foreach ($children->subchildren as $k => $sub)
                                                <li>
                                                {{$i."." . $l+1 . "." .$k+1 }}    {{$sub->name}}
                                                </li>
                                                @endforeach
                                            @endforeach
                                        </td> 
                                    </tr>
                                @endforeach                         
                            </tbody>
                        </table>
                    </div>
                   
                </div>
            </div>
          </section>
    </div>
</x-app-layout>
