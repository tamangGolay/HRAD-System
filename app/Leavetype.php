<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leavetype extends Model
{
    //
    protected $table = 'leavetypemaster';

    protected $fillable = ['id','leaveType','status'];
    
    public $timestamps = false;
}
 