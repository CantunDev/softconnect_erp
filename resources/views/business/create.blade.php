<x-app-layout>
  <div class="py-14">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <form action="{{ route('business.store') }}" method="POST" class="dark:bg-gray-800 rounded-xl p-5"
        enctype="multipart/form-data">
        @csrf
        @method('POST')
        <h1 class="text-white text-2xl mb-3 font-semibold">Nueva empresa</h1>

        <div class="grid gap-4 grid-cols-12">
          <div class="col-span-12 sm:col-span-6 lg:col-span-4">
            <label for="inputName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre
              corto</label>
            <input type="text" name="name" id="inputName"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Ej: Empresa Demo" value="{{ old('name') }}">
            @error('name')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-6 lg:col-span-6">
            <label for="inputBusinessName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre
              oficial</label>
            <input type="text" name="business_name" id="inputBusinessName"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Ej: Empresa Demo SA de CV" value="{{ old('business_name') }}">
            @error('business_name')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-4 md:col-span-3 lg:col-span-2">
            <label for="inputRfc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RFC</label>
            <input type="text" name="rfc" id="inputRfc" minlength="12" maxlength="13"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 uppercase"
              value="{{ old('rfc') }}">
            @error('rfc')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-8 md:col-span-6 lg:col-span-3">
            <label for="inputAddress"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dirección</label>
            <input type="text" name="business_address" id="inputAddress"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Ej: Calle A entre B y C" value="{{ old('business_address') }}">
            @error('business_address')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-6 md:col-span-3 lg:col-span-2">
            <label for="inputPhone"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
            <input type="tel" name="telephone" id="inputPhone" minlength="10" maxlength="15"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Ej: 9380000000" value="{{ old('telephone') }}">
            @error('telephone')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-6 lg:col-span-4">
            <label for="inputEmail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo
              electrónico</label>
            <input type="email" name="email" id="inputEmail"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 lowercase"
              placeholder="softconnect_erp@mail.com" value="{{ old('email') }}">
            @error('email')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-6 lg:col-span-3">
            <label for="inputWeb" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sitio web
              <span class="dark:text-gray-500">(opcional)</span></label>
            <input type="url" name="web" id="inputWeb"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Ej: www.sitioweb.com" value="{{ old('web') }}">
            @error('web')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-6 md:col-span-4 lg:col-span-3">
            <label for="inputBusinessLine" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Línea de
              negocio</label>
            <input type="text" name="business_line" id="inputBusinessLine"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              placeholder="Ej: Restaurantes" value="{{ old('business_line') }}">
            @error('business_line')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-4 lg:col-span-3">
            <label for="inputCountry" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">País</label>
            <input type="text" name="country" id="inputCountry"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ old('country', 'México') }}">
            @error('country')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-4 lg:col-span-3">
            <label for="inputState"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Estado</label>
            <input type="text" name="state" id="inputState"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ old('state') }}">
            @error('state')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-4 lg:col-span-3">
            <label for="inputCity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ciudad</label>
            <input type="text" name="city" id="inputCity"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ old('city') }}">
            @error('city')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-6 md:col-span-4">
            <label for="inputRegime" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Régimen <span class="dark:text-gray-500">(opcional)</span>
            </label>
            <input type="text" name="regime" id="inputRegime"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ old('regime') }}">
            @error('regime')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 sm:col-span-6 md:col-span-4">
            <label for="inputRegimensat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Regimen SAT <span class="dark:text-gray-500">(opcional)</span>
            </label>
            <input type="text" name="idregiment_sat" id="inputRegimensat"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
              value="{{ old('idregiment_sat') }}">
            @error('idregiment_sat')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-12 lg:col-span-4">
            <label for="inputLogo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
              Logo <span class="dark:text-gray-500">(opcional)</span>
            </label>
            <input type="file" name="business_file" accept=".jpg,.jpeg,.png" id="inputLogo"
              class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
            @error('business_file')
              <span class="block text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
          </div>

          <div class="col-span-full">
            <div class="flex gap-3 items-center">
              <button type="submit"
                class="inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-green-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-green-900 hover:bg-green-800">
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
