<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class increment extends Model
{
    //
    protected $table = 'incrementhistorymaster';

    protected $fillable = ['personalNo', 'incrementDate','increment','newBasic'];
    
    public $timestamps = false;
}
