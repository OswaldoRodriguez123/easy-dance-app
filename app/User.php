<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

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
        return $this->belongsToMany('App\Role');
    }

    public function isType()
    {
        $rol = $this->roles()->select('role_id','name')->first();
        return $rol->name;
    }    
}
