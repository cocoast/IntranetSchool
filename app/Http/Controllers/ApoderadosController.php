<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\ApoderadoUpdateRequest;
use App\Http\Requests\ApoderadoRequest;
use App\Http\Controllers\Controller;
use App\Apoderado;
use App\Alumno;
use App\Curso;
use App\Asistencia;
use App\Nota;
use App\Establecimiento;
use App\FuturaEvaluacion;
use App\AnotacionCurso;
use App\Anotacion;
use App\Asignatura;
use App\User;
use Laracasts\Flash\Flash;
use Excel;
use Auth;
use App\Reunion;

class ApoderadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $apoderados=Apoderado::search($request->name)->orderBy('id','ASC')->paginate(30);
        return view('admin.apoderados.index')->with('apoderados',$apoderados);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.apoderados.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ApoderadoRequest $request)
    {
        if(User::where('email',$request->mail)->get()->count()==0){
            $apoderado=new Apoderado($request->all());
            $rut=str_replace('-','',$request->rut);
            $rut=str_replace('.','',$rut);
            $apoderado->rut=$rut;
            $apoderado->mail=$request->mail;
            $user=New User();
            $nombre_completo=$request->nombre .' '. $request->apellido;
            $user->name=$nombre_completo;
            $user->email=$request->mail;
            $user->password=bcrypt($request->rut);
            $user->type='apoderado';
            $user->save();
            $apoderado->save();
            Flash::error( "El rut Ingresado ya se encuentra registrado Favor contacte a su Administrador");
            return redirect()->route('admin.apoderados.index'); 
        }
        else{
            Flash::error("Se ha registrado ". $apoderado->nombre ." ".$apoderado->apellido . " de forma exitosa" );
            return redirect()->route('admin.apoderados.index');    
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $apoderado    =   Apoderado::find($id);
        return view('admin.apoderados.edit')->with('apoderado',$apoderado);        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ApoderadoUpdateRequest $request, $id)
    {
        $apoderado    =   Apoderado::find($id);
        $apoderado->nombre=$request->nombre;
        $apoderado->apellido=$request->apellido;
        $apoderado->rut=$request->rut;
        $apoderado->mail=$request->mail;
        $apoderado->telefono=$request->telefono;
        $apoderado->save();

        Flash::warning("Se ha editado ". $apoderado->nombre ." ".$apoderado->apellido . " de forma exitosa" );

        return redirect()->route('admin.apoderados.index'); 
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
        * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apoderado    =Apoderado::find($id);
        $nombre=$apoderado->nombre ." ".$apoderado->apellido;
        if(Alumno::where('apoderado_id',$apoderado->id)->get()->count()==0){
            $apoderado->delete();
            Flash::error('El apoderado '.$nombre. " ha sido borrado de forma exitosa");
            return redirect()->route('admin.apoderados.index'); 
        }
        else{
           Flash::error('El apoderado '.$nombre. " No se puede Eliminar ya que tiene dependencias");
           return redirect()->route('admin.apoderados.index');        
       }
   }
   public function upExcel(Request $request)
   {
    if($request->file('apoderados')!=null){
        $file   =   $request->file('apoderados');
        if($file->getClientOriginalExtension()!='xls'){
            Flash::error('Favor Seleccione un archivo Excel en Formato XLS');
            return redirect()->route('admin.apoderados.index');    
        }
        else{
            $name   =   'apoderados_'.time().'.'.$file->getClientOriginalExtension();
            $path   =   public_path().'/uploads/';
            $file->move($path,$name);
            $archivo=$path.''.$name;
            return $this->storeExcel($archivo);
        }
    }
    else{
        Flash::error('Favor Seleccione un archivo');
        return redirect()->route('admin.apoderados.index');
    }
}
public function storeExcel($archivo)
{   
    Excel::load($archivo,function($archivo)
    {
        $result=$archivo->get();
        foreach ($result as $key =>$value) 
            { if(Apoderado::where('nombre',$value->nombre)->where('rut',$value->rut)->where('apellido',$value->apellido)->get()->count()==0&&User::where('email',$value->email)->get()->count()==0){
                $apoderado =new Apoderado();
                $apoderado->nombre=$value->nombres;
                $apoderado->apellido=$value->apellidos;

                $rut=str_replace('-','',$value->rut);
                $rut=str_replace('.','',$rut);
                $apoderado->rut=$rut;
                $apoderado->mail=$value->email;
                $apoderado->telefono=$value->telefono;
                $nombre_completo=$apoderado->nombre .' '. $apoderado->apellido;
                $user=New User();
                $user->name=$nombre_completo;
                $user->email=$apoderado->mail;
                $user->password=bcrypt($rut);
                $user->type='apoderado';
                $user->save();
                $apoderado->save();
            }

        }
    })->get();
    Flash::success("El archivo a sido Importado de forma exitosa");
    return redirect()->route('admin.index');     
}
public function Alumno($id)
{
    $apoderado=Apoderado::where('mail',Auth::user()->email)->first();
    $alumnos=Alumno::where('apoderado_id',$apoderado->id)->get();
    $date=date('d-m-Y');
    $mespasado= date("d-m-Y",mktime(0,0,0,date("d")-1,date("m"),date("Y")));
    $alumno=Alumno::find($id);
    $curso=Curso::find($alumno->curso_id);
    $asignaturas=$curso->Asignaturas()->get();
    $presente=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',1)->get();
    $ausente=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',0)->get();
    $aus=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',0)->orderBy('fecha','DESC')->limit(7)->get();
    $total=Asistencia::where('alumno_id',$alumno->id)->get();
    $asignaturas=$curso->Asignaturas()->get();
    $notas=Nota::where('alumno_id',$alumno->id)->having('fecha','>',$mespasado)->orderBy('updated_at','DESC')->limit(7)->get();
    $promedios=$this->promedio($alumno);
    $promediocurso=$this->promedioCurso($curso->id);
    $reunion=$this->comunicado($curso->id);

    return view('apoderado.alumno.index')->with('presente',$presente)->with('ausente',$ausente)->with('total',$total)->with('alumno',$alumno)->with('notas',$notas)->with('promedios',$promedios)->with('asignaturas',$asignaturas)->with('curso',$curso)->with('aus',$aus)->with('promediocurso',$promediocurso)->with('alumnos',$alumnos)->with('reunion',$reunion);
}
public function asignaturasAlumno($id){
    $apoderado=Apoderado::where('mail',Auth::user()->email)->first();
    $alumnos=Alumno::where('apoderado_id',$apoderado->id)->get();
    $alumno=Alumno::find($id);
    $curso=Curso::find($alumno->curso_id);
    $asignaturas=$curso->Asignaturas()->get();
    return view('apoderado.alumno.asignaturas')
    ->with('alumno',$alumno)
    ->with('asignaturas',$asignaturas)
    ->with('curso',$curso)
    ->with('alumnos',$alumnos);
}
public function notasAlumno($id){
    $apoderado=Apoderado::where('mail',Auth::user()->email)->first();
    $alumnos=Alumno::where('apoderado_id',$apoderado->id)->get();
    $alumno=Alumno::find(explode('-',$id)[0]);
    $asignatura=Asignatura::find(explode('-',$id)[1]);
    $curso=Curso::find($alumno->curso_id);
    $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->orderBy('fecha','ASC')->get();
    $establecimiento=Establecimiento::find(1);
    return view('apoderado.alumno.asignaturas.notas')->with('notas',$notas)->with('asignatura',$asignatura)->with('alumno',$alumno)->with('establecimiento',$establecimiento)->with('curso',$curso)->with('alumnos',$alumnos);
}
public function asignaturaproximaAlumno($id){
    $apoderado=Apoderado::where('mail',Auth::user()->email)->first();
    $alumnos=Alumno::where('apoderado_id',$apoderado->id)->get();
    $date=date('Y-m-d');
    $alumno=Alumno::find(explode('-',$id)[0]);
    $asignatura=Asignatura::find(explode('-',$id)[1]);
    $curso=Curso::find($alumno->curso_id);
    $establecimiento=Establecimiento::find(1);
    $proximas=FuturaEvaluacion::where('curso_id',$curso->id)->where('asignatura_id',$asignatura->id)->where('fecha','>',$date)->get();
    return view('apoderado.alumno.asignaturas.proximas')->with('proximas',$proximas)->with('asignatura',$asignatura)->with('alumno',$alumno)->with('establecimiento',$establecimiento)->with('alumnos',$alumnos);    
}
public function anotacionesAlumno($id){
    $apoderado=Apoderado::where('mail',Auth::user()->email)->first();
    $alumnos=Alumno::where('apoderado_id',$apoderado->id)->get();
    $alumno=Alumno::find(explode('-',$id)[0]);
    $asignatura=Asignatura::find(explode('-',$id)[1]);
    $curso=Curso::find($alumno->curso_id);
    $establecimiento=Establecimiento::find(1);
    $anotaciones=Anotacion::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->get();
    return view('apoderado.alumno.asignaturas.anotaciones')->with('anotaciones',$anotaciones)->with('asignatura',$asignatura)->with('alumno',$alumno)->with('establecimiento',$establecimiento)->with('curso',$curso)->with('alumnos',$alumnos);
}
public function anotacionesCurso($id){
    $apoderado=Apoderado::where('mail',Auth::user()->email)->first();
    $alumnos=Alumno::where('apoderado_id',$apoderado->id)->get();
    $alumno=Alumno::find(explode('-',$id)[0]);
    $curso=Curso::find(explode('-',$id)[1]);
    $establecimiento=Establecimiento::find(1);
    $anotaciones=AnotacionCurso::where('curso_id',$curso->id)->get();
    return view('apoderado.alumno.cursoanotaciones')->with('curso',$curso)->with('anotaciones',$anotaciones)->with('establecimiento',$establecimiento)->with('alumnos',$alumnos)->with('alumno',$alumno);

}
public function proximasAlumno($id){
    $apoderado=Apoderado::where('mail',Auth::user()->email)->first();
    $alumnos=Alumno::where('apoderado_id',$apoderado->id)->get();
    $alumno=Alumno::find($id);
    $curso=Curso::find($alumno->curso_id);
    $establecimiento=Establecimiento::find(1);
    $date=date('Y-m-d');
    $mes_proximo  = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));
    $proximas=FuturaEvaluacion::where('curso_id',$curso->id)->where('fecha','>',$date)->where('fecha','<',$mes_proximo)->get();
    return view('apoderado.alumno.proximas')->with('proximas',$proximas)->with('curso',$curso)->with('establecimiento',$establecimiento)->with('alumnos',$alumnos)->with('alumno',$alumno);   
}

