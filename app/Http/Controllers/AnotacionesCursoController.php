<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\AnotacionCurso;
use App\Curso;
use App\Asignatura;
use Laracasts\Flash\Flash;

class AnotacionesCursoController extends Controller
{
    
     public function index($id)
    {
        $curso=Curso::find($id);
        $anotaciones=AnotacionCurso::where('curso_id',$curso->id)->orderBy('fecha','ASC')->get();       
        return view ('docente.anotaciones.indexCurso')
            ->with('curso',$curso)
            ->with('anotaciones',$anotaciones);

    }
     public function create($id)
    {
        $curso=Curso::find($id);
        $asignaturas=$curso->Asignaturas()->lists('nombre','asignatura.id');
        return  view('docente.anotaciones.createCurso')
            ->with('curso',$curso)
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
        $anotacion=new AnotacionCurso();
        $anotacion->curso_id=$request->curso;
        $anotacion->tipo=$request->tipo;
        $anotacion->fecha=$request->fecha;
        $anotacion->asignatura_id=$request->asignatura;
        $anotacion->anotacion=$request->anotacion;
        $anotacion->save();
        Flash::success('Anotacion Creada de manera exitosa');
        return redirect()->route('docente.anotaciones.indexCurso',$request->curso);  
    }
     public function show($id)
    {
        //
    }

     public function edit($id)
    {
        $anotacion=AnotacionCurso::find($id);
        $curso=Curso::find($anotacion->curso_id);
        $asignaturas=$curso->Asignaturas()->lists('nombre','asignatura.id');
        return view('docente.anotaciones.editCurso')
            ->with('anotacion',$anotacion)
            ->with('asignaturas',$asignaturas)
            ->with('curso',$curso);
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
        $anotacion=AnotacionCurso::find($id);
        $anotacion->curso_id=$request->curso;
        $anotacion->tipo=$request->tipo;
        $anotacion->fecha=$request->fecha;
        $anotacion->asignatura_id=$request->asignatura;
        $anotacion->anotacion=$request->anotacion;
        $anotacion->save();
        Flash::warning('Anotacion editada de Forma exitosa');
        return redirect()->route('docente.anotaciones.indexCurso',$request->curso);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       $anotacion=AnotacionCurso::find($id);
       $curso=Curso::find($anotacion->curso_id);
       $anotacion->delete();
       Flash::error('Anotacion Eliminada de forma exitosa');
       return redirect()->route('docente.anotaciones.indexCurso',$curso->id);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    
}
