<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\FuturaEvaluacion;
use App\Asignatura;
use App\Curso;
use DB;
use Laracasts\Flash\Flash;

class ProximasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {   
        $date=date('Y-m-d');
        $asignatura=Asignatura::find($id);
        $proximas=FuturaEvaluacion::where('asignatura_id',$id)->orderBy('fecha','ASC')->where('fecha','>',$date)->get();
        return view('docente.proximas.index')
        ->with('proximas',$proximas)
        ->with('asignatura',$asignatura);
    }
    public function indexCurso($id){
        $date=date('Y-m-d');
        $curso=Curso::find($id);
        $proximas=FuturaEvaluacion::where('curso_id',$id)->orderBy('fecha','ASC')->where('fecha','>',$date)->get();
        return view('docente.curso.proximasindex')
        ->with('proximas',$proximas);

    }

    /*
  *   * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $asignatura=Asignatura::find($id);
        $idcurso=DB::table('curso_asignatura')->where('asignatura_id',$asignatura->id)->get();
        $cursos=Array();
        $cont=0;
        foreach ($idcurso as $id) {
            $curso=Curso::find($id->curso_id);
            $cursos[$curso->id]=$curso->nombre;
            $cont+=1;
        }  
        return view('docente.proximas.create')
        ->with('cursos',$cursos)
        ->with('asignatura',$asignatura);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proximas=new FuturaEvaluacion();
        $fecha=$request->fecha;
        $dia=jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0);
        if($dia==0||$dia==6){
            Flash::error("Fecha Corresponde a Sabado o Domingo" );
            return redirect()->route('docente.proximas.create',$request->asignatura);
        }
        $proximas->fecha=$request->fecha;
        $proximas->curso_id=$request->curso;
        $proximas->contenido=$request->contenido;
        $proximas->asignatura_id=$request->asignatura;
        $proximas->save();
        return redirect()->route('docente.proximas.index',$request->asignatura);
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
        $proximas=FuturaEvaluacion::find($id);
        $asignatura=Asignatura::where('id',$proximas->asignatura_id)->first();
        return view('docente.proximas.edit')
        ->with('proxima',$proximas)
        ->with('asignatura',$asignatura);
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
        $fecha=$request->fecha;
        $proxima=FuturaEvaluacion::find($id);
        $dia=jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0);
        if($dia==0||$dia==6){
            Flash::error("Fecha Corresponde a Sabado o Domingo" );
             return view('docente.proximas.edit')
        ->with('proxima',$proxima)
        ->with('asignatura',Asignatura::find($proxima->asignatura_id));
        }
       
        $proxima->fecha=$request->fecha;
        $proxima->contenido=$request->contenido;
        $proxima->save();
        return redirect()->route('docente.proximas.index',$proxima->asignatura_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $proximas=FuturaEvaluacion::find($id);
        $asignatura=Asignatura::find($proximas->asignatura_id);
        $proximas->delete();
        return redirect()->route('docente.proximas.index',$asignatura->id);
    }
}
