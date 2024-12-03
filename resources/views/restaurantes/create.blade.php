<x-app-layout>
    <div class="py-10">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form action="{{ route('restaurants.store') }}" method="POST" class="dark:bg-gray-800 rounded-xl p-5"
          enctype="multipart/form-data">
          @csrf
          @method('POST')
          <h1 class="text-white text-2xl mb-3 font-semibold">Nuevo Restaurante</h1>
  
          <div class="grid gap-4 grid-cols-12">
            <div class="col-span-12 sm:col-span-6 lg:col-span-4">
              <label for="inputName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre
                corto</label>
              <input type="text" name="name" id="inputName"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="Nombre Restaurante" value="{{ old('name') }}">
              @error('name')
                <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
              @enderror
            </div>
  
            <div class="col-span-12 sm:col-span-8 md:col-span-6 lg:col-span-3">
              <label for="inputDescription"
                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion</label>
              <input type="text" name="description" id="inputDescription"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="" value="{{ old('description') }}">
              @error('description')
                <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
              @enderror
            </div>
    
            <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
              <label for="inputIp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VPN IP</label>
              <input type="text" name="ip" id="inputBusinessLine"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                placeholder="192.xxx.xxx.xxx" value="{{ old('ip') }}">
              @error('ip')
                <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
              @enderror
            </div>
  
            <div class="col-span-12 sm:col-span-4 lg:col-span-3">
              <label for="inputDatabase" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Base de datos</label>
              <input type="text" name="database" id="database"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                value="{{ old('database', 'database') }}">
              @error('database')
                <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
              @enderror
            </div>
  
            <div class="col-span-12 lg:col-span-4">
              <label for="inputLogo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                Logo <span class="dark:text-gray-500">(opcional)</span>
              </label>
              <input type="file" name="restaurant_file" accept=".jpg,.jpeg,.png" id="inputLogo"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
              @error('restaurant_file')
                <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
              @enderror
            </div>
  
            <div class="col-span-full">
              <div class="flex gap-3 items-center">
                <button type="submit"
                  class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                  Registrar
                </button>
                <a href="{{ route('business.index') }}" type="button"
                  class="text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-500 dark:focus:ring-gray-700">
                  Cancelar
                </a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </x-app-layout>
  