public function promedio($alumno){
    $establecimiento=Establecimiento::find(1);
    $curso=Curso::find($alumno->curso_id);
    $asignaturas=$curso->Asignaturas()->get();
    $promedio=Array();
    $sum=0;
    foreach ($asignaturas as $asignatura) {
        $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<',$establecimiento->s1fin)->get();
        foreach ($notas as $nota) { 
            $sum=$sum+$nota->nota;
        }
        if(count($notas)==0){
            $promedio[$asignatura->id.'s1']=0;
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
        }
        else
        {
            $promedio[$asignatura->id.'s2']=round($sum/count($notas));    
        }
        $sum=0;
    }
    foreach ($asignaturas as $asignatura) {
        if($promedio[$asignatura->id.'s2']==0)
            $promedio[$asignatura->id.'final']=round($promedio[$asignatura->id.'s1']);
        else{    
            $promedio[$asignatura->id.'final']=round(($promedio[$asignatura->id.'s1']+$promedio[$asignatura->id.'s2'])/2);
        }
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
    $promedio['final1']=round($final1);
    $promedio['final2']=round($final2);
    $promedio['final']=round(($final2+$final1)/2);


    return $promedio; 
}

public function promedioCurso($id){
    $curso=Curso::find($id);
    $alumnos=Alumno::where('curso_id',$curso->id)->get();
    $asignaturas=$curso->Asignaturas()->get();
    $promedioscurso=Array();
    $pura=0;
    $uno=0;
    $dos=0;
    $profi=0;
    $asid="";
    foreach ($asignaturas as $asignatura) {
        foreach ($alumnos as $alumno) {
            $proalumno=$this->promedio($alumno);    
            $asid=$asignatura->id;
            $uno+=$proalumno[$asignatura->id.'s1'];
            $dos+=$proalumno[$asignatura->id.'s2'];
            $pura+=$proalumno[$asignatura->id.'final'];
        }
        $promedioscurso[$asid.'s1']=round($uno/$alumnos->count());
        $promedioscurso[$asid.'s2']=round($dos/$alumnos->count());
        $promedioscurso[$asid.'final']=round($pura/$alumnos->count());
        $profi+=round($pura/$alumnos->count());
        $pura=0;
    }
    $promedioscurso['final']=round($profi/$asignaturas->count());
    return $promedioscurso;
}    
public function comunicado($id)
{
    $curso=Curso::find($id);
    $reunion=Reunion::where('curso_id',$curso->id)->get();
    return $reunion;


}
}
