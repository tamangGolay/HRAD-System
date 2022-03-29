<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'guesthouserate';
    protected $fillable = ['id','grade','rate'];

     public $timestamps = false;
}
