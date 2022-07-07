<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employeeR extends Model
{
    //
    protected $table = 'empreportingstructuremaster';


    protected $fillable = ['personalNo', 'reportsToOffice','reportsToEmployee','fromDate','endDate'];
    
    public $timestamps = false;
}
