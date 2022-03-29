<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class rangeofpeople extends Model
{
    protected $table = 'rangeofpeople';
    protected $fillable = ['range'];

     public $timestamps = false;
}
