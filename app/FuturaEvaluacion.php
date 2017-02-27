<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FuturaEvaluacion extends Model
{
    protected $table='futuraevaluacion';
    protected $fillable=['fecha','contenido','asignatura_id','curso_id'];

    public function Asignatura()
    {
    	return $this->belongsTo('App\Asignatura');
    }
    public function Curso()
    {
    	return $this->belongsTo('App\Curso');
    }
}
