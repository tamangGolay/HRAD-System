<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualificationLevel extends Model
{
    //
    protected $table = 'qualilevelmaster';

    protected $fillable = ['id','qualiLevelName','status'];
    
    public $timestamps = false;
}
