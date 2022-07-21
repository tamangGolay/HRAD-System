<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradeMaster extends Model
{
    protected $table = 'payscalemaster';

   
    protected $fillable = ['id','grade','low', 'increment', 'high', 'status'];

     public $timestamps = false;
}
