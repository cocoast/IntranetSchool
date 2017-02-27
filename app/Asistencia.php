<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table='asistencia';
    protected $fillable=['fecha','asistencia','alunno_id'];

    public function Alumno()
    {
    	return $this->belongsTo('App\Alumno');
    }
     public function scopeSearch($query, $name)
    {
        return $query->where('fecha','LIKE',"%$name%");
    }
}
