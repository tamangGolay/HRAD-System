<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualificationview extends Model
{
    //
    protected $table = 'qualification';

    protected $fillable = ['id','qualificationName','empId'];
    
    public $timestamps = false;
}
