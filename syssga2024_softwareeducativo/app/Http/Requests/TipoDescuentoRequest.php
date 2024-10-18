<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipoDescuentoRequest extends FormRequest
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
            'nombreTP' => 'required|max:60|unique:tipos_descuento,nombreTP,' . $this->idTipoDescuento . ',idTipoDescuento',
            'valorPorcentaje' => 'required|integer|max:100|min:0',
        ];
    }

    public function messages()
    {
        return [
            'nombreTP.required' => 'El campo Nombre del Tipo de Descuento es obligatorio.',
            'nombreTP.max' => 'El campo Nombre del Tipo de Descuento no debe ser mayor a 60 caracteres.',
            'nombreTP.unique' => 'El Nombre del Tipo de Descuento ya ha sido registrado.',
            'valorPorcentaje.required' => 'El campo Valor Porcentaje es obligatorio.',
            'valorPorcentaje.integer' => 'El campo Valor Porcentaje debe ser un número entero.',
        ];
    }
}
