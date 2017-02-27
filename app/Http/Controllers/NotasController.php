<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\NotaRequest;
use App\Alumno;
use App\Nota;
use App\Asignatura;
use App\Docente;
use App\Curso;
use App\Asistencia;
use App\Establecimiento;
use App\Http\Controllers\Controller;
use Laracasts\Flash\Flash;
use App\Anotacion;
use Auth;
use DB;
use PDF;
use Validator;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($var){
        if(Establecimiento::count()>0){
            $establecimiento=Establecimiento::first();
            $idcurso=explode('-',$var)[0];
            $idasignatura=explode('-',$var)[1];
            $curso=Curso::where('id',$idcurso)->first();
            $asignatura=Asignatura::where('id',$idasignatura)->first();
            $docente=Docente::where('mail',Auth::user()->email)->first();
            $alumnos=Alumno::orderBy('apellido','ASC')->where('curso_id','=',$curso->id)->get();


            return view('docente.notas.index')
            ->with('alumnos',$alumnos)
            ->with('curso',$curso)
            ->with('asignatura',$asignatura)
            ->with('establecimiento',$establecimiento);
        }
        else{
            $docente=Docente::where('mail',Auth::user()->email)->first();
            $asignaturas=$docente->Asignaturas()->get();
            Flash::Error("ESTABLECIMIENTO NO CONFIGURADO CONTACTE ADMINISTRADOR" ); 
            return view('docente.asignaturas.index')
            ->with('docente',$docente)
            ->with('asignaturas',$asignaturas);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($var){

        $idcurso=explode('-',$var)[0];
        $idasignatura=explode('-',$var)[1];
        $curso=Curso::where('id',$idcurso)->first();
        //dd($curso);
        $asignatura=Asignatura::where('id',$idasignatura)->first();
        //dd($asignatura);
        $docente=Docente::where('mail',Auth::user()->email)->first();
        $alumnos=Alumno::orderBy('apellido','ASC')->where('curso_id','=',$curso->id)->get();
        return view('docente.notas.create')
        ->with('alumnos',$alumnos)
        ->with('curso',$curso)
        ->with('asignatura',$asignatura); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotaRequest $request){
        $establecimiento=Establecimiento::find(1);
        $notas=Array();
        $fecha=$request->fecha;       
        $asignatura=Asignatura::where('id',$request->asignatura)->first();
        $curso=Curso::where('id',$request->curso)->first();
        $var=$curso->id.'-'.$asignatura->id;
        $alumnos=Alumno::where('curso_id',$curso->id)->get();
        $dia=jddayofweek(cal_to_jd(CAL_GREGORIAN,explode('-',$fecha)[1],explode('-',$fecha)[2],explode('-',$fecha)[0]),0);
        if($dia==0||$dia==6){
            Flash::error("Fecha: ".$fecha." Corresponde a Sabado o Domingo" );
            return view('docente.notas.create')
            ->with('alumnos',$alumnos)
            ->with('curso',$curso)
            ->with('asignatura',$asignatura);   
        }
        if($fecha>$establecimiento->s1fin&&$fecha<$establecimiento->s2inicio||$fecha<$establecimiento->s1inicio||$fecha>$establecimiento->s2fin){
         Flash::error("Fecha ".$fecha." NO Corresponde al Año Academico" );

         return view('docente.notas.create')
         ->with('alumnos',$alumnos)
         ->with('curso',$curso)
         ->with('asignatura',$asignatura);
     }   
     foreach ($alumnos as $alumno) {
         $validator=Validator::make($request->all(), [
            'nota-'.$alumno->id =>'required|integer|between:20,70',
            ]);
         if('nota-'.$alumno->id){
            $notaid='nota-'.$alumno->id; 
            $calificacion=$request->$notaid;
            $nota=new Nota();
            $nota->fecha=$fecha;
            $nota->observacion=$request->observacion;
            $nota->alumno_id=$alumno->id;
            $nota->asignatura_id=$asignatura->id;
            $nota->nota=$calificacion;
            $notas[$alumno->id]=$nota;

        }
        if ($validator->fails()) {
            return redirect()
            ->route('docente.notas.creates',$var)
            ->withErrors($validator)
            ->withInput();
        }
    }
    foreach ($alumnos as $alumno) {
        if(Nota::where('alumno_id',$alumno->id)->where('fecha',$fecha)->where('asignatura_id',$asignatura->id)->get()->count()==0){
        $nota=new Nota();
        $nota=$notas[$alumno->id];
        $nota->save();
    }
    else{
         Flash::error("Ya existen NOTAS registradas en esta fecha" );
         return view('docente.notas.create')
         ->with('alumnos',$alumnos)
         ->with('curso',$curso)
         ->with('asignatura',$asignatura);
    }
    }
    Flash::success("Se ha registrado las notas del curso ". $curso->nombre ." en la asigntarua ".$asignatura->nombre. " de forma exitosa" );

    return redirect()->route('docentes.asignaturas.index'); 

}
public function createOne($id)
{
    $fecha=explode('+',$id)[0];
    $alumno=Alumno::find(explode('+',$id)[1]);
    $asignatura=Asignatura::find(explode('+',$id)[2]);
    $aux=Nota::select('observacion')->where('fecha',$fecha)->where('asignatura_id',$asignatura->id)->distinct()->first();
    $observacion=$aux->observacion;
    return view ('docente.notas.createone')->with('fecha',$fecha)->with('alumno',$alumno)->with('asignatura',$asignatura)->with('observacion',$observacion);
}
public function storeOne(Request $request)
{
    $nota=new Nota();
    $nota->fecha=$request->fecha;
    $nota->nota=$request->nota;
    $nota->observacion=$request->observacion;
    $nota->alumno_id=$request->alumno;
    $nota->asignatura_id=$request->asignatura;
    $nota->save();
    Flash::success("Se ha registrado la nota de forma exitosa" );

    return redirect()->route('docentes.asignaturas.index'); 
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
    public function edit($id){
        $nota=Nota::find($id);
        return view('docente.notas.edit')
        ->with('nota',$nota);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        $nota=Nota::find($id);
        $oldnota=$nota->nota;
        $nota->nota=$request->nota;
        $nota->save();
        $alumno=Alumno::find($nota->alumno_id);
        $asignatura=Asignatura::find($nota->asignatura_id);
        Flash::warning('Se ha modificado la nota '.$oldnota.' por '.$nota->nota.' del alumno: ' .$alumno->nombre .' '. $alumno->apellido.' de fecha: '.$nota->fecha.' de la asignatura '.$asignatura->nombre );
        return redirect()->route('docentes.asignaturas.index');
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
    public function promedios1($alumno){
        $establecimiento=Establecimiento::find(1);
        $curso=Curso::find($alumno->curso_id);
        $asignaturas=$curso->Asignaturas()->get();
        $promedio=Array();
        $suma=0;
        foreach ($asignaturas as $asignatura) {
            $notas=Nota::select('nota')->where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->get();
            $suma=$notas->sum('nota');
            if($notas->count()!=0)
                $promedio[$asignatura->id]=round($suma/$notas->count());
            else
                $promedio[$asignatura->id]=0;
        }
        return $promedio;
    }
    public function promedios2($alumno){
        $establecimiento=Establecimiento::find(1);
        $curso=Curso::find($alumno->curso_id);
        $asignaturas=$curso->Asignaturas()->get();
        $promedio=Array();
        $suma=0;
        foreach ($asignaturas as $asignatura) {
            $notas=Nota::select('nota')->where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s2inicio)->where('fecha','<=',$establecimiento->s2fin)->get();
            $suma=$notas->sum('nota');
            if($notas->count()!=0)
                $promedio[$asignatura->id]=round($suma/$notas->count());
            else
                $promedio[$asignatura->id]=0;
        }
        return $promedio;
    }
    public function promedioFinal($alumno)  
    {
        $promedios1=$this->promedios1($alumno);
        $promedios2=$this->promedios2($alumno);
        $promediofinal=Array();
        $curso=Curso::find($alumno->curso_id);
        $asignaturas=$curso->Asignaturas()->get();
        foreach ($asignaturas as $asignatura) {
            if($promedios1[$asignatura->id]!=0&&$promedios2[$asignatura->id]!=0)
                $promediofinal[$asignatura->id]=round(($promedios1[$asignatura->id]+$promedios2[$asignatura->id])/2);
            else
                $promediofinal[$asignatura->id]="-";
        }
        return $promediofinal;
    }

    public function promedio($alumno){
        $establecimiento=Establecimiento::find(1);
        $curso=Curso::find($alumno->curso_id);
        $asignaturas=$curso->Asignaturas()->get();
        $promedio=Array();
        $sum=0;
        $notiene1=0;
        $notiene2=0;
        foreach ($asignaturas as $asignatura) {
            $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s1fin)->get();
            foreach ($notas as $nota) { 
                $sum=$sum+$nota->nota;
            }
            if(count($notas)==0){
                $promedio[$asignatura->id.'s1']=0;
                $notiene1+=1;
            }
            else
            {
                $promedio[$asignatura->id.'s1']=round($sum/count($notas));    
            }
            $sum=0;
        }
        foreach ($asignaturas as $asignatura) {
            $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->get();
            foreach ($notas as $nota) { 
                $sum=$sum+$nota->nota;
            }
            if(count($notas)==0){
                $promedio[$asignatura->id.'s2']=0;
                $notiene2+=1;
            }
            else
            {
                $promedio[$asignatura->id.'s2']=round($sum/count($notas));    
            }
            $sum=0;
        }
        foreach ($asignaturas as $asignatura) {
            $promedio[$asignatura->id.'final']=round(($promedio[$asignatura->id.'s1']+$promedio[$asignatura->id.'s2'])/2);
        }
         //promedio final 1 semestre
        foreach ($asignaturas as $asignatura) {
            $sum=$sum+$promedio[$asignatura->id.'s1'];
        }
        $final1=$sum/count($asignaturas);
        $sum=0;
            //promedio final 2 semestre
        foreach ($asignaturas as $asignatura) {
            $sum=$sum+$promedio[$asignatura->id.'s2'];
        }
        $final2=$sum/count($asignaturas);
        $sum=0;
        if($notiene1==0)
            $promedio['final1']=round($final1);
        else
            $promedio['final1']='-';
        if($notiene2==0)
            $promedio['final2']=round($final2);

        else
            $promedio['final2']='-';
        if($notiene1==0&&$notiene2==0)
            $promedio['final']=round(($final2+$final1)/2);
        else
            $promedio['final']='-';
        return $promedio; 
    }
    public function promedioCurso($id){
        $curso=Curso::find($id);
        $alumnos=Alumno::where('curso_id',$curso->id)->get();
        $asignaturas=$curso->Asignaturas()->get();
        $promedioscurso=Array();
        $pura=0;
        $profi=0;
        $asid="";
        foreach ($asignaturas as $asignatura) {
            foreach ($alumnos as $alumno) {
                $proalumno=$this->promedio($alumno);    
                $asid=$asignatura->id;
                $pura+=$proalumno[$asignatura->id.'final'];
            }
            $promedioscurso[$asid]=round($pura/$alumnos->count());
            $profi+=round($pura/$alumnos->count());
            $pura=0;
        }
        $promedioscurso['final']=round($profi/$asignaturas->count());
        return $promedioscurso;
    }

    public function indexrepo($id){
        $alumno=Alumno::find($id);
        return view('docente.informes.index')
        ->with('alumno',$alumno);
    }

    public function cantnotas($id,$periodo){
        $alumno=Alumno::find($id);
        $curso=Curso::find($alumno->curso_id);
        $asignaturas=$curso->Asignaturas()->get();
        $establecimiento=Establecimiento::find(1);
        $cant=0;
        if($periodo=='s1'){
            $fecha1=$establecimiento->s1inicio;
            $fecha2=$establecimiento->s1fin;
        }
        if($periodo=='s2'){
            $fecha1=$establecimiento->s2inicio;
            $fecha2=$establecimiento->s2fin;
        }
        if($periodo=='final'){
            $fecha1=$establecimiento->s1inicio;
            $fecha2=$establecimiento->s2fin;
        }
        foreach ($asignaturas as $asignatura) {
            $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$fecha1)->where('fecha','<=',$fecha2)->get()->count();
            if($cant==0)
                $cant=$notas;
            if($cant<$notas)
                $cant=$notas;
        }
        return $cant;
    }

    public function notassemestral1($id){
        $date=date('d-m-Y');
        $contnotas=0;
        $alumno=Alumno::find($id);
        $establecimiento=Establecimiento::find(1);
        $curso=Curso::find($alumno->curso_id);
        $masnotas=$this->cantnotas($alumno->id,'s1');
        $str=$alumno->curso->docente->rut;
        $rut=substr($str,0,strlen($str)-1);
        $digito=substr($str,-1);
        $rutdocente=$rut.'-'.$digito;
        $asignaturas=$curso->Asignaturas()->get();
        $notas=Nota::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->orderBy('fecha','ASC')->get();
        $promedios1=$this->promedios1($alumno);
        $negativas=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',0)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->get());
        $positivas=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',1)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->get());
        $asistencias=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->where('asistencia',1)->count();
        $asistotal=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->count();   
        if($asistotal!=0)   
            $asistencia=intval(($asistencias/$asistotal)*100);
        else
            $asistencia="no posee Asistencia";

        $pdf=PDF::loadView('docente.informes.notassemestral1',compact('alumno','curso','asignaturas','establecimiento','notas','promedios1','date','negativas','positivas','asistencia','rutdocente','masnotas','contnotas'));
        return $pdf->stream($alumno->rut.'primersemestre.pdf');  

    }

    public function notassemestral2($id){
        $date=date('d-m-Y');
        $contnotas=0;
        $alumno=Alumno::find($id);
        $establecimiento=Establecimiento::find(1);
        $curso=Curso::find($alumno->curso_id);
        $masnotas=$this->cantnotas($alumno->id,'s2');
        $str=$alumno->curso->docente->rut;
        $rut=substr($str,0,strlen($str)-1);
        $digito=substr($str,-1);
        $rutdocente=$rut.'-'.$digito;
        $asignaturas=$curso->Asignaturas()->get();
        $notas=Nota::where('alumno_id',$alumno->id)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->orderBy('fecha','ASC')->get();
        $promedios2=$this->promedios2($alumno);
        $negativas=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',0)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->get());
        $positivas=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',1)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->get());
        $asistencias=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->where('asistencia',1)->count();
        $asistotal=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->count();
        if($asistotal!=0)   
            $asistencia=intval(($asistencias/$asistotal)*100);
        else
            $asistencia="0";

        $pdf=PDF::loadView('docente.informes.notassemestral2',compact('alumno','curso','asignaturas','establecimiento','notas','promedios2','date','negativas','positivas','asistencia','rutdocente','masnotas','contnotas'));
        return $pdf->stream($alumno->rut.'seguntosemestre.pdf');  
    }

    public function notasAnual($id){
        $date=date('d-m-Y');
        $alumno=Alumno::find($id);
        $establecimiento=Establecimiento::find(1);
        $curso=Curso::find($alumno->curso_id);
        $str=$alumno->curso->docente->rut;
        $rut=substr($str,0,strlen($str)-1);
        $digito=substr($str,-1);
        $rutdocente=$rut.'-'.$digito;
        $asignaturas=$curso->Asignaturas()->get();
        $procurso=$this->promedioCurso($curso->id);
        $contnotas=0;
        /*
        *Primer Semestre
        */  
        $masnotas1=$this->cantnotas($alumno->id,'s1');
        $notas1=Nota::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->orderBy('fecha','ASC')->get();
        $promedios1=$this->promedios1($alumno);
        $negativas1=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',0)->where('fecha','>',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s1fin)->get());
        $positivas1=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',1)->where('fecha','>',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s1fin)->get());
        $asistencias1=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s1fin)->where('asistencia',1)->count();
        $asistotal1=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s1fin)->count();   
        if($asistotal1!=0)   
            $asistencia1=intval(($asistencias1/$asistotal1)*100);
        else
            $asistencia1="0";
        /*
        *Inicio Segundo Semestre
        */
        $masnotas2=$this->cantnotas($alumno->id,'s2');
        $notas2=Nota::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s2inicio)->where('fecha','<=',$establecimiento->s2fin)->orderBy('fecha','ASC')->get();
        $promedios2=$this->promedios2($alumno);
        $negativas2=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',0)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->get());
        $positivas2=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',1)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->get());
        $asistencias2=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->where('asistencia',1)->count();
        $asistotal2=Asistencia::where('alumno_id',$alumno->id)->where('fecha','>',$establecimiento->s2inicio)->where('fecha','<',$establecimiento->s2fin)->count();
        if($asistotal2!=0)   
            $asistencia2=intval(($asistencias2/$asistotal2)*100);
        else
            $asistencia2="0";
        /*
        *Fin Segundo semestre
        */
        $profinal=$this->promedioFinal($alumno);
        $pdf=PDF::setPaper('letter','landscape')->loadView('docente.informes.notasanual',compact('alumno','curso','asignaturas','establecimiento','date','rutdocente','promedios1','notas1','negativas1','positivas1','asistencia1','masnotas1','promedios2','notas2','negativas2','positivas2','asistencia2','masnotas2','profinal','procurso','contnotas'));
        return $pdf->stream($alumno->rut.'notasanual.pdf');  
    }

    public function certificadoAnual($id){
        $date=date('d-m-Y');
        $contnotas=0;
        $establecimiento=Establecimiento::find(1);
        $alumno=Alumno::find($id);
        $curso=Curso::find($alumno->curso_id);
        $asignaturas= $asignaturas=$curso->Asignaturas()->get();
        $str=$alumno->curso->docente->rut;
        $rut=substr($str,0,strlen($str)-1);
        $digito=substr($str,-1);
        $rutdocente=$rut.'-'.$digito;
        $promedios1=$this->promedios1($alumno);
        $promedios2=$this->promedios2($alumno);
        $profinal=$this->promedioFinal($alumno);
        
        $negativas=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',0)->where('fecha','>',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s2fin)->get());
        $positivas=count(Anotacion::where('alumno_id',$alumno->id)->where('tipo',1)->where('fecha','>',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s2fin)->get());
        if(Asistencia::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s2fin)->count()!=0)
            $asistencia=round((Asistencia::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s2fin)->where('asistencia',1)->count())/Asistencia::where('alumno_id',$alumno->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s2fin)->count()*100);
        else
            $asistencia=0;     
        $pdf=PDF::loadView('docente.informes.certificadoanual',compact('alumno','curso','asignaturas','establecimiento','promedios1','promedios2','profinal','date','negativas','positivas','asistencia','rutdocente','contnotas'));
        return $pdf->stream($alumno->rut.'certificado_anual.pdf');  
    }

}
