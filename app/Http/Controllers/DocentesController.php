<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\DocenteRequest;
use App\Http\Requests\DocenteUpdateRequest;
use App\Http\Controllers\Controller;
use App\Docente;
use App\User;
use App\Curso;
use App\Nota;
use App\FuturaEvaluacion;
use Auth;
use App\Alumno;
use App\Asignatura;
use DB;
use App\Establecimiento;
use Laracasts\Flash\Flash;
use Excel;
use App\Reunion;
use App\Asistencia;

class DocentesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docentes=Docente::search($request->name)->orderBy('id','ASC')->paginate(30);

        return view('admin.docentes.index')->with('docentes',$docentes);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DocenteRequest $request){

        if(User::where('email',$request->mail)->get()->count()==0){ 
            $docente=new Docente($request->all());
            $rut=str_replace('-','',$request->rut);
            $rut=str_replace('.','',$rut);
            $docente->rut=$rut;
            $user=New User();
            $nombre_completo=$request->nombre .' '. $request->apellido;
            $user->name=$nombre_completo;
            $user->email=$request->mail;
            $user->password=bcrypt($request->rut);
            $user->type='docente';
            $user->save();
            $docente->save();
            Flash::success("Se ha registrado ". $docente->nombre ." ".$docente->apellido . " de forma exitosa" );
            return redirect()->route('admin.docentes.index');  
        }
        else{
            Flash::Error("El rut Ingresado ya se encuentra registrado Favor contacte a su Administrador" );
            return redirect()->route('admin.docentes.index');  
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
        $docente    =   Docente::find($id);
        return view('admin.docentes.edit')->with('docente',$docente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DocenteUpdateRequest $request, $id){

        $docente    =   Docente::find($id);
        $docente->nombre=$request->nombre;
        $docente->apellido=$request->apellido;
        $docente->rut=$request->rut;
        $docente->mail=$request->mail;
        $docente->telefono=$request->telefono;
        $docente->save();

        Flash::warning("Se ha editado ". $docente->nombre ." ".$docente->apellido . " de forma exitosa" );

        return redirect()->route('admin.docentes.index');         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $docente    =Docente::find($id);
        $nombre=$docente->nombre ." ".$docente->apellido;
        if(Curso::where('docente_id',$docente->id)->get()->count()==0){
            $docente->delete();
            Flash::error('El Docente '.$nombre. " ha sido borrado de forma exitosa");
            return redirect()->route('admin.docentes.index');  
        }
        else{
            Flash::error('El Docente '.$nombre. " no se puede eliminar ya que tiene dependencias");
            return redirect()->route('admin.docentes.index');  
        }
    }

     /*
    *Listar Alumnos dependiendo del curso del profesor
    *NO recive parametros
    * retorna vista index
    */
     public function listCurso(){
        $docente=Docente::where('mail',Auth::user()->email)->first();
        if(DB::table('curso')->where('docente_id','=',$docente->id)->exists()){
            $curso=Curso::where('docente_id','=',$docente->id)->first();
            $alumnos=Alumno::orderBy('apellido','ASC')->where('curso_id','=',$curso->id)->get();
            return view('docente.curso.index')
            ->with('docente',$docente)
            ->with('curso',$curso)
            ->with('alumnos',$alumnos);
        }
        else{

            return redirect()->route('admin.index');
        }
    }

    public function listasignaturas(){
        $docente=Docente::where('mail',Auth::user()->email)->first();
        $asignaturas=Asignatura::orderBy('id','ASC')->where('docente_id','=',$docente->id)->get();
       // dd($asignaturas);
        return view('docente.asignaturas.index')
        ->with('docente',$docente)
        ->with('asignaturas',$asignaturas);
    }

    public function crearasistencia(){
        $docente=Docente::where('mail',Auth::user()->email)->first();
        if(DB::table('curso')->where('docente_id','=',$docente->id)->exists()){
            $curso=Curso::where('docente_id','=',$docente->id)->first();
            $alumnos=Alumno::orderBy('apellido','ASC')->where('curso_id','=',$curso->id)->get();
            return view('docente.curso.crasistencia')
            ->with('docente',$docente)
            ->with('curso',$curso)
            ->with('alumnos',$alumnos);
        }
        else{

            return redirect()->route('admin.index');
        }
    }

    public function verNotasCurso($id){
        $curso=Curso::find($id);
        $alumnos=Alumno::where('curso_id',$curso->id)->orderBy('apellido','ASC')->get();
        $asignaturas=DB::table('curso_asignatura')->where('curso_id',$curso->id)->get();
        foreach ($asignaturas as $asignatura) {
            foreach ($alumnos as $alumno) {
                if(Nota::where('asignatura_id',$asignatura->id)->where('alumno_id',$alumno->id)->get()->count()==0){
                 Flash::error('Notas de los Alumnos Insuficientes para mostrar información');
                 return $this->listasignaturas();
             }
         }
     }
     $establecimiento=Establecimiento::first();
     return view ('docente.curso.indexnotas')
     ->with('curso',$curso)
     ->with('alumnos',$alumnos)
     ->with('idasignaturas',$asignaturas)
     ->with('establecimiento',$establecimiento);
 }

 public function upExcel(Request $request)
 {
    if($request->file('docentes')!=null){
        $file   =   $request->file('docentes');
        if($file->getClientOriginalExtension()!='xls'){
            Flash::error('Favor Seleccione un archivo Excel en Formato XLS');
            return redirect()->route('admin.docentes.index');    
        }
        else{
            $name   =   'docentes_'.time().'.'.$file->getClientOriginalExtension();
            $path   =   public_path().'/uploads/';
            $file->move($path,$name);
            $archivo=$path.''.$name;
            return $this->storeExcel($archivo);
        }
    }
    else {
       Flash::error('Seleccione un Archivo');
       return redirect()->route('admin.docentes.index'); 
   }
}

public function storeExcel($archivo){   
    Excel::load($archivo,function($archivo)
    {
        $result=$archivo->get();
        foreach ($result as $key =>$value) 
        {

            if(Docente::where('nombre',$value->nombre)->where('rut',$value->rut)->where('apellido',$value->apellido)->get()->count()==0&&User::where('email',$value->email)->get()->count()==0){
                $docente =new Docente();
                $docente->nombre=$value->nombres;
                $docente->apellido=$value->apellidos;
                $rut=str_replace('-','',$value->rut);
                $rut=str_replace('.','',$rut);
                $docente->rut=$rut;
                $docente->mail=$value->email;
                $docente->telefono=$value->telefono;
                $user=New User();
                $nombre_completo=$docente->nombre .' '. $docente->apellido;
                $user->name=$nombre_completo;
                $user->email=$docente->mail;
                $user->password=bcrypt($rut);
                $user->type='docente';
                $user->save();
                $docente->save();
            }
        }
    })->get();
    Flash::success("El archivo a sido Importado de forma exitosa");
    return redirect()->route('admin.index');
}

public function indexPag() {
    $docente=Docente::where('mail',Auth::user()->email)->first();
    $asigProfe=$docente->Asignaturas()->get();
    $proxProfe=$this->proximas30asignaturas();
    if($docente->Curso()->get()->count()!=0){
        $curso=$docente->Curso()->first();
        $asignaturas=$curso->Asignaturas()->get();
        $alumnos=$curso->Alumnos()->get();
        foreach ($asignaturas as $asignatura) {
            foreach ($alumnos as $alumno) {
                if(Nota::where('asignatura_id',$asignatura->id)->where('alumno_id',$alumno->id)->get()->count()==0){
                 Flash::error('Notas de los Alumnos Insuficientes para mostrar información');
                 return $this->listasignaturas();
             }
         }
     }
     $proximascurso=$this->proximas30curso();
     $promedios=$this->promedioCurso($curso->id);
 }
 else{
    $asignaturas=$docente->Asignaturas()->get();
    $curso="";
    $promedioCurso="";
    $promedios="";
    $proximascurso="";
}
return view('docente.index')->with('promedios',$promedios)->with('curso',$curso)->with('docente',$docente)->with('asignaturas',$asignaturas)->with('proxcurso',$proximascurso)->with('proxProfe',$proxProfe);

}


public function proximas30curso(){
    $docente=Docente::where('mail',Auth::user()->email)->first();
    $curso=$docente->Curso()->first();
    $establecimiento=Establecimiento::find(1);
    $date=date('Y-m-d');
    $mes_proximo  = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));
    $proximas=FuturaEvaluacion::where('curso_id',$curso->id)->where('fecha','>',$date)->where('fecha','<',$mes_proximo)->get();
    return $proximas;
}

