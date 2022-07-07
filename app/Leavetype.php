<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leavetype extends Model
{
    //
    protected $table = 'leavetypemaster';

    protected $fillable = ['id','leaveType','created_at','updated_at','status'];
    
}
 