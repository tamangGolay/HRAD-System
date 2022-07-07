<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    //
    protected $table = 'bankmaster';

    protected $fillable = ['id','bankName','status'];

     public $timestamps = false;
}
