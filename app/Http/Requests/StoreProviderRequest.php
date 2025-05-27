<?php

namespace App\Http\Requests;

use App\Models\Sfrt\Provider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class StoreProviderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $connectionName = Provider::query()->getConnection()->getName();
        // dd($connectionName);
        return [
            'nombre' => ['required', 'min:3', 'max:100', 'unique:sqlsrv.proveedores,nombre'],
            'razonsocial' => ['required', 'min:3', 'max:100'],
            'rfc' => ['required', 'min:12', 'max:13', 'unique:sqlsrv.proveedores,rfc'],
            'direccion' => ['required', 'min:3'],
            'codigopostal' => ['required', 'min:5', 'max:5'],
            'email' => ['required', 'unique:sqlsrv.proveedores,email'],
            'fax' => ['nullable'],
            'credito' => ['nullable'],
            'estatus' => ['required'],
            'telefono' => ['required', 'unique:sqlsrv.proveedores,telefono'],
            'idtipoproveedor' => ['required'],
            'cuentaclave' => ['required', 'digits:18', 'regex:/^\d{18}$/','unique:sqlsrv.proveedores,cuentaclave'],
            'nocuenta' => ['required', 'digits_between:10,12', 'regex:/^\d{10,12}$/', 'unique:sqlsrv.proveedores,nocuenta'],
            'nombrebanco' => ['required', 'string'],
        ];

        Log::info('Reglas de validación:', $rules);
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.min' => 'Debe tener al menos 3 caracteres',

            'razonsocial.required' => 'La razon social es obligatoria',
            'razonsocial.min' => 'Debe tener al menos 3 caracteres',

            'rfc.required' => 'El RFC es obligatorio',
            'rfc.min' => 'Debe tener al menos 12 caracteres',

            'direccion.required' => 'La direccion no puede estar vacia',

            'codigopostal.required' => 'El codigo postal es obligatorio',
            'codigopostal.min' => 'Debe tener 5 digitos',

            'idtipoproveedor.required' => 'Selecciona el tipo de proveedor',

            'email.required' => 'El correo es obligatorio',

            'telefono.required' => 'El telefono es obligatorio',

            'nombrebanco.required' => 'Selecciona un banco',
            'nombrebanco.string' => 'Solo se permite una opcion de las listadas',

            'cuentaclave.required' => 'La cuenta CLABE es obligatoria.',
            'cuentaclave.digits' => 'La CLABE debe tener exactamente 18 dígitos.',
            'cuentaclave.required' => 'El número de cuenta es obligatorio.',

            'nocuenta.digits_between' => 'El número de cuenta debe tener entre 10 y 12 dígitos.',

        ];
    }
}
