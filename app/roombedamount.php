<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class roombedamount extends Model
{
    //
    protected $table = 'roombed';

   
       

    protected $fillable = ['rate'];

     public $timestamps = false;
}
