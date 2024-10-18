<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormaPagoRequest extends FormRequest
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
            'nombreFP' => 'required|max:60|unique:formas_pago,nombreFP,' . $this->idFormaPago . ',idFormaPago',
        ];
    
    }

    public function messages()
    {
        return [
            'nombreFP.required' => 'El campo Nombre de Forma de Pago es obligatorio.',
            'nombreFP.max' => 'El campo Nombre de Forma de Pago no debe ser mayor a 60 caracteres.',
            'nombreFP.unique' => 'El Nombre de Forma de Pago ya ha sido registrado.',
        ];
    }
}
