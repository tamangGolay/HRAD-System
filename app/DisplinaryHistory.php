<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisplinaryHistory extends Model
{
    //
    protected $table = 'displinaryhistorymaster';

    protected $fillable = ['id','personalNo','issueDate','case','actionTaken','status'];
    
    public $timestamps = false;
}
