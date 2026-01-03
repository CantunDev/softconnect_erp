<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

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
            'email' => 'required|email',
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
            'telephone.unique' => 'El teléfono ya está registrado en otra empresa.',
            'telephone.digits_between' => 'El teléfono debe tener entre 10 y 15 dígitos.',
            'rfc.max' => 'El RFC no puede tener más de 13 caracteres.',
        ];
    }
}