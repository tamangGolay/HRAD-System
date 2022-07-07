<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    //
    protected $table = 'resignationtypemaster';

    protected $fillable = ['id','resignationType','created_at','updated_at','status'];
    
    public $timestamps = false;
}
 