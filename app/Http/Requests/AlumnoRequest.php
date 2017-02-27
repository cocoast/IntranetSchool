<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AlumnoRequest extends Request
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
            'nombre'        =>  'required',
            'apellido'      =>  'required',
            'rut'           =>  'required|unique:alumno',
            'mail'          =>  'required|unique:alumno',
            'telefono'      =>  'required',
            'direccion'     =>  'required',
            'curso_id'      =>  'required',
        ];
    }
}
