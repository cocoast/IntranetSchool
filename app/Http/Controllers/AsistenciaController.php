<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Asistencia;
use App\Docente;
use App\Alumno;
use App\Curso;
use App\Establecimiento;
use DB;
use Auth;
use Carbon\Carbon;
use Laracasts\Flash\Flash;
use PDF;
class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id,Request $request=null)
    {

        $alumno= Alumno::find($id);
        $asistencias=Asistencia::search($request->name)->orderBy('fecha','ASC')->where('alumno_id',$alumno->id)->get();
        $inasistencias=count(Asistencia::search($request->name)->where('alumno_id',$alumno->id)->where('asistencia',0)->get());
        $asistio=count(Asistencia::search($request->name)->where('alumno_id',$alumno->id)->where('asistencia',1)->get());
        return view('docente.asistencias.index')
        ->with('alumno',$alumno)
        ->with('asistencias',$asistencias)
        ->with('inasistencias',$inasistencias)
        ->with('asistio',$asistio);
    }
    public function pdfAsistencias($id){
        $asistencias=Asistencia::where('alumno_id',$id)->where('asistencia',0)->orderBy('fecha','ASC')->get();
        $alumno=Alumno::where('id',$id)->first();
        return $this->CrearReporte($asistencias,$alumno);           
    }
    public function CrearReporte($asistencias,$alumno){
        $date=date('d-m-Y');
        $establecimiento=Establecimiento::first();
        $pdf=PDF::loadView('asistencia',compact('date','asistencias','alumno','establecimiento'));
        return $pdf->stream('asistencia');
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
        $docente=Docente::where('mail',Auth::user()->email)->first();
        $curso=Curso::where('docente_id','=',$docente->id)->first();
        $alumnos=Alumno::orderBy('apellido','ASC')->where('curso_id','=',$curso->id)->get();
        $fecha=$request->date;
        if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==6||jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==0){
         Flash::error("No se puede crear  Asistencia del Curso con fecha ".$fecha." ya que es Sabado o Domingo" );
         return view('docente.curso.index')
            ->with('docente',$docente)
            ->with('curso',$curso)
            ->with('alumnos',$alumnos);
     }
     if($fecha<Establecimiento::find(1)->s1inicio){
        Flash::warning("No se puede crear  Asistencia del Curso con fecha ".$fecha." ya que es anterior al inicio de Clases" );
         return view('docente.curso.crasistencia')
         ->with('docente',$docente)
         ->with('curso',$curso)
         ->with('alumnos',$alumnos);
     }
     if($fecha>Establecimiento::find(1)->s1fin&&$fecha<Establecimiento::find(1)->s2inicio){
         Flash::warning("No se puede crear  Asistencia del Curso con fecha ".$fecha." ya que es Periodo de Vacaciones" );
         return view('docente.curso.crasistencia')
         ->with('docente',$docente)
         ->with('curso',$curso)
         ->with('alumnos',$alumnos);
     }
     if($fecha>Establecimiento::find(1)->s2fin){
         Flash::warning("No se puede crear  Asistencia del Curso con fecha ".$fecha." ya que no pertenece al Año Academico" );
         return view('docente.curso.crasistencia')
         ->with('docente',$docente)
         ->with('curso',$curso)
         ->with('alumnos',$alumnos);
     }
     

     if(Asistencia::where('fecha',$fecha)->value('fecha')==$fecha)
     {
      foreach ($alumnos as $alumno) {
        if(Asistencia::where('fecha',$fecha)->where('alumno_id',$alumno->id)->get()->count()!=0) {
            $id=Asistencia::where('fecha',$fecha)->where('alumno_id',$alumno->id)->value('id'); 
            $asistencia=Asistencia::find($id);
            $asistencia->fecha=$fecha;
            $check='check-'.$alumno->id;
            if($request->$check)
                $asistencia->asistencia=1;
            else
                $asistencia->asistencia=0;
            $asistencia->alumno_id=$alumno->id;
            $asistencia->save(); 
        }
        else
        {
            $asistencia=new Asistencia();
            $asistencia->fecha=$fecha;
            $check='check-'.$alumno->id;
            if($request->$check)
                $asistencia->asistencia=1;
            else
                $asistencia->asistencia=0;
            $asistencia->alumno_id=$alumno->id;
            $asistencia->save(); 


        }

    }
    Flash::warning("Se ha Editado la Asistencia del Curso con fecha ".$fecha." de forma exitosa" );

    return redirect()->route('docentes.curso.index'); 
}
foreach ($alumnos as $alumno) {

    $asistencia=new Asistencia();
    $asistencia->fecha=$fecha;
    $check='check-'.$alumno->id;
    if($request->$check)
        $asistencia->asistencia=1;
    else
        $asistencia->asistencia=0;
    $asistencia->alumno_id=$alumno->id;
    $asistencia->save();
}
Flash::success("Se ha registrado la Asistencia del Curso con fecha ".$fecha."  de forma exitosa" );

return redirect()->route('docentes.curso.index'); 


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
        dd($id);
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
    public function diasSemana($fecha){
        if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==1)
            return '<td class="alert alert-danger" role="alert">Lunes</td>';

        if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==2)
            return '<td class="alert alert-danger" role="alert">Martes</td>';
        
        if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==3)
         return '<td class="alert alert-danger" role="alert">Miercoles</td>';

     if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==4)
         return '<td class="alert alert-danger" role="alert">Jueves</td>';

     if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==5)
         return '<td class="alert alert-danger" role="alert">Viernes</td>';

     if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==6)
         return '<td class="alert alert-danger" role="alert">Sabado</td>';

     if(jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0)==0)
         return '<td class="alert alert-danger" role="alert">Domingo</td>';



 }
 public function MesAno($fecha){

    if(explode('-',$fecha)[1]==3)
        return '<td class="alert alert-danger">Marzo</td>';

    if(explode('-',$fecha)[1]==4)
        return '<td class="alert alert-danger">Abril</td>';

    if(explode('-',$fecha)[1]==5)
        return '<td class="alert alert-danger">Mayo</td>';

    if(explode('-',$fecha)[1]==6)
        return '<td class="alert alert-danger">Junio</td>';

    if(explode('-',$fecha)[1]==7)
        return '<td class="alert alert-danger">Julio</td>';

    if(explode('-',$fecha)[1]==8)
        return '<td class="alert alert-danger">Agosto</td>';

    if(explode('-',$fecha)[1]==9)
        return '<td class="alert alert-danger">Septiembre</td>';

    if(explode('-',$fecha)[1]==10)
        return '<td class="alert alert-danger">Octubre</td>';

    if(explode('-',$fecha)[1]==11)
        return '<td class="alert alert-danger">Noviembre</td>';

    if(explode('-',$fecha)[1]==12)
        return '<td class="alert alert-danger">Diciembre</td>';

}

}
