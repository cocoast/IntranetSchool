<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Anotacion;  
use App\Alumno;
use App\Establecimiento;
use App\Docente;
use App\Curso;
use Laracasts\Flash\Flash;

class AnotacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     *Por alumno 
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $alumno=Alumno::find($id);
        $anotaciones=Anotacion::where('alumno_id',$alumno->id)->orderBy('fecha','ASC')->get();       
        return view ('docente.anotaciones.index')
        ->with('alumno',$alumno)
        ->with('anotaciones',$anotaciones);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $alumno=Alumno::find($id);
        $curso=Curso::find($alumno->curso_id);
        $asignaturas=$curso->Asignaturas()->lists('nombre','asignatura.id');
        return  view('docente.anotaciones.create')
        ->with('alumno',$alumno)
        ->with('asignaturas',$asignaturas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $anotacion=new Anotacion();
        $anotacion->alumno_id=$request->alumno;
        $anotacion->tipo=$request->tipo;
        $anotacion->fecha=$request->fecha;
        $anotacion->asignatura_id=$request->asignatura;
        $anotacion->anotacion=$request->anotacion;
        $anotacion->save();
        Flash::success('Anotacion Creada de manera exitosa');
        return redirect()->route('docente.anotaciones.index',$request->alumno);
        

        
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
        $anotacion=Anotacion::find($id);
        $alumno=Alumno::find($anotacion->alumno_id);
        $curso=Curso::find($alumno->curso_id);
        $asignaturas=$curso->Asignaturas()->lists('nombre','asignatura.id');
        return view('docente.anotaciones.edit')
        ->with('anotacion',$anotacion)
        ->with('asignaturas',$asignaturas)
        ->with('alumno',$alumno);
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
        $anotacion=Anotacion::find($id);
        $anotacion->alumno_id=$request->alumno;
        $anotacion->tipo=$request->tipo;
        $anotacion->fecha=$request->fecha;
        $anotacion->asignatura_id=$request->asignatura;
        $anotacion->anotacion=$request->anotacion;
        $anotacion->save();
        Flash::warning('Anotacion editada de Forma exitosa');
        return redirect()->route('docente.anotaciones.index',$request->alumno);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

     $anotacion=Anotacion::find($id);
     $alumno=Alumno::find($anotacion->alumno_id);
     $anotacion->delete();
     Flash::error('Anotacion Eliminada de forma exitosa');
     return redirect()->route('docente.anotaciones.index',$alumno->id);
 }
 
 


}
