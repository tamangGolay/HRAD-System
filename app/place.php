<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class place extends Model
{
    protected $table = "placemaster";

    protected $fillable = ['id','villageId','townId','gewogId','drungkhagId','dzongkhagId','placeCategory','status'];

     public $timestamps = false;
}
