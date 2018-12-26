<?php

namespace App\Data\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;
use Hash;

class HomeEntity extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;
    protected $table = 'users';
    protected $primaryKey='id';


    protected $fillable =[
        'name',
        'email',        
        'password'
    ];

    protected $hidden = [
        'id',
        'name',
        'email',        
        'password',
        'created_at',
        'updated_at'
    ];

    protected $appends = ['Id', 'Nombre', 'Correo', 'Clave', 'Created', 'Modified'];

    public function getIdAttribute()
    {
        return $this->attributes['id'];
    }

    public function getNombrettribute()
    {
        return $this->attributes['name'];
    }

    public function getCorreoAttribute()
    {
        return $this->attributes['email'];
    }

    public function getClaveAttribute()
    {
        return $this->attributes['password'];
    }

    public function getCreatedAttribute()
    {
        return $this->attributes['created_at'];
    }

    public function getModifiedAttribute()
    {
        return $this->attributes['updated_at'];
    }

    //public function habitants()
    //{
    //    return $this->hasMany('App\Data\Entities\HabitantEntity', 'id_hogar', 'id_hogar');
    //}
}
