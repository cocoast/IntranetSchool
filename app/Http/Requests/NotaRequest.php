<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Alumno;

class NotaRequest extends Request
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

        return    [
        'fecha' =>'required|before:today',
        'observacion'   =>'required',
        
        ];
        
    }
    public function messages()
    {
        return [
        'fecha.before' => 'Fecha no puede ser Mayor que el dia de Hoy',
        ];

    }
}
