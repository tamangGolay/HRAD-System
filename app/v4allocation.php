<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class v4allocation extends Model
{
    //
    protected $table = 'v4allocation';

    protected $fillable = ['ipV4Address','serverName','internalAddress','createdBy','createdOn','modifiedBy','modifiedOn'];

     public $timestamps = false;
}
