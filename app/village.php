<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class village extends Model
{
    //
    protected $table = 'villagemaster';

    protected $fillable = ['id','villageId','villageName','gewogId','status'];

     public $timestamps = false;
}
