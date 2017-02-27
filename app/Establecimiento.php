<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    protected $table='establecimiento';
    protected $fillable=['nombre','telefono','direccion','mail','director','mail_director','telefono_director'];
}

class Year extends Model
{
    protected $table='year';
    protected $fillable=['s1inicio','s1fin','s2inicio','s2fin'];
}

