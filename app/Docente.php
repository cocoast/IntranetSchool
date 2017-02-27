<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
 	protected $table="docente";

 	protected $fillable=['nombre','apellido','rut','mail','telefono'];

	
	public function Curso()
	{
		return $this->hasOne('App\Curso');
	}
	public function Asignaturas()
	{
		return $this->hasMany('App\Asignatura');
	}
	//Aqui Scope
	public function scopeSearch($query, $name)
    {
        return $query->where('apellido','LIKE',"%$name%");
    }
}
