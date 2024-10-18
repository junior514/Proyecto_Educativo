<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaFormRequest extends FormRequest
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
            'nomEmp' => 'required|max:255',
            'dirEmp' => 'required|max:255',
            'telEmp' => 'required|max:25',
            'rucEmp' => 'digits:13',
            'emaEmp' => 'max:191',
            'logEmp' => 'image|mimes:jpeg,png,jpg|max:8048',
        ];
    }
}
