<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apoderado extends Model
{
    protected $table='apoderado';
    protected $fillable=['nombre','apellido','rut','mail','telefono'];

    public function alumnos()
    {
    	return $this->hasMany('App\Alumno');
    }
    //Scope Aqui
    public function scopeSearch($query, $name)
    {
        return $query->where('apellido','LIKE',"%$name%");
    }
}
