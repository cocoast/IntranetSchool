<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntiguoCurso extends Model
{
    protected $table='antiguo_curso';
    protected $fillable=['nombre_curso','nivel_curso','id_antiguo','ano'];

    public function Antiguo(){
    	return $this->belongsTo('App\Antiguo');
    }
}
