<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    //
    protected $table = 'fieldmaster';

    protected $fillable = ['id','fieldName','status'];

     public $timestamps = false;
}
