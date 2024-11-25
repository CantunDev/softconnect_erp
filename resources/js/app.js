import './bootstrap';
// import 'laravel-datatables-vite';


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// public/js/app.js

document.addEventListener('DOMContentLoaded', () => {
    const levelSelect = document.getElementById('level');
    const parentCategoryContainer = document.getElementById('parent-category-container');
    const parentSubcategoryContainer = document.getElementById('parent-subcategory-container');
    const parentCategorySelect = document.getElementById('parent_category');
    const parentSubcategorySelect = document.getElementById('parent_subcategory');

    // Obtener el token CSRF desde la meta etiqueta
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Escuchar cambios en el selector de nivel
    levelSelect.addEventListener('change', function() {
        const selectedLevel = this.value;

        // Resetear y ocultar los selects de padre
        parentCategoryContainer.classList.add('hidden');
        parentSubcategoryContainer.classList.add('hidden');
        parentCategorySelect.innerHTML = '<option value="" selected>Selecciona una categoría</option>';
        parentSubcategorySelect.innerHTML = '<option value="" selected>Selecciona una subcategoría</option>';

        if (selectedLevel === '2') {
            // Mostrar el selector de Categoría Padre
            parentCategoryContainer.classList.remove('hidden');
            fetchCategories();
        } else if (selectedLevel === '3') {
            // Mostrar los selectores de Categoría y Subcategoría Padre
            parentCategoryContainer.classList.remove('hidden');
            parentSubcategoryContainer.classList.remove('hidden');
            fetchCategories();
        }
    });

    // Escuchar cambios en el selector de Categoría Padre
    parentCategorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;

        // Resetear el selector de Subcategoría Padre
        parentSubcategorySelect.innerHTML = '<option value="" selected>Selecciona una subcategoría</option>';

        if (selectedCategoryId) {
            fetchSubcategories(selectedCategoryId);
        }
    });

    /**
     * Función para obtener las categorías principales desde el backend.
     */
    function fetchCategories() {
        fetch('/categories', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            parentCategorySelect.innerHTML = '<option value="" selected>Selecciona una categoría</option>';
            data.forEach(category => {
                parentCategorySelect.innerHTML += `<option value="${category.id}">${category.name}</option>`;
            });
        })
        .catch(error => {
            console.error('Error al obtener categorías:', error);
            alert('Hubo un error al cargar las categorías. Por favor, inténtalo de nuevo.');
        });
    }

    /**
     * Función para obtener las subcategorías basadas en una categoría padre.
     * @param {number} categoryId
     */
    function fetchSubcategories(categoryId) {
        fetch(`/subcategories/${categoryId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => response.json())
        .then(data => {
            parentSubcategorySelect.innerHTML = '<option value="" selected>Selecciona una subcategoría</option>';
            data.forEach(subcategory => {
                parentSubcategorySelect.innerHTML += `<option value="${subcategory.id}">${subcategory.name}</option>`;
            });
        })
        .catch(error => {
            console.error('Error al obtener subcategorías:', error);
            alert('Hubo un error al cargar las subcategorías. Por favor, inténtalo de nuevo.');
        });
    }
});
