<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
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
            'nombreProducto' => 'required|string|max:191|unique:productos,nombreProducto,' . $this->idProducto  . ',idProducto',
            'precio' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'nombreProducto.required' => 'El nombre del producto es obligatorio.',
            'nombreProducto.string' => 'El nombre del producto debe ser una cadena de texto.',
            'nombreProducto.max' => 'El nombre del producto no puede exceder los 191 caracteres.',
            'nombreProducto.unique' => 'El nombre del producto ya existe en la base de datos.',
        ];
    }
}

