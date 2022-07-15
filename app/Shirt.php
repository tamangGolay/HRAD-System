<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shirt extends Model
{
    protected $table = 'shirtmaster';
    protected $fillable = ['id','shirtSizeName','gender','status'];

     public $timestamps = false;
}
