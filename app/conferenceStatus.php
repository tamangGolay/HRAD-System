<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class conferencestatus extends Model
{
    //
    protected $table = 'conferencestatus';         

    protected $fillable = ['ids','state'];

     public $timestamps = false;
}
