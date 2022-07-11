<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class town extends Model
{
    //
    protected $table = 'townmaster';

    protected $fillable = ['townClass','townName','dzongkhagId','status'];

     public $timestamps = false;
}