public function proximas30asignaturas(){       
    $date=date('Y-m-d');
    $mes_proximo  = date("Y-m-d",mktime(0,0,0,date("m")+1,date("d"),date("Y")));
    $docente=Docente::where('mail',Auth::user()->email)->first();
    $asignaturas=$docente->Asignaturas()->get();
    $proximas=Array();
    $i=0;
    foreach ($asignaturas as $asignatura) {
     $aux=$asignatura->FuturasEvaluaciones()->where('fecha','>',$date)->where('fecha','<',$mes_proximo)->get();

     foreach ($aux as $sila) {
         $proximas[$i]=$sila;
     }
     $i+=1;
 }
 return $proximas;
}

public function promedioCurso($id){
    $curso=Curso::find($id);
    $alumnos=Alumno::where('curso_id',$curso->id)->get();
    $asignaturas=$curso->Asignaturas()->get();
    $promedioscurso=Array();
    $pura=0;
    $profi=0;
    $asid="";
    $uno=0;
    $dos=0;
    foreach ($asignaturas as $asignatura) {
        foreach ($alumnos as $alumno) {
            $proalumno=$this->promedio($alumno);    
            $asid=$asignatura->id;
            $uno+=$proalumno[$asignatura->id.'s1'];
            $dos+=$proalumno[$asignatura->id.'s2'];
            $pura+=$proalumno[$asignatura->id.'final'];
            //dd($proalumno);
        }
        $promedioscurso[$asid.'s1']=round($uno/$alumnos->count());
        $promedioscurso[$asid.'s2']=round($dos/$alumnos->count());
        if($promedioscurso[$asid.'s2']==0){
            $promedioscurso[$asid]=$promedioscurso[$asid.'s1'];
            $profi+=round($promedioscurso[$asid.'s1']/$alumnos->count());
        }
        else{
            $promedioscurso[$asid]=round($pura/$alumnos->count());
            $profi+=round($pura/$alumnos->count());
        }
        
        $pura=0;
        $uno=0;
        $dos=0;
    }
    if($asignaturas->count()!=0){
        $promedioscurso['final']=round($profi/$asignaturas->count());    
        return $promedioscurso;
    }
    else{
     Flash::error('no posee asignatas');   
     return redirect()->route('admin.index');    
 }

}

