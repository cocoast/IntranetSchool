<?php

namespace App;
 
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password','type'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
    public function admin(){
        return $this->type==='admin';
    }
    public function docente(){
        return $this->type==='docente';
    }
    public function alumno(){
        return $this->type==='alumno';
    }
    public function apoderado(){
        return $this->type==='apoderado';
    }
    public function scopeSearch($query, $name)
    {
        return $query->where('name','LIKE',"%$name%");
    }
}
