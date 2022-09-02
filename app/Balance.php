<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    //
    protected $table = 'wfbalance';

    protected $fillable = ['id','balance'];
    public $timestamps = false;
}  
