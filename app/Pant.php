<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pant extends Model
{
    protected $table = 'pantmaster';
    protected $fillable = ['id','pantSizeName','status'];

     public $timestamps = false;
}