public function promedio($alumno){
    $establecimiento=Establecimiento::find(1);
    $curso=Curso::find($alumno->curso_id);
    $asignaturas=$curso->Asignaturas()->get();
    $promedio=Array();
    $sum=0;
    $notas=0;
    foreach ($asignaturas as $asignatura) {
        if(Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->get()->count()!=0){
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
    }
    foreach ($asignaturas as $asignatura) {
        if(Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->get()->count()!=0){
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
    }
    foreach ($asignaturas as $asignatura) {
        if(Nota::where('asignatura_id',$asignatura->id)->get()->count()!=0){
            if($promedio[$asignatura->id.'s2']==0)
                $promedio[$asignatura->id.'final']=round($promedio[$asignatura->id.'s1']);
            else    
                $promedio[$asignatura->id.'final']=round(($promedio[$asignatura->id.'s1']+$promedio[$asignatura->id.'s2'])/2);
        }
    }
         //promedio final 1 semestre
    foreach ($asignaturas as $asignatura) {
        if(Nota::where('asignatura_id',$asignatura->id)->get()->count()!=0)
            $sum=$sum+$promedio[$asignatura->id.'s1'];
    }
    $final1=$sum/count($asignaturas);
    $sum=0;
            //promedio final 2 semestre
    foreach ($asignaturas as $asignatura) {
        if(Nota::where('asignatura_id',$asignatura->id)->get()->count()!=0)
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
public function indexReunion(){
    $docente=Docente::where('mail',Auth::user()->email)->first();
    $curso=Curso::where('docente_id',$docente->id)->first();
    $avisos=Reunion::where('curso_id',$curso->id)->get();
    return view('docente.reunion.index')->with('comunicados',$avisos);
}
public function createReunion(){
    return view('docente.reunion.create');
}
public function storeReunion(Request $request){
    $docente=Docente::where('mail',Auth::user()->email)->first();
    $curso=Curso::where('docente_id',$docente->id)->first();
    $reunion=new Reunion();
    $reunion->fecha=date('Y-m-d');
    $reunion->contenido=$request->contenido;
    $reunion->curso_id=$curso->id;
    $reunion->save();
    Flash::success("Se ha registrado Comunicado de Forma Exitosa!" );
    return redirect()->route('docentes.reunion.index');
}
public function editReunion($id){
    $reunion=Reunion::find($id);
    return view('docente.reunion.edit')->with('reunion',$reunion);
}
public function updateReunion(Request $request,$id){
    $reunion=Reunion::find($id);
    $reunion->contenido=$request->contenido;
    $reunion->save();
    Flash::warning("Se ha editado el Comunicado de Forma Exitosa!" );
    return redirect()->route('docentes.reunion.index');
}
public function destroyReunion($id){
    $reunion=Reunion::find($id);
    $reunion->delete();
    Flash::error("Se ha elimininado el  Comunicado de Forma Exitosa!" );
    return redirect()->route('docentes.reunion.index');   
}
}
