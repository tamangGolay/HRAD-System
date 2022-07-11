<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class drungkhag extends Model
{
    //
    protected $table = 'drungkhagmaster';

    protected $fillable = ['drungkhagid','drungkhagName','dzongkhagId','status'];

     public $timestamps = false;
}
