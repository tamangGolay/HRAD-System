<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisplinaryHistory extends Model
{
    //
    protected $table = 'displinaryhistorymaster';

    protected $fillable = ['id','personalNo','incrementDate','case','actionTaken','status'];
    
    public $timestamps = false;
}
