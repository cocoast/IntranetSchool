<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntiguoAsistencia extends Model
{
    protected $table='antiguo_asistencia';
    protected $fillable=['id_antiguo','asistencia','inasistencia','ano'];

    public function Antiguo(){
    	return $this->belongsTo('App\Antiguo');
    }
}
