@extends('layouts.master')
@section('title')
  Categorias |
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Categoria gastos
    @endslot
    @slot('bcPrevText')
    Categoria gastos
    @endslot
    @slot('bcPrevLink')
      {{ route('expenses_categories.index') }}
    @endslot
    @slot('bcActiveText')
      Listado
    @endslot
  @endcomponent
    <div class="card">
        <div class="card-body border-bottom">
            <div class="d-flex align-items-center">
                <h5 class="mb-0 card-title flex-grow-1">Categoria de gastos</h5>
                <div class="flex-shrink-0">
                    <a href="{{route('expenses_categories.create')}}" class="btn btn-primary">Nuevo</a>
                    {{-- <a href="#!" class="btn btn-light"><i class="mdi mdi-refresh"></i></a> --}}
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title">Striped rows</h4> --}}
                    {{-- <p class="card-title-desc">Use <code>.table-striped</code> to add zebra-striping to any table row within
                        the <code>&lt;tbody&gt;</code>.</p> --}}

                    <div class="table-responsive">
                        <table class="table table-striped mb-0">

                            <thead>
                                <tr>
                                    <th>Categorias</th>
                                    <th>Subcategorias</th>
                                    <th>Sub-subcategorias</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses_categories as $i => $categories)
                                <tr>
                                        <td class="flex px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                               {{$i = $i+1}} {{$categories->name}}                                                
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
                                                @endforeach                                        </td> 
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
        </div>
    </div>
@endsection
