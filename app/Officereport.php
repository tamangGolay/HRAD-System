<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officem extends Model
{
    //
    protected $table = 'officereportingstructuremaster';

    protected $fillable = ['id','officeId ','reportsToOffice','fromDate','	endDate'];
    public $timestamps = false;
    
}  
