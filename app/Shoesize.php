<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shoesize extends Model
{
    //
    protected $table = 'shoesize';

    protected $fillable = ['id','usShoeSize','ukShoeSize','euShoeSize','footLengthInches','footLengthCm','status'];
    public $timestamps = false;
}  
