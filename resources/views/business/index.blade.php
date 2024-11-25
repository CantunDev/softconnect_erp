{{-- <x-app-layout>
  <!-- Table Section -->
  <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 mx-auto">
    <!-- Card -->
    <div class="flex flex-col">
      <div class="-m-1.5 overflow-x-auto">
        <div class="p-1.5 min-w-full inline-block align-middle">
          <div
            class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden dark:bg-gray-800 dark:border-gray-900">
            <!-- Header -->
            <div
              class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
              <div>
                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                  {{ __('Empresas') }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                  {{ $companies->total() }} registros
                </p>
              </div>

              <div>
                <div class="inline-flex gap-x-2">
                  <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                    href="{{ route('business.create') }}">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                      viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                      stroke-linejoin="round">
                      <path d="M5 12h14" />
                      <path d="M12 5v14" />
                    </svg>
                    Nueva empresa
                  </a>
                </div>
              </div>
            </div>
            <!-- End Header -->

            <!-- Table -->
            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700 text-sm">
              <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Nombre
                      </span>
                    </div>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Rfc
                      </span>
                    </div>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Linea de negocio
                      </span>
                    </div>
                  </th>

                  <th scope="col" class="px-6 py-3 text-start">
                    <div class="flex items-center gap-x-2">
                      <span class="text-xs font-semibold uppercase tracking-wide text-gray-800 dark:text-neutral-200">
                        Regimen
                      </span>
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 text-end"></th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                @if ($companies->isEmpty())
                  <tr>
                    <td class="text-center size-px whitespace-nowrap" colspan="5">
                      <div class="px-6 py-3">
                        <span class="block text-sm text-gray-800 dark:text-gray-400">No
                          existen registros aún...</span>
                      </div>
                    </td>
                  </tr>
                @else
                  @foreach ($companies as $company)
                    <tr>
                      <td class="size-px whitespace-nowrap">
                        <div class="px-6 py-3">
                          <div class="flex items-center gap-x-3">
                            <div class="grow">
                              <span class="block text-sm text-gray-800 dark:text-gray-400">{{ $company->name }}</span>
                            </div>
                          </div>
                        </div>
                      </td>
                      <td class="h-px w-72 whitespace-nowrap">
                        <div class="px-6 py-3">
                          <span class="block text-sm text-gray-800 dark:text-gray-400 uppercase">{{ $company->rfc }}</span>
                        </div>
                      </td>
                      <td class="size-px whitespace-nowrap">
                        <div class="px-6 py-3">
                          <span class="text-gray-500 dark:text-gray-400">{{ $company->business_line }}</span>
                        </div>
                      </td>
                      <td class="size-px whitespace-nowrap">
                        <div class="px-6 py-3">
                          <span class="text-gray-500 dark:text-gray-400">{{ $company->regime }}</span>
                        </div>
                      </td>
                      <td class="size-px whitespace-nowrap">
                        <div class="px-6 py-1.5">
                          <div class="flex gap-1 px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('business.edit', $company) }}" type="button"
                              class="px-2 py-1 text-xs font-medium text-center inline-flex items-center text-white bg-yellow-600 rounded-lg hover:bg-yellow-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                              <svg class="w-4 h-5 text-white-800 dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" width="6" height="6" fill="none"
                                viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                              </svg>
                            </a>

                            <form method="POST" action="{{ route('business.destroy', $company) }}"
                              data-id="{{ $company->name }}" class="form-delete">
                              @csrf
                              @method('DELETE')
                              <button type="submit"
                                class="px-2 py-1 ml-1 text-xs font-medium text-center inline-flex items-center text-white bg-gray-600 rounded-lg hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                                <svg class="w-4 h-5 text-white-800 dark:text-white" aria-hidden="true"
                                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                  viewBox="0 0 24 24">
                                  <path fill-rule="evenodd"
                                    d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                    clip-rule="evenodd" />
                                </svg>
                              </button>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
                @endif
              </tbody>
            </table>
            <!-- End Table -->

            <!-- Footer -->
            @if ($companies->hasPages())
              <div
                class="px-6 py-4 grid gap-3 md:flex md:justify-end md:items-center border-t border-gray-200 dark:border-neutral-700">
                <div>
                  <div class="inline-flex gap-x-2">
                    {{ $companies->links() }}
                  </div>
                </div>
              </div>
            @endif
            <!-- End Footer -->
          </div>
        </div>
      </div>
    </div>
    <!-- End Card -->
  </div>
  <!-- End Table Section -->
</x-app-layout> --}}

@extends('layouts.master')
@section('title')
  Empresas |
@endsection

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0 font-size-18">Empresas</h4>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('business.create') }}" class="btn btn-success">
          <i class="bx bx-plus font-size-15"></i> Nueva empresa
        </a>
      </div>
      <div class="table-responsive">
        <table class="table project-list-table table-nowrap align-middle table-hover" id="datatable">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Nombre</th>
              <th scope="col">RFC</th>
              <th scope="col">Linea de negocio</th>
              <th scope="col">Regimen</th>
              <th scope="col">Opciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($companies as $company)
              <tr>
                <td>
                  <p class="text-muted mb-0">{{ $company->id }}</p>
                </td>
                <td>
                  {{-- <h5 class="font-size-14 mb-0">{{ $company->name }}</h5> --}}
                  <p class="text-muted mb-0">{{ $company->name }}</p>
                </td>
                <td>
                  <p class="text-muted mb-0">{{ $company->rfc }}</p>
                </td>
                <td>
                  <p class="text-muted mb-0">{{ $company->business_line }}</p>
                </td>
                <td>
                  <p class="text-muted mb-0">{{ $company->regime }}</p>
                </td>
                <td class="text-center">
                  <div class="dropdown">
                    <a href="#" class="dropdown-toggle card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical font-size-18"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                      {{-- <a class="dropdown-item" href="#"><i class="bx bx-show font-size-15"></i> Ver</a> --}}
                      <a class="dropdown-item" href="{{ route('business.edit', $company->id) }}"><i
                          class="bx bx-edit font-size-15"></i> Editar</a>
                      <form method="POST" action="{{ route('business.destroy', $company) }}"
                        data-id="{{ $company->name }}" class="form-delete">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"><i class="bx bx-trash font-size-15"></i>
                          Eliminar</button>
                      </form>
                    </div>
                  </div>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(document).ready(function() {
      $("#datatable").DataTable({
        responsive: true,
        autoWidth: false,
        pagingType: "simple",
        language: {
          lengthMenu: "Mostrar _MENU_ registros / página",
          zeroRecords: "No se encontraron registros coincidentes",
          info: "Mostrando _PAGE_ de _PAGES_ páginas",
          infoEmpty: "No hay registros disponibles",
          infoFiltered: "(_TOTAL_ registros filtrados)",
          search: "Buscar:",
          paginate: {
            next: "Siguiente",
            previous: "Anterior",
          },
          emptyTable: 'No hay datos disponibles en la tabla',
        },
        order: [
          [0, "desc"]
        ],
      });
      $(".datatable").attr("style", "border-collapse: collapse !important");
    });

    $(document).on('submit', '.form-delete', function(e) {
      e.preventDefault();

      const alertAttribute = $(this).data('id');

      Swal.fire({
        title: '¿Estás seguro?',
        text: 'La empresa ' + alertAttribute + ' se eliminará definitivamente.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '¡Si, eliminar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      })
    });
  </script>
@endsection
