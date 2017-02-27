<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table='imagen_alumno';
    protected $fillable=['nombre','alumno_id'];


    public function Alumno(){
    	return $this->hasOne('App\Alumno');
    }
}
