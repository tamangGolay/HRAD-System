<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WfRelease extends Model
{
    //
    protected $table = 'wfrelease';

    protected $fillable = [ 'id','empId','releaseDate','amount','reason','status'];
    public $timestamps = false;

}
