<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class village extends Model
{
    //
    protected $table = 'villagemaster';

    protected $fillable = ['id','villageName','gewogId','status'];

     public $timestamps = false;
}
