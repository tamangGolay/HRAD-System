<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class v6allocation extends Model
{
    //
    protected $table = 'v6allocation';

    protected $fillable = ['id','ipV6Address','serverName','internalAddress','createdBy','createdOn','modifiedOn','modifedBy','status'];

     public $timestamps = false;
}
