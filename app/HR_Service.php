<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HR_Service extends Model
{
    //
    protected $table = 'hrservice';

    protected $fillable = ['id','createdBy','serviceType','justification','officeId','createdOn','status'];

    public $timestamps = false;


}
