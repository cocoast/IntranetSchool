<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nota extends Model
{
    protected $table='notas';
    protected $fillable=['fecha','semestre','nota','alumno_id','asignatura_id'];

    public function Asignatura()
    {
    	return $this->belongsTo('App\Asignatura');
    }
    
}
