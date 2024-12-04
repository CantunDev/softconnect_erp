<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuevo proveedor') }}
        </h2>

        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                {{-- <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new product</h2> --}}
                <form action="{{ route('expenses_categories.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-1 sm:gap-6">    
                        <!-- Selección de Nivel -->
                        <div>
                            <label for="level" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona una opción</label>
                            <select id="level" name="level" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="" selected>Selecciona...</option>
                                <option value="1">Categoria</option>
                                <option value="2">Subcategoria</option>
                                <option value="3">Sub-subcategoria</option>
                            </select>
                            @error('level')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
            
                        <!-- Selección de Categoría Padre -->
                        <div id="parent-category-container" class="hidden">
                            <label for="parent_category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona la Categoría Padre</label>
                            <select id="parent_category" name="parent_category" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <!-- Las opciones se cargarán dinámicamente -->
                            </select>
                            @error('parent_category')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
            
                        <!-- Selección de Subcategoría Padre -->
                        <div id="parent-subcategory-container" class="hidden">
                            <label for="parent_subcategory" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Selecciona la Subcategoría Padre</label>
                            <select id="parent_subcategory" name="parent_subcategory" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option value="" selected>Selecciona una subcategoría</option>
                                <!-- Las opciones se cargarán dinámicamente -->
                            </select>
                            @error('parent_subcategory')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
            
                        <!-- Campo de Nombre -->
                        <div class="w-full">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nombre" required>
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-green-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-green-900 hover:bg-green-800">
                        Registrar 
                    </button>
                    <a href="{{ URL::previous() }}" type="button" class="ml-4 text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-500 dark:focus:ring-gray-700">
                        Cancelar 
                    </a>
                </form>
            </div>
        </section>
    </x-slot>

    
</x-app-layout>
@section('js')
    
<script>
    $(document).ready(function() {
        $('#level').on('change', function() {
            const selectedLevel = $(this).val();
            const parentCategoryContainer = $('#parent-category-container');
            const parentSubcategoryContainer = $('#parent-subcategory-container');
            const parentSelect = $('#parent_category');
            const parentSubcategorySelect = $('#parent_subcategory');

            // Ocultar y limpiar los contenedores y selects adicionales
            parentCategoryContainer.addClass('hidden');
            parentSubcategoryContainer.addClass('hidden');
            parentSelect.empty().append('<option value="" selected>Selecciona una categoría</option>');
            parentSubcategorySelect.empty().append('<option value="" selected>Selecciona una subcategoría</option>');

            if (selectedLevel === '2') { // Subcategoría
                // Mostrar el contenedor de Categoría Padre
                parentCategoryContainer.removeClass('hidden');
                // Cargar las categorías de nivel 1
                $.ajax({
                    url: "{{ route('categories.get') }}",
                    method: 'GET',
                    success: function(data) {
                        parentSelect.append('<option value="">Selecciona una categoría</option>');
                        $.each(data, function(index, category) {
                            parentSelect.append(`<option value="${category.id}">${category.name}</option>`);
                        });
                    },
                    error: function() {
                        alert('Error al cargar las categorías.');
                    }
                });
            } else if (selectedLevel === '3') { // Sub-subcategoría
                // Mostrar ambos contenedores
                parentCategoryContainer.removeClass('hidden');
                parentSubcategoryContainer.removeClass('hidden');
                // Cargar las categorías de nivel 1
                $.ajax({
                    url: "{{ route('categories.get') }}",
                    method: 'GET',
                    success: function(data) {
                        parentSelect.append('<option value="">Selecciona una categoría</option>');
                        $.each(data, function(index, category) {
                            parentSelect.append(`<option value="${category.id}">${category.name}</option>`);
                        });
                    },
                    error: function() {
                        alert('Error al cargar las categorías.');
                    }
                });

                // Remover cualquier listener previo para evitar duplicación
                parentSelect.off('change').on('change', function() {
                    const selectedCategoryId = $(this).val();
                    parentSubcategorySelect.empty().append('<option value="" selected>Selecciona una subcategoría</option>');

                    if (selectedCategoryId) {
                        $.ajax({
                            url: "{{ route('subcategories.get', ':id') }}".replace(':id', selectedCategoryId),

                            method: 'GET',
                            success: function(data) {
                                parentSubcategorySelect.append('<option value="">Selecciona una subcategoría</option>');
                                $.each(data, function(index, subcategory) {
                                    parentSubcategorySelect.append(`<option value="${subcategory.id}">${subcategory.name}</option>`);
                                });
                            },
                            error: function() {
                                alert('Error al cargar las subcategorías.');
                            }
                        });
                    }
                });

            } else { // Categoría
                // Ocultar los contenedores adicionales
                parentCategoryContainer.addClass('hidden');
                parentSubcategoryContainer.addClass('hidden');
            }
        });
    });
</script>

@endsection