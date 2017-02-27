<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AsignaturaRequest;
use App\Http\Controllers\Controller;
use App\Asignatura;
use App\Alumno;
use App\Nota;
use Laracasts\Flash\Flash;
use App\Docente;
use DB;
use Excel;

class AsignaturasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Scope aqui
        $asignaturas=Asignatura::search($request->name)->orderBy('nombre','ASC')->paginate(20);
        return view ('admin.asignaturas.index')->with('asignaturas',$asignaturas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docentes=Docente::select('id',DB::raw('CONCAT(nombre," ",apellido) AS nombre_completo'))->OrderBy('nombre')->lists('nombre_completo','id');
        return view('admin.asignaturas.create')->with('docentes',$docentes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AsignaturaRequest $request)
    {
        $asignatura=new Asignatura($request->all());
        $nombre=$asignatura->nombre .' - '.$request->docente_id;
        $asignatura->nombre=$nombre;
        $asignatura->save();

        Flash::success("Se ha registrado " .$asignatura->nombre  ." de forma exitosa");
        return redirect()->route('admin.asignaturas.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $asignatura      =   Asignatura::find($id);
        $docentes   =   Docente::select('id',DB::raw('CONCAT(nombre," ",apellido) AS nombre_completo'))->OrderBy('nombre')->lists('nombre_completo','id');
        return view('admin.asignaturas.edit')
        ->with('asignatura',$asignatura)
        ->with('docentes',$docentes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id 
     * @return \Illuminate\Http\Response
     */
    public function update(AsignaturaRequest $request, $id)
    {
        $asignatura = Asignatura::find($id);
        $docente=Docente::find($request->docente_id);
        $asignatura->docente_id = $docente->id;
        $name=explode('-',$request->nombre);
        $asignatura->nombre=$name[0];
        $nombre=$asignatura->nombre .' - '.$docente->id;
        $asignatura->nombre=$nombre;
        $asignatura->save();
        Flash::warning("Se ha editado ". $asignatura->nombre ." de forma exitosa");
        return redirect()->route('admin.asignaturas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $asignatura=Asignatura::find($id);
        $nombre=$asignatura->nombre;
        if(Nota::where('asignatura_id',$asignatura->id)->get()->count()==0){
            $asignatura->delete();
            Flash::error('El asignatura '. $nombre ."ha sido borrado de forma exitosa");
            return redirect()->route('admin.asignaturas.index');
        }
        else{
           Flash::error("No se puede Eliminar porque existen Notas relacionadas a la Asignatura");
           return redirect()->route('admin.asignaturas.index');   
       }
   }
   public function upExcel(Request $request)
   {
    if($request->file('asignaturas')!=null){
        $file   =   $request->file('asignaturas');
        if($file->getClientOriginalExtension()!='xls'){
            Flash::error('Favor Seleccione un archivo Excel en Formato XLS');
            return redirect()->route('admin.asignaturas.index');    
        }
        else{
            $name   =   'asignaturas_'.time().'.'.$file->getClientOriginalExtension();
            $path   =   public_path().'/uploads/';
            $file->move($path,$name);
            $archivo=$path.''.$name;
            return $this->storeExcel($archivo);
        }
    }
    else{
        Flash::error('Favor Seleccione un archivo');
        return redirect()->route('admin.asignaturas.index');
    }
}
public function storeExcel($archivo)
{   
    Excel::load($archivo,function($archivo)
    {
        $result=$archivo->get();
        foreach ($result as $key =>$value) 
        {
            if($value->nombre!=""||$value->id!=""){
                if(Docente::where('id',$value->docente_id)->get()->count()==1){
                    $docente=Docente::find($value->docente_id);
                    $asignatura =new Asignatura();
                    $asignatura->nombre=$value->nombre.' -'.$docente->id;
                    $asignatura->docente_id=$docente->id;
                    $asignatura->save();
                }
            }
        }
    })->get();
    Flash::success("El archivo a sido Importado de forma exitosa");
    return redirect()->route('admin.index');
    
}
}
