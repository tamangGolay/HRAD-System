<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WfBank extends Model
{
    //
    protected $table = 'wfbank';

    protected $fillable = [ 'id','date','narration','transaction','amount'];
    public $timestamps = false;

}

