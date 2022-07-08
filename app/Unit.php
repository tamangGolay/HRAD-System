<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unitmaster';
   
    protected $fillable = ['id','unitNameShort','unitNameLong','unitHead','unitReportsToSubDivision','unitReportsToDivision','unitReportsToDepartment','unitReportsToService','unitReportsToCompany','unitReportsToEmp','status'];
      public $timestamps = false;
}
