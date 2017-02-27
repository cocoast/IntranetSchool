<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anotacion extends Model
{
    protected $table='anotacion';
    protected $fillable=['tipo','fecha','anotacion','alumno_id','asignatura_id'];
    
public function Alumno()
{
	return $this->belongsTo('App\Alumno');
}
public function Asignatura()
{
	return $this->belongsTo('App\Asignatura');
}

}


