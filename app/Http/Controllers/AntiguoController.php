<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Antiguo;
use App\AntiguoAnotacion;
use App\AntiguoAsignatura;
use App\AntiguoCurso;
use App\AntiguoAsistencia;

class AntiguoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $antiguo=Antiguo::search($request->name)->orderBy('apellido','ASC')->paginate(25);
        return view('admin.alumnos.ghost')->with('alumnos',$antiguo);
    }
    public function listarAdmin($id)
    {
        $antiguo=Antiguo::find($id);
        $promedios=$this->Promedios($id);
        $asignaturas=$this->Asignaturas($id);
        $anotaciones=$this->Anotacion($id);
        $asistencias=$this->Asistencia($id);
        $cursos=$this->Curso($id);
        //dd($cursos,$asistencias,$anotaciones);
        return view('admin.antiguo.index')->with('antiguo',$antiguo)->with('promedios',$promedios)->with('anotaciones',$anotaciones)->with('asistencias',$asistencias)->with('cursos',$cursos)->with('asignaturas',$asignaturas);
    }
    public function listarDocente($id)
    {
        $antiguo=Antiguo::find($id);
        $promedios=$this->Promedios($id);
        $asignaturas=$this->Asignaturas($id);
        $anotaciones=$this->Anotacion($id);
        $asistencias=$this->Asistencia($id);
        $cursos=$this->Curso($id);
        return view('docente.alumno.antiguo')->with('antiguo',$antiguo)->with('promedios',$promedios)->with('anotaciones',$anotaciones)->with('asistencias',$asistencias)->with('cursos',$cursos)->with('asignaturas',$asignaturas);   
        
        
    }
    public function Asignaturas($id)    
    {
     $antiguo=Antiguo::find($id);
     $asignaturas=AntiguoAsignatura::where('id_antiguo',$id)->orderBy('ano','ASC')->get(); 
     return $asignaturas;  
 }
 public function Promedios($id)
 {
    $antiguo=Antiguo::find($id);
    $asignaturas=AntiguoAsignatura::where('id_antiguo',$id)->orderBy('ano','ASC')->get();
    $promedio=Array();
    $year=2015;
    $suma=0;
    $cont=0;
    foreach ($asignaturas as $asignatura) {               
        if($year==$asignatura->ano){
            $final=round(($asignatura->promedio_s1+$asignatura->promedio_s2)/2);
            $suma+=$final;
            $cont+=1;
            $final=0;
        }
        else{
            $promedio[$year]=round($suma/$cont);
            $suma=0;
            $cont=0;
            $year+=1;
        }

    }
    $promedio[$year]=round($suma/$cont);
    $suma=0;
    $cont=0;
    $year+=1;
    return $promedio;
}
public function Anotacion($id)  
{
    $antiguo=Antiguo::find($id);
    $anotacion=AntiguoAnotacion::where('id_antiguo',$antiguo->id)->get();
    return $anotacion;
}
public function Asistencia($id) 
{
    $antiguo=Antiguo::find($id);
    $asistencia=AntiguoAsistencia::where('id_antiguo',$antiguo->id)->get();
    return $asistencia;
}
public function Curso($id)
{
    $antiguo=Antiguo::find($id);
    $cursos=AntiguoCurso::where('id_antiguo',$antiguo->id)->get();
    return $cursos;
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
