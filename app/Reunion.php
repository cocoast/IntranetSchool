<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reunion extends Model
{
    protected $table='reunion';
    protected $fillable=['fecha','contenido','curso_id'];

    public function Curso(){
    	return $this->belongsTo('App\curso');
    }
}
