<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnotacionCurso extends Model
{
    protected $table='anotacion_curso';
    protected $fillable=['tipo','fecha','anotacion','curso_id','asignatura_id'];
    
public function Curso()
{
	return $this->belongsTo('App\Curso');
}
public function Asignatura()
{
	return $this->belongsTo('App\Asignatura');
}
}
