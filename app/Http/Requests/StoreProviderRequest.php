<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        return [
            'nombre' => ['required','min:3','max:100'],
            'razonsocial' => ['required', 'min:3', 'max:100'],
            'rfc' => ['required','min:12','max:13'],
            'direccion' => ['required', 'min:3'],
            'codigopostal' => ['required', 'min:5', 'max:5'],
            'email' => ['required'],
            'telefono' => ['required'],
        ];
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

            'email.required' => 'El correo es obligatorio',

            'telefono.required' => 'El telefono es obligatorio'

        ];
    }
}
