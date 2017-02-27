<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Establecimiento;
use Flash;
use App\Alumno;
use App\Nota;
use App\Asignatura;
use App\Curso;
use App\Docente;
use App\Asistencia;
use App\Year;
use App\Antiguo;
use App\AntiguoAsignatura;
use App\AntiguoCurso;
use App\Anotacion;
use App\AntiguoAnotacion;
use App\AntiguoAsistencia;
use App\AnotacionCurso;
use App\FuturaEvaluacion;
use App\Reunion;
use App\Apoderado;
use App\User;
use Auth;
use DB;

class EstablecimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.configure.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('admin.configure.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $establecimiento=new Establecimiento();
      $establecimiento->nombre=$request->nombre;
      $establecimiento->direccion=$request->direccion;
      $establecimiento->telefono=$request->telefono;
      $establecimiento->mail=$request->mail;
      $establecimiento->director=$request->director;
      $establecimiento->rutdirec=$request->rutdirec;
      $establecimiento->mail_director=$request->mail_director;
      $establecimiento->telefono_director=$request->telefono_director;
      $establecimiento->s1inicio=$request->s1inicio;
      $establecimiento->s1fin=$request->s1fin;
      $establecimiento->s2inicio=$request->s2inicio;
      $establecimiento->s2fin=$request->s2fin;
      $file   =   $request->file('logo');
      if($file->getClientOriginalExtension()!='png')
      {
        Flash::Error("Formato de imagen no permitida favor revise que su archivo sea extension PNG");
        return view('admin.configure.index');
      }
      else
        $name   =   'logo'.'.'.$file->getClientOriginalExtension();
      $path   =   public_path().'/img';
      $file->move($path,$name);
      $establecimiento->logo='img/'.$name;
      $establecimiento->save();
      Flash::success("Se ha configurado el establecimiento ". $establecimiento->nombre );

      return redirect()->route('admin.index');
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
      $establecimiento=Establecimiento::find(1);
      $establecimiento->nombre=$request->nombre;
      $establecimiento->direccion=$request->direccion;
      $establecimiento->telefono=$request->telefono;
      $establecimiento->mail=$request->mail;
      $establecimiento->director=$request->director;
      $establecimiento->rutdirec=$request->rutdirec;
      $establecimiento->mail_director=$request->mail_director;
      $establecimiento->telefono_director=$request->telefono_director;
      $establecimiento->s1inicio=$request->s1inicio;
      $establecimiento->s1fin=$request->s1fin;
      $establecimiento->s2inicio=$request->s2inicio;
      $establecimiento->s2fin=$request->s2fin;
      if($request->file('logo')==null)
        $file=public_path().'/img/'.'logo.png';
      else{
        $file   =   $request->file('logo');

        if($file->getClientOriginalExtension()!='png')
        {
          Flash::Error("Formato de imagen no permitida, favor revise que su archivo sea extension PNG");
          return view('admin.configure.index');
        }

        else
          $name   =   'logo'.'.'.$file->getClientOriginalExtension();
        $name   =   'logo'.'.'.$file->getClientOriginalExtension();
        $path   =   public_path().'/img/';
        $file->move($path,$name);
      }
      $establecimiento->save();
      Flash::success("Se ha configurado el establecimiento ". $establecimiento->nombre );


      return redirect()->route('admin.index');  
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
    public function promedio($alumno){
      $establecimiento=Establecimiento::find(1);
      $curso=Curso::find($alumno->curso_id);
      $asignaturas=$curso->Asignaturas()->get();
      $promedio=Array();
      $sum=0;
      $notiene1=0;
      $notiene2=0;
      foreach ($asignaturas as $asignatura) {
        $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s1inicio)->where('fecha','<=',$establecimiento->s1fin)->get();
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
        $notas=Nota::where('alumno_id',$alumno->id)->where('asignatura_id',$asignatura->id)->where('fecha','>=',$establecimiento->s2inicio)->where('fecha','<=',$establecimiento->s2fin)->get();
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
    public function Asignaturas($id){
      $establecimiento=Establecimiento::find(1);
      $alumno=Alumno::find($id);
      $antiguo=$this->Antiguo($id);
      $curso=$alumno->Curso()->first();
      $asignaturas=$curso->Asignaturas()->get();
      foreach ($asignaturas as $asignatura) {
        if(!AntiguoAsignatura::where('nombre_asignatura',$asignatura->nombre)->where('id_antiguo',$antiguo->id)->where('ano',explode('-',$alumno->created_at)[0])->exists()){
         $promedios=$this->promedio($alumno);
         $aasig= new AntiguoAsignatura();
         $aasig->nombre_asignatura=$asignatura->nombre;
         $aasig->id_antiguo=$antiguo->id;
         $aasig->promedio_s1=$promedios[$asignatura->id.'s1'];
         $aasig->promedio_s2=$promedios[$asignatura->id.'s2'];
         $aasig->ano=explode('-',$establecimiento->s2fin)[0];
         $aasig->save();
       }
     }
     return true;
   }
   public function Curso($id){
    $establecimiento=Establecimiento::find(1);
    $alumno=Alumno::find($id);
    $antiguo=$this->Antiguo($id);
    $curso=Curso::find($alumno->curso_id);
    if(!AntiguoCurso::where('id_antiguo',$antiguo->id)->where('nombre_curso',$curso->nombre)->where('ano',explode('-',$alumno->created_at)[0])->exists()){
      $acur=new AntiguoCurso();
      $acur->id_antiguo=$antiguo->id;
      $acur->nombre_curso=$curso->nombre;
      $acur->nivel_curso=$curso->nivel;
      $acur->ano=explode('-',$establecimiento->s2fin)[0];
      $acur->save();
    }
    return true;
  }
  public function Anotacion($id){
    $establecimiento=Establecimiento::find(1);
    $alumno=Alumno::find($id);
    $antiguo=$this->Antiguo($id);
    $positivas=Anotacion::where('alumno_id',$alumno->id)->where('tipo',1)->get()->count();
    $negativas=Anotacion::where('alumno_id',$alumno->id)->where('tipo',0)->get()->count();
    if(!AntiguoAnotacion::where('id_antiguo',$antiguo->id)->where('positivas',$positivas)->where('negativas',$negativas)->where('ano',explode('-',$alumno->created_at)[0])->exists()){
      $aanot=new AntiguoAnotacion();
      $aanot->id_antiguo=$antiguo->id;
      $aanot->positivas=$positivas;
      $aanot->negativas=$negativas;
      $aanot->ano=explode('-',$establecimiento->s2fin)[0];
      $aanot->save();
    }
    return true;
  }
  public function Asistencia($id){
    $establecimiento=Establecimiento::find(1);
    $alumno=Alumno::find($id);
    $antiguo=$this->Antiguo($id);
    $asistencia=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',1)->get()->count();
    $inasistencia=Asistencia::where('alumno_id',$alumno->id)->where('asistencia',0)->get()->count();
    if(!AntiguoAsistencia::where('id_antiguo',$antiguo->id)->where('asistencia',$asistencia)->where('inasistencia',$inasistencia)->where('ano',explode('-',$alumno->created_at)[0])->exists()){
      $aasis=new AntiguoAsistencia();
      $aasis->id_antiguo=$antiguo->id;
      $aasis->asistencia=$asistencia;
      $aasis->inasistencia=$inasistencia;
      $aasis->ano=explode('-',$establecimiento->s2fin)[0];
      $aasis->save();
    }
    return true;

  }
  public function closeYear(){
    $establecimiento=Establecimiento::find(1);
    if($establecimiento->s2fin<date('Y-m-d')){
      $alumnos=Alumno::all();
      $exito=false;
      foreach ($alumnos as $alumno) {
        $antiguo=$this->Antiguo($alumno->id);
        $exito=$this->Asignaturas($alumno->id);
        $exito=$this->Curso($alumno->id);
        $exito=$this->Anotacion($alumno->id);
        $exito=$this->Asistencia($alumno->id);
      }
      DB::statement("SET foreign_key_checks = 0");
      if(DB::table('curso_asignatura')->count()!=0)
        DB::table('curso_asignatura')->truncate();
      if(Anotacion::count()!=0)
        Anotacion::query()->truncate();
      if(AnotacionCurso::count()!=0)
        AnotacionCurso::query()->truncate();
      if(Asistencia::count()!=0)
        Asistencia::query()->truncate();
      if(Nota::count()!=0)
        Nota::query()->truncate();
      if(FuturaEvaluacion::count()!=0)
        FuturaEvaluacion::query()->truncate();
      if(Reunion::count()!=0)
        Reunion::query()->truncate();
      if(Asignatura::count()!=0)
        Asignatura::query()->truncate();
      if(Curso::count()!=0)
        Curso::query()->truncate();
      if(Alumno::count()!=0) 
        Alumno::query()->truncate();
      if(Apoderado::count()!=0)
        Apoderado::query()->truncate();
      if(Docente::count()!=0)
        Docente::query()->truncate();

      Establecimiento::query()->truncate();
      $user=User::find(Auth::user()->id);
      User::query()->truncate();
      $admin=new User();
      $admin->name=$user->name;
      $admin->email=$user->email;
      $admin->password=$user->password;
      $admin->type=$user->type;
      $admin->save();
      DB::statement("SET foreign_key_checks = 1");
      $es= new Establecimiento();
      $es->nombre=$establecimiento->nombre;
      $es->direccion=$establecimiento->direccion;
      $es->telefono=$establecimiento->telefono;
      $es->mail=$establecimiento->mail;
      $es->director=$establecimiento->director;
      $es->rutdirec=$establecimiento->rutdirec;
      $es->mail_director=$establecimiento->mail_director;
      $es->telefono_director=$establecimiento->telefono_director;
      $es->logo=$establecimiento->logo;
      $es->save();
      Flash::success("Se ha cerrado el Año Academico con exito!" );
    }
    else 
     Flash::error("No se Puede cerrar el año Academico ya que aun no termina el segundo Semestre" ); 
   return redirect()->route('admin.configure.index');


 }

}