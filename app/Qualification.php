<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    //
    protected $table = 'qualificationmaster';

    protected $fillable = ['qualificationLevelId','qualificationShortName','qualificationLongName','status','updated_at','created_at'];
    
    public $timestamps = false;
}
