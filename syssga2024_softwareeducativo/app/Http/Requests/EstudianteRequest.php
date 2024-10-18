<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstudianteRequest extends FormRequest
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
            'nroDoc' => 'required|max:15|unique:estudiantes,nroDoc,'. $this->idEstudiante . ',idEstudiante',
            'nomEst' => 'required|max:191',
            'telEst' => 'max:15',
            'dirEst' => 'max:80',
            'correoEst' => 'max:191',
            'generoEst' => 'max:45',
            'email' => !empty($this->password) ? 'required|max:191|unique:estudiantes,email,'. $this->idEstudiante . ',idEstudiante' : '',
            'password' => !empty($this->password) ? ['string', 'min:4', 'confirmed'] : '',
            'password_confirmation' => !empty($this->password_confirmation) && empty($this->password) ? 'confirmed': '',
        ];
    }

    public function messages()
    {
        return [
            'nroDoc.required' => 'El número de documento es obligatorio.',
            'nroDoc.unique' => 'El número de documento ya está registrado.',
            'nroDoc.max' => 'El número de documento no puede ser mayor a 15 caracteres.',
            'nomEst.required' => 'El nombre es obligatorio.',
            'nomEst.max' => 'El nombre no puede ser mayor a 191 caracteres.',
            'telEst.max' => 'El teléfono no puede ser mayor a 15 caracteres.',
            'dirEst.max' => 'La dirección no puede ser mayor a 80 caracteres.',
            'generoEst.max' => 'El género no puede ser mayor a 191 caracteres.',
            'f_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.max' => 'El correo electrónico no puede ser mayor a :max caracteres.',
            'email.unique' => 'El correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.max' => 'La contraseña no puede ser mayor a 191 caracteres.',
            'fecCre.required' => 'La fecha de creación es obligatoria.',
            'fecCre.date' => 'La fecha de creación debe ser una fecha válida.',
        ];
    }
}
