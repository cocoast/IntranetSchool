<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $table='year';
    protected $fillable=['name','s1inicio','s1fin','s2inicio','s2fin'];
}
