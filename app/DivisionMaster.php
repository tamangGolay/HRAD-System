<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisionmaster extends Model
{
    protected $table = 'divisionmaster';
   
    protected $fillable = ['id','divNameShort','divNameLong','divDzoId','divHead','divReportsToDepartment','deptDzoId','divReportsToService','serviceDzoId','divReportsToCompany','status'];

      public $timestamps = false;
}
