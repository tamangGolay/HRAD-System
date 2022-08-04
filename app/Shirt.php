<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shirt extends Model
{
    protected $table = 'shirtmaster';
    protected $fillable = ['id','shirtSizeName','status'];

     public $timestamps = false;
}
 