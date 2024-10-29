<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuevo proveedor') }}
        </h2>

        <section class="bg-white dark:bg-gray-900">
            <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
                {{-- <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">Add a new product</h2> --}}
                <form action="{{route('providers.store')}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="grid gap-4 sm:grid-cols-4 sm:gap-6">
                        <div class="sm:col-span-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->name}}" required="">
                        </div>
                        <div class="sm:col-span-4">
                            <label for="company_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Razon Social</label>
                            <input type="text" name="company_name" id="company_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->company_name}}" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="rfc" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">RFC</label>
                            <input type="text" name="rfc" id="rfc" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->rfc}}" required="">
                        </div>
                        <div class="col-span-1">
                            <label for="telephone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefono</label>
                            <input type="tel" name="telephone" id="telephone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->telephone}}" required="">
                        </div>
                        <div class="w-full">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->email}}" required="">
                        </div>
                        <div class="col-span-3">
                            <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Direccion</label>
                            <input type="text" name="address" id="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->address}}" required="">
                        </div>
                        <div class="col-span-1">
                            <label for="cp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CP</label>
                            <input type="text" name="cp" id="cp" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->cp}}" required="">
                        </div>
                       
                        <div class="w-full">
                            <label for="credit_days" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dias credito</label>
                            <input type="number" name="credit_days" id="credit_days" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{$provider->credit_days}}" required="">
                        </div>
                        <div>
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tipo de proveedor</label>
                            <select id="type" name="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected="">Selecciona tipo</option>
                                <option value="General"  {{ $provider->type == 'General' ? 'selected' : '' }}>General</option>
                                <option value="Carnes"  {{ $provider->type == 'Carnes' ? 'selected' : '' }}>Carnes</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-yellow-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-yellow-400 hover:bg-yellow-500">
                        Actualizar 
                    </button>
                    <a href="{{URL::previous()}}" type="button" class="ml-4 text-gray-700 hover:text-white border border-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-gray-500 dark:text-gray-500 dark:hover:text-white dark:hover:bg-gray-500 dark:focus:ring-gray-700">
                        Cancelar 
                    </a>
                </form>
            </div>
        </section>
    </x-slot>
</x-app-layout>