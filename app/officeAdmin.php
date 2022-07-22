<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class officeAdmin extends Model
{
    //
    protected $table = 'officeadmin';
    protected $fillable = ['id','officeId','officeAdmin','status'];
    public $timestamps = false;
}  
