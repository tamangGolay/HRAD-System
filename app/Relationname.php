<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relationname extends Model
{
    //
    protected $table = 'relationmaster';

    protected $fillable = ['id','relationshipName','verification','status'];
    
    public $timestamps = false;
}
