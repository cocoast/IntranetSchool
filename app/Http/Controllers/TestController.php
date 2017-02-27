<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Docente;

class TestController extends Controller
{
    public function view($id)
    {
        $docente = Docente::find($id);
        $docente->anotaciones;
        $docente->curso;
        $docente->Asignaturas;
       return view('test.index',['docente'=> $docente]); 
       
        
    }
}
