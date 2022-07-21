<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeMaster extends Model
{
    protected $table = 'grademaster';

   
    protected $fillable = ['id','grade','level','status'];

     public $timestamps = false;
}
