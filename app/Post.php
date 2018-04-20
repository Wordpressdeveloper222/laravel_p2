<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;
    
    protected $dates=['deleted_at'];
   // protected $table = 'posts';     
    protected $fillable=['title','content'];

public function user(){
    return $this->belongsTo('App\User');
}
}