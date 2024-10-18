<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MatriculaRequest extends FormRequest
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
            'idCurso' => 'required|unique:matriculas,idCurso,' . $this->idMatricula . ',idMatricula,idEstudiante,' . $this->idEstudiante,
            // 'precioMat' => 'required|numeric',
            // 'precioMod' => 'required|numeric',
            // 'nroCuotas' => 'required|numeric',
        ];
    }

     public function messages()
    {

        return [
            'idCurso.unique' => 'El estudiante ya se encuentra matriculado en el curso seleccionado.',
            // 'precioMat.numeric' => 'El valor de matrícula debe ser un número.',
            // 'precioMod.numeric' => 'El valor de módulo debe ser un número.',
            // 'nroCuotas.numeric' => 'El N° de cuotas debe ser un número.',
        ];
    }
}
