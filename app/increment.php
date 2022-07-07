<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class increment extends Model
{
    //
    protected $table = 'incrementhistorymaster';

    protected $fillable = ['personalNo', 'incrementDate','oldBasic','newBasic','nextDue','remarks'];
    
    public $timestamps = false;
}
