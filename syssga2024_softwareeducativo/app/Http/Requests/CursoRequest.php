<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
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
            'nomCur' => 'required|string|max:250|unique:cursos,nomCur,' . $this->idCurso . ',idCurso',
        ];
    }

    public function messages()
    {
        return [
            'nomCur.required' => 'El nombre del curso es obligatorio.',
            'nomCur.string' => 'El nombre del curso debe ser una cadena de caracteres.',
            'nomCur.max' => 'El nombre del curso no puede exceder los 250 caracteres.',
            'nomCur.unique' => 'El nombre del curso ya está en uso.',
        ];
    }
}
