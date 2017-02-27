<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table='curso';
    protected $fillable=['id','nombre','nivel','docente_id'];

    public function  Asignaturas()
    {
        return $this->belongsToMany('App\Asignatura','curso_asignatura');
    }

    public function Alumnos()
    {
    	return $this->hasMany('App\Alumno');
    }
      public function AnotacionesCurso()
    {
        return $this->hasMany('App\Anotacion');
    }
    public function Docente()
    {
    	return $this->belongsTo('App\Docente');
    }

    public function FuturasEvaluaciones()
    {
    	return $this->hasMany('App\FuturaEvaluacion');
    }

    public function Reuniones()
    {
    	return $this->hasMany('App\Reunion');
    }

   

}
