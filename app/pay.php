<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class pay extends Model
{
    //
    protected $table = 'payscalemaster';

    protected $fillable = ['id','grade', 'low','increment','high'];
    
    public $timestamps = false;
}
