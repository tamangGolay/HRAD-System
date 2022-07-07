<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisionmaster extends Model
{
    protected $table = 'divisionmaster';

   
    protected $fillable = ['id','divNameShort','divNameLong','divHead','divReportsToDepartment','divReportsToService','divReportsToCompany','divReportsToEmp','status'];

      public $timestamps = false;
}
