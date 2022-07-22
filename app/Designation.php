<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    //
    protected $table = 'designationmaster';

    protected $fillable = ['id','desisNameShort','desisNameLong','status'];
    public $timestamps = false;
}  
