<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CursoUpdateRequest;
use App\Http\Requests\CursoRequest;
use App\Http\Controllers\Controller;
use App\Curso;
use Laracasts\Flash\Flash;
use App\Docente;
use App\Asignatura;
use App\Alumno;
use DB;
use Excel;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
     $cursos=Curso::orderBy('id','ASC')->paginate(30);
     return view('admin.cursos.index')->with('cursos',$cursos);
 }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $docentes   =   Docente::select('id',DB::raw('CONCAT(nombre," ",apellido) AS nombre_completo'))->OrderBy(           'nombre')->lists('nombre_completo','id');
        return view('admin.cursos.create')->with('docentes',$docentes);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CursoRequest $request)
    {   
        
        $curso=new Curso ($request->all());
        $curso->save();
        
        Flash::success("Se ha registrado " .$curso->nombre  ." de forma exitosa");
        return redirect()->route('admin.cursos.index');
    }
    public function storeca(Request $request)
    {

     $curso=Curso::find($request->curso_id);
     $curso->Asignaturas()->sync($request->asignaturas);
        /*foreach ($request->asignaturas as $key ) {
        DB::table('curso_asignatura')->insert(
            array(
                'curso_id'      =>$curso->id,
                'asignatura_id' =>$key
                )
            );
            por si falla lo de arriba
        }*/
        Flash::success("Se ha registrado relacion de forma exitosa");
        return redirect()->route('admin.cursos.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $curso      =   Curso::find($id);
        $docentes   =   Docente::select('id',DB::raw('CONCAT(nombre," ",apellido) AS nombre_completo'))->OrderBy('nombre')->lists('nombre_completo','id');
        return view('admin.cursos.edit')->with('curso',$curso)->with('docentes',$docentes);       
    }
    public function cursoAsignaturas($id){
        $curso=Curso::find($id);
        $name="";
        $grado="";
        if($curso->nivel==2||$curso->nivel==3)
        {
            $array=explode(" ",$curso->nombre);
            $name='N'.$curso->nivel.'C'.$array[0];
        }
        else
        {
            dd('Este Curso No Posee Asignatura');
        }

        $asignaturas=Asignatura::where('nombre','LIKE','%'.$name.'%')->orderBy('nombre','ASC')->lists('nombre' ,'id'); 

        if($curso->Asignaturas()){
            $my_tags=$curso->Asignaturas()->lists('asignatura_id')->ToArray();
            
            return view('admin.cursos.cursoasig')->with('curso',$curso)->with('asignaturas',$asignaturas)->with('my_tags',$my_tags);
        }
        else{
            return view('admin.cursos.cursoasig')->with('curso',$curso)->with('asignaturas',$asignaturas);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CursoUpdateRequest $request, $id)
    {
        $curso=Curso::find($id);
        $curso->nombre = $request->nombre;
        $curso->nivel = $request->nivel;
        $curso->docente_id = $request->docente_id;
        $curso->save();

        Flash::warning("Se ha editado ". $curso->nombre ." de forma exitosa");

        return redirect()->route('admin.cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso=Curso::find($id);
        $nombre=$curso->nombre ;
        if(Alumno::where('curso_id',$curso->id)->get()->count()==0){
        $curso->delete();
        Flash::error('El Curso '. $nombre ." ha sido borrado de forma exitosa");
        return redirect()->route('admin.cursos.index');
    }
    else{
     Flash::error('El Curso '. $nombre ." No puede ser Eliminado porque tiene Alumnos relacionados");
        return redirect()->route('admin.cursos.index');   
    }
    }
    public function upExcel(Request $request)
    {   
        if($request->file('cursos')!=null){
            $file   =   $request->file('cursos');
            if($file->getClientOriginalExtension()!='xls'){
                Flash::error('Favor Seleccione un archivo Excel en Formato XLS');
                return redirect()->route('admin.cursos.index');    
            }
            else{
                $name   =   'cursos_'.time().'.'.$file->getClientOriginalExtension();
                $path   =   public_path().'/uploads/';
                $file->move($path,$name);
                $archivo=$path.''.$name;
                return $this->storeExcel($archivo);
            }
        }
        else{
            Flash::error('Favor Seleccione un archivo');
            return redirect()->route('admin.cursos.index');
        }
    }
    public function storeExcel($archivo)
    {   
        Excel::load($archivo,function($archivo)
        {
            $result=$archivo->get();
            foreach ($result as $key =>$value) 
            {
                
                if(Curso::where('nombre',$value->nombre)->get()->count()==0||Curso::where('docente_id',$value->docente_id)->get()->count()==0){
                    $curso =new Curso();
                    $curso->nombre=$value->nombre;
                    $curso->nivel=$value->nivel;
                    $curso->docente_id=$value->docente_id;
                    $curso->save();
                }

            }
        })->get();
        Flash::success("El archivo a sido Importado de forma exitosa");
        return redirect()->route('admin.index');
        
    }
}
