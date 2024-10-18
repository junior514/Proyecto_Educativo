<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AjusteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'nombre' => 'required|max:60',
            'direccion' => 'required|max:191',
            'telefono' => 'required|max:15',
            'ruc' => 'required|max:11',
            'correo' => 'nullable|email|max:91',
            'logo' => 'nullable|max:191',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.max' => 'El campo nombre no puede tener más de :max caracteres.',
            'direccion.required' => 'El campo dirección es obligatorio.',
            'direccion.max' => 'El campo dirección no puede tener más de :max caracteres.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.max' => 'El campo teléfono no puede tener más de :max caracteres.',
            'ruc.required' => 'El campo RUC es obligatorio.',
            'ruc.max' => 'El campo RUC no puede tener más de :max caracteres.',
            'correo.email' => 'El campo correo debe ser una dirección de correo electrónico válida.',
            'correo.max' => 'El campo correo no puede tener más de :max caracteres.',
            'logo.max' => 'El campo logo no puede tener más de :max caracteres.',
        ];
    }
}
