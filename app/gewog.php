<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gewog extends Model
{
    //
    protected $table = 'gewogmaster';

    protected $fillable = ['id','gewogName','drungkhagId','dzongkhagId','status'];

     public $timestamps = false;
}
