<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officem extends Model
{
    //
    protected $table = 'officemaster';

    protected $fillable = ['id','officeName','officeAddress','officeHead','reportToOffice','createdBy','status', 'updated_at','created_at'];
    
}  
