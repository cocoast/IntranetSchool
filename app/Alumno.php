<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Alumno extends Model
{
    protected $table='alumno';
    protected $fillable=['nombre','apellido','rut','mail','telefono','direccion','curso_id','apoderado_id'];

    public function Curso()
    {
    	return $this->belongsTo('App\Curso');
    }
    public function Anotaciones()
    {
    	return $this->hasMany('App\Anotacion');
    }
    public function Apoderado()
    {
    	return $this->belongsTo('App\Apoderado');
    }
    public function Asistencias()
    {
    	return $this->hasMany('App\Asistencia');
    }
    public function Asignaturas()
    {
        return $this->belongsToMany('App\Asignatura');
    }
    public function Imagen_alumno(){
        return $this->hasOne('App\Imagen');
    }
    //Scope Aqui
    public function scopeSearch($query, $name)
    {
        return $query->where('apellido','LIKE',"%$name%");
    }

}
