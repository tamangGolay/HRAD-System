<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dzongkhags extends Model
{
    //
    protected $table = 'dzongkhags';

    protected $fillable = ['Dzongkhag_Name'];

     public $timestamps = false;
}
