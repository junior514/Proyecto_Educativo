<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocenteRequest extends FormRequest
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
            'nroDoc' => 'required|string|max:15|unique:docentes,nroDoc,' .  $this->idDocente . ',idDocente',
            'nomDoc' => 'required|string|max:191',
            'telDoc' => 'nullable|string|max:15',
            'dirDoc' => 'nullable|string|max:80',
            'espDoc' => 'nullable|string|max:80',
            'email' => !empty($this->email) ? 'required|string|email|max:191|unique:docentes,email,'  .  $this->idDocente . ',idDocente' : '',
            'password' => !empty($this->password) ? ['string', 'min:4', 'confirmed'] : '',
            'password_confirmation' => !empty($this->password_confirmation) && empty($this->password) ? 'confirmed': '',
        ];
    }

    public function messages()
    {
        return [
            'nroDoc.required' => 'El número de documento del docente es obligatorio.',
            'nroDoc.string' => 'El número de documento del docente debe ser una cadena de caracteres.',
            'nroDoc.max' => 'El número de documento del docente no puede exceder los 15 caracteres.',

            'nomDoc.required' => 'El nombre del docente es obligatorio.',
            'nomDoc.string' => 'El nombre del docente debe ser una cadena de caracteres.',
            'nomDoc.max' => 'El nombre del docente no puede exceder los 191 caracteres.',

            'telDoc.string' => 'El teléfono del docente debe ser una cadena de caracteres.',
            'telDoc.max' => 'El teléfono del docente no puede exceder los 15 caracteres.',

            'dirDoc.string' => 'La dirección del docente debe ser una cadena de caracteres.',
            'dirDoc.max' => 'La dirección del docente no puede exceder los 80 caracteres.',

            'espDoc.string' => 'La especialidad del docente debe ser una cadena de caracteres.',
            'espDoc.max' => 'La especialidad del docente no puede exceder los 80 caracteres.',

            'email.required' => 'El correo electrónico del docente es obligatorio.',
            'email.string' => 'El correo electrónico del docente debe ser una cadena de caracteres.',
            'email.email' => 'El correo electrónico del docente debe ser una dirección de correo válida.',
            'email.max' => 'El correo electrónico del docente no puede exceder los 191 caracteres.',
            'email.unique' => 'El correo electrónico del docente ya está en uso.',
        ];
    }
}
