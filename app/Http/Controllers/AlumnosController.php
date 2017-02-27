<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AlumnoRequest;
use App\Http\Requests\AlumnoUpdateRequest;
use App\Http\Controllers\Controller;
use App\Alumno;
use App\Curso;
use App\User;
use App\Nota;
use App\Asignatura;
use App\Anotacion;
use App\FuturaEvaluacion;
use App\AnotacionCurso;
use App\Asistencia;
use DB;
use Auth;
use App\Apoderado;
use App\Imagen;
use App\Docente;
use App\Establecimiento;
use Laracasts\Flash\Flash;
use Excel;
use App\Antiguo;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alumnos=Alumno::search($request->name)->orderBy('id','ASC')->paginate(30);
        return view('admin.alumnos.index')->with('alumnos',$alumnos);
    }
    public function listghost(Request $request)     
    {
        $antiguo=Antiguo::search($request->name)->orderBy('apellido','ASC')->paginate(25);
        return view('admin.alumnos.ghost')->with('alumnos',$antiguo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apoderados=Apoderado::select('id',DB::raw('CONCAT(nombre," ",apellido) AS nombre_completo'))->OrderBy('nombre')->lists('nombre_completo','id');
        $cursos=Curso::orderBy('nombre','ASC')->lists('nombre','id');
        return view('admin.alumnos.create')->with('cursos',$cursos)->with('apoderados',$apoderados);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlumnoRequest $request)
    {
      if(User::where('email',$request->mail)->get()->count()==0){
        $alumno= new Alumno();
        $nombre_completo=$request->nombre .' '. $request->apellido;
        $user=New User();
        $user->name=$nombre_completo;
        $user->email=$request->mail;
        $user->password=bcrypt($request->rut);
        $user->type='alumno';
        $alumno->nombre=$request->nombre;
        $alumno->apellido=$request->apellido;
        $rut=str_replace('-','',$request->rut);
        $rut=str_replace('.','',$rut);
        $alumno->rut=$rut;
        $alumno->mail=$request->mail;
        $alumno->telefono=$request->telefono;
        $alumno->direccion=$request->direccion;
        $alumno->curso_id=$request->curso_id;
        $alumno->apoderado_id=$request->apoderado_id;
        $alumno->save();
        $user->save();
        Flash::success("Se ha registrado " .$alumno->nombre ." y ".$alumno->apellido . " de forma exitosa" );
        return redirect()->route('admin.alumnos.index');
    }
    else{
        Flash::error("El rut Ya se encuentra registrado en el Sistema Favor Contacte a su administrador" );
        return redirect()->route('admin.alumnos.index');    
    }
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
        $apoderados=Apoderado::select('id',DB::raw('CONCAT(nombre," ",apellido) AS nombre_completo'))->OrderBy('nombre')->lists('nombre_completo','id');
        $cursos=Curso::orderBy('nombre','ASC')->lists('nombre','id');
        $alumno     =   Alumno::find($id);
        return view('admin.alumnos.edit')->with('alumno',$alumno)->with('cursos',$cursos)->with('apoderados',$apoderados);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlumnoUpdateRequest $request, $id)
    {
        $alumno=Alumno::find($id);
        $alumno->nombre=$request->nombre;
        $alumno->apellido=$request->apellido;
        $alumno->rut=$request->rut;
        $alumno->mail=$request->mail;
        $alumno->telefono=$request->telefono;
        $alumno->direccion=$request->direccion;
        $alumno->curso_id=$request->curso_id;
        $alumno->apoderado_id=$request->apoderado_id;

        $alumno->save();
        
        Flash::warning("Se ha editado ". $alumno->nombre ." ". $alumno->apellido ." de forma exitosa");
        
        return redirect()->route('admin.alumnos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alumno =Alumno::find($id);
        $nombre=$alumno->nombre.' '.$alumno->apellido;
        $alumno->delete()->cascade();
        Flash::error('El alumno '. $nombre ." ha sido borrado de forma exitosa");
        return redirect()->route('admin.alumnos.index');
    }
    public function Antiguo($id){
      $alumno=Alumno::find($id);
      if(!Antiguo::where('rut',$alumno->rut)->exists()){
        $antiguo=new Antiguo();
        $antiguo->rut=$alumno->rut;
        $antiguo->nombre=$alumno->nombre;
        $antiguo->apellido=$alumno->apellido;
        $antiguo->save();
    }
    else
        $antiguo=Antiguo::where('rut',$alumno->rut)->first();
    return $antiguo;
}
public function ghost($id)
{
    $antiguo=$this->Antiguo($id);
    $this->destroy($id);
    Flash::error('El alumno '. $nombre ." ha sido retirado de forma exitosa");
    return redirect()->route('admin.alumnos.index');
}

public function verNotas($id){
    $alumno=Alumno::find($id);
    $curso=Curso::find($alumno->curso_id);
    $establecimiento=Establecimiento::first();
    $asignaturas=$curso->Asignaturas()->orderBy('id','ASC')->get();
    return view('docente.alumno.indexnota')
    ->with('alumno',$alumno)
    ->with('asignaturas',$asignaturas)
    ->with('establecimiento',$establecimiento);
}

public function upExcel(Request $request)
{
    if($request->file('alumnos')!=null){
      $file   =   $request->file('alumnos');
      if($file->getClientOriginalExtension()!='xls'){
        Flash::error('Favor Seleccione un archivo Excel en Formato XLS');
        return redirect()->route('admin.alumnos.index');    
    }
    else{

        $name   =   'alumnos_'.time().'.'.$file->getClientOriginalExtension();
        $path   =   public_path().'/uploads/';
        $file->move($path,$name);
        $archivo=$path.''.$name;
        return $this->storeExcel($archivo);
    }
}
else {
    Flash::error('Favor Seleccione un archivo');
    return redirect()->route('admin.alumnos.index');
}
}
public function storeExcel($archivo)
{   
    Excel::load($archivo,function($archivo)
    {
        $result=$archivo->get();
        foreach ($result as $key =>$value) 
        {
            if(Alumno::where('nombre',$value->nombre)->where('rut',$value->rut)->where('apellido',$value->apellido)->where('mail',$value->mail)->get()->count()==0&&User::where('email',$value->mail)->get()->count()==0){ 
                $alumno =new Alumno();
                $alumno->nombre=$value->nombres;
                $alumno->apellido=$value->apellidos;
                $rut=str_replace('-','',$value->rut);
                $rut=str_replace('.','',$rut);
                $alumno->rut=$rut;
                $alumno->mail=$value->mail;
                $alumno->telefono=$value->telefono;
                $alumno->direccion=$value->direccion;
                $alumno->curso_id=$value->curso;
                $alumno->apoderado_id=$value->apoderados;
                $nombre_completo=$alumno->nombre.' '.$alumno->apellido;
                $user=New User();
                $user->name=$nombre_completo;
                $user->email=$alumno->mail;
                $user->password=bcrypt($rut);
                $user->type='alumno';
                $user->save();
                $alumno->save();
            }
        }
    })->get();
    Flash::success("El archivo a sido Importado de forma exitosa");
    return redirect()->route('admin.index');   
}
public function listAsignaturas(){
    $alumno=Alumno::where('mail',Auth::user()->email)->first();
    $curso=Curso::find($alumno->curso_id);
    $asignaturas=$curso->Asignaturas()->get();
    return view('alumno.asignaturas.index')
    ->with('alumno',$alumno)
    ->with('asignaturas',$asignaturas)
    ->with('curso',$curso);
}
public function asignaturaNotas($id){
    $alumno=Alumno::where('mail',Auth::user()->email)->first();
    $curso=Curso::find($alumno->curso_id);
    $asignatura=Asignatura::find($id);
    $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->orderBy('fecha','ASC')->get();
    $establecimiento=Establecimiento::find(1);
    return view('alumno.nota.index')->with('notas',$notas)->with('asignatura',$asignatura)->with('alumno',$alumno)->with('establecimiento',$establecimiento)->with('curso',$curso);
}
public function asignaturaAnotaciones($id){
    $alumno=Alumno::where('mail',Auth::user()->email)->first();
    $curso=Curso::find($alumno->curso_id);
    $asignatura=Asignatura::find($id);
    $establecimiento=Establecimiento::find(1);
    $anotaciones=Anotacion::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->get();
    return view('alumno.anotaciones.index')->with('anotaciones',$anotaciones)->with('asignatura',$asignatura)->with('alumno',$alumno)->with('establecimiento',$establecimiento)->with('curso',$curso);
}
public function asignaturaProximas($id){
    $date=date('Y-m-d');
    $alumno=Alumno::where('mail',Auth::user()->email)->first();
    $curso=Curso::find($alumno->curso_id);
    $asignatura=Asignatura::find($id);
    $establecimiento=Establecimiento::find(1);
    $proximas=FuturaEvaluacion::where('curso_id',$curso->id)->where('asignatura_id',$asignatura->id)->where('fecha','>',$date)->get();
    return view('alumno.proximas.index')->with('proximas',$proximas)->with('asignatura',$asignatura)->with('alumno',$alumno)->with('establecimiento',$establecimiento);    
}
public function listCursoanotaciones(){
    $alumno=Alumno::where('mail',Auth::user()->email)->first();
    $curso=Curso::find($alumno->curso_id);
    $establecimiento=Establecimiento::find(1);
    $anotaciones=AnotacionCurso::where('curso_id',$curso->id)->get();
    return view('alumno.cursoanotaciones.index')->with('curso',$curso)->with('anotaciones',$anotaciones)->with('establecimiento',$establecimiento);
}
public function proximas30(){
    $alumno=Alumno::where('mail',Auth::user()->email)->first();
    $curso=Curso::find($alumno->curso_id);
    $establecimiento=Establecimiento::find(1);
    $date=date('Y-m-d');
    $mes_proximo  = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));
    $proximas=FuturaEvaluacion::where('curso_id',$curso->id)->where('fecha','>',$date)->where('fecha','<',$mes_proximo)->get();
    return view('alumno.curso.proximas')->with('proximas',$proximas)->with('curso',$curso)->with('establecimiento',$establecimiento);    
}
public function Alumno(){
    $date=date('d-m-Y');
    $mespasado= date("d-m-Y",mktime(0,0,0,date("d")-1,date("m"),date("Y")));
    $alumno=Alumno::where('mail',Auth::user()->email)->first();
    $curso=Curso::find($alumno->curso_id);
    $presente=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',1)->get();
    $ausente=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',0)->get();
    $aus=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',0)->orderBy('fecha','DESC')->limit(7)->get();
    $total=Asistencia::where('alumno_id',$alumno->id)->get();
    $asignaturas=$curso->Asignaturas()->get();
    $notas=Nota::where('alumno_id',$alumno->id)->having('fecha','>',$mespasado)->orderBy('updated_at','DESC')->limit(7)->get();
    $promedios=$this->promedio($alumno);
    $promediocurso=$this->promedioCurso($curso->id);
    return view('alumno.alumno.index')->with('presente',$presente)->with('ausente',$ausente)->with('total',$total)->with('alumno',$alumno)->with('notas',$notas)->with('promedios',$promedios)->with('asignaturas',$asignaturas)->with('curso',$curso)->with('aus',$aus)->with('promediocurso',$promediocurso);
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
        else    
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
    $promedio['final1']=round($final1);
    $promedio['final2']=round($final2);
    if($promedio['final2']==0)
        $promedio['final']=round($final1);
    else  {
        $promedio['final']=round(($final2+$final1)/2);           
    }    



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
}
