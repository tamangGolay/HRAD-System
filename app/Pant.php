<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pant extends Model
{
    protected $table = 'pantmaster';
    protected $fillable = ['id','pantSizeName','gender','status'];

     public $timestamps = false;
}
