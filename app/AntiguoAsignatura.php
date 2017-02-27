<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntiguoAsignatura extends Model
{
    protected $table='antiguo_asignatura';
    protected $fillable=['nombre_asignatura','id_antiguo','promedio_s1','promedio_s2','ano'];

    public function Antiguo(){
    	return $this->belongsTo('App\Antiguo');
    }
}
