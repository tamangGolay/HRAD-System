<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class guesthouserate extends Model
{
    //
    protected $table = 'guesthouserate';       

    protected $fillable = ['grade','rate']; 
     public $timestamps = false;
}
