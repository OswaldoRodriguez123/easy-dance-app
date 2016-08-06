<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password', 'telefono', 'como_nos_conociste_id', 'academia_id','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function roles(){
        return $this->hasOne('App\Role','id','usuario_tipo');
    }

    public function isType()
    {
        $rol = $this->roles()->select('roles.id','roles.name')->first();
        return $rol->name;
    }    
}
