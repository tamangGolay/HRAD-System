<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    //
    protected $table = 'qualificationmaster';

    protected $fillable = ['id','qualificationName','qualificationLevelId','qualificationField','status','updated_at','created_at'];
    
    public $timestamps = false;
}
