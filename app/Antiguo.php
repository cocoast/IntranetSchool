<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antiguo extends Model
{
    protected $table='antiguo';
    protected $fillable=['rut','nombre','apellido'];

    public function AntiguoAnotaciones(){
    	return $this->hasMany('App\AntiguoAnotacion');
    }
    public function AntiguoAsignaturas(){
    	return $this->hasMany('App\AntiguoAsistencia');
    }
    public function AntiguoCursos(){
    	return $this->hasMany('App\AntiguoCurso');
    }
    public function AntiguoAsistencias(){
    	return $this->hasMany('App\AntiguoAsistencia');
    }
    //Scope Aqui
    public function scopeSearch($query, $name)
    {
        return $query->where('apellido','LIKE',"%$name%");
    }
}
