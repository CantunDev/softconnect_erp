<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequestStore extends FormRequest
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
            'name'      => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'lastname'  => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'surname'   => ['required', 'string', 'min:3', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/'],
            'phone'     => ['required', 'digits:10'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'user_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            // Nombre
            'name.required' => 'El nombre es requerido',
            'name.min'      => 'El nombre debe tener al menos 3 caracteres',
            'name.regex'    => 'El nombre solo puede contener letras',

            // Apellido paterno
            'lastname.required' => 'El apellido paterno es requerido',
            'lastname.min'      => 'El apellido paterno debe tener al menos 3 caracteres',
            'lastname.regex'    => 'El apellido paterno solo puede contener letras',

            // Apellido materno
            'surname.required' => 'El apellido materno es requerido',
            'surname.min'      => 'El apellido materno debe tener al menos 3 caracteres',
            'surname.regex'    => 'El apellido materno solo puede contener letras',

            // Teléfono
            'phone.required' => 'El teléfono es requerido',
            'phone.digits'   => 'El teléfono debe tener exactamente 10 dígitos',

            // Resto
            'email.required'    => 'El correo es requerido',
            'email.unique'      => 'Este correo ya está registrado',
            'password.required' => 'La contraseña es requerida',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres',
            'user_file.image'   => 'El archivo debe ser una imagen',
            'user_file.mimes'   => 'La imagen debe ser jpeg, png, jpg o gif',
            'user_file.max'     => 'La imagen no debe pesar más de 2MB',
        ];
    }
}
