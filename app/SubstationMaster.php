<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Substationmaster extends Model
{
    protected $table = 'substationmaster';

   
    protected $fillable = ['id','ssNameShort','ssNameLong','ssHead','ssReportsToUnit','ssReportsToSubDivision','ssReportsToDivision','ssReportsToDepartment', 'ssReportsToService','ssReportsToCompany','ssReportsToEmp','status'];

      public $timestamps = false;
}
