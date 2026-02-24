<?php

namespace App\Http\Requests\Business;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequestStore extends FormRequest
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
        $id = $this->route('business'); 

        return [
            'name' => 'required',
            'business_name' => 'required',
            'business_address' => 'required',
            'rfc' => 'required|min:12|max:13',
            'telephone' => 'required|digits_between:10,15|unique:business,telephone,' . $id,
            'business_line' => 'required',
            'email' => 'required|email|unique:business,email,'.$id,
            'web' => 'nullable|url',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'regime' => 'nullable',
            'business_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
            'idregiment_sat' => 'nullable',
            'color_primary' => 'nullable',
            'color_secondary' => 'nullable',
            'color_accent' => 'nullable',
        ];
    }

    public function messages()
    {
         return [
            // Requeridos 
            'name.required' => 'El nombre comercial es necesario',
            'business_name.required' => 'El nombre la empresa es necesario',
            'business_address.required' => 'La direccion es necesaria',
            'rfc.required' => 'El rfc es necesario',
            'business_line.required' => 'El giro de la empresa es necesario',
            'email.required' => 'El correo es necesario',
            'state.required' => 'El estado es necesario',
            'city.required' => 'La ciudad es necesaria',
            'telephone.required' => 'El telefono es necesario', 
            'telephone.unique' => 'El teléfono ya está registrado en otra empresa.',
            'telephone.digits_between' => 'El teléfono debe tener entre 10 y 15 dígitos.',
            'rfc.max' => 'El RFC no puede tener más de 13 caracteres.',
        ];
    }
}
