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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function post(){
        return $this->hasOne('App\Post');   //onetoone
    } 
    
     public function posts(){
        return $this->hasMany('App\Post');  //onetomany
    }
    
    public function roles()
    {
       // return $this->belongsToMany('App\Role'); //manytomany
        return $this->belongsToMany('App\Role')->withPivot('created_at'); //manytomany
        //to customize columns and tables name follow the format below.
        
    }
}
