<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class place extends Model
{
    protected $table = "placemaster";

    protected $fillable = ['id','placeName','dzongkhag','gewog','drungkhag','village','status'];

     public $timestamps = false;
}
