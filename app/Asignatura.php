<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $table ="asignatura";

    protected $fillable=['id','nombre','docente_id'];

    public function Docente()
    {
    	return $this->belongsTo('App\Docente');
    }
    
    public function FuturasEvaluaciones()
    {
    	return $this->hasMany('App\FuturaEvaluacion');
    }
      public function AnotacionesCurso()
    {
        return $this->hasMany('App\AnotacionCurso');
    }
    public function Anotaciones(){
    return $this->hasMany('App\Anotacion');

    }
    public function Notas()
    {
    	return $this->hasMany('App\Nota');
    }
    public function Cursos()
    {
    	return $this->belongsToMany('App\Curso','curso_asignatura');
    }
    public function Alumnos ()
    {
    	return $this->belongsToMany('App\Alumno');
    }
    //Scope Aqui
    public function scopeSearch($query, $name)
    {
        return $query->where('nombre','LIKE',"%$name%");
    }
}
