<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AlumnoUpdateRequest extends Request
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
            'rut'           =>  'required',
            'mail'          =>  'required',
            'telefono'      =>  'required',
            'direccion'     =>  'required',
            'apoderado_id'  =>  'required',
            'curso_id'      =>  'required',
        ];
    }
}
