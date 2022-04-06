<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class guesthouse extends Model
{
    //
    protected $table = 'guesthousename';

    protected $fillable = ['name','dzo_id'];

     public $timestamps = false;
}
