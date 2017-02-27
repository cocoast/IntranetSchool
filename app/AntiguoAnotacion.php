<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntiguoAnotacion extends Model
{
 	protected $table='antiguo_anotacion';
 	protected $fillable=['id_antiguo','positivas','negativas','ano'];

 	public function Antiguo(){
 		return $this->belongsTo('App\Antiguo');
 	} 	
}
