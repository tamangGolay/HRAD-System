<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WfRelatives extends Model
{
    protected $table = 'wfrelatives';

   
    protected $fillable = ['id','empId','cIdNo','cIDOther','name','doB','relation','status'];

     public $timestamps = false;
}
