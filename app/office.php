<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class office extends Model
{
    //
    protected $table = 'officereportingstructuremaster';

    protected $fillable = ['officeId', 'reportsToOffice','fromDate','endDate'];
    
    public $timestamps = false;
}
