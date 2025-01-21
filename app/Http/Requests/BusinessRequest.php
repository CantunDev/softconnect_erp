<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BusinessRequest extends FormRequest
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
            'name' => 'required',
            'business_name' => 'required',
            'business_address' => 'required',
            'rfc' => 'required|min:12|max:13',
            'telephone' => 'required|digits_between:10,15',
            'business_line' => 'required',
            'email' => 'required|email',
            'web' => 'nullable|url',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'regime' => 'nullable',
            'business_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'idregiment_sat' => 'nullable'
        ];
    }
}
