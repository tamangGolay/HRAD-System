<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMaster extends Model
{
    //
    protected $table = 'postmaster';

    // protected $fillable = ['id','bankName','status'];
    protected $fillable = ['id','shortName', 'longName','positionSpecificAllowance','contractAllowance','communicationAllowance','type','status'];


     public $timestamps = false;
}
