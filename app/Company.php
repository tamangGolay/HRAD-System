<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = 'companymaster';

    protected $fillable = ['id','comNameShort','comNameLong','comReportsTo','status'];
    public $timestamps = false;
}  
