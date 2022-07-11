<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceMaster extends Model
{
    protected $table = 'servicemaster';

   
    protected $fillable = ['id','serNameShort','serNameLong','serviceHead','company','status'];
      public $timestamps = false;
}
