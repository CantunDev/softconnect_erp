@extends('layouts.master')
<style>
    .hidden {
        display: none !important;
    }
</style>
@section('title')
  Categorías |
@endsection
@section('content')
  @component('components.breadcrumb')
    @slot('title')
      Categoría Gastos
    @endslot
    @slot('bcPrevText')
      Categoría Gastos
    @endslot
    @slot('bcPrevLink')
      {{ route('expenses_categories.index') }}
    @endslot
    @slot('bcActiveText')
      Listado
    @endslot
  @endcomponent

  <div class="card">
    <div class="col-xl-12">
      <div class="card">
        <div class="card-body">
          <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
              <form action="{{ route('expenses_categories.store') }}" method="POST">
                @csrf
                <div class="grid gap-4 sm:grid-cols-1 sm:gap-6">
                  <!-- Selección de Nivel -->
                  <div>
                    <label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona una opción</label>
                    <select id="level" name="level" class="form-control">
                      <option value="" selected>Selecciona...</option>
                      <option value="1">Categoría</option>
                      <option value="2">Subcategoría</option>
                      {{-- <option value="3">Sub-subcategoría</option> --}}
                    </select>
                    @error('level')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Selección de Categoría Padre -->
                  <div id="parent-category-container" class="hidden">
                    <label for="parent_category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona la Categoría </label>
                    <select id="Idtipogasto" name="idtipogasto" class="form-control">
                    </select>
                    @error('Idtipogasto')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Selección de Subcategoría Padre -->
                  <div id="parent-subcategory-container" class="hidden">
                    <label for="parent_subcategory" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona la Subcategoría</label>
                    <select id="parent_subcategory" name="parent_subcategory" class="form-control">
                    </select>
                    @error('parent_subcategory')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                  </div>
                  
                  <!-- Selección de Proveedor -->
                  <div id="provider-container" class="hidden">
                    <label for="idproveedor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona un Proveedor</label>
                    <select id="idproveedor" name="idproveedor" class="form-control">
                    </select>
                    @error('idproveedor')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                  </div>

                  <!-- Campo de Nombre -->
                  <div class="w-full">
                    <label for="descripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
                    <input type="text" name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" required>
                    @error('descripcion')
                      <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                  </div>
                </div>
                <div class="col-12 mt-4 d-flex gap-2">
                  <button type="submit" class="btn btn-primary">Registrar</button>
                  <a class="btn btn-outline-secondary" href="{{ URL::previous() }}">Cancelar</a>
                </div>
              </form>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('js')
<script>
  $(document).ready(function() {
    $('#level').on('change', function() {
        const selectedLevel = $(this).val();
        const parentCategoryContainer = $('#parent-category-container');
        const parentSubcategoryContainer = $('#parent-subcategory-container');
        const parentProviderContainer = $('#provider-container');
        const parentSelect = $('#Idtipogasto');
        const parentSubcategorySelect = $('#parent_subcategory');
        const parentProviderSelect = $('#idproveedor');

        // Ocultar y limpiar los contenedores y selects adicionales
        parentCategoryContainer.addClass('hidden');
        parentSubcategoryContainer.addClass('hidden');
        parentProviderContainer.addClass('hidden');
        parentSelect.empty().append('<option disabled selected>Selecciona</option>');
        parentSubcategorySelect.empty().append('<option disabled selected> Selecciona </option>');
        parentProviderSelect.empty().append('<option disabled selected> Selecciona </option>');

        if (selectedLevel === '2') { // Subcategoría
            // Mostrar el contenedor de Categoría Padre
            parentCategoryContainer.removeClass('hidden');
            parentProviderContainer.removeClass('hidden');
            // Cargar las categorías de nivel 1
            $.ajax({
                url: "{{ route('categories.get') }}",
                method: 'GET',
                success: function(data) {
                     parentSelect.append('<option disabled selected>Selecciona</option>');
                     parentProviderSelect.append('<option disabled selected>Selecciona</option>');
                     
                     $.each(data.tipogastos, function(index, tipogastos) {
                         parentSelect.append(`<option value="${tipogastos.Idtipogasto}">${tipogastos.descripcion}</option>`);
                      });
                     $.each(data.proveedores, function(index, proveedores) {
                          parentProviderSelect.append(`<option value="${proveedores.idproveedor}">${proveedores.nombre}</option>`);
                      });
  
                },
                error: function() {
                    alert('Error al cargar las categorías.');
                }
            });
         } //else if (selectedLevel === '3') { // Sub-subcategoría
        //     // Mostrar ambos contenedores
        //     parentCategoryContainer.removeClass('hidden');
        //     parentSubcategoryContainer.removeClass('hidden');
        //     // Cargar las categorías de nivel 1
        //     $.ajax({
        //         url: "{{ route('categories.get') }}",
        //         method: 'GET',
        //         success: function(data) {
        //             parentSelect.append('<option disabled selected>Selecciona</option>');
        //             $.each(data, function(index, category) {
        //                 parentSelect.append(`<option value="${category.id}">${category.name}</option>`);
        //             });
        //         },
        //         error: function() {
        //             alert('Error al cargar las categorías.');
        //         }
        //     });

        //     // Listener para cargar subcategorías
        //     parentSelect.off('change').on('change', function() {
        //         const selectedCategoryId = $(this).val();
        //         parentSubcategorySelect.empty().append('<option disabled selected>Selecciona</option>');

        //         if (selectedCategoryId) {
        //             $.ajax({
        //                 url: "{{ route('subcategories.get', ':id') }}".replace(':id', selectedCategoryId),
        //                 method: 'GET',
        //                 success: function(data) {
        //                     parentSubcategorySelect.append('<option disabled selected>Selecciona</option>');
        //                     $.each(data, function(index, subcategory) {
        //                         parentSubcategorySelect.append(`<option value="${subcategory.id}">${subcategory.name}</option>`);
        //                     });
        //                 },
        //                 error: function() {
        //                     alert('Error al cargar las subcategorías.');
        //                 }
        //             });
        //         }
        //     });
        // }
    });
});

</script>
@endsection